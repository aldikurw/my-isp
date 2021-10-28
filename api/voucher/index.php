<?php

require_once "../config/config.php";

$sql = <<<EOT
SELECT 
SUM(trx.total) pemasukan
FROM `transaksi_voucher` trx
WHERE
    MONTH(`trx`.`created_at`) = MONTH(curdate())
    AND
    YEAR(`trx`.`created_at`) = YEAR(curdate())
EOT;

$pemasukan = $db->query($sql)->fetchAll()[0]["pemasukan"];
$reseller = $db->count("akun_reseller");

$sql = <<<EOT
SELECT 
COUNT(trx.id_transaksi_voucher) total_transaksi
FROM `transaksi_voucher` trx
WHERE
    MONTH(`trx`.`created_at`) = MONTH(curdate())
    AND
    YEAR(`trx`.`created_at`) = YEAR(curdate())
EOT;
$total_transaksi = $db->query($sql)->fetchAll()[0]["total_transaksi"];


$response["data"] = [
    "pemasukan" => $pemasukan,
    "reseller" => $reseller,
    "total_transaksi" => $total_transaksi
];

$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);