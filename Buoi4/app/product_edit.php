<?php

require_once __DIR__ . '/model/product.php';

$id = 0;
$error = '';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

$product = getProductById($id);

if ($product && $_SERVER['REQUEST_METHOD'] === 'POST') {
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
        updateProduct($id, $name, $price, $quantity);
        header('Location: product_list.php');
        exit;
    }

    $product['name'] = $name;
    $product['price'] = $price;
    $product['quantity'] = $quantity;
}

$pageTitle = 'Sửa sản phẩm';
require_once __DIR__ . '/view/header.php';
?>

<h2>Sửa sản phẩm</h2>

<?php if (!$product): ?>
    <p>Sản phẩm không tồn tại.</p>
    <p><a href="product_list.php">Quay lại danh sách sản phẩm</a></p>
<?php else: ?>
    <?php if ($error != ''): ?>
        <p><?= $error ?></p>
    <?php endif; ?>

    <form method="post" action="product_edit.php?id=<?= (int) $id ?>">
        <p>
            <label for="name">Tên sản phẩm</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" required>
        </p>
        <p>
            <label for="price">Giá</label>
            <input type="number" id="price" name="price" min="0.01" step="0.01" value="<?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') ?>" required>
        </p>
        <p>
            <label for="quantity">Số lượng</label>
            <input type="number" id="quantity" name="quantity" min="0" step="1" value="<?= htmlspecialchars($product['quantity'], ENT_QUOTES, 'UTF-8') ?>" required>
        </p>
        <button type="submit">Cập nhật</button>
        <a href="product_list.php">Quay lại</a>
    </form>
<?php endif; ?>

<?php require_once __DIR__ . '/view/footer.php'; ?>
