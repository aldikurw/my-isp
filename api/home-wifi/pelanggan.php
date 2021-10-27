<?php
require_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $values = [
        "nama" => $data->nama,
        "jenis_kelamin" => $data->jenis_kelamin,
        "id_alamat" => $data->alamat,
        "jenis_pemasangan" => $data->jenis_pemasangan
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

    $values = [
        "id_pelanggan" => $id_pelanggan,
        "id_paket_home_wifi" => $data->paket,
        "jenis_koneksi" => $data->jenis_koneksi
    ];

    if ($data->jenis_koneksi == "IP static") {
        $values["ip_static"] = $data->ip_static;
    } else {
        $values["username_pppoe"] = $data->username_pppoe;
        $values["password_pppoe"] = $data->password_pppoe;
    }

    if (!empty($data->tanggal_pemasangan)) {
        $values["tanggal_pemasangan"] = $data->tanggal_pemasangan;
    }

    switch ($data->bulan_awal_penagihan) {
        case "Bulan depan":
            $values["bulan_awal_penagihan"] = date("Y-m-d",strtotime('+1 month'));
            break;
        case "Bulan ini":
            $values["bulan_awal_penagihan"] = date("Y-m-d");
            break;
        case "Sesuai tanggal pemasangan":
            $values["bulan_awal_penagihan"] = $data->tanggal_pemasangan;
    }

    $db->insert("akun_home_wifi", $values);
    
    $response["data"] = ["id_pelanggan" => $id_pelanggan];
    $response["success"] = true;
    $response["message"] = "Berhasil menambahkan pelanggan";
    
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    
}  elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    
}
echo json_encode($response);