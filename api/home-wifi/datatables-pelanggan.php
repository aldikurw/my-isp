<?php
require_once "../config/config.php";

$table = "view_pelanggan_home";

$primaryKey = 'id_akun_home_wifi';

$i = 0;
$columns = array(
    array( 'db' => 'id_pelanggan', 'dt' => $i++ ),
    array( 'db' => 'id_akun_home_wifi', 'dt' => $i++ ),
    array( 'db' => 'nama', 'dt' => $i++ ),
    array( 'db' => 'alamat', 'dt' => $i++ ),
    array( 'db' => 'kecepatan', 'dt' => $i++ ),
    array( 'db' => 'koneksi', 'dt' => $i++ )
);

require_once( '../config/ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);