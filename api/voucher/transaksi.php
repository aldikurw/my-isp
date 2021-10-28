<?php
require_once "../config/config.php";

$data = json_decode(file_get_contents("php://input"));

if ($_SERVER["REQUEST_METHOD"] === "GET") {

} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $values = [
        "id_akun_reseller" => $data->id_akun_reseller,
        "total" => $data->grand_total
    ];

    $db->insert("transaksi_voucher", $values);
    $id_transaksi_voucher = $db->id();

    foreach ($data->data_paket as $dp) {
        if (!empty($dp->jumlah_pembelian) && $dp->jumlah_pembelian != 0) {
            $val = [
                "id_transaksi_voucher" => $id_transaksi_voucher,
                "id_paket_voucher" => $dp->id_paket_voucher,
                "jumlah_pembelian" => $dp->jumlah_pembelian,
                "bonus" => $dp->bonus
            ];
            
            $db->insert("transaksi_voucher_detail", $val);
        }
    }

    $response["success"] = true;
    $response["message"] = "Berhasil menambahkan paket";
} elseif ($_SERVER["REQUEST_METHOD"] === "PUT") {

} elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $db->delete("transaksi_voucher", ["id_transaksi_voucher" => $_GET["id_transaksi_voucher"]]);
    
    $response["success"] = true;
    $response["message"] = "Berhasil menghapus paket";
}
echo json_encode($response);
