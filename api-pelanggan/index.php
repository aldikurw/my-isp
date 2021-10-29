<?php

require_once "config/config.php";

$nama = $db->select("pelanggan", "nama", ["id_pelanggan" => $_COOKIE["id"]])[0];

$response["data"] = [
    "nama" => $nama
];

$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);