<?php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController {
    private $model;
    public function __construct() {
        $this->model = new CategoryModel();
    }
    public function list() {
        $categories = $this->model->getAll();
        require_once dirname(__DIR__) . '/Admin/Views/CategoryList.php';
    }
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $code = $_POST['code'] ?? '';
            $this->model->add($name, $code);
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=category&action=list');
            exit;
        }
        require_once dirname(__DIR__) . '/Admin/Views/CategoryAddForm.php';
    }
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=category&action=list');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $code = $_POST['code'] ?? '';
            $this->model->update($id, $name, $code);
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=category&action=list');
            exit;
        }
        $category = $this->model->getById($id);
        require_once dirname(__DIR__) . '/Admin/Views/CategoryUpdateForm.php';
    }
    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $result = $this->model->delete($id);
            
            if (is_array($result) && $result['success']) {
                // Xóa thành công, set thông báo
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['category_delete_success'] = [
                    'category_name' => $result['category_name'],
                    'products_deleted' => $result['products_deleted']
                ];
            } else {
                // Xóa thất bại
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['category_delete_error'] = 'Có lỗi xảy ra khi xóa danh mục!';
            }
        }
        header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=category&action=list');
        exit;
    }
}