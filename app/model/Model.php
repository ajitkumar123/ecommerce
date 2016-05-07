<?php
/**
 * Created by PhpStorm.
 * User: ajit
 * Date: 5/5/16
 * Time: 12:20 AM
 */

include_once 'DB.php';

class Model {
    public $dbObj;
    public function __construct()
    {
        $this->dbObj = Db::getInstance();
    }
}