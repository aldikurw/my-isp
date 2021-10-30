<?php
require_once "config/config.php";
$id_pelanggan = $_COOKIE["id_pelanggan"];
$sql = <<<EOT
SELECT
inv.tahun,
inv.bulan,
pkt.nama nama_paket,
pkt.kecepatan,
pkt.harga,
IFNULL(inv.status_pembayaran, 'Belum lunas')
FROM akun_home_wifi akn
LEFT JOIN invoice_home_wifi inv
	ON akn.id_akun_home_wifi = inv.id_akun_home_wifi
INNER JOIN paket_home_wifi pkt
	ON pkt.id_paket_home_wifi = akn.id_paket_home_wifi
WHERE akn.id_pelanggan = $id_pelanggan
AND inv.tahun = YEAR(CURDATE())
EOT;
$data = $db->query($sql)->fetchAll();

$response["data"] = $data;

echo json_encode($response);