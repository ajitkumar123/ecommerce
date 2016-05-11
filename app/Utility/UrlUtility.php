<?php
/**
 * Created by PhpStorm.
 * User: ajit
 * Date: 5/5/16
 * Time: 2:38 AM
 */

class Url{
    public static function generate($url, $add_key, $add_value, $remove_key = 'ajax'){
        $parts = parse_url($url);
        $query = [];
        if(isset($parts['query']))
            parse_str($parts['query'], $query);

        unset($query[$remove_key]);

        unset($query[$add_key]);
        $query[$add_key] = $add_value;

        return  explode('?',$url)[0].'?'.http_build_query($query);
    }

}