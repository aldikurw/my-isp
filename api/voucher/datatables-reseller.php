<?php
require_once "../config/config.php";

$table = "view_reseller";

$primaryKey = 'id_akun_reseller';

$i = 0;
$columns = array(
    array( 'db' => 'id_pelanggan', 'dt' => $i++ ),
    array( 'db' => 'id_akun_reseller', 'dt' => $i++ ),
    array( 'db' => 'nama', 'dt' => $i++ ),
    array( 'db' => 'alamat', 'dt' => $i++ ),
    array( 'db' => 'ip_router', 'dt' => $i++ ),
    array( 'db' => 'trx_bulan_ini', 'dt' => $i++ )
);

require_once( '../config/ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);