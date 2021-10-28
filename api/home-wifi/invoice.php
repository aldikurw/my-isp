<?php

require_once "../config/config.php";

use Medoo\Medoo;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $response["data"] = $db->select("invoice_home_wifi", "*", ["id_akun_home_wifi" => $_GET["id_akun_home_wifi"]]);
    $response["success"] = true;
    $response["message"] = "Berhasil mendapatkan data";
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $count = $db->count("invoice_home_wifi", [
        "id_akun_home_wifi" => $_GET["id_akun_home_wifi"],
        "tahun" => $_GET["tahun"],
        "bulan" => $_GET["bulan"]
    ]);
    
    if ($count == 0) {
        $response["data"] = $db->insert("invoice_home_wifi", [
            "uuid" => Medoo::raw('UUID()'),
            "id_akun_home_wifi" => $_GET["id_akun_home_wifi"],
            "tahun" => $_GET["tahun"],
            "bulan" => $_GET["bulan"],
            "status_pembayaran" => "Lunas"
        ]);
    } else {
        $response["data"] = $db->update("invoice_home_wifi", 
        [
            "status_pembayaran" => "Lunas",
            "tanggal_pembayaran" => date('Y-m-d H:i:s')
        ], 
        [
            "id_akun_home_wifi" => $_GET["id_akun_home_wifi"],
            "tahun" => $_GET["tahun"],
            "bulan" => $_GET["bulan"]
        ]);
    }

    $response["success"] = true;
    $response["message"] = "Pembayaran berhasil";
} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $count = $db->count("invoice_home_wifi", [
        "id_akun_home_wifi" => $_GET["id_akun_home_wifi"],
        "tahun" => $_GET["tahun"],
        "bulan" => $_GET["bulan"]
    ]);
    
    if ($count == 0) {
        $response["data"] = $db->insert("invoice_home_wifi", [
            "uuid" => Medoo::raw('UUID()'),
            "id_akun_home_wifi" => $_GET["id_akun_home_wifi"],
            "tahun" => $_GET["tahun"],
            "bulan" => $_GET["bulan"],
            "status_pembayaran" => "Belum Lunas",
            "tanggal_pembayaran" => null
        ]);
    } else {
        $response["data"] = $db->update("invoice_home_wifi", 
        [
            "status_pembayaran" => "Belum Lunas",
            "tanggal_pembayaran" => null
        ],
        [
            "id_akun_home_wifi" => $_GET["id_akun_home_wifi"],
            "tahun" => $_GET["tahun"],
            "bulan" => $_GET["bulan"]
        ]);
    }
    
    $response["success"] = true;
    $response["message"] = "Pembayaran dibatalkan";
}

echo json_encode($response);