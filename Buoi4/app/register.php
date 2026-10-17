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
    } elseif (strlen($username) > 50) {
        $error = 'Username tối đa 50 ký tự.';
    } elseif (getUserByUsername($username)) {
        $error = 'Username đã tồn tại.';
    } elseif (addUser($username, $password)) {
        header('Location: login.php?registered=1');
        exit;
    } else {
        $error = 'Đăng ký thất bại, vui lòng thử lại.';
    }
}

$pageTitle = 'Đăng ký';
require_once __DIR__ . '/view/header.php';
?>

<h2>Đăng ký</h2>

<?php if ($error != ''): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" action="register.php">
    <p>Username: <input type="text" name="username" value="<?= htmlspecialchars($username) ?>"></p>
    <p>Password: <input type="password" name="password"></p>
    <button type="submit">Đăng ký</button>
</form>

<p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>

<?php require_once __DIR__ . '/view/footer.php'; ?>
