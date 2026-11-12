<?php
header('Content-Type: application/json; charset=utf-8');

function respond($body, $code = 200)
{
    http_response_code($code);
    echo json_encode($body, JSON_UNESCAPED_UNICODE);
    exit;
}

function fail($message, $code = 400)
{
    respond(['success' => false, 'message' => $message], $code);
}

try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=buoi8_products;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    fail('Không kết nối được cơ sở dữ liệu', 500);
}

// Chỉ nhận số nguyên hoặc chuỗi số nguyên; từ chối bool, số thực, null, chuỗi rỗng
function toInt($v)
{
    if (is_int($v)) {
        return $v;
    }
    if (is_string($v) && preg_match('/^-?\d{1,18}$/', trim($v))) {
        return (int) $v;
    }
    return null;
}

// Đọc và kiểm tra dữ liệu JSON, trả về [name, price, stock]
function readInput()
{
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)) {
        fail('Dữ liệu gửi lên không phải JSON hợp lệ');
    }
    // trim cả khoảng trắng NBSP (U+00A0)
    $name = isset($data['name']) && is_string($data['name'])
        ? (string) preg_replace('/^[\s\x{00A0}]+|[\s\x{00A0}]+$/u', '', $data['name'])
        : '';
    $len = mb_strlen($name, 'UTF-8');
    if ($len < 1 || $len > 100) {
        fail('Tên sản phẩm phải từ 1 đến 100 ký tự');
    }
    $price = toInt($data['price'] ?? null);
    if ($price === null || $price <= 0 || $price > 2147483647) {
        fail('Đơn giá phải là số nguyên lớn hơn 0');
    }
    $stock = toInt($data['stock'] ?? null);
    if ($stock === null || $stock < 0 || $stock > 2147483647) {
        fail('Số lượng tồn phải là số nguyên không âm');
    }
    return [$name, $price, $stock];
}

function requireId()
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === false || $id === null || $id <= 0) {
        fail('Thiếu hoặc sai id sản phẩm');
    }
    return $id;
}

function productExists($pdo, $id)
{
    $st = $pdo->prepare('SELECT 1 FROM products WHERE id = ?');
    $st->execute([$id]);
    return (bool) $st->fetchColumn();
}

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $rows = $pdo->query('SELECT id, name, price, stock FROM products ORDER BY id')->fetchAll();
            respond(['success' => true, 'data' => $rows]);

        case 'POST':
            [$name, $price, $stock] = readInput();
            $st = $pdo->prepare('INSERT INTO products (name, price, stock) VALUES (?, ?, ?)');
            $st->execute([$name, $price, $stock]);
            respond(['success' => true, 'message' => 'Đã thêm sản phẩm', 'id' => (int) $pdo->lastInsertId()], 201);

        case 'PUT':
            $id = requireId();
            [$name, $price, $stock] = readInput();
            if (!productExists($pdo, $id)) {
                fail('Sản phẩm không tồn tại', 404);
            }
            $st = $pdo->prepare('UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?');
            $st->execute([$name, $price, $stock, $id]);
            respond(['success' => true, 'message' => 'Đã cập nhật sản phẩm']);

        case 'DELETE':
            $id = requireId();
            if (!productExists($pdo, $id)) {
                fail('Sản phẩm không tồn tại', 404);
            }
            $st = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $st->execute([$id]);
            respond(['success' => true, 'message' => 'Đã xóa sản phẩm']);

        default:
            header('Allow: GET, POST, PUT, DELETE');
            fail('Phương thức không được hỗ trợ', 405);
    }
} catch (PDOException $e) {
    fail('Lỗi cơ sở dữ liệu', 500);
}
