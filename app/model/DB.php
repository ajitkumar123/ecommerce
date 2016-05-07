<?php
/**
 * Created by PhpStorm.
 * User: ajit
 * Date: 4/5/16
 * Time: 1:48 AM
 */

class Db {

    private static $_instance;
    private $_pdo;

    private function __construct() {
        $this->connect();
    }

    private function connect() {
        # connect to the database
        $host = DB_HOST;
        $dbname = DB_NAME;
        $username = DB_USER;
        $password = DB_PASS;
        try {
            $this->_pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->_pdo-> exec("SET CHARACTER SET utf8");
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            trigger_error("Error connecting to database due to: " . $e->getMessage(), E_USER_WARNING);
        }
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            self::$_instance = new Db();
        }
        return self::$_instance->_pdo;
    }

}
