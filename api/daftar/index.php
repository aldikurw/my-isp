
<?php
require_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $values = [
        "username_akun" => $data->username_akun,
        "password_akun" => $data->password_akun,
        "nama" => $data->nama,
        "jenis_kelamin" => $data->jenis_kelamin,
        "nik" => $data->nik,
        "kontak" => $data->kontak,
        "jenis_layanan" => $data->jenis_layanan,
        "lng" => $data->lng,
        "lat" => $data->lat
    ];

    if ($data->jenis_layanan == "Home") {
        $values["id_paket_home_wifi"] = $data->id_paket_home_wifi;
    }

    if ($data->alamat == "_alamat_lain") {
        $values["alamat_lain"] = $data->alamat_lain;
    } else {
        $values["id_alamat"] = $data->alamat;
    }

    $db->insert("calon_pelanggan", $values);
    $id_calon_pelanggan = $db->id();

    $response["data"] = ["id_calon_pelanggan" => $id_calon_pelanggan];
    $response["success"] = true;
    $response["message"] = "Berhasil menambahkan pelanggan";
}
echo json_encode($response);
