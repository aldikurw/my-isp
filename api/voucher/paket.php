<?php
require_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $response["data"] = $db->select("paket_voucher", "*", ["id_paket_voucher" => $_GET["id_paket_voucher"]])[0];
    
    $response["success"] = true;
    $response["message"] = "Berhasil mendapatkan data paket";
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $values = [
        "nama" => $data->nama,
        "kecepatan" => $data->kecepatan,
        "durasi" => $data->durasi,
        "harga_beli" => $data->harga_beli,
        "harga_jual" => $data->harga_jual,
        "target_bonus" => $data->target_bonus,
        "jumlah_bonus" => $data->jumlah_bonus
    ];

    $db->insert("paket_voucher", $values);

    $response["success"] = true;
    $response["message"] = "Berhasil menambahkan paket";
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {
    $values = [
        "nama" => $data->nama,
        "kecepatan" => $data->kecepatan,
        "durasi" => $data->durasi,
        "harga_beli" => $data->harga_beli,
        "harga_jual" => $data->harga_jual,
        "target_bonus" => $data->target_bonus,
        "jumlah_bonus" => $data->jumlah_bonus
    ];

    $db->update("paket_voucher", $values, ["id_paket_voucher" => $_GET["id_paket_voucher"]]);

    $response["success"] = true;
    $response["message"] = "Berhasil menyimpan perubahan";
} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $db->delete("paket_voucher", ["id_paket_voucher" => $_GET["id_paket_voucher"]]);
    
    $response["success"] = true;
    $response["message"] = "Berhasil menghapus paket";
}
echo json_encode($response);
