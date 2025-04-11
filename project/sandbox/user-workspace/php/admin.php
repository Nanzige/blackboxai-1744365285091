<?php
session_start();
require_once 'includes/header.php';
require_once 'db.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== ADMIN_USERNAME) {
    header("Location: login.php");
    exit();
}

$pdo = getDBConnection();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $registration_enabled = isset($_POST['registration_enabled']) ? 1 : 0;
    $stmt = $pdo->prepare("UPDATE settings SET registration_enabled = :registration_enabled WHERE id = 1");
    $stmt->execute(['registration_enabled' => $registration_enabled]);
}

$stmt = $pdo->query("SELECT registration_enabled FROM settings WHERE id = 1");
$setting = $stmt->fetch();
?>

<div class="max-w-md mx-auto">
    <h2 class="text-2xl font-bold mb-4">Admin Panel</h2>
    <form method="POST">
        <label class="block mb-2">
            <input type="checkbox" name="registration_enabled" value="1" <?php echo $setting['registration_enabled'] ? 'checked' : ''; ?>>
            Enable Registration
        </label>
        <button type="submit" class="bg-blue-500 text-white p-2">Save Changes</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
