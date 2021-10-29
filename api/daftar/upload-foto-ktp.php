<?php
require_once "../config/config.php";

$id_calon_pelanggan = json_decode($_POST["foto_ktp"])->id_calon_pelanggan;
$target_dir = "../../assets/images/foto-ktp/calon-pelanggan/";  
$file_type = strtolower(pathinfo(basename($_FILES["foto_ktp"]["name"]), PATHINFO_EXTENSION));
$file_name = $id_calon_pelanggan . "." . $file_type;
$target_file = $target_dir . $file_name;
$uploadOk = 1;

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["foto_ktp"]["tmp_name"]);
    if ($check === false) {
        $response["message"] = "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["foto_ktp"]["size"] > 500000) {
    $response["message"] = "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if (
    $file_type != "jpg" && $file_type != "png" && $file_type != "jpeg"
    && $file_type != "gif" && $file_type != "svg"
) {
    $response["message"] = "Sorry, only JPG, JPEG, PNG, SVG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["foto_ktp"]["tmp_name"], $target_file)) {
        $db->update("calon_pelanggan", 
            ["url_foto_ktp" => $file_name], 
            ["id_calon_pelanggan" => $id_calon_pelanggan]
        );

        $response["success"] = true;
        $response["message"] = "Berhasil upload logo";
    } else {

        $response["message"] = "Sorry, there was an error uploading your file.";
    }
}

echo json_encode($response);