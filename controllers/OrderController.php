<?php
require_once __DIR__ . '/../commons/session.php';

class OrderController {
    public function Checkout() {
        safe_session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /mvc-oop-basic-duanmau/?act=login'); 
            exit;
        }
        
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $error = '❌ Giỏ hàng của bạn đang trống!';
            require './views/cart.php';
            return;
        }
        
        // Nếu là mua ngay 1 sản phẩm, lấy thông tin sản phẩm đầu tiên
        $productInfo = null;
        if (count($cart) == 1) {
            $firstProduct = array_values($cart)[0];
            $productInfo = [
                'name' => $firstProduct['name'],
                'price' => $firstProduct['price'],
                'image' => 'uploads/imgproduct/' . $firstProduct['image'],
                'description' => 'Sản phẩm chất lượng cao'
            ];
        }
        
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $userId = $_SESSION['user']['id'];
            
            // Validation phía client
            if (empty($name)) {
                $error = '❌ Vui lòng nhập họ tên!';
            } elseif (empty($address)) {
                $error = '❌ Vui lòng nhập địa chỉ giao hàng!';
            } elseif (empty($phone)) {
                $error = '❌ Vui lòng nhập số điện thoại!';
            } else {
                $total = 0;
                $items = [];
                
                foreach ($cart as $item) {
                    if (!isset($item['id'], $item['qty'], $item['price']) || $item['qty'] <= 0 || $item['price'] <= 0) {
                        $error = '❌ Giỏ hàng chứa sản phẩm không hợp lệ!';
                        break;
                    }
                    
                    $total += $item['price'] * $item['qty'];
                    $items[] = [
                        'product_id' => $item['id'],
                        'quantity' => $item['qty'], // Đổi từ 'qty' thành 'quantity'
                        'price' => $item['price']
                    ];
                }
                
                if (empty($error)) {
                    require_once './models/OrderModel.php';
                    $orderModel = new OrderModel();
                    $result = $orderModel->createOrder($userId, $name, $address, $phone, $total, $items);
                    
                    if ($result['success']) {
                        unset($_SESSION['cart']);
                        set_session_message('success', $result['message'], 'order_success');
                        header('Location: /mvc-oop-basic-duanmau/?act=order_success&id=' . $result['order_id']); 
                        exit;
                    } else {
                        $error = $result['message'];
                    }
                }
            }
        }
        
        require './views/checkout.php';
    }
    public function OrderSuccess() {
        $id = $_GET['id'] ?? 0;
        require './views/order_success.php';
    }
    public function History() {
        if (!isset($_SESSION['user'])) {
            header('Location: /mvc-oop-basic-duanmau/?act=login'); exit;
        }
        require_once './models/OrderModel.php';
        $orderModel = new OrderModel();
        // Xử lý xóa đơn hàng nếu có yêu cầu
        if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
            $orderId = (int)$_GET['delete'];
            $orderModel->deleteOrder($orderId, $_SESSION['user']['id']);
            header('Location: /mvc-oop-basic-duanmau/?act=order_history'); exit;
        }
        $orders = $orderModel->getOrdersByUser($_SESSION['user']['id']);
        require './views/order_history.php';
    }
    public function list() {
        // Kiểm tra đăng nhập admin (nên dùng session riêng cho admin)
        if (!isset($_SESSION['admin'])) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=admin&action=login'); exit;
        }
        require_once __DIR__ . '/../models/OrderModel.php';
        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrders();
        require_once __DIR__ . '/../Admin/Views/order_admin.php';
    }

    public function deleteByAdmin() {
        // Kiểm tra đăng nhập admin
        if (!isset($_SESSION['admin'])) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=admin&action=login'); 
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
            $orderId = (int)$_POST['order_id'];
            
            if ($orderId > 0) {
                require_once __DIR__ . '/../models/OrderModel.php';
                $orderModel = new OrderModel();
                
                // Debug log
                error_log("Attempting to delete order ID: " . $orderId);
                
                if ($orderModel->deleteOrderByAdmin($orderId)) {
                    // Thêm thông báo thành công vào session
                    $_SESSION['admin_message'] = "✅ Đã xóa đơn hàng #$orderId thành công!";
                    error_log("Successfully deleted order ID: " . $orderId);
                } else {
                    // Thêm thông báo lỗi vào session
                    $_SESSION['admin_error'] = "❌ Không thể xóa đơn hàng #$orderId! Có thể đơn hàng không tồn tại.";
                    error_log("Failed to delete order ID: " . $orderId);
                }
            } else {
                $_SESSION['admin_error'] = "❌ ID đơn hàng không hợp lệ!";
                error_log("Invalid order ID: " . $_POST['order_id']);
            }
        } else {
            $_SESSION['admin_error'] = "❌ Yêu cầu không hợp lệ!";
            error_log("Invalid request method or missing order_id");
        }
        
        // Redirect về trang quản lý đơn hàng
        header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=order');
        exit;
    }

    public function UpdateStatus() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['id'] != 1) {
            header('Location: /mvc-oop-basic-duanmau/?act=login'); exit;
        }
        $id = $_POST['id'] ?? 0;
        $status = $_POST['status'] ?? '';
        require_once './models/OrderModel.php';
        $orderModel = new OrderModel();
        $orderModel->updateStatus($id, $status);
        header('Location: /mvc-oop-basic-duanmau/?act=admin_orders'); exit;
    }
}