<?php

require 'function.php';

// Cek apakah pengguna sudah login
if (isset($_SESSION['email'])) {
    header('location:index.php');
    exit();
}

// Cek login
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Periksa apakah email dan password tidak kosong
    if (!empty($email) && !empty($password)) {
        // Jalankan query dan cek hasilnya
        $cekdata = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");

        if ($cekdata) {
            $row = mysqli_fetch_assoc($cekdata);

            if ($row) {
                // Verifikasi password
                if ($password === $row['password']) { // Jika password disimpan dalam bentuk plain text (tidak disarankan)
                    // Set session
                    $_SESSION['nama'] = $row['nama'];
                    $_SESSION['email'] = $row['email'];
                    header('Location: index.php');
                    exit(); // Menghentikan eksekusi setelah header
                } else {
                    // Password salah
                    header('location:login.php?error=wrongpassword');
                    exit();
                }
            } else {
                // Email tidak ditemukan
                header('location:login.php?error=emailnotfound');
                exit();
            }
        } else {
            // Jika query gagal
            echo "Query Error: " . mysqli_error($conn);
        }
    } else {
        // Jika email atau password kosong
        header('location:login.php?error=emptyfields');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Aplikasi Peminjaman Barang</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" autocomplete="off">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                                            <input class="form-control py-4" id="inputEmailAddress" type="email"
                                                placeholder="Enter email address" name="email" required
                                                autocomplete="off" readonly
                                                onfocus="this.removeAttribute('readonly');" />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input class="form-control py-4" id="inputPassword" name="password"
                                                type="password" placeholder="Enter password" required autocomplete="off"
                                                readonly onfocus="this.removeAttribute('readonly');" />
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" id="rememberPasswordCheck"
                                                    type="checkbox" />
                                                <label class="custom-control-label" for="rememberPasswordCheck">Remember
                                                    password</label>
                                            </div>
                                        </div>
                                        <div
                                            class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" name="login">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <?php
                                if (isset($_GET['error'])) {
                                    if ($_GET['error'] == 'wrongpassword') {
                                        echo "<div class='alert alert-danger text-center'>Password salah!</div>";
                                    } elseif ($_GET['error'] == 'emailnotfound') {
                                        echo "<div class='alert alert-danger text-center'>Email tidak ditemukan!</div>";
                                    } elseif ($_GET['error'] == 'emptyfields') {
                                        echo "<div class='alert alert-danger text-center'>Email dan password harus diisi!</div>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Kuren</div>
                        <div>
                            <a href="https://www.instagram.com/rizk.rangga09/" target="_blank">Kuren</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
</body>

</html>