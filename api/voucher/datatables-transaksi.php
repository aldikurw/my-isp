<?php
require_once "../config/config.php";

$table = "view_transaksi_voucher";

$primaryKey = 'id_transaksi_voucher';

$i = 0;
$columns = array(
    array( 'db' => 'id_pelanggan', 'dt' => $i++ ),
    array( 'db' => 'id_akun_reseller', 'dt' => $i++ ),
    array( 'db' => 'id_transaksi_voucher', 'dt' => $i++ ),
    array( 'db' => 'created_at', 'dt' => $i++ ),
    array( 'db' => 'nama', 'dt' => $i++ ),
    array( 'db' => 'alamat', 'dt' => $i++ ),
    array( 'db' => 'total', 'dt' => $i++ )
);

require_once( '../config/ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);