<?php
class CartController {
    public function addToCart() {
        try {
            if (session_status() === PHP_SESSION_NONE) session_start();

            // Debug: Log all POST data
            error_log("Cart Debug - POST data: " . print_r($_POST, true));
            error_log("Cart Debug - Session before: " . print_r($_SESSION['cart'] ?? 'empty', true));

            $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $qty = max(1, (int)($_POST['qty'] ?? 1));

            // Debug: Log input data
            error_log("Cart Debug - Product ID: $productId, Qty: $qty");

            if ($productId <= 0) {
                error_log("Cart Error - Invalid product ID: $productId");
                header('Location: /mvc-oop-basic-duanmau/?act=cart&error=invalid_product');
                exit;
            }

            require_once './models/ProductModel.php';
            $productModel = new ProductModel();
            $product = $productModel->getProductById($productId);

            if (!$product) {
                error_log("Cart Error - Product not found: $productId");
                header('Location: /mvc-oop-basic-duanmau/?act=cart&error=product_not_found');
                exit;
            }

            // Initialize cart if needed
            if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $key = (string)$productId;

            // Add or update cart item
            if (isset($_SESSION['cart'][$key])) {
                $_SESSION['cart'][$key]['qty'] += $qty;
                error_log("Cart Debug - Updated existing item. New qty: " . $_SESSION['cart'][$key]['qty']);
            } else {
                $_SESSION['cart'][$key] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'qty' => $qty,
                    'image' => $product['image']
                ];
                error_log("Cart Debug - Added new item: " . $product['name']);
            }

            // Set success message
            $_SESSION['cart_message'] = "Đã thêm {$qty} {$product['name']} vào giỏ hàng!";

            // Debug: Log session after
            error_log("Cart Debug - Session after: " . print_r($_SESSION['cart'], true));
            error_log("Cart Debug - About to redirect to cart page");

            // Redirect based on action
            if (isset($_POST['buy_now'])) {
                error_log("Cart Debug - Redirecting to checkout");
                header('Location: /mvc-oop-basic-duanmau/?act=checkout');
            } else {
                error_log("Cart Debug - Redirecting to cart");
                header('Location: /mvc-oop-basic-duanmau/?act=cart');
            }
            exit;

        } catch (Exception $e) {
            error_log("Cart Error - Exception: " . $e->getMessage());
            $_SESSION['cart_error'] = "Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!";
            header('Location: /mvc-oop-basic-duanmau/?act=cart');
            exit;
        }
    }

    public function showCart() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        require './views/cart.php';
    }

    public function removeFromCart() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $id = (string)($_GET['id'] ?? 0);
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /mvc-oop-basic-duanmau/?act=cart');
        exit;
    }

    public function clearCart() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['cart']);
        header('Location: /mvc-oop-basic-duanmau/?act=cart');
        exit;
    }
}