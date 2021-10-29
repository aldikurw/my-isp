<?php
require_once "../config/config.php";

$table = "view_psb";

$primaryKey = 'id_calon_pelanggan';

$i = 0;
$columns = array(
    array( 'db' => 'id_calon_pelanggan', 'dt' => $i++ ),
    array( 'db' => 'created_at', 'dt' => $i++ ),
    array( 'db' => 'nama', 'dt' => $i++ ),
    array( 'db' => 'alamat', 'dt' => $i++ ),
    array( 'db' => 'jenis_layanan', 'dt' => $i++ ),
    array( 'db' => 'status', 'dt' => $i++ )
);

require_once( '../config/ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);