<?php

require_once "config/config.php";

$data = json_decode(file_get_contents("php://input"));

$result = $db->select("calon_pelanggan", "id_calon_pelanggan", ["username_akun" => $data->username_akun, "password_akun" =>$data->password_akun]);
if (count($result)) {
    setcookie("id", $result[0], time() + (86400 * 30), "/");
    setcookie("accountLevel", "calon_pelanggan", time() + (86400 * 30), "/");

    $response["success"] = true;
    $response["message"] = "Berhasil login";
} else {
    $result = $db->select("pelanggan", "id_pelanggan", ["username_akun" => $data->username_akun, "password_akun" =>$data->password_akun]);
    if (count($result)) {
        setcookie("id", $result[0], time() + (86400 * 30), "/");
        setcookie("accountLevel", "pelanggan", time() + (86400 * 30), "/");
        
        $response["success"] = true;
        $response["message"] = "Berhasil login";   
    } else {
        $response["message"] = "Username atau password salah";   
    }
}
echo json_encode($response);