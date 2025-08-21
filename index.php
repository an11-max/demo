<?php 
if (session_status() === PHP_SESSION_NONE) session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Require basic files
require_once './commons/env.php';
require_once './commons/function.php';

// Route
$act = $_GET['act'] ?? '/';

switch ($act) {
    case '/':
    case 'home':
    case 'products':
        // Direct home page handling
        try {
            $title = "Hòa Thủy Shop xin chào các bậc phụ huynh!";
            $thoiTiet = "Hãy cùng tìm niềm vui cho trẻ!";
            
            require_once './models/ProductModel.php';
            $productModel = new ProductModel();
            
            $search = $_GET['search'] ?? '';
            $category = $_GET['category'] ?? '';
            $minPrice = $_GET['min_price'] ?? '';
            $maxPrice = $_GET['max_price'] ?? '';

            if ($search) {
                $products = $productModel->searchProduct($search);
            } elseif ($minPrice !== '' || $maxPrice !== '' || $category !== '') {
                // Sử dụng filter theo giá
                $products = $productModel->filterProductsByPrice($minPrice, $maxPrice, $category);
            } else {
                $products = $productModel->getAllProduct();
            }

            require_once './views/trangchu.php';
            
        } catch (Exception $e) {
            echo "<div style='color:red; padding:20px; background:#ffe6e6; border:1px solid red;'>";
            echo "<h3>Error occurred:</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "</div>";
        }
        break;

    case 'product-list':
        // Dedicated product list page with advanced filtering
        try {
            require_once './models/ProductModel.php';
            $productModel = new ProductModel();
            
            $search = $_GET['search'] ?? '';
            $category = $_GET['category'] ?? '';
            $minPrice = $_GET['min_price'] ?? '';
            $maxPrice = $_GET['max_price'] ?? '';

            if ($search) {
                $products = $productModel->searchProduct($search);
            } elseif ($minPrice !== '' || $maxPrice !== '' || $category !== '') {
                // Sử dụng filter theo giá
                $products = $productModel->filterProductsByPrice($minPrice, $maxPrice, $category);
            } else {
                $products = $productModel->getAllProduct();
            }

            require_once './views/product_list.php';
            
        } catch (Exception $e) {
            echo "<div style='color:red; padding:20px; background:#ffe6e6; border:1px solid red;'>";
            echo "<h3>Error occurred:</h3>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "</div>";
        }
        break;
        
        
    case 'cart':
        // Simple cart handling
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            // Add to cart
            $productId = (int)$_POST['product_id'];
            $qty = max(1, (int)($_POST['qty'] ?? 1));
            
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            
            require_once './models/ProductModel.php';
            $productModel = new ProductModel();
            $product = $productModel->getProductById($productId);
            
            if ($product) {
                $key = (string)$productId;
                if (isset($_SESSION['cart'][$key])) {
                    $_SESSION['cart'][$key]['qty'] += $qty;
                } else {
                    $_SESSION['cart'][$key] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'qty' => $qty,
                        'image' => $product['image']
                    ];
                }
            }
        }
        require './views/cart.php';
        break;
        
    case 'add_cart':
        // Handle add to cart
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $productId = (int)$_POST['product_id'];
            $qty = max(1, (int)($_POST['qty'] ?? 1));
            
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            
            require_once './models/ProductModel.php';
            $productModel = new ProductModel();
            $product = $productModel->getProductById($productId);
            
            if ($product) {
                $key = (string)$productId;
                if (isset($_SESSION['cart'][$key])) {
                    $_SESSION['cart'][$key]['qty'] += $qty;
                } else {
                    $_SESSION['cart'][$key] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'qty' => $qty,
                        'image' => $product['image']
                    ];
                }
            }
        }
        
        if (isset($_POST['buy_now'])) {
            header('Location: /mvc-oop-basic-duanmau/?act=checkout');
        } else {
            header('Location: /mvc-oop-basic-duanmau/?act=cart');
        }
        exit;
        break;
        
    case 'remove_cart':
        $id = (string)($_GET['id'] ?? 0);
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /mvc-oop-basic-duanmau/?act=cart');
        exit;
        break;
        
    case 'clear_cart':
        unset($_SESSION['cart']);
        header('Location: /mvc-oop-basic-duanmau/?act=cart');
        exit;
        break;
        
    case 'contact':
        require './views/lienhe.php';
        break;
        
    case 'product_detail':
        require './views/product_detail.php';
        break;
        
    case 'login':
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $conn = connectDB();
            
            // Check admin login first
            $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin'] = $admin;
                header('Location: /mvc-oop-basic-duanmau/Admin/');
                exit;
            }
            
            // If not admin, check user login
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                // Check if user has admin role
                if ($user['role'] === 'admin') {
                    $_SESSION['admin'] = $user;
                    header('Location: /mvc-oop-basic-duanmau/Admin/');
                    exit;
                } else {
                    header('Location: /mvc-oop-basic-duanmau/');
                    exit;
                }
            } else {
                $error = 'Sai tên đăng nhập hoặc mật khẩu!';
            }
        }
        require './views/login.php';
        break;
        
    case 'register':
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $password2 = $_POST['password2'] ?? '';
            
            if ($password !== $password2) {
                $error = 'Mật khẩu nhập lại không khớp!';
            } else {
                $conn = connectDB();
                $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetch()) {
                    $error = 'Tên đăng nhập đã tồn tại!';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users (username, password, email, phone) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute([$username, $hash, $email, $phone])) {
                        header('Location: /mvc-oop-basic-duanmau/?act=login');
                        exit;
                    } else {
                        $error = 'Lỗi đăng ký!';
                    }
                }
            }
        }
        require './views/register.php';
        break;
        
    case 'logout':
        unset($_SESSION['user']);
        unset($_SESSION['admin']);
        header('Location: /mvc-oop-basic-duanmau/');
        exit;
        break;
        
    case 'checkout':
        // Handle checkout page
        $error = '';
        $productInfo = null;
        
        // If POST request, process the order
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            
            if (empty($name) || empty($address) || empty($phone)) {
                $error = 'Vui lòng điền đầy đủ thông tin!';
            } elseif (strlen($name) < 2) {
                $error = 'Họ tên phải có ít nhất 2 ký tự!';
            } elseif (strlen($address) < 10) {
                $error = 'Địa chỉ phải có ít nhất 10 ký tự!';
            } elseif (!preg_match('/^[0-9]{9,12}$/', $phone)) {
                $error = 'Số điện thoại phải có 9-12 chữ số!';
            } else {
                // Process order if cart is not empty
                if (!empty($_SESSION['cart'])) {
                    $conn = connectDB();
                    
                    // Create order
                    $user_id = $_SESSION['user']['id'] ?? null;
                    $total = 0;
                    
                    // Calculate total
                    foreach ($_SESSION['cart'] as $item) {
                        $total += $item['price'] * $item['qty'];
                    }
                    
                    // Validate total amount to prevent database overflow
                    // DECIMAL(15,2) can store maximum 9,999,999,999,999.99
                    if ($total > 9999999999999.99) {
                        $error = 'Tổng tiền đơn hàng quá lớn! Vui lòng chia nhỏ đơn hàng.';
                    } else {
                        // Insert order
                        $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, customer_phone, shipping_address, total_amount, status) VALUES (?, ?, ?, ?, ?, 'pending')");
                        $stmt->execute([$user_id, $name, $phone, $address, $total]);
                        $order_id = $conn->lastInsertId();
                    
                    // Insert order items
                    foreach ($_SESSION['cart'] as $item) {
                        $item_total = $item['price'] * $item['qty'];
                        
                        // Validate individual item total
                        if ($item_total > 9999999999999.99) {
                            $item_total = 9999999999999.99; // Cap at maximum allowed value
                        }
                        
                        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, total) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([$order_id, $item['id'], $item['qty'], $item['price'], $item_total]);
                    }
                    
                    // Clear cart
                    unset($_SESSION['cart']);
                    
                    // Redirect to success page
                    header('Location: /mvc-oop-basic-duanmau/?act=order_success&id=' . $order_id);
                    exit;
                    }
                } else {
                    $error = 'Giỏ hàng trống!';
                }
            }
        }
        
        // Get product info if buying single product
        if (isset($_GET['product_id'])) {
            require_once './models/ProductModel.php';
            $productModel = new ProductModel();
            $productInfo = $productModel->getProductById((int)$_GET['product_id']);
        }
        
        require './views/checkout.php';
        break;
        
    case 'order_success':
        $order_id = (int)($_GET['id'] ?? 0);
        $order = null;
        
        if ($order_id > 0) {
            $conn = connectDB();
            $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->execute([$order_id]);
            $order = $stmt->fetch();
            
            if ($order) {
                // Get order items
                $stmt = $conn->prepare("SELECT oi.*, p.name as product_name FROM order_items oi LEFT JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
                $stmt->execute([$order_id]);
                $order_items = $stmt->fetchAll();
                $order['items'] = $order_items;
            }
        }
        
        require './views/order_success.php';
        break;
        
    case 'order_history':
        if (!isset($_SESSION['user'])) {
            header('Location: /mvc-oop-basic-duanmau/?act=login');
            exit;
        }
        
        $conn = connectDB();
        
        // Handle delete order
        if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
            $order_id = (int)$_GET['delete'];
            $user_id = $_SESSION['user']['id'];
            
            try {
                // Check if order belongs to user and is deletable
                $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
                $stmt->execute([$order_id, $user_id]);
                $order = $stmt->fetch();
                
                if (!$order) {
                    $_SESSION['error'] = "Không tìm thấy đơn hàng #$order_id hoặc đơn hàng không thuộc về bạn.";
                } else {
                    // Check if order can be deleted
                    $deletable_statuses = ['pending', 'cancelled'];
                    if (in_array($order['status'], $deletable_statuses)) {
                        
                        // Start transaction
                        $conn->beginTransaction();
                        
                        // Delete order items first (due to foreign key constraint)
                        $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
                        $result1 = $stmt->execute([$order_id]);
                        
                        // Then delete the order
                        $stmt = $conn->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");
                        $result2 = $stmt->execute([$order_id, $user_id]);
                        
                        if ($result1 && $result2) {
                            $conn->commit();
                            $_SESSION['message'] = "Đơn hàng #$order_id đã được xóa thành công!";
                        } else {
                            $conn->rollback();
                            $_SESSION['error'] = "Có lỗi xảy ra khi xóa đơn hàng #$order_id.";
                        }
                        
                    } else {
                        $_SESSION['error'] = "Không thể xóa đơn hàng #$order_id. Chỉ có thể xóa đơn hàng có trạng thái 'Chờ xử lý' hoặc 'Đã hủy'. Trạng thái hiện tại: " . $order['status'];
                    }
                }
                
            } catch (Exception $e) {
                if ($conn->inTransaction()) {
                    $conn->rollback();
                }
                $_SESSION['error'] = "Lỗi hệ thống: " . $e->getMessage();
            }
            
            // Redirect to avoid resubmission
            header('Location: /mvc-oop-basic-duanmau/?act=order_history');
            exit;
        }
        
        $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$_SESSION['user']['id']]);
        $orders = $stmt->fetchAll();
        
        require './views/order_history.php';
        break;
        
    case 'review':
        if (!isset($_SESSION['user'])) {
            header('Location: /mvc-oop-basic-duanmau/?act=login');
            exit;
        }
        
        $user_id = $_SESSION['user']['id'];
        $product_id = (int)($_POST['product_id'] ?? 0);
        $rating = (int)($_POST['rating'] ?? 5);
        $comment = trim($_POST['comment'] ?? '');
        
        if ($product_id && $rating >= 1 && $rating <= 5 && $comment !== '') {
            $conn = connectDB();
            $stmt = $conn->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
            $stmt->execute([$product_id, $user_id, $rating, $comment]);
        }
        
        header('Location: /mvc-oop-basic-duanmau/?act=product_detail&id=' . $product_id);
        exit;
        break;
        
    default:
        header('Location: /mvc-oop-basic-duanmau/?act=home');
        exit;
        break;
}