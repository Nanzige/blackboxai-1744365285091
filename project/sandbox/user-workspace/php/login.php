<?php
session_start();
require_once 'includes/header.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = getDBConnection();
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Implement login logic here
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<div class="max-w-md mx-auto">
    <h2 class="text-2xl font-bold mb-4">Login</h2>
    <?php if (isset($error)): ?>
        <div class="bg-red-500 text-white p-2 mb-4"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username or Email" class="border p-2 mb-4 w-full" required>
        <input type="password" name="password" placeholder="Password" class="border p-2 mb-4 w-full" required>
        <button type="submit" class="bg-blue-500 text-white p-2 w-full">Login</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
