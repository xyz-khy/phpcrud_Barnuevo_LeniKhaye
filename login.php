<?php
session_start();
require_once 'database.php';

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if ($password === $hashed_password) {
            $_SESSION['user'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "Account not found. Check your username.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login - Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="pro-login-body">

    <div class="pro-login-wrapper">
        <div class="card pro-login-card border-0 shadow-lg">
            <div class="card-body p-5">
                
                <div class="text-center mb-4">
                    <div class="pro-icon-box mb-3 mx-auto">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Welcome Back</h3>
                    <p class="text-muted small">Please enter your credentials to access the dashboard.</p>
                </div>

                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger py-2 text-center small border-0 shadow-sm mb-4" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> <?php echo $error; ?>
                    </div>
                <?php } ?>

                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label class="form-label text-uppercase fs-7 fw-bold text-secondary tracking-wide">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" name="username" class="form-control bg-light border-start-0 py-2" placeholder="Enter your username" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-uppercase fs-7 fw-bold text-secondary tracking-wide">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-start-0 py-2" placeholder="Enter your password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-2.5 fw-semibold shadow-sm text-uppercase tracking-wide">Sign In</button>
                </form>

            </div>
            <div class="card-footer bg-light text-center py-3 border-0">
                <span class="text-muted small">Student Management System &copy; 2026</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>