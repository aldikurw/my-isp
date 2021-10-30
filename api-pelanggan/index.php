<?php

require_once "config/config.php";

$pelanggan = $db->select("pelanggan", "*", ["id_pelanggan" => $_COOKIE["id"]])[0];
$alamat = $db->select("alamat", "*", ["id_alamat" => $pelanggan["id_alamat"]])[0];

$response["data"] = [
    "pelanggan" => $pelanggan,
    "alamat" => $alamat
];
$response["data"]["akun_home_wifi"] = $db->select("akun_home_wifi", "*", ["id_pelanggan" => $pelanggan["id_pelanggan"]])[0];
$response["data"]["paket_home_wifi"] = $db->select("paket_home_wifi", "*", ["id_paket_home_wifi" => $response["data"]["akun_home_wifi"]["id_paket_home_wifi"]])[0];

$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);