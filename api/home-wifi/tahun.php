<?php

require_once "../config/config.php";

$response["data"] = $db->max("tahun", "tahun");
$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);