<?php
/**
 * model/Authentication.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
require_once './model/AuthA.inc.php';


class Authentication extends AuthA {

    private $now;                                        // Preventing Brute Force
    protected static $login_timeout = 15;                // -"-

    protected function __construct($user, $pwd) {
        parent::__construct($user);
            $this->now = time();                                                // time when this obj is created
        try {
            self::dbLookUp($user, $pwd, $this->now);                            // invoke auth
            $_SESSION[self::$sessvar] = $this->getUserId();                     // succes
        }
        catch (Exception $e) {
            self::$logInstance = FALSE;
            unset($_SESSION[self::$sessvar]);                                   //miserys
            print "error in password or username or wait and try again";       //move to a view

            // Preventing Brute Force - update last_failure attemp
            $sql = "UPDATE user
                    SET last_failure = $this->now
                    WHERE id = :uid";

            $dbh = Model::connect();

            try {
                $q = $dbh->prepare($sql);
                $q->bindValue(':uid', $user);
                $q->execute();

            } catch(PDOException $e) {
                die($e->getMessage());
            }
        }
    }

    public static function authenticate($user, $pwd) {
        if (! self::$logInstance) {
            self::$logInstance = new Authentication($user, $pwd);
        }
        return self::$logInstance;
    }

    protected static function dbLookUp($user, $pwdtry, $now) {
        // Using prepared statement to prevent SQL injection
        $sql = "select id, password, last_failure
                from user
                where id = :uid
                and activated = true;";

        $dbh = Model::connect();
        try {
            $q = $dbh->prepare($sql);
            $q->bindValue(':uid', $user);
            $q->execute();
            $row = $q->fetch();

            if (!($row['id'] === $user
                  && password_verify($pwdtry, $row['password'])
                  && ($now - $row['last_failure']) > self::$login_timeout)) {
                  if ($row['id'] === $user) {
                    echo "<br /> last falure: " . $row['last_failure'] . "<br />";
                    echo "time now" . $now . "<br />";
                    echo "if under 15sec since last attempt login is rejected due to preventing against Brute Force attacks<br />";
                  }
                  throw new Exception("Not authenticated", 42);                  //misery
            }
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
}
