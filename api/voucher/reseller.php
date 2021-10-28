<?php
require_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["id_akun_reseller"])) {
        $response["data"] = $db->select(
            "akun_reseller",
            ["[><]pelanggan" => ["id_pelanggan" => "id_pelanggan"]],
            [
                "pelanggan.nama",
                "pelanggan.nik",
                "pelanggan.username_akun",
                "pelanggan.password_akun",
                "pelanggan.jenis_kelamin",
                "pelanggan.kontak",
                "pelanggan.id_alamat",
                "pelanggan.jenis_pemasangan",
                "pelanggan.lng",
                "pelanggan.lat",
                "pelanggan.url_foto_ktp",
                "akun_reseller.id_akun_reseller",
                "akun_reseller.ip_router",
                "akun_reseller.tanggal_pemasangan"
            ],
            ["akun_reseller.id_akun_reseller" => $_GET["id_akun_reseller"]]
        );
        if (!empty($response["data"][0]["url_foto_ktp"])) {
            $response["data"][0]["url_foto_ktp"] = $response["data"][0]["url_foto_ktp"] . "?" . time();
        }
    } else {
        $sql = <<<EOT
            SELECT
                akn.id_akun_reseller,
                plg.nama,
                alm.nama alamat
            FROM akun_reseller akn
            INNER JOIN pelanggan plg
                ON plg.id_pelanggan = akn.id_pelanggan
            INNER JOIN alamat alm
                ON alm.id_alamat = plg.id_alamat;
        EOT;
        $response["data"] = $db->query(($sql))->fetchAll();
    }

    $response["success"] = true;
    $response["message"] = "Berhasil mendapatkan data reseller";
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $values = [
        "nama" => $data->nama,
        "jenis_kelamin" => $data->jenis_kelamin,
        "id_alamat" => $data->alamat,
        "jenis_pemasangan" => $data->jenis_pemasangan,
        "username_akun" => $data->username_akun,
        "password_akun" => $data->password_akun
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
        "ip_router" => $data->ip_router
    ];

    if (!empty($data->tanggal_pemasangan)) {
        $values["tanggal_pemasangan"] = $data->tanggal_pemasangan;
    }

    $db->insert("akun_reseller", $values);

    $response["data"] = ["id_pelanggan" => $id_pelanggan];
    $response["success"] = true;
    $response["message"] = "Berhasil menambahkan reseller";
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $values = [
        "pelanggan.username_akun" => $data->username_akun,
        "pelanggan.password_akun" => $data->password_akun,
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

    $pelanggan = $db->select("akun_reseller", ["[><]pelanggan" => ["id_pelanggan" => "id_pelanggan"]], ["akun_reseller.id_pelanggan", "pelanggan.url_foto_ktp"], ["akun_reseller.id_akun_reseller" => $_GET["id_akun_reseller"]])[0];

    if (!empty($pelanggan["url_foto_ktp"])) {
        $file = "../../assets/images/foto-ktp/" . $pelanggan["url_foto_ktp"];
        if (file_exists($file)) {
            unlink($file);
        }
    }

    $db->update("pelanggan", $values, ["id_pelanggan" => $pelanggan["id_pelanggan"]]);


    $values = [
        "ip_router" => $data->ip_router
    ];

    if (!empty($data->tanggal_pemasangan)) {
        $values["tanggal_pemasangan"] = $data->tanggal_pemasangan;
    }

    $db->update("akun_reseller", $values, ["id_akun_reseller" => $_GET["id_akun_reseller"]]);

    $response["data"] = ["id_pelanggan" => $pelanggan["id_pelanggan"]];
    $response["success"] = true;
    $response["message"] = "Berhasil menyimpan perubahan";
} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $db->delete("pelanggan", ["id_pelanggan" => $_GET["id_pelanggan"]]);
    $response["success"] = true;
    $response["message"] = "Berhasil menghapus pelanggan";
}
echo json_encode($response);
