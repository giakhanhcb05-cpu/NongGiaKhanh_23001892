<?php

require_once __DIR__ . '/model/product.php';

$id = 0;

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}

if (isset($_POST['id'])) {
    $id = (int) $_POST['id'];
}

$product = getProductById($id);

if ($product && isset($_POST['confirm'])) {
    deleteProduct($id);
    header('Location: product_list.php');
    exit;
}

$pageTitle = 'Xóa sản phẩm';
require_once __DIR__ . '/view/header.php';
?>

<h2>Xóa sản phẩm</h2>

<?php if (!$product): ?>
    <p>Sản phẩm không tồn tại.</p>
    <p><a href="product_list.php">Quay lại danh sách sản phẩm</a></p>
<?php else: ?>
    <p>Bạn có chắc muốn xóa sản phẩm "<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" không?</p>
    <form method="post" action="product_delete.php">
        <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
        <button type="submit" name="confirm" value="1">Xác nhận xóa</button>
        <a href="product_list.php">Hủy</a>
    </form>
<?php endif; ?>

<?php require_once __DIR__ . '/view/footer.php'; ?>
