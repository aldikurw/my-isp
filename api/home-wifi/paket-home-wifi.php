<?php

require_once "../config/config.php";

$response["data"] = $db->select("paket_home_wifi", "*");
$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);