<?php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';

class CategoryModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        $stmt = $this->conn->prepare('SELECT * FROM categories ORDER BY id DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function add($name, $code) {
        $stmt = $this->conn->prepare('SELECT id FROM categories WHERE name = ? OR code = ?');
        $stmt->execute([$name, $code]);
        if ($stmt->fetch()) {
            return 'exists';
        }
        $stmt = $this->conn->prepare('INSERT INTO categories (name, code) VALUES (?, ?)');
        return $stmt->execute([$name, $code]) ? true : false;
    }

    public function update($id, $name, $code) {
        // Lấy tên cũ và mã cũ
        $stmt = $this->conn->prepare('SELECT name, code FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        $old = $stmt->fetch();
        $oldName = $old['name'] ?? '';
        $oldCode = $old['code'] ?? '';

        // Cập nhật tên và mã mới
        $stmt = $this->conn->prepare('UPDATE categories SET name = ?, code = ? WHERE id = ?');
        $result = $stmt->execute([$name, $code, $id]);

        // Cập nhật lại sản phẩm liên kết với danh mục này
        $stmt = $this->conn->prepare('UPDATE products SET category = ? WHERE category = ?');
        $stmt->execute([$code, $oldCode]);

        return $result;
    }

    public function delete($id) {
        try {
            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            $this->conn->beginTransaction();
            
            // 1. Lấy thông tin danh mục
            $stmt = $this->conn->prepare('SELECT name, code FROM categories WHERE id = ?');
            $stmt->execute([$id]);
            $cat = $stmt->fetch();
            if (!$cat) {
                $this->conn->rollback();
                return false;
            }
            
            $catName = $cat['name'];
            $catCode = $cat['code'] ?? '';
            
            // Map tên sang mã category (fallback cho dữ liệu cũ)
            $categoryMap = [
                'Xe ô tô điện trẻ em' => 'oto',
                'Xe máy điện trẻ em' => 'maydien',
                'Xe cần cẩu máy xúc' => 'cancau',
                'Xe chòi chân cho bé' => 'choichan',
                'Xe đạp trẻ em' => 'xedap',
                'Xe trượt scooter trẻ em' => 'scooter',
                'Đồ chơi cho bé' => 'dochoi',
            ];
            $finalCatCode = !empty($catCode) ? $catCode : ($categoryMap[$catName] ?? $catName);
            
            // 2. Đếm số sản phẩm sẽ bị xóa
            $stmt = $this->conn->prepare('SELECT COUNT(*) as count FROM products WHERE category = ? OR category = ?');
            $stmt->execute([$finalCatCode, $catName]);
            $productCount = $stmt->fetch()['count'] ?? 0;
            
            // 3. Xóa tất cả sản phẩm trong danh mục này
            $stmt = $this->conn->prepare('DELETE FROM products WHERE category = ? OR category = ?');
            $stmt->execute([$finalCatCode, $catName]);
            
            // 4. Xóa danh mục
            $stmt = $this->conn->prepare('DELETE FROM categories WHERE id = ?');
            $result = $stmt->execute([$id]);
            
            if ($result) {
                // Commit transaction
                $this->conn->commit();
                
                // Log thông tin xóa
                error_log("Category Delete - Deleted category '{$catName}' (ID: {$id}) and {$productCount} products");
                
                return [
                    'success' => true,
                    'category_name' => $catName,
                    'products_deleted' => $productCount
                ];
            } else {
                $this->conn->rollback();
                return false;
            }
            
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->conn->rollback();
            error_log("Category Delete Error: " . $e->getMessage());
            return false;
        }
    }
}