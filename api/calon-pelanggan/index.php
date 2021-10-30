<?php

require_once "../config/config.php";

$calon_pelanggan = $db->select("calon_pelanggan", "*", ["id_calon_pelanggan" => $_COOKIE["id"]])[0];
$alamat = $db->select("alamat", "*", ["id_alamat" => $calon_pelanggan["id_alamat"]])[0];

$response["data"] = [
    "calon_pelanggan" => $calon_pelanggan,
    "alamat" => $alamat
];

if ($calon_pelanggan["jenis_layanan"] === "Home") {
    $response["data"]["paket_home"] = $db->select("paket_home_wifi", "*", ["id_paket_home_wifi" => $calon_pelanggan["id_paket_home_wifi"]])[0];
}
$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);