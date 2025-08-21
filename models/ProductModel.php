<?php
require_once __DIR__ . '/../commons/function.php'; // Gọi file chứa hàm connectDB()

class ProductModel 
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả sản phẩm kèm tên danh mục (FIX: đảm bảo DISTINCT và JOIN đúng)
    public function getAllProduct()
    {
        $sql = "SELECT DISTINCT p.*, c.name AS category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category = c.id 
                ORDER BY p.id DESC";
        $stmt = $this->conn->query($sql);
        return $stmt ? $stmt->fetchAll() : [];
    }

    // Lấy sản phẩm theo mã danh mục (chuỗi, ví dụ: 'xedap', 'oto') - FIX: Sửa JOIN sai
    public function getProductByCategory($categoryCode, $excludeId = null)
    {
        if ($excludeId) {
            $sql = "SELECT DISTINCT p.*, c.name AS category_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category = c.id 
                    WHERE p.category = :category AND p.id != :excludeId 
                    ORDER BY p.id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['category' => $categoryCode, 'excludeId' => $excludeId]);
        } else {
            $sql = "SELECT DISTINCT p.*, c.name AS category_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category = c.id 
                    WHERE p.category = :category 
                    ORDER BY p.id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['category' => $categoryCode]);
        }
        return $stmt->fetchAll();
    }

    // Tìm kiếm sản phẩm theo từ khóa - FIX: Thêm DISTINCT
    public function searchProduct($keyword)
    {
        $sql = "SELECT DISTINCT * FROM products WHERE name LIKE :kw OR description LIKE :kw ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $kw = "%" . $keyword . "%";
        $stmt->bindParam(':kw', $kw, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lọc sản phẩm theo khoảng giá
    public function filterProductsByPrice($minPrice = null, $maxPrice = null, $category = null)
    {
        $sql = "SELECT DISTINCT p.*, c.name AS category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category = c.id 
                WHERE 1=1";
        $params = [];

        if ($minPrice !== null && $minPrice !== '') {
            $sql .= " AND p.price >= :minPrice";
            $params[':minPrice'] = $minPrice;
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $sql .= " AND p.price <= :maxPrice";
            $params[':maxPrice'] = $maxPrice;
        }

        if ($category !== null && $category !== '') {
            $sql .= " AND p.category = :category";
            $params[':category'] = $category;
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Lấy giá min và max để hiển thị range
    public function getPriceRange()
    {
        $sql = "SELECT MIN(price) as min_price, MAX(price) as max_price FROM products";
        $stmt = $this->conn->query($sql);
        return $stmt->fetch();
    }

    // Lấy chi tiết sản phẩm theo ID
    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Thêm sản phẩm mới
    public function addProduct($name, $price, $image, $description, $category)
    {
        $stmt = $this->conn->prepare("INSERT INTO products (name, price, image, description, category) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $price, $image, $description, $category]);
    }

    // Cập nhật sản phẩm - FIX: Thống nhất connection và clear cache
    public function update($id, $name, $price, $image, $category) {
        $sql = "UPDATE products SET name = :name, price = :price, image = :image, category = :category WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':image' => $image,
            ':category' => $category,
            ':id' => $id
        ]);
        
        // Clear any potential cache (đảm bảo dữ liệu được refresh)
        if ($result) {
            // Force refresh connection để tránh cache
            $this->conn = null;
            $this->conn = connectDB();
        }
        
        return $result;
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>