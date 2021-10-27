<?php
require_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $response["data"] = $db->select(
        "akun_home_wifi",
        ["[><]pelanggan" => ["id_pelanggan" => "id_pelanggan"]],
        [
            "pelanggan.nama",
            "pelanggan.nik",
            "pelanggan.jenis_kelamin",
            "pelanggan.kontak",
            "pelanggan.id_alamat",
            "pelanggan.jenis_pemasangan",
            "pelanggan.lng",
            "pelanggan.lat",
            "pelanggan.url_foto_ktp",
            "akun_home_wifi.id_paket_home_wifi",
            "akun_home_wifi.jenis_koneksi",
            "akun_home_wifi.ip_static",
            "akun_home_wifi.username_pppoe",
            "akun_home_wifi.password_pppoe",
            "akun_home_wifi.tanggal_pemasangan",
            "akun_home_wifi.bulan_awal_penagihan"
        ],
        ["akun_home_wifi.id_akun_home_wifi" => $_GET["id_akun_home_wifi"]]
    );
    if (!empty($response["data"][0]["url_foto_ktp"])) {
        $response["data"][0]["url_foto_ktp"] = $response["data"][0]["url_foto_ktp"] . "?" . time();
    }
    $response["success"] = true;
    $response["message"] = "Berhasil mendapatkan data pelanggan";
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
            $values["bulan_awal_penagihan"] = date("Y-m-d", strtotime('+1 month'));
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
    $values = [
        "nama" => $data->nama,
        "jenis_kelamin" => $data->jenis_kelamin,
        "id_alamat" => $data->alamat,
        "jenis_pemasangan" => $data->jenis_pemasangan,
        "nik" => $data->nik,
        "kontak" => $data->kontak,
        "lng" => $data->lng,
        "lat" => $data->lat,
        "url_foto_ktp" => ""
    ];

    if ($data->alamat === "_buat_baru") {
        $db->insert("alamat", [
            "nama" => trim($data->alamat_baru)
        ]);
        $values["id_alamat"] = $db->id();
    }

    $pelanggan = $db->select("akun_home_wifi", ["[><]pelanggan" => ["id_pelanggan" => "id_pelanggan"]], ["akun_home_wifi.id_pelanggan", "pelanggan.url_foto_ktp"], ["akun_home_wifi.id_akun_home_wifi" => $_GET["id_akun_home_wifi"]])[0];

    if (!empty($pelanggan["url_foto_ktp"])) {
        $file = "../../assets/images/foto-ktp/" . $pelanggan["url_foto_ktp"];
        if (file_exists($file)) {
            unlink($file);
        }
    }

    $db->update("pelanggan", $values, ["id_pelanggan" => $pelanggan["id_pelanggan"]]);


    $values = [
        "id_paket_home_wifi" => $data->paket,
        "jenis_koneksi" => $data->jenis_koneksi,
        "ip_static" => "",
        "username_pppoe" => "",
        "password_pppoe" => ""
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

    $db->update("akun_home_wifi", $values, ["id_akun_home_wifi" => $_GET["id_akun_home_wifi"]]);
    
    $response["data"] = ["id_pelanggan" => $pelanggan["id_pelanggan"]];
    $response["success"] = true;
    $response["message"] = "Berhasil menyimpan perubahan";
} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $db->delete("pelanggan", ["id_pelanggan" => $_GET["id_pelanggan"]]);
    $response["success"] = true;
    $response["message"] = "Berhasil menghapus pelanggan";
}
echo json_encode($response);
