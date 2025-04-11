<?php
session_start();
require_once 'includes/header.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = getDBConnection();
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pin = $_POST['pin'];

    // Implement registration logic here
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    if ($stmt->rowCount() > 0) {
        $error = "Username or email already exists.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $pin_hash = password_hash($pin, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password_hash, pin_hash) VALUES (:full_name, :username, :email, :password_hash, :pin_hash)");
        $stmt->execute(['full_name' => $full_name, 'username' => $username, 'email' => $email, 'password_hash' => $password_hash, 'pin_hash' => $pin_hash]);
        header("Location: login.php");
        exit();
    }
}
?>

<div class="max-w-md mx-auto">
    <h2 class="text-2xl font-bold mb-4">Register</h2>
    <?php if (isset($error)): ?>
        <div class="bg-red-500 text-white p-2 mb-4"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" class="border p-2 mb-4 w-full" required>
        <input type="text" name="username" placeholder="Username" class="border p-2 mb-4 w-full" required>
        <input type="email" name="email" placeholder="Email" class="border p-2 mb-4 w-full" required>
        <input type="password" name="password" placeholder="Password" class="border p-2 mb-4 w-full" required>
        <input type="text" name="pin" placeholder="PIN" class="border p-2 mb-4 w-full" required>
        <button type="submit" class="bg-blue-500 text-white p-2 w-full">Register</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
