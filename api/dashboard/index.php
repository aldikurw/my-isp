<?php

require_once "../config/config.php";

$tahun = date("Y");
$bulan = date("m");

$lunas = $db->count("invoice_home_wifi", ["status_pembayaran" => "Lunas", "tahun" => $tahun, "bulan" => $bulan]);
$total_pelanggan = $db->count("akun_home_wifi");

$sql = <<<EOT
SELECT 
SUM(trx.total) pemasukan_voucher
FROM `transaksi_voucher` trx
WHERE
    MONTH(`trx`.`created_at`) = MONTH(curdate())
    AND
    YEAR(`trx`.`created_at`) = YEAR(curdate())
EOT;
$pemasukan_voucher = $db->query($sql)->fetchAll()[0]["pemasukan_voucher"];

$response["data"] = [
    "home_wifi_lunas" => $lunas,
    "home_wifi_belum_lunas" => $total_pelanggan - $lunas,
    "pemasukan_voucher" => $pemasukan_voucher
];

$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";
echo json_encode($response);
