<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý danh mục</title>
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
        max-width: 600px;
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
    
    .message {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    
    .message.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .message.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .message .icon {
        margin-right: 8px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa-solid fa-list"></i> Quản lý danh mục sản phẩm</h2>
        
        <?php
        // Hiển thị thông báo
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (isset($_SESSION['category_delete_success'])) {
            $success = $_SESSION['category_delete_success'];
            echo '<div class="message success">';
            echo '<i class="fa-solid fa-check-circle icon"></i>';
            echo "Đã xóa danh mục '{$success['category_name']}' và {$success['products_deleted']} sản phẩm liên quan!";
            echo '</div>';
            unset($_SESSION['category_delete_success']);
        }
        
        if (isset($_SESSION['category_delete_error'])) {
            echo '<div class="message error">';
            echo '<i class="fa-solid fa-exclamation-triangle icon"></i>';
            echo htmlspecialchars($_SESSION['category_delete_error']);
            echo '</div>';
            unset($_SESSION['category_delete_error']);
        }
        ?>
        
        <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=category&action=add" class="add-btn"><i
                class="fa-solid fa-plus"></i>
            Thêm danh mục</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Hành động</th>
            </tr>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td><?= $cat['name'] ?></td>
                <td class="actions">
                    <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=category&action=edit&id=<?= $cat['id'] ?>"
                        title="Sửa"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="javascript:void(0)" onclick="confirmDeleteCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>')"
                        title="Xóa"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <!-- Floating Dashboard Button -->
        <a href="/mvc-oop-basic-duanmau/Admin/index.php" class="floating-dashboard" title="Về Dashboard Admin">
            <i class="fa-solid fa-home"></i>
        </a>
    </div>
    
    <script>
    function confirmDeleteCategory(categoryId, categoryName) {
        // Hiển thị confirm dialog với thông tin chi tiết
        const message = `⚠️ CẢNH BÁO: Bạn có chắc chắn muốn xóa danh mục "${categoryName}"?\n\n` +
                       `🚨 TẤT CẢ SẢN PHẨM TRONG DANH MỤC NÀY SẼ BỊ XÓA VĨNH VIỄN!\n\n` +
                       `✅ Nhấn "OK" để xác nhận xóa\n` +
                       `❌ Nhấn "Cancel" để hủy bỏ`;
        
        if (confirm(message)) {
            // Nếu user xác nhận, chuyển hướng đến URL xóa
            window.location.href = `/mvc-oop-basic-duanmau/Admin/index.php?controller=category&action=delete&id=${categoryId}`;
        }
    }
    </script>
</body>

</html>