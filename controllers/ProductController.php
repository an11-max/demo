<?php
class ProductController
{
    public $modelProduct;

    public function __construct()
    {
        require_once __DIR__ . '/../models/ProductModel.php';
        $this->modelProduct = new ProductModel();
    }
    // Xóa sản phẩm cho admin
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelProduct->deleteProduct($id);
        }
        header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=list');
        exit;
    }
    // Hiển thị form sửa sản phẩm cho admin
    public function edit() {
        require_once __DIR__ . '/../models/ProductModel.php';
        require_once __DIR__ . '/../models/CategoryModel.php';
        $model = new ProductModel();
        $catModel = new CategoryModel();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=list');
            exit;
        }

        $product = $model->getProductById($id);
        $categories = $catModel->getAll();

        // Xử lý cập nhật khi submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $category = $_POST['category'] ?? '';
            $old_image = $_POST['old_image'] ?? '';
            $image = $old_image;

            // Xử lý upload ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imgName = basename($_FILES['image']['name']);
                $targetPath = __DIR__ . '/../uploads/imgproduct/' . $imgName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $image = $imgName;
                }
            }

            // Gọi hàm update trong model
            $model->update($id, $name, $price, $image, $category);

            // Chuyển hướng về danh sách sản phẩm
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=list');
            exit;
        }

        // Hiển thị form sửa
        require_once dirname(__DIR__) . '/Admin/Views/ProductUpdateForm.php';
    }

    // Thêm sản phẩm mới cho admin
    public function add() {
        require_once __DIR__ . '/../models/ProductModel.php';
        require_once __DIR__ . '/../models/CategoryModel.php';
        $model = new ProductModel();
        $catModel = new CategoryModel();
        $categories = $catModel->getAll();

        // Xử lý thêm sản phẩm khi submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $category = $_POST['category_id'] ?? '';
            $description = $_POST['description'] ?? '';
            $image = '';

            // Xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imgName = basename($_FILES['image']['name']);
                $targetPath = __DIR__ . '/../uploads/imgproduct/' . $imgName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $image = $imgName;
                }
            }

            // Thêm sản phẩm vào database
            $model->addProduct($name, $price, $image, $description, $category);

            // Chuyển hướng về danh sách sản phẩm
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=list');
            exit;
        }

        // Hiển thị form thêm sản phẩm
        require_once dirname(__DIR__) . '/Admin/Views/ProductAddForm.php';
    }

    // Hiển thị danh sách sản phẩm cho admin
    public function list() {
        $products = $this->modelProduct->getAllProduct();
        require_once __DIR__ . '/../Admin/Views/ProductList.php';
    }

    public function Home()
    {
        $title = "Hòa Thủy Shop xin chào các bậc phụ huynh!";
        $thoiTiet = "Hãy cùng tìm niềm vui cho trẻ!";
        $search = $_GET['search'] ?? '';
        $category = $_GET['category'] ?? '';

        if ($search) {
            $products = $this->modelProduct->searchProduct($search);
        } elseif ($category) {
            $products = $this->modelProduct->getProductByCategory($category);
        } else {
            $products = $this->modelProduct->getAllProduct();
        }

        // DEBUG: Kiểm tra sản phẩm có bị lặp không
        $productIds = [];
        $duplicates = [];
        foreach ($products as $p) {
            if (in_array($p['id'], $productIds)) {
                $duplicates[] = $p['id'];
            } else {
                $productIds[] = $p['id'];
            }
        }
        
        // Nếu có duplicate, remove chúng
        if (!empty($duplicates)) {
            $uniqueProducts = [];
            $seenIds = [];
            foreach ($products as $p) {
                if (!in_array($p['id'], $seenIds)) {
                    $uniqueProducts[] = $p;
                    $seenIds[] = $p['id'];
                }
            }
            $products = $uniqueProducts;
        }

        require_once './views/trangchu.php';
    }

    public function ProductDetail()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id || !is_numeric($id)) {
            header('Location: /mvc-oop-basic-duanmau/?act=home');
            exit;
        }

        $product = $this->modelProduct->getProductById($id);
        if (!$product) {
            header('Location: /mvc-oop-basic-duanmau/?act=home');
            exit;
        }

        $suggestedProducts = $this->modelProduct->getProductByCategory($product['category'], $id);

        require_once './views/product_detail.php';
    }

    public function Category()
    {
        $category = $_GET['category'] ?? '';
        if (!$category) {
            header('Location: /mvc-oop-basic-duanmau/?act=home');
            exit;
        }

        $products = $this->modelProduct->getProductByCategory($category);
        require_once './views/category.php';
    }

    public function Search()
    {
        $keyword = $_GET['keyword'] ?? '';
        if (!$keyword) {
            header('Location: /mvc-oop-basic-duanmau/?act=home');
            exit;
        }

        $products = $this->modelProduct->searchProduct($keyword);
        require_once __DIR__ . '/../views/search.php';
    }

    public function AddToCart()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id || !is_numeric($id)) {
            header('Location: /mvc-oop-basic-duanmau/?act=home');
            exit;
        }

        $product = $this->modelProduct->getProductById($id);
        if (!$product) {
            header('Location: /mvc-oop-basic-duanmau/?act=home');
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'qty' => 1,
                'image' => $product['image']
            ];
        }
        $_SESSION['cart'] = $cart;

        header('Location: /mvc-oop-basic-duanmau/?act=cart');
    }

    public function Cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $message = "Giỏ hàng của bạn đang trống!";
        }

        require_once './views/cart.php';
    }

    public function RemoveFromCart()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id || !is_numeric($id)) {
            header('Location: /mvc-oop-basic-duanmau/?act=cart');
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $_SESSION['cart'] = $cart;
        }

        header('Location: /mvc-oop-basic-duanmau/?act=cart');
    }

    public function Checkout()
    {
        if (!isset($_SESSION['user'])) {
        }

        require './views/checkout.php';
    }

    public function OrderSuccess()
    {
        $id = $_GET['id'] ?? 0;
        if (!$id || !is_numeric($id)) {
            header('Location: /mvc-oop-basic-duanmau/?act=home');
            exit;
        }

        require_once './models/OrderModel.php';
        $orderModel = new OrderModel();
        $order = $orderModel->getOrderItems($id);
        if (!$order) {
            header('Location: /mvc-oop-basic-duanmau/?act=home');
            exit;
        }

        require './views/order_success.php';
    }

    public function History()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /mvc-oop-basic-duanmau/?act=login');
            exit;
        }

        require_once './models/OrderModel.php';
        $orderModel = new OrderModel();

        if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
            $orderId = (int)$_GET['delete'];
            $orderModel->deleteOrder($orderId, $_SESSION['user']['id']);
            header('Location: /mvc-oop-basic-duanmau/?act=order_history');
            exit;
        }

        $orders = $orderModel->getOrdersByUser($_SESSION['user']['id']);
        require './views/order_history.php';
    }

    public function Admin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['id'] != 1) {
            header('Location: /mvc-oop-basic-duanmau/?act=login');
            exit;
        }

        require_once './models/OrderModel.php';
        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrders();
        require './views/order_admin.php';
    }

    public function UpdateStatus()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['id'] != 1) {
            header('Location: /mvc-oop-basic-duanmau/?act=login');
            exit;
        }

        $id = $_POST['id'] ?? 0;
        $status = $_POST['status'] ?? '';
        if (!$id || !is_numeric($id) || empty($status)) {
            header('Location: /mvc-oop-basic-duanmau/?act=order_admin');
            exit;
        }

        require_once './models/OrderModel.php';
        $orderModel = new OrderModel();
        $orderModel->updateStatus($id, $status);
        header('Location: /mvc-oop-basic-duanmau/?act=order_admin');
    }

    public function DeleteOrder()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['id'] != 1) {
            header('Location: /mvc-oop-basic-duanmau/?act=login');
            exit;
        }

        $id = $_POST['id'] ?? 0;
        if (!$id || !is_numeric($id)) {
            header('Location: /mvc-oop-basic-duanmau/?act=order_admin');
            exit;
        }

        require_once './models/OrderModel.php';
        $orderModel = new OrderModel();
        $orderModel->deleteOrder($id, $_SESSION['user']['id']);
        header('Location: /mvc-oop-basic-duanmau/?act=order_admin');
    }

    // Lọc sản phẩm theo giá và danh mục
    public function filter() {
        $minPrice = $_GET['min_price'] ?? '';
        $maxPrice = $_GET['max_price'] ?? '';
        $category = $_GET['category'] ?? '';
        
        // Lấy price range để hiển thị
        $priceRange = $this->modelProduct->getPriceRange();
        
        // Lọc sản phẩm
        if ($minPrice !== '' || $maxPrice !== '' || $category !== '') {
            $products = $this->modelProduct->filterProductsByPrice($minPrice, $maxPrice, $category);
        } else {
            $products = $this->modelProduct->getAllProduct();
        }
        
        // Hiển thị trang danh sách sản phẩm với filter
        require_once __DIR__ . '/../views/product_list.php';
    }

    public function __destruct()
    {
        // Có thể thêm logic dọn dẹp nếu cần
    }
}
?>