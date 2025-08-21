<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="assets/css/animation.css">
    <script src="assets/css/animation.js"></script>
    <style>
    body {
        font-family: Arial;
        background: #f7f7f7;
    }

    .cart-box {
        max-width: 800px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 8px #ccc;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    th {
        background: #f1f1f1;
    }

    .actions a {
        color: #e74c3c;
        text-decoration: none;
    }

    .actions a:hover {
        color: #c0392b;
    }

    .btn-clear {
        background: #e67e22;
        color: #fff;
        padding: 7px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;
    }

    .btn-clear:hover {
        background: #d35400;
    }

    .btn-add-cart {
        background: #3498db;
        color: #fff;
        padding: 10px 28px;
        text-align: center;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
        margin-top: 18px;
    }

    .btn-add-cart:hover {
        background: #2980b9;
    }

    .price-cell {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        font-weight: 600;
        color: #495057;
        border-radius: 4px;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .total-cell {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-weight: 600;
        color: #495057;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .grand-total {
        background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        font-weight: bold;
        color: #ffffff;
        font-size: 1.1em;
        border-radius: 4px;
        border: 1px solid #495057;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }
    </style>
</head>

<body>
    <div class="cart-box">
        <h2>Giỏ hàng của bạn</h2>

        <?php
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Display messages
        if (isset($_SESSION['cart_message'])) {
            echo '<div style="background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin-bottom:15px;border:1px solid #c3e6cb;">' . 
                 htmlspecialchars($_SESSION['cart_message']) . '</div>';
            unset($_SESSION['cart_message']);
        }
        
        if (isset($_SESSION['cart_error'])) {
            echo '<div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:15px;border:1px solid #f5c6cb;">' . 
                 htmlspecialchars($_SESSION['cart_error']) . '</div>';
            unset($_SESSION['cart_error']);
        }

        // Handle URL parameters for error messages
        if (isset($_GET['error'])) {
            $errorMessages = [
                'invalid_product' => 'Sản phẩm không hợp lệ!',
                'product_not_found' => 'Sản phẩm không tồn tại!'
            ];
            $errorMsg = $errorMessages[$_GET['error']] ?? 'Có lỗi xảy ra!';
            echo '<div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:15px;border:1px solid #f5c6cb;">' . 
                 htmlspecialchars($errorMsg) . '</div>';
        }
        
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            echo '<p>Giỏ hàng trống!</p>';
        } else {
            $total = 0;
            echo '<table>';
            echo '<tr><th>STT</th><th>Sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Thành tiền</th><th>Xóa</th></tr>';
            $i = 1;

            foreach ($cart as $id => $item) {
                $thanhtien = $item['price'] * $item['qty'];
                $total += $thanhtien;

                echo '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . htmlspecialchars($item['name']) . '</td>
                        <td class="price-table-cell">' . number_format($item['price'], 0, ',', '.') . 'đ</td>
                        <td>' . $item['qty'] . '</td>
                        <td class="price-total-cell">' . number_format($thanhtien, 0, ',', '.') . 'đ</td>
                        <td class="actions"><a href="/mvc-oop-basic-duanmau/?act=remove_cart&id=' . $id . '">Xóa</a></td>
                      </tr>';
            }

            echo '<tr><th colspan="4">Tổng cộng</th><th class="price-grand-total" colspan="2">' . number_format($total, 0, ',', '.') . 'đ</th></tr>';
            echo '</table>';
            echo '<form method="post" action="/mvc-oop-basic-duanmau/?act=clear_cart">
                    <button class="btn-clear" type="submit">Xóa toàn bộ</button>
                  </form>';
        }
        ?>

        <div style="margin-top:20px;">
            <a href="?act=products">&lt; Tiếp tục mua hàng</a>
        </div>

        <div style="text-align:center;margin-top:18px;">
            <a href="/mvc-oop-basic-duanmau/?act=checkout" class="btn-add-cart">Đặt hàng</a>
        </div>
    </div>
</body>

</html>