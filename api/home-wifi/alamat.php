<?php

require_once "../config/config.php";

$response["data"] = $db->select("alamat", "*");
$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);