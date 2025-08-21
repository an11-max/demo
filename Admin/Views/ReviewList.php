<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý đánh giá</title>
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
        max-width: 1200px;
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

    .rating-breakdown {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .rating-item {
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        text-align: center;
        min-width: 100px;
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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 24px;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    th {
        background: #e9f2fb;
        color: #007bff;
        font-weight: 600;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 18px;
    }

    .rating-stars .fa-star {
        margin-right: 2px;
    }

    .rating-stars .empty {
        color: #dee2e6;
    }

    .review-comment {
        max-width: 300px;
        word-wrap: break-word;
        line-height: 1.4;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(45deg, #007bff, #0056b3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
    }

    .actions a {
        margin-right: 10px;
        color: #dc3545;
        text-decoration: none;
        font-size: 16px;
        padding: 4px 8px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .actions a:hover {
        background: #f8d7da;
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

    .product-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .product-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .container {
            margin: 20px;
            padding: 20px;
        }
        
        .rating-breakdown {
            justify-content: center;
        }
        
        table {
            font-size: 14px;
        }
        
        th, td {
            padding: 8px;
        }
        
        .review-comment {
            max-width: 200px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa-solid fa-star"></i> Quản lý đánh giá sản phẩm</h2>

        <?php
        // Hiển thị thông báo
        if (get_session_message('review_delete_success')) {
            echo '<div class="message success">';
            echo '<i class="fa-solid fa-check-circle icon"></i>';
            echo htmlspecialchars(get_session_message('review_delete_success'));
            echo '</div>';
        }
        
        if (get_session_message('review_delete_error')) {
            echo '<div class="message error">';
            echo '<i class="fa-solid fa-exclamation-triangle icon"></i>';
            echo htmlspecialchars(get_session_message('review_delete_error'));
            echo '</div>';
        }
        ?>

        <?php if ($stats): ?>
        <!-- Phân tích theo sao -->
        <div class="rating-breakdown">
            <div class="rating-item">
                <strong>5 ⭐</strong><br>
                <?= $stats['five_star'] ?? 0 ?> đánh giá
            </div>
            <div class="rating-item">
                <strong>4 ⭐</strong><br>
                <?= $stats['four_star'] ?? 0 ?> đánh giá
            </div>
            <div class="rating-item">
                <strong>3 ⭐</strong><br>
                <?= $stats['three_star'] ?? 0 ?> đánh giá
            </div>
            <div class="rating-item">
                <strong>2 ⭐</strong><br>
                <?= $stats['two_star'] ?? 0 ?> đánh giá
            </div>
            <div class="rating-item">
                <strong>1 ⭐</strong><br>
                <?= $stats['one_star'] ?? 0 ?> đánh giá
            </div>
        </div>
        <?php endif; ?>

        <!-- Tìm kiếm -->
        <form class="search-form" method="get" action="/mvc-oop-basic-duanmau/Admin/index.php">
            <input type="hidden" name="controller" value="review">
            <input type="hidden" name="action" value="search">
            <input type="text" name="keyword" placeholder="Tìm kiếm theo tên user, sản phẩm, nội dung..." 
                   value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            <button type="submit"><i class="fa-solid fa-search"></i> Tìm kiếm</button>
        </form>

        <!-- Bảng đánh giá -->
        <table>
            <tr>
                <th>ID</th>
                <th>Người dùng</th>
                <th>Sản phẩm</th>
                <th>Đánh giá</th>
                <th>Bình luận</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?= $review['id'] ?></td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">
                                <?= strtoupper(substr($review['username'] ?? 'U', 0, 1)) ?>
                            </div>
                            <div>
                                <strong><?= htmlspecialchars($review['username'] ?? 'Unknown') ?></strong><br>
                                <small><?= htmlspecialchars($review['user_email'] ?? '') ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="/mvc-oop-basic-duanmau/?act=product_detail&id=<?= $review['product_id'] ?>" 
                           class="product-link" target="_blank">
                            <?= htmlspecialchars($review['product_name'] ?? 'Sản phẩm không tồn tại') ?>
                        </a>
                    </td>
                    <td>
                        <div class="rating-stars">
                            <?php 
                            $rating = $review['rating'] ?? 0;
                            for ($i = 1; $i <= 5; $i++): 
                            ?>
                                <i class="fa-solid fa-star <?= $i <= $rating ? '' : 'empty' ?>"></i>
                            <?php endfor; ?>
                            <span style="color: #666; margin-left: 5px;">(<?= $rating ?>/5)</span>
                        </div>
                    </td>
                    <td>
                        <div class="review-comment">
                            <?= htmlspecialchars($review['comment'] ?? '') ?>
                        </div>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></td>
                    <td class="actions">
                        <a href="javascript:void(0)" 
                           onclick="confirmDeleteReview(<?= $review['id'] ?>, '<?= htmlspecialchars($review['username'] ?? 'Unknown', ENT_QUOTES) ?>')"
                           title="Xóa đánh giá">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #888; padding: 40px;">
                        <i class="fa-solid fa-star" style="font-size: 48px; margin-bottom: 16px; color: #ddd;"></i><br>
                        <?= isset($_GET['keyword']) && $_GET['keyword'] ? 'Không tìm thấy đánh giá nào!' : 'Chưa có đánh giá nào!' ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>

        <!-- Floating Dashboard Button -->
        <a href="/mvc-oop-basic-duanmau/Admin/index.php" class="floating-dashboard" title="Về Dashboard Admin">
            <i class="fa-solid fa-home"></i>
        </a>
    </div>

    <script>
    function confirmDeleteReview(reviewId, username) {
        const message = `⚠️ CẢNH BÁO: Bạn có chắc chắn muốn xóa đánh giá của "${username}"?\n\n` +
                       `🚨 HÀNH ĐỘNG NÀY KHÔNG THỂ HOÀN TÁC!\n\n` +
                       `✅ Nhấn "OK" để xác nhận xóa\n` +
                       `❌ Nhấn "Cancel" để hủy bỏ`;
        
        if (confirm(message)) {
            window.location.href = `/mvc-oop-basic-duanmau/Admin/index.php?controller=review&action=delete&id=${reviewId}`;
        }
    }
    </script>
</body>

</html>
