<?php

require_once "../config/config.php";

$tahun = date("Y");
$bulan = date("m");
$lunas = $db->count("invoice_home_wifi", ["status_pembayaran" => "Lunas", "tahun" => $tahun, "bulan" => $bulan]);
$total_pelanggan = $db->count("akun_home_wifi");
$belum_lunas = $total_pelanggan - $lunas;
$jumlah_reseller_voucher = $db->count("akun_reseller");

$sql = <<<EOT
SELECT 
    plg.username_akun,
    plg.nama, 
    plg.lng, 
    plg.lat,
    IFNULL(inv.status_pembayaran, 'Belum Lunas') status_pembayaran
FROM `akun_home_wifi` akn
INNER JOIN pelanggan plg
	ON plg.id_pelanggan = akn.id_pelanggan
LEFT JOIN invoice_home_wifi inv
	ON inv.id_akun_home_wifi = akn.id_akun_home_wifi
WHERE
	(
        inv.tahun = YEAR(CURDATE())
    	AND
    	inv.bulan = MONTH(CURDATE())
    )
    OR
    (
    	inv.tahun IS NULL
        AND
        inv.bulan IS NULL
    )
EOT;
$pelanggan_home = $db->query($sql)->fetchAll();
$reseller_voucher = $db->select("akun_reseller",
    ["[><]pelanggan" => ["id_pelanggan" => "id_pelanggan"]],
    ["pelanggan.username_akun","pelanggan.nama", "pelanggan.lng", "pelanggan.lat"]
);

$response["data"] = [
    "jumlah_home_lunas" => $lunas,
    "jumlah_home_belum_lunas" => $belum_lunas,
    "jumlah_reseller_voucher" => $jumlah_reseller_voucher,
    "pelanggan_home" => $pelanggan_home,
    "reseller_voucher" => $reseller_voucher
];
$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);