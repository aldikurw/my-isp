<?php

require_once "../config/config.php";

$calon_pelanggan = $db->select("calon_pelanggan", "*", ["id_calon_pelanggan" => $_COOKIE["id"]])[0];


$response["data"] = [
    "nama" => $nama
];

$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);