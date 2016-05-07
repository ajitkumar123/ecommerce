<?php
/**
 * Created by PhpStorm.
 * User: ajit
 * Date: 5/5/16
 * Time: 12:06 AM
 */


class Controller{


    public function __construct()
    {

    }

    public function loadView($view_path, Array $data = []){
        extract($data);
        require_once $view_path;
    }

}