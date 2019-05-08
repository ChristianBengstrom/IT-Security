<?php
/**
 * model/DbH.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
set_include_path('.:../model:../inc');
require_once 'DbP.inc.php';

class DbH extends DbP {
    private static $instance = FALSE;
    private static $dbh;

    private function __construct() {
        try {
            self::$dbh = new PDO(DbP::DSN, DbP::DBUSER, DbP::USERPWD);
            self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            printf("<p>Connect failed for following reason: <br/>%s</p>\n",
              $e->getMessage());
        }
    }

    public static function getDbH() {
        if (! self::$instance) {
            self::$instance = new DbH();
        }
        return self::$dbh;
    }

    public static function better_session_start() {
        /*
         * Inspired by https://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL
         */

        if (!ini_set('session.use_only_cookies', true)) {   // Forces sessions to only use cookies.
            header("Location: ".$_SERVER['HTTP_REFERER']."?err=Could not initiate a safe session (ini_set)");
            exit();
        }

        $cookieParams = session_get_cookie_params();        // Gets and changes current cookies params.
        session_set_cookie_params($cookieParams["lifetime"],
                                  $cookieParams["path"],
                                  $cookieParams["domain"],
                                  self::SECURE,
                                  self::HTTP_ONLY);
        session_name(self::SESS_NAME);                      // Sets session name
        session_start();                                    // Start the PHP session
        session_regenerate_id();                            // regenerated the session.
    }
}
