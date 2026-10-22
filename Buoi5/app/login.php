<?php

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/user.php';

$username = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username == '' || $password == '') {
        $error = 'Vui lòng nhập đầy đủ username và password.';
    } else {
        $user = getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: product_list.php');
            exit;
        } else {
            $error = 'Sai username hoặc password.';
        }
    }
}

$pageTitle = 'Đăng nhập';
require_once __DIR__ . '/view/header.php';
?>

<h2>Đăng nhập</h2>

<?php if (isset($_GET['registered'])): ?>
    <p style="color:green">Đăng ký thành công, vui lòng đăng nhập.</p>
<?php endif; ?>

<?php if ($error != ''): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="login.php">
    <p>Username: <input type="text" name="username" value="<?= htmlspecialchars($username) ?>"></p>
    <p>Password: <input type="password" name="password"></p>
    <button type="submit">Đăng nhập</button>
</form>

<p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>

<?php require_once __DIR__ . '/view/footer.php'; ?>
