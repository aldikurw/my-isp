<?php
require_once "../config/config.php";

$target_dir = "../../assets/images/foto-ktp/";  
$file_type = strtolower(pathinfo(basename($_FILES["foto-ktp"]), PATHINFO_EXTENSION));

$target_file = $target_dir . $_GET["id_pelanggan"] . $file_type;
$uploadOk = 1;

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["foto-ktp"]["tmp_name"]);
    if ($check === false) {
        $response["message"] = "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["foto-ktp"]["size"] > 500000) {
    $response["message"] = "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "svg"
) {
    $response["message"] = "Sorry, only JPG, JPEG, PNG, SVG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $response["message"] = "Sorry, your file was not uploaded.";

    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["foto-ktp"]["tmp_name"], $target_file)) {
        $response["success"] = true;
        $response["message"] = "Berhasil upload logo";
    } else {

        $response["message"] = "Sorry, there was an error uploading your file.";
    }
}

echo json_encode($response);