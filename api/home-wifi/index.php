<?php

require_once "../config/config.php";

$tahun = date("Y");
$bulan = date("m");
$sql = <<<EOT
SELECT 
SUM(pkt.harga) pemasukan
FROM invoice_home_wifi inv
INNER JOIN akun_home_wifi akn
    ON inv.id_akun_home_wifi = akn.id_akun_home_wifi
INNER JOIN paket_home_wifi pkt
    ON pkt.id_paket_home_wifi = akn.id_paket_home_wifi
WHERE
    inv.tahun = '$tahun'
    AND
    inv.bulan = '$bulan';
    
EOT;

$pemasukan = $db->query($sql)->fetchAll()[0]["pemasukan"];
$lunas = $db->count("invoice_home_wifi", ["status_pembayaran" => "Lunas", "tahun" => $tahun, "bulan" => $bulan]);
$total_pelanggan = $db->count("akun_home_wifi");


$response["data"] = [
    "pemasukan" => $pemasukan,
    "lunas" => $lunas,
    "belum_lunas" => $total_pelanggan - $lunas,
];

$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);