<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background: #f7f7f7;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    /* Floating Dashboard Button */
    .floating-dashboard {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        background: #007bff;
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        transition: all 0.3s ease;
        font-size: 24px;
    }

    .floating-dashboard:hover {
        background: #0056b3;
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        color: white;
        text-decoration: none;
    }

    .floating-dashboard:active {
        transform: scale(0.95);
    }

    .container {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px #ccc;
        padding: 32px;
    }

    h2 {
        text-align: center;
        color: #007bff;
        margin-bottom: 24px;
    }

    .search-form {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }

    .search-form input {
        flex: 1;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .search-form button {
        padding: 12px 24px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }

    .search-form button:hover {
        background: #0056b3;
    }

    .add-btn {
        display: block;
        width: 100%;
        padding: 14px;
        background: #28a745;
        color: #fff;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 24px;
        transition: background 0.2s;
    }

    .add-btn:hover {
        background: #218838;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 24px;
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    th {
        background: #e9f2fb;
        color: #007bff;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .actions a {
        margin-right: 10px;
        color: #007bff;
        text-decoration: none;
        font-size: 18px;
    }

    .actions a:hover {
        color: #0056b3;
    }

    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 2px solid #ddd;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .product-img:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        border-color: #007bff;
    }

    .no-image {
        width: 80px;
        height: 80px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 12px;
        text-align: center;
    }

    /* Modal styles */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        cursor: pointer;
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 90%;
        max-height: 90%;
    }

    .modal-image {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .modal-close {
        position: absolute;
        top: 10px;
        right: 20px;
        color: white;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
    }

    .modal-title {
        position: absolute;
        bottom: -40px;
        left: 0;
        right: 0;
        color: white;
        text-align: center;
        font-size: 16px;
    }

    .back-link {
        text-align: center;
        margin-top: 24px;
    }

    .back-link a {
        color: #555;
        text-decoration: underline;
        font-size: 16px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa-solid fa-box"></i> Quản lý sản phẩm</h2>
        <form class="search-form" method="get" action="/mvc-oop-basic-duanmau/Admin/index.php">
            <input type="hidden" name="controller" value="product">
            <input type="hidden" name="action" value="search">
            <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm..." required>
            <button type="submit"><i class="fa-solid fa-search"></i> Tìm kiếm</button>
        </form>
        <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=add" class="add-btn"><i
                class="fa-solid fa-plus"></i> Thêm sản phẩm</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Ảnh</th>
                <th>Hành động</th>
            </tr>
            <?php foreach ($products as $prod): ?>
            <tr>
                <td><?= $prod['id'] ?></td>
                <td><?= $prod['name'] ?></td>
                <td><?= number_format($prod['price'] ?? 0) ?>đ</td>
                <td><?= $prod['category_name'] ?></td>
                <td>
                    <?php if (!empty($prod['image']) && file_exists(__DIR__ . '/../../uploads/imgproduct/' . $prod['image'])): ?>
                    <img src="/mvc-oop-basic-duanmau/uploads/imgproduct/<?= htmlspecialchars($prod['image']) ?>"
                        class="product-img" alt="<?= htmlspecialchars($prod['name']) ?>" title="Click để xem ảnh lớn"
                        onclick="showImageModal('<?= htmlspecialchars($prod['image']) ?>', '<?= htmlspecialchars($prod['name']) ?>')">
                    <?php else: ?>
                    <div class="no-image">
                        <i class="fa-solid fa-image"></i><br>
                        Không có ảnh
                    </div>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=edit&id=<?= $prod['id'] ?>"
                        title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=delete&id=<?= $prod['id'] ?>"
                        onclick="return confirm('Xác nhận xóa?')" title="Xóa"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <!-- Floating Dashboard Button -->
        <a href="/mvc-oop-basic-duanmau/Admin/index.php" class="floating-dashboard" title="Về Dashboard Admin">
            <i class="fa-solid fa-home"></i>
        </a>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <span class="modal-close">&times;</span>
        <div class="modal-content" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="" class="modal-image">
            <div id="modalTitle" class="modal-title"></div>
        </div>
    </div>

    <script>
    function showImageModal(imageName, productName) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');

        modal.style.display = 'block';
        modalImg.src = '/mvc-oop-basic-duanmau/uploads/imgproduct/' + imageName;
        modalImg.alt = productName;
        modalTitle.textContent = productName;
    }

    function closeImageModal() {
        document.getElementById('imageModal').style.display = 'none';
    }


    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });
    </script>
</body>

</html>