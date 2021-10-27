<?php
date_default_timezone_set("Asia/Jakarta");

require_once "Medoo.php";

use Medoo\Medoo;

$config["host"] = "mysql";
$config["username"] = "root";
$config["password"] = "root";
$config["db"] = "my-isp";


$db = new Medoo([
    'type' => 'mysql',
    'host' => $config["host"],
    'database' => $config["db"],
    'username' => $config["username"],
    'password' => $config["password"] 
]);

$sql_details = array(
    'host' => $config["host"],
    'user' => $config["username"],
    'pass' => $config["password"],
    'db'   => $config["db"]
);

$list_tahun = $db->select("tahun", ["tahun"]);
if (!in_array(date("Y"), array_column($list_tahun, "tahun"))) {
    $db->insert("tahun", [
        "tahun" => date("Y")
    ]);
}

$response["success"] = false;
$response["message"] = "Error";