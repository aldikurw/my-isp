<?php
require_once "../config/config.php";

$table = "paket_home_wifi";

$primaryKey = 'id_paket_home_wifi';

$i = 0;
$columns = array(
    array( 'db' => 'id_paket_home_wifi', 'dt' => $i++ ),
    array( 'db' => 'nama', 'dt' => $i++ ),
    array( 'db' => 'kecepatan', 'dt' => $i++ ),
    array( 'db' => 'harga', 'dt' => $i++ )
);

require_once( '../config/ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);