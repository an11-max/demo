<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh mục sản phẩm</title>
    <link rel="stylesheet" href="../assets/css/animation.css">
</head>

<body>
    <h2>Danh mục sản phẩm</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Ảnh</th>
            <th>Danh mục</th>
        </tr>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $prod): ?>
            <tr>
                <td><?= $prod['id'] ?></td>
                <td><?= $prod['name'] ?></td>
                <td><?= number_format($prod['price'] ?? 0) ?>đ</td>
                <td><img src="../uploads/imgproduct/<?= $prod['image'] ?>" width="60"></td>
                <td><?= isset($prod['category_name']) ? $prod['category_name'] : $prod['category'] ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Không có sản phẩm nào trong danh mục này.</td></tr>
        <?php endif; ?>
    </table>
    <a href="/?act=home">Về trang chủ</a>
</body>

</html>