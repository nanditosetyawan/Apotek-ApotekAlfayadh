<?php
session_start();
include "koneksi.php";
$status = "";
$pesan  = "";
if(isset($_POST['reset'])){

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $kode     = mysqli_real_escape_string($conn, $_POST['kode_reset']);

    $cek = mysqli_query($conn,"SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($cek);

    if($user){

        if($kode === $user['kode_reset']){

            mysqli_query($conn,"
            UPDATE users SET password='$password' 
            WHERE username='$username'
            ");

           $status = "sukses";
$pesan  = "SUKSES, Password berhasil diubah";

        } else {
            $status = "gagal";
$pesan  = " GAGAL, Kode reset salah!";
        }

    } else {
    $status = "gagal";
$pesan  = "GAGAL, User tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/lupa_password.css">
</head>
<body>

<div class="container">

    <!-- LOGO -->
    <img src="img/logo.png" alt="" width="290px">

    <!-- CARD -->
    <div class="card">
        <div class="login-box">

            <h2>Login</h2> <br>

            <form method="POST">

                <input type="text" name="username" placeholder="Username" required>

                <input type="password" name="password" placeholder="Password Baru" required>

                <input type="text" name="kode_reset" placeholder="Kode Reset" required> <br>

                <button name="reset">Reset</button>

            </form>

        </div>
    </div>

</div>

<?php if($status): ?>
<div class="popup-overlay">
    <div class="popup-box <?= $status ?>">
        <p><?= $pesan ?></p>
        <button onclick="closePopup()">Close</button>
    </div>
</div>
<?php endif; ?>

<script>
function closePopup(){
    window.location = "index.php";
}
</script>

</body>
</html>