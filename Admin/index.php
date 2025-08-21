<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Điều hướng các chức năng admin
$controller = $_GET['controller'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

switch ($controller) {
    case 'category':
        require_once '../controllers/CategoryController.php';
        $categoryController = new CategoryController();
        switch ($action) {
            case 'list':
                $categoryController->list();
                break;
            case 'add':
                $categoryController->add();
                break;
            case 'edit':
                $categoryController->edit();
                break;
            case 'delete':
                $categoryController->delete();
                break;
            default:
                $categoryController->list();
        }
        break;
    case 'product':
        require_once '../controllers/ProductController.php';
        $productController = new ProductController();
        switch ($action) {
            case 'list':
                $productController->list();
                break;
            case 'add':
                $productController->add();
                break;
            case 'edit':
                $productController->edit();
                break;
            case 'delete':
                $productController->delete();
                break;
            case 'search':
                $productController->search();
                break;
            default:
                $productController->list();
        }
        break;
    case 'admin':
        require_once '../controllers/AdminController.php';
        $adminController = new AdminController();
        switch ($action) {
            case 'register':
                $adminController->register();
                break;
            case 'login':
                $adminController->login();
                break;
            default:
                $adminController->login();
        }
        break;
    case 'order':
        require_once '../controllers/OrderController.php';
        $orderController = new OrderController();
        switch ($action) {
            case 'delete':
                $orderController->deleteByAdmin();
                break;
            default:
                $orderController->list();
        }
        break;
    case 'user':
        require_once '../controllers/UserController.php';
        $userController = new UserController();
        switch ($action) {
            case 'list':
                $userController->list();
                break;
            case 'add':
                $userController->add();
                break;
            case 'edit':
                $userController->edit();
                break;
            case 'delete':
                $userController->delete();
                break;
            case 'search':
                $userController->search();
                break;
            case 'toggleStatus':
                $userController->toggleStatus();
                break;
            default:
                $userController->list();
        }
        break;
    case 'review':
        require_once '../controllers/ReviewController.php';
        $reviewController = new ReviewController();
        switch ($action) {
            case 'list':
                $reviewController->list();
                break;
            case 'delete':
                $reviewController->delete();
                break;
            case 'search':
                $reviewController->search();
                break;
            default:
                $reviewController->list();
        }
        break;
    default:
        require_once '../models/OrderModel.php';
        $orderModel = new OrderModel();
        $orders = $orderModel->getAllOrders();
        require_once 'Views/AdminDashboard.php';
}