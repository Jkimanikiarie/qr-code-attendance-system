<?php
include ('./conn/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $emailExists = $stmt->fetchColumn();

    if ($emailExists) {
        $error = "Email already exists. Please use a different email.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error creating account.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Sign Up</h2>
        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="lecturer">Lecturer</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
        <p class="mt-3">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>