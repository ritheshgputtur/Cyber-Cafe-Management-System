<?php
session_start();
include 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, username, password FROM tblusers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["userid"] = $id;
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "No account found with that email.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: #1e1e1e;
            border-radius: 15px;
            padding: 2rem 2.5rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
        }

        .login-card h3 {
            color: #00e5ff;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-control {
            background-color: #2c2c2c;
            color: #fff;
            border: 1px solid #444;
        }

        .form-control:focus {
            border-color: #00e5ff;
            box-shadow: none;
        }

        .btn-success {
            background-color: #00c853;
            border: none;
        }

        .btn-success:hover {
            background-color: #00b248;
        }

        .form-text a {
            color: #00e5ff;
            text-decoration: none;
        }

        .form-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <h3><i class='bx bx-lock-alt'></i> User Login</h3>

        <?php if ($message): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Enter password">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Login</button>
            </div>
            <p class="form-text text-white text-center mt-3">
                Don't have an account? <a href="register.php">Register now</a>
            </p>
        </form>
    </div>

</body>

</html>