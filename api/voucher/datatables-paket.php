<?php
require_once "../config/config.php";

$table = "paket_voucher";

$primaryKey = 'id_paket_voucher';

$i = 0;
$columns = array(
    array( 'db' => 'id_paket_voucher', 'dt' => $i++ ),
    array( 'db' => 'nama', 'dt' => $i++ ),
    array( 'db' => 'kecepatan', 'dt' => $i++ ),
    array( 'db' => 'durasi', 'dt' => $i++ ),
    array( 'db' => 'harga_beli', 'dt' => $i++ ),
    array( 'db' => 'harga_jual', 'dt' => $i++ ),
    array( 'db' => 'target_bonus', 'dt' => $i++ ),
    array( 'db' => 'jumlah_bonus', 'dt' => $i++ )
);

require_once( '../config/ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);