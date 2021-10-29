<?php

require_once "../config/config.php";

$jumlah_psb_selesai = $db->count("calon_pelanggan", ["status[!]" => "Pending"]);
$jumlah_psb_pending = $db->count("calon_pelanggan", ["status" => "Pending"]);


$response["success"] = true;
$response["message"] = "Berhasil mendapatkan data";

echo json_encode($response);