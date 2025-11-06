<?php
include 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $address = trim($_POST["address"]);
    $mobile = trim($_POST["mobile"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO tblusers (username, address, mobile, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $username, $address, $mobile, $email, $password);

    if ($stmt->execute()) {
        $message = "<span class='text-success'>Registration successful. <a href='login.php' class='text-info'>Login now</a></span>";
    } else {
        $message = "<span class='text-danger'>Error: " . htmlspecialchars($stmt->error) . "</span>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            background-color: #1e1e1e;
            border-radius: 15px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
        }

        .register-card h3 {
            color: #00e5ff;
            margin-bottom: .5rem;
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

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
    <div class="register-card  p-5 ">
        <h3><i class='bx bx-user-plus'></i> Create an Account</h3>

        <?php if ($message): ?>
            <div class="alert alert-dismissible fade show text-center">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Enter your name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="City / Area / Street">
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile</label>
                <input type="text" name="mobile" class="form-control" placeholder="10-digit number" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Choose a strong password"
                    required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>

            <p class="form-text text-center text-white mt-3">
                Already have an account? <a href="login.php">Login here</a>
            </p>
        </form>
    </div>
</body>

</html>