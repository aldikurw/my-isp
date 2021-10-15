<?php
session_start();

require_once "pages.php";

$page = null;
if (isset($_GET["page"])) {
    if ($_GET["page"] === "logout") {
        session_destroy();
        header("Location: ../");
        exit();
    }
    $page = $_GET["page"];
} else {
    $page = "dashboard";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    <title>ISP</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">


    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/vendors/iconly/bold.css">
    <link rel="stylesheet" href="../assets/vendors/toastify/toastify.css">
    <link rel="stylesheet" href="../assets/vendors/datatables/datatables.min.css">

    <script src="../assets/vendors/jquery/jquery.min.js"></script>
    <script src="../assets/vendors/toastify/toastify.js"></script>



    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />


    <link rel="stylesheet" href="../assets/css/app.css">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="../assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-item ">
                            <a href="?page=dashboard" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="?page=riwayat-tagihan" class='sidebar-link'>
                                <i class="bi bi-cash-stack"></i>
                                <span>Riwayat Tagihan</span>
                            </a>
                        </li>

                        <li class="sidebar-item  ">
                            <a href="?page=lapor-gangguan" class='sidebar-link'>
                                <i class="bi bi-bookmarks-fill"></i>
                                <span>Lapor Gangguan</span>
                            </a>
                        </li>

                        <li class="sidebar-item  ">
                            <a href="?page=pengaturan" class='sidebar-link'>
                                <i class="bi bi-gear-fill"></i>
                                <span>Pengaturan</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>

        <div id="main" class='layout-navbar'>
            <header>
                <nav class="navbar navbar-expand navbar-light ">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <div class="dropdown ms-auto">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <h6 class="mb-0 text-gray-600">Febri</h6>
                                            <p class="mb-0 text-sm text-gray-600">Pelanggan</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="../assets/images/faces/3.jpg">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="icon-mid bi bi-person me-2"></i>My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <div id="main-content">

                <?php
                $found = false;
                foreach ($pages as $pg) {
                    if ($pg["name"] === $page) {
                        $found = true;
                        require_once $pg["file_name"];
                    }
                }
                if (!$found) {
                    require_once "../pages/404.html";
                }
                ?>

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2021 &copy; CV Perdana Mitra Inovasi</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendors/datatables/datatables.min.js"></script>


    <script src="../assets/js/main.js"></script>

    <script>
        document.querySelector(`a[href='?page=<?= $page ?>'].sidebar-link`).parentNode.classList.add("active")
    </script>
</body>

</html>