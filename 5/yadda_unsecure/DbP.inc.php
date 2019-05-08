<?php
/**
 * DbP.inc.php
 * @author nml
 * @copyright (c) 2018, nml
 * @license http://www.fsf.org/licensing/ GPLv3
 */
abstract class DbP {
    const DBHOST = 'localhost';
    const DBUSER = 'root';
    const USERPWD = '';
    const DB = 'yaddaUnsecure';
    const DSN = "mysql:host=".self::DBHOST.";dbname=".self::DB;
}
