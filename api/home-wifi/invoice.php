<?php

require_once "../config/config.php";

$response["data"] = $db->select("invoice_home_wifi", "*", ["id_akun_home" => $_GET["id_akun_home"]]);
$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);