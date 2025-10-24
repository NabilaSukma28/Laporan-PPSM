<?php
ob_start();
session_start();
include "assets/koneksi.php";
if (isset($_SESSION['admin'])) {
  header("Location: index.php");
  exit();
}

function createAlert($type, $message)
{
  return '<div class="alert alert-' . $type . ' alert-dismissible alert-fixed" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            ' . $message . '
            </div>';
}

if (isset($_POST['loginBtn'])) {
  $username = $koneksi->real_escape_string($_POST['username']);
  $password = $_POST['password']; // Tidak perlu real_escape_string karena akan di-hash

  // Query disesuaikan dengan tabel users yang ada di database
  $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $data = $result->fetch_assoc();

    // Verifikasi password yang di-hash
    if (password_verify($password, $data['password'])) {
      $_SESSION['admin'] = $data['id'];
      $_SESSION['nama'] = $data['nama'];
      $_SESSION['role'] = $data['role'];
      // Tidak ada id_toko di tabel users, jadi dihilangkan atau sesuaikan jika perlu

      // Update last login
      $update_stmt = $koneksi->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
      $update_stmt->bind_param("i", $data['id']);
      $update_stmt->execute();
      $update_stmt->close();

      header("Location: index.php");
      exit();
    } else {
      $_SESSION['alert'] = createAlert('danger', 'Login gagal! Username atau password salah.');
    }
  } else {
    $_SESSION['alert'] = createAlert('danger', 'Login gagal! Username atau password salah.');
  }

  header("Location: login.php");
  exit();
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Login - Alfamart Focus Marketing</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <meta name="description" content="Login page">
  <script src="assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Open+Sans:300,400,600,700"]
      },
      custom: {
        families: [
          "Flaticon",
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
        ],
        urls: ["assets/css/fonts.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/azzara.css" />
  <link rel="stylesheet" href="assets/css/mystyle.css">
  <style>
    .judul {
      height: 200px;
      width: 100%;
      color: black;
      text-align: center;
    }

    .logo {
      height: 70px;
      width: auto;
    }
  </style>
</head>

<body class="login" style="background-color:azure;">
  <?php
  if (isset($_SESSION['alert'])) {
    echo $_SESSION['alert'];
    unset($_SESSION['alert']);
  }
  ?>
  <div class="wrapper wrapper-login">
    <div class="container container-login animated fadeIn" style="background-color:darkred;">
      <div style="text-align:center;color:aliceblue">
        <h2>Log In</h2>
        <p>Aplikasi Monitoring Focus Marketing Alfamart</p>
      </div>
      <div class="login-form">
        <form role="form" action="" method="POST">
          <div class="form-group form-floating-label">
            <input
              id="username"
              name="username"
              type="text"
              class="form-control input-border-bottom"
              required />
            <label for="username" class="placeholder">Username</label>
          </div>

          <div class="form-group form-floating-label">
            <input
              id="password"
              name="password"
              type="password"
              class="form-control input-border-bottom"
              required />
            <label for="password" class="placeholder">Password</label>
            <div class="show-password">
              <i class="flaticon-interface"></i>
            </div>
          </div>

          <div class="form-action mb-3">
            <button type="submit" name="loginBtn" class="btn btn-primary btn-login">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="assets/js/core/jquery.3.2.1.min.js"></script>
  <script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/ready.js"></script>
  <script src="assets/js/MyJs.js"></script>
</body>

</html>
<?php
ob_end_flush();
?>