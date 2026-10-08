<?php

require_once __DIR__ . '/model/product.php';

$name = '';
$price = '';
$quantity = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');

    if ($name == '') {
        $error = 'Tên sản phẩm không được để trống.';
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = 'Giá phải là số lớn hơn 0.';
    } elseif ($quantity == '' || !ctype_digit($quantity)) {
        $error = 'Số lượng phải là số nguyên lớn hơn hoặc bằng 0.';
    } else {
        addProduct($name, $price, $quantity);
        header('Location: product_list.php');
        exit;
    }
}

$pageTitle = 'Thêm sản phẩm';
require_once __DIR__ . '/view/header.php';
?>

<h2>Thêm sản phẩm</h2>

<?php if ($error != ''): ?>
    <p><?= $error ?></p>
<?php endif; ?>

<form method="post" action="product_add.php">
    <p>
        <label for="name">Tên sản phẩm</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" required>
    </p>
    <p>
        <label for="price">Giá</label>
        <input type="number" id="price" name="price" min="0.01" step="0.01" value="<?= htmlspecialchars($price, ENT_QUOTES, 'UTF-8') ?>" required>
    </p>
    <p>
        <label for="quantity">Số lượng</label>
        <input type="number" id="quantity" name="quantity" min="0" step="1" value="<?= htmlspecialchars($quantity, ENT_QUOTES, 'UTF-8') ?>" required>
    </p>
    <button type="submit">Thêm sản phẩm</button>
    <a href="product_list.php">Quay lại</a>
</form>

<?php require_once __DIR__ . '/view/footer.php'; ?>
