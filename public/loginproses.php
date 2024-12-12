<?php
session_start();

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "umrahkeren");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    // Sanitize input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Validate if fields are not empty
    if (empty($username) || empty($password)) {
        $_SESSION['error_msg'] = "Username and password are required!";
        header("Location: login.php");
        exit();
    }

    // Fetch user based on username or email
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session for logged-in user
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_msg'] = "Incorrect password!";
        }
    } else {
        $_SESSION['error_msg'] = "User not found!";
    }

    // Redirect back to login page with error
    header("Location: login.php");
    exit();
}
?>

