<?php
require_once __DIR__ . '/../commons/function.php';
require_once __DIR__ . '/../commons/session.php';

class ReviewModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    /**
     * Lấy tất cả đánh giá với thông tin user và product
     */
    public function getAllReviews() {
        try {
            $sql = "
                SELECT 
                    r.id,
                    r.rating,
                    r.comment,
                    r.created_at,
                    u.username,
                    u.email as user_email,
                    p.name as product_name,
                    p.id as product_id
                FROM reviews r
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN products p ON r.product_id = p.id
                ORDER BY r.created_at DESC
            ";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all reviews: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy đánh giá theo ID
     */
    public function getReviewById($id) {
        try {
            $sql = "
                SELECT 
                    r.*,
                    u.username,
                    u.email as user_email,
                    p.name as product_name
                FROM reviews r
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN products p ON r.product_id = p.id
                WHERE r.id = :id
            ";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting review by ID: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy đánh giá theo sản phẩm
     */
    public function getReviewsByProduct($product_id) {
        try {
            $sql = "
                SELECT 
                    r.*,
                    u.username,
                    u.email as user_email
                FROM reviews r
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.product_id = :product_id
                ORDER BY r.created_at DESC
            ";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting reviews by product: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Thêm đánh giá mới
     */
    public function addReview($product_id, $user_id, $rating, $comment) {
        try {
            // Kiểm tra xem user đã đánh giá sản phẩm này chưa
            $checkSql = "SELECT id FROM reviews WHERE product_id = :product_id AND user_id = :user_id";
            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $checkStmt->execute();
            
            if ($checkStmt->fetch()) {
                return ['success' => false, 'message' => 'Bạn đã đánh giá sản phẩm này rồi!'];
            }

            $sql = "INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (:product_id, :user_id, :rating, :comment)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Thêm đánh giá thành công!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi khi thêm đánh giá!'];
            }
        } catch (PDOException $e) {
            error_log("Error adding review: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }

    /**
     * Xóa đánh giá
     */
    public function deleteReview($id) {
        try {
            $sql = "DELETE FROM reviews WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Xóa đánh giá thành công!'];
            } else {
                return ['success' => false, 'message' => 'Lỗi khi xóa đánh giá!'];
            }
        } catch (PDOException $e) {
            error_log("Error deleting review: " . $e->getMessage());
            return ['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }

    /**
     * Tìm kiếm đánh giá
     */
    public function searchReviews($keyword) {
        try {
            $keyword = '%' . $keyword . '%';
            $sql = "
                SELECT 
                    r.id,
                    r.rating,
                    r.comment,
                    r.created_at,
                    u.username,
                    u.email as user_email,
                    p.name as product_name,
                    p.id as product_id
                FROM reviews r
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN products p ON r.product_id = p.id
                WHERE u.username LIKE :keyword 
                   OR p.name LIKE :keyword 
                   OR r.comment LIKE :keyword
                ORDER BY r.created_at DESC
            ";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching reviews: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy thống kê đánh giá
     */
    public function getReviewStats() {
        try {
            $sql = "
                SELECT 
                    COUNT(*) as total_reviews,
                    AVG(rating) as avg_rating,
                    COUNT(CASE WHEN rating = 5 THEN 1 END) as five_star,
                    COUNT(CASE WHEN rating = 4 THEN 1 END) as four_star,
                    COUNT(CASE WHEN rating = 3 THEN 1 END) as three_star,
                    COUNT(CASE WHEN rating = 2 THEN 1 END) as two_star,
                    COUNT(CASE WHEN rating = 1 THEN 1 END) as one_star
                FROM reviews
            ";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting review stats: " . $e->getMessage());
            return false;
        }
    }
}
?>
