<?php
$table = <<<EOT
(
    
)
EOT;

$primaryKey = 'id';

$i = 0;
$columns = array(
    array( 'db' => 'first_name', 'dt' => $i++ ),
    array( 'db' => 'last_name',  'dt' => $i++ ),
    array( 'db' => 'position',   'dt' => $i++ ),
    array( 'db' => 'office',     'dt' => $i++ )
);

require_once( '../config/ssp.class.php' );

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);