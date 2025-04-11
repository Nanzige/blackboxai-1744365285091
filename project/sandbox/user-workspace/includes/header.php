<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User System</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <header class="bg-blue-500 text-white p-4">
        <nav class="flex justify-between">
            <a href="index.php" class="text-lg font-bold">Home</a>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="mr-4">Logout</a>
                    <a href="admin.php" class="mr-4">Admin</a>
                <?php else: ?>
                    <a href="login.php" class="mr-4">Login</a>
                    <a href="register.php" class="mr-4">Register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main class="p-4">
