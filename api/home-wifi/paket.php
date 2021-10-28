<?php
require_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $response["data"] = $db->select("paket_home_wifi", "*", ["id_paket_home_wifi" => $_GET["id_paket_home_wifi"]])[0];
    
    $response["success"] = true;
    $response["message"] = "Berhasil mendapatkan data pelanggan";
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $values = [
        "nama" => $data->nama,
        "kecepatan" => $data->kecepatan,
        "harga" => $data->harga
    ];

    $db->insert("paket_home_wifi", $values);

    $response["success"] = true;
    $response["message"] = "Berhasil menambahkan paket";
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $values = [
        "nama" => $data->nama,
        "kecepatan" => $data->kecepatan,
        "harga" => $data->harga
    ];

    $db->update("paket_home_wifi", $values, ["id_paket_home_wifi" => $_GET["id_paket_home_wifi"]]);

    $response["success"] = true;
    $response["message"] = "Berhasil menyimpan perubahan";
} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $db->delete("paket_home_wifi", ["id_paket_home_wifi" => $_GET["id_paket_home_wifi"]]);
    
    $response["success"] = true;
    $response["message"] = "Berhasil menghapus paket";
}
echo json_encode($response);
