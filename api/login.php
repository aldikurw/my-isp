<?php

require_once "config/config.php";

$data = json_decode(file_get_contents("php://input"));

$id = $db->select("calon_pelanggan", "id_calon_pelanggan", ["username_akun" => $data->username_akun, "password_akun" =>$data->password_akun]);
if (count($id)) {
    $response["id"] = $id[0]["id_calon_pelanggan"];
    $response["success"] = true;
    $response["message"] = "Berhasil login";
} else {
    $id = $db->select("pelanggan", "id_pelanggan", ["username_akun" => $data->username_akun, "password_akun" =>$data->password_akun]);
    if (count($id)) {
        $response["id"] = $id[0]["id_pelanggan"];
        $response["success"] = true;
        $response["message"] = "Berhasil login";   
    } else {
        $response["message"] = "Username atau password salah";   
    }
}
echo json_encode($response);