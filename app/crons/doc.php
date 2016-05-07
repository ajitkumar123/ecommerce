<?php
include_once 'DB.php';
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("max_execution_time", -1);
//$str = file_get_contents('flipkart-20160429-032508-2751519.json');

$myfile = fopen("flipkart-20160429-032508-2751519.json", "r") or die("Unable to open file!");

// Output one line until end-of-file
$i = 0;
$keys = [];
$data = [];
while(!feof($myfile)) {
//    echo fgets($myfile) . "<br>";
    $json = json_decode(fgets($myfile), true);
    if(is_array($json)) {
        $keys = array_unique(array_merge($keys, array_keys($json)));
    }
}
fclose($myfile);
//array_walk($keys ,function(&$key){
//    $key = ','. $key. ' TEXT NOT NULL';
//});
//$sql = 'CREATE TABLE `dataweave`.`prod_test` ( `id` INT(11) NOT NULL AUTO_INCREMENT ';
//$sql .= implode(' ', $keys);
//$sql .= ') ENGINE = InnoDB';
//echo $sql;exit;


$pdo = DB::getInstance();
$myfile = fopen("flipkart-20160429-032508-2751519.json", "r") or die("Unable to open file!");
    while(!feof($myfile)) {
        $json = json_decode(fgets($myfile), true);
        unset($json['page_error']);
        unset($json['error']);
        foreach ($json as &$value) {
            if(is_array($value)) $value = json_encode($value);
            $value = '"'.addslashes($value).'"';
        }

        unset($value);
        if(is_array($json)) {
            $sql = 'INSERT INTO `prod_test`('. implode(', ', array_keys($json)) . ')
            VALUES (  ' . implode(',', $json) .' )';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }



    }
//var_dump($keys);

exit;

