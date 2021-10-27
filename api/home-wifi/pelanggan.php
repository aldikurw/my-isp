<?php
require_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $values = [
        "nama" => $data->nama,
        "jenis_kelamin" => $data->jenis_kelamin,
        "id_alamat" => $data->alamat,
        "jenis_pemasangan" => $data->jenis_pemasangan,
        "url_foto_ktp" => ""
    ];

    if (!empty(trim($data->nik))) {
        $values["nik"] = $data->nik;
    }

    if (!empty(trim($data->kontak))) {
        $values["kontak"] = $data->kontak;
    }

    if ($data->alamat === "_buat_baru") {
        $db->insert("alamat", [
            "nama" => trim($data->alamat_baru)
        ]);
        $values["id_alamat"] = $db->id();
    }

    if (!empty(trim($data->lat))) {
        $values["lat"] = $data->lat;
    }

    if (!empty(trim($data->lng))) {
        $values["lng"] = $data->lng;
    }

    $db->insert("pelanggan", $values);
    $id_pelanggan = $db->id();
    
    $response["success"] = true;
    $response["message"] = "Berhasil menambahkan pelanggan";
    
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    
}  elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    
}
echo json_encode($response);