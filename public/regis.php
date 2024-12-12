<?php
session_start();
// Connect ke database
$conn = mysqli_connect("localhost", "root", "", "umrahkeren");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Logic untuk handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['pass'];
    $re_pass = $_POST['re_pass'];
    $agree_term = isset($_POST['agree-term']) ? true : false;

    $errors = [];

    // Validasi input
    if (empty($name) || empty($email) || empty($password) || empty($re_pass)) {
        $errors[] = "Semua field harus diisi!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid!";
    }

    if ($password !== $re_pass) {
        $errors[] = "Password tidak cocok!";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password harus minimal 8 karakter!";
    }

    if (!$agree_term) {
        $errors[] = "Anda harus menyetujui syarat dan ketentuan!";
    }

    // Cek email unik
    $sql_check = "SELECT id FROM users WHERE email = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    if ($result_check->num_rows > 0) {
        $errors[] = "Email ini sudah digunakan. Coba yang lain.";
    }

    // Simpan data jika tidak ada error
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password_hash);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_msg'] = "Akun berhasil dibuat!";
            header("Location: login.html");
            exit();
        } else {
            $errors[] = "Terjadi kesalahan. Coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="loginregis/fonts/material-icon/css/material-design-iconic-font.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="loginregis/css/loginregis.css">
</head>
<body>
    <div class="main">
        <section class="signup">
            <div class="container">
                <!-- Display errors kalo ada -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <!-- Update form action ke self -->
                        <form method="POST" class="register-form" id="register-form" >
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" <?php echo isset($_POST['agree-term']) ? 'checked' : ''; ?>/>
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in <a href="#" class="term-service">Terms of service</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="assets/img/gallery/logoumrah.png" alt="UmrahKeren"></figure>
                        <a href="login.html" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
