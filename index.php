<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        die("Harap isi semua data!");
    }

    // Ambil data user
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php"); // Redirect ke dashboard
            exit;
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username tidak ditemukan!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    
</head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <h4 class="mb-3">Log in to Locativy</h4>
            <p>Welcome back! Select method to log in:</p>
            <div class="social-login">
                <button class="btn btn-outline-secondary w-100"><img src="https://img.icons8.com/color/16/000000/google-logo.png"/> Google</button>
                <!-- <button class="btn btn-outline-secondary w-100"><img src="https://img.icons8.com/fluency/16/000000/facebook.png"/> Facebook</button> -->
            </div>
            <hr>
            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">username</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password">
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input type="checkbox" id="rememberMe">
                        <label for="rememberMe"> Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none">Forgot Password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100" style="background-color: #355aa9">Log in</button>
            </form>
            <p class="mt-3">Don't have an account? <a href="regis.html">Create an account</a></p>
        </div>
        <div class="right-panel">
            <h4>Connect with every application.</h4>
            <p>Everything you need in an easily customizable dashboard.</p>
        </div>
    </div>
</body>
</html>
