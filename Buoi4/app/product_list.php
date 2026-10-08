<?php

require_once __DIR__ . '/model/product.php';

$products = getAllProducts();
$pageTitle = 'Danh sách sản phẩm';

require_once __DIR__ . '/view/header.php';
?>

<h2>Danh sách sản phẩm</h2>

<p><a href="product_add.php">Thêm sản phẩm</a></p>

<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá (VNĐ)</th>
            <th>Số lượng</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($products)): ?>
            <tr>
                <td colspan="5">Chưa có sản phẩm.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= number_format($product['price'], 0, ',', '.') ?></td>
                    <td><?= $product['quantity'] ?></td>
                    <td>
                        <a href="product_edit.php?id=<?= $product['id'] ?>">Sửa</a>
                        <a href="product_delete.php?id=<?= $product['id'] ?>">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/view/footer.php'; ?>
