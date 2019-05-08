<?php
/**
 * model/AuthA.inc.php
 * @package MVC_NML_Sample
 * @author nml
 * @copyright (c) 2017, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
abstract class DbP {
    const DBHOST = 'localhost';
    const DBUSER = 'cmb';
    const USERPWD = 'pass123øæl';  // on sql db run: grant all on yaddax3.* to cmb@localhost IDENTIFIED BY 'pass123øæl';
    const DB = 'yaddax3';
    const DSN = "mysql:host=".self::DBHOST.";dbname=".self::DB;

    // secure sessions
    const SECURE = false;           // dev only, true in production
    const HTTP_ONLY = true;         // enforces cookie only sessions
    const SESS_NAME = 'cmb00';      // application session name
}
