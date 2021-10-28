<?php

require_once "../config/config.php";

use Medoo\Medoo;

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
}

$invoice = $db->select("invoice_home_wifi", ["uuid", "status_pembayaran", "tanggal_pembayaran"], [
    "id_akun_home_wifi" => $_GET["id_akun_home_wifi"],
    "tahun" => $_GET["tahun"],
    "bulan" => $_GET["bulan"]
])[0];
$id_pelanggan = $db->select("akun_home_wifi", "id_pelanggan", ["id_akun_home_wifi" => $_GET["id_akun_home_wifi"]]);
$pelanggan = $db->select("pelanggan", ["[><]alamat" => ["id_alamat" => "id_alamat"]], ["pelanggan.username_akun", "pelanggan.nama", "alamat.nama (alamat)"], ["id_pelanggan" => $id_pelanggan])[0];
$paket = $db->select("paket_home_wifi", ["[><]akun_home_wifi" => ["id_paket_home_wifi" => "id_paket_home_wifi"]],["nama", "kecepatan", "harga"])[0];

$response["data"] = [
    "uuid" => $invoice["uuid"],
    "username_akun" => $pelanggan["username_akun"],
    "nama_pelanggan" => $pelanggan["nama"],
    "alamat_pelanggan" => $pelanggan["alamat"],
    "status_pembayaran" => $invoice["status_pembayaran"],
    "nama_paket" => $paket["nama"],
    "kecepatan_paket" => $paket["kecepatan"],
    "harga_paket" => $paket["harga"],

];
if ($invoice["status_pembayaran"] == "Lunas") {
    $response["data"]["tanggal_pembayaran"] = $invoice["tanggal_pembayaran"];
}
$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);