<?php
session_start();
include 'config.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

include "includes/header.php";

$userid = $_SESSION['userid'];
$message = '';

// Fetch user details
$stmt = $conn->prepare("SELECT username, address, mobile, email FROM tblusers WHERE id = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($username, $address, $mobile, $email);
$stmt->fetch();
$stmt->close();

// Update logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = trim($_POST["username"]);
    $new_address = trim($_POST["address"]);
    $new_mobile = trim($_POST["mobile"]);
    $new_password = $_POST["password"];

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update = $conn->prepare("UPDATE tblusers SET username=?, address=?, mobile=?, password=? WHERE id=?");
        $update->bind_param("ssssi", $new_username, $new_address, $new_mobile, $hashed_password, $userid);
    } else {
        $update = $conn->prepare("UPDATE tblusers SET username=?, address=?, mobile=? WHERE id=?");
        $update->bind_param("sssi", $new_username, $new_address, $new_mobile, $userid);
    }

    if ($update->execute()) {
        $message = "<span class='text-success'>Profile updated successfully.</span>";
        $_SESSION["username"] = $new_username;
        $username = $new_username;
        $address = $new_address;
        $mobile = $new_mobile;
    } else {
        $message = "<span class='text-danger'>Error updating profile.</span>";
    }

    $update->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
        }

        .profile-card {
            background-color: #1e1e1e;
            border-radius: 15px;
            padding: 2rem;
            max-width: 600px;
            margin: 5% auto;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
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
            background-color: #00c853;
            border: none;
        }

        .btn-primary:hover {
            background-color: #00b248;
        }
    </style>
</head>

<body>

    <div class="profile-card">
        <h3 class="text-info mb-4 text-center"><i class='bx bx-user-circle'></i> Manage Profile</h3>

        <?php if ($message): ?>
            <div class="alert alert-dismissible fade show text-center"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($address) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Mobile</label>
                <input type="text" name="mobile" class="form-control" value="<?= htmlspecialchars($mobile) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email (readonly)</label>
                <input type="email" class="form-control" value="<?= htmlspecialchars($email) ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">New Password <small class="text-muted">(Leave blank to keep
                        current)</small></label>
                <input type="password" name="password" class="form-control"
                    placeholder="Enter new password if changing">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </form>
    </div>

</body>
<?php include "includes/footer.php"; ?>

</html>