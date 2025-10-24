<?php
session_start();
include "assets/koneksi.php";

// Cek session login
if (!isset($_SESSION['admin'])) {
    header("location:login.php");
    exit();
}

// Ambil data user dari database
$user_id = $_SESSION['admin'];
$user_query = $koneksi->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user_data = $user_result->fetch_assoc();
$user_query->close();

// Set default photo jika tidak ada
$user_photo = !empty($user_data['photo']) ? $user_data['photo'] : 'assets/img/default-profile.png';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Aplikasi Focus Marketing - Alfamart Focus Marketing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Aplikasi Monitoring Focus Marketing Alfamart">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Open+Sans:300,400,600,700"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"],
                urls: ['assets/css/fonts.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/azzara.css">
    <link rel="stylesheet" href="assets/css/mystyle.css">
</head>

<body>
    <div class="wrapper">
        <div class="main-header" data-background-color="red">
            <!-- Logo Header -->
            <div class="logo-header">
                <div class="logo-container">
                    <a href="index.php" class="logo-link">
                        <img src="assets/img/logo.png" alt="Company Logo" class="avatar-sm rounded-circle " style="height: 50px;width:50px;">
                    </a>
                </div>

                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fa fa-bars"></i>
                    </span>
                </button>

                <button class="topbar-toggler more" aria-label="More options"><i class="fa fa-ellipsis-v"></i></button>

                <div class="navbar-minimize">
                    <button class="btn btn-minimize btn-rounded" aria-label="Minimize navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg">
                <div class="container-fluid">
                    <div class="app-title">
                        <h2 style="color:aliceblue;">
                            Aplikasi Monitoring Focus Marketing Alfamart
                        </h2>
                    </div>

                    <style>
                        @keyframes blink {
                            0% {
                                opacity: 1;
                            }

                            50% {
                                opacity: 0.3;
                            }

                            100% {
                                opacity: 1;
                            }
                        }
                    </style>
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="<?= $user_photo; ?>" alt="User Profile" class="avatar-img rounded-circle">
                                </div>
                            </a>

                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg">
                                            <img src="<?= $user_photo; ?>" alt="Profile Image" class="avatar-img rounded">
                                        </div>
                                        <div class="u-text">
                                            <h4><?php echo htmlspecialchars($user_data['nama'] ?? 'User'); ?></h4>
                                            <p class="text-muted"><?php echo htmlspecialchars($user_data['role'] ?? 'Role'); ?></p>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalProfil">Profile</a>
                                    <a class="dropdown-item" href="logout.php">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-background"></div>
            <div class="sidebar-wrapper scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-3 mt-2">
                            <img src="<?= $user_photo; ?>" alt="User Image" class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    <span class="user-level mt-2"><?php echo "Nama: " . htmlspecialchars($user_data['nama']); ?></span>
                                    <span class="user-level mt-2"><?php echo "Role: " . htmlspecialchars($user_data['role']); ?></span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <div class="collapse in" id="collapseExample">
                                <ul class="nav">
                                    <li>
                                        <a href="#">
                                            <span class="link-collapse">Last Login: <?php echo isset($user_data['last_login']) ? date('d M Y H:i', strtotime($user_data['last_login'])) : 'Belum pernah login'; ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <ul class="nav">
                        <li class="nav-item active">
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Menu Utama</h4>
                        </li>

                        <?php if ($user_data['role'] == 'admin' || $user_data['role'] == 'gudang' || $user_data['role'] == 'keuangan'): ?>
                            <li class="nav-item">
                                <a data-toggle="collapse" href="#base">
                                    <i class="fas fa-layer-group"></i>
                                    <p>Data Master</p>
                                    <span class="caret"></span>
                                </a>
                                <div class="collapse" id="base">
                                    <ul class="nav nav-collapse">
                                        <li>
                                            <a href="?page=Toko">
                                                <span class="sub-item">Data Toko</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="?page=JenisFokus">
                                                <span class="sub-item">Jenis Fokus Marketing</span>
                                            </a>
                                        </li>
                                        <?php if ($user_data['role'] == 'admin'): ?>
                                            <li>
                                                <a href="?page=User">
                                                    <span class="sub-item">Data User</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a data-toggle="collapse" href="#transaksi">
                                <i class="fas fa-pen-square"></i>
                                <p>Input Data Transaksi</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="transaksi">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="?page=InputAktual">
                                            <span class="sub-item">Input Aktual</span>
                                        </a>
                                    </li>
                                    <?php if ($user_data['role'] == 'admin' || $user_data['role'] == 'gudang' || $user_data['role'] == 'keuangan'): ?>
                                        <li>
                                            <a href="?page=InputTarget">
                                                <span class="sub-item">Input Target</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a data-toggle="collapse" href="#laporan">
                                <i class="fas fa-file-alt"></i>
                                <p>Laporan</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="laporan">
                                <ul class="nav nav-collapse">
                                    <li>
                                        <a href="?page=LaporanHarian">
                                            <span class="sub-item">Laporan Harian</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=LaporanBulanan">
                                            <span class="sub-item">Laporan Bulanan</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=RekapArea">
                                            <span class="sub-item">Rekap Area</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="logout.php">
                                <i class="fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Modal Profil -->
        <div class="modal fade" id="modalProfil" tabindex="-1" role="dialog" aria-labelledby="modalProfilLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProfilLabel">User Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <img src="<?= $user_photo; ?>" alt="Profile Image" class="avatar-img rounded-circle" style="width: 150px; height: 150px;">
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data['nama'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data['username'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data['role'] ?? ''); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>User ID</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data['user_id'] ?? ''); ?>" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Panel utama -->
        <div class="main-panel">
            <div class="content">
                <div class="col-md-12">
                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : '';

                    // Define allowed pages based on user role
                    $allowed_pages = [
                        'Dashboard',
                        'Toko',
                        'JenisFokus',
                        'User',
                        'InputAktual',
                        'InputTarget',
                        'LaporanHarian',
                        'LaporanBulanan',
                        'RekapArea'
                    ];

                    // Additional restrictions for non-admin roles
                    if ($user_data['role'] == 'gudang' || $user_data['role'] == 'keuangan') {
                        $allowed_pages = [
                            'Dashboard',
                            'Toko',
                            'JenisFokus',
                            'InputAktual',
                            'InputTarget',
                            'LaporanHarian',
                            'LaporanBulanan',
                            'RekapArea'
                        ];
                    }

                    // Include the requested page if allowed
                    if (empty($page)) {
                        include "page/Dashboard/Dashboard.php";
                    } elseif (in_array($page, $allowed_pages) && file_exists("page/$page/$page.php")) {
                        include "page/$page/$page.php";
                    } else {
                        include "page/errors/404.php";
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Akhir panel utama -->
    </div>

    <!-- JavaScript Files -->
    <script src="assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="assets/js/plugin/moment/moment.min.js"></script>
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="assets/js/ready.js"></script>
    <script src="assets/js/MyJs.js"></script>

</body>

</html>