<?php
require_once __DIR__ . '/../commons/function.php';
class OrderModel {
    public function createOrder($userId, $name, $address, $phone, $total, $items) {
        $conn = connectDB();
        
        // Validate dữ liệu đầu vào
        if (empty($name) || strlen(trim($name)) < 2) {
            return ['success' => false, 'message' => '❌ Họ tên phải có ít nhất 2 ký tự!'];
        }
        
        if (empty($address) || strlen(trim($address)) < 10) {
            return ['success' => false, 'message' => '❌ Địa chỉ giao hàng phải có ít nhất 10 ký tự!'];
        }
        
        if (empty($phone) || !preg_match('/^[0-9]{9,12}$/', $phone)) {
            return ['success' => false, 'message' => '❌ Số điện thoại phải có 9-12 chữ số!'];
        }
        
        if (empty($items) || !is_array($items)) {
            return ['success' => false, 'message' => '❌ Giỏ hàng trống hoặc không hợp lệ!'];
        }
        
        if ($total <= 0) {
            return ['success' => false, 'message' => '❌ Tổng tiền đơn hàng không hợp lệ!'];
        }
        
        // Kiểm tra user tồn tại
        $userStmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
        $userStmt->execute([$userId]);
        if (!$userStmt->fetch()) {
            return ['success' => false, 'message' => '❌ Người dùng không tồn tại!'];
        }
        
        // Kiểm tra tồn kho sản phẩm
        foreach ($items as $item) {
            $productStmt = $conn->prepare("SELECT id, name FROM products WHERE id = ?");
            $productStmt->execute([$item['product_id']]);
            $product = $productStmt->fetch();
            
            if (!$product) {
                return ['success' => false, 'message' => '❌ Sản phẩm ID ' . $item['product_id'] . ' không tồn tại!'];
            }
            
            if ($item['quantity'] <= 0) {
                return ['success' => false, 'message' => '❌ Số lượng sản phẩm "' . $product['name'] . '" không hợp lệ!'];
            }
            
            if ($item['price'] <= 0) {
                return ['success' => false, 'message' => '❌ Giá sản phẩm "' . $product['name'] . '" không hợp lệ!'];
            }
        }
        
        $conn->beginTransaction();
        try {
            // Lấy email từ user
            $userInfo = $conn->prepare("SELECT email FROM users WHERE id = ?");
            $userInfo->execute([$userId]);
            $user = $userInfo->fetch();
            $email = $user['email'] ?? '';
            
            // Tạo đơn hàng với schema mới
            $stmt = $conn->prepare("
                INSERT INTO orders (
                    user_id, 
                    customer_name, 
                    customer_email, 
                    customer_phone, 
                    shipping_address, 
                    total_amount, 
                    status, 
                    created_at
                ) VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())
            ");
            
            if (!$stmt->execute([$userId, $name, $email, $phone, $address, $total])) {
                $conn->rollBack();
                return ['success' => false, 'message' => '❌ Lỗi khi tạo đơn hàng trong cơ sở dữ liệu!'];
            }
            
            $orderId = $conn->lastInsertId();
            
            // Thêm chi tiết đơn hàng
            $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, total) VALUES (?, ?, ?, ?, ?)");
            foreach ($items as $item) {
                $itemTotal = $item['quantity'] * $item['price'];
                if (!$stmtItem->execute([$orderId, $item['product_id'], $item['quantity'], $item['price'], $itemTotal])) {
                    $conn->rollBack();
                    return ['success' => false, 'message' => '❌ Lỗi khi thêm chi tiết đơn hàng!'];
                }
            }
            
            $conn->commit();
            return ['success' => true, 'order_id' => $orderId, 'message' => '✅ Đặt hàng thành công!'];
            
        } catch (PDOException $e) {
            $conn->rollBack();
            error_log("Order creation error: " . $e->getMessage());
            
            // Phân loại lỗi database
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return ['success' => false, 'message' => '❌ Đơn hàng đã tồn tại, vui lòng thử lại!'];
            } elseif (strpos($e->getMessage(), 'Data too long') !== false) {
                return ['success' => false, 'message' => '❌ Dữ liệu quá dài, vui lòng kiểm tra thông tin!'];
            } elseif (strpos($e->getMessage(), 'foreign key constraint') !== false) {
                return ['success' => false, 'message' => '❌ Dữ liệu liên quan không hợp lệ!'];
            } else {
                return ['success' => false, 'message' => '❌ Lỗi hệ thống: ' . $e->getMessage()];
            }
        } catch (Exception $e) {
            $conn->rollBack();
            error_log("General order error: " . $e->getMessage());
            return ['success' => false, 'message' => '❌ Lỗi không xác định: ' . $e->getMessage()];
        }
    }

    public function getOrdersByUser($userId) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getOrderItems($orderId) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    public function getAllOrders() {
        $conn = connectDB();
        $stmt = $conn->query("
            SELECT 
                o.id, 
                o.user_id, 
                o.total_amount, 
                o.status, 
                o.customer_name, 
                o.customer_email, 
                o.customer_phone, 
                o.shipping_address, 
                o.created_at, 
                u.username 
            FROM orders o 
            LEFT JOIN users u ON o.user_id = u.id 
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function updateStatus($orderId, $status) {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $result = $stmt->execute([$status, $orderId]);
        // Không cache, luôn cập nhật trực tiếp DB
        return $result;
    }

    public function deleteOrder($orderId, $userId) {
        $conn = connectDB();
        // Chỉ xóa đơn của đúng user và trạng thái là 'pending' hoặc 'canceled'
        $stmt = $conn->prepare("DELETE FROM orders WHERE id = ? AND user_id = ? AND (status = 'pending' OR status = 'canceled')");
        return $stmt->execute([$orderId, $userId]);
    }

    public function deleteOrderByAdmin($orderId) {
        $conn = connectDB();
        
        try {
            // Kiểm tra đơn hàng có tồn tại không
            $checkStmt = $conn->prepare("SELECT id FROM orders WHERE id = ?");
            $checkStmt->execute([$orderId]);
            if (!$checkStmt->fetch()) {
                return false; // Đơn hàng không tồn tại
            }
            
            // Bắt đầu transaction
            $conn->beginTransaction();
            
            // Xóa các order_items trước (để tránh lỗi foreign key)
            $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
            $stmt->execute([$orderId]);
            
            // Xóa order
            $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
            $result = $stmt->execute([$orderId]);
            
            // Commit transaction
            $conn->commit();
            
            return $result;
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            if ($conn->inTransaction()) {
                $conn->rollback();
            }
            error_log("Error deleting order: " . $e->getMessage());
            return false;
        }
    }
}