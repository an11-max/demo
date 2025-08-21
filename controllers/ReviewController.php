<?php
require_once __DIR__ . '/../models/ReviewModel.php';
require_once __DIR__ . '/../commons/session.php';

class ReviewController {
    private $reviewModel;
    
    public function __construct() {
        $this->reviewModel = new ReviewModel();
    }

    /**
     * Hiển thị danh sách đánh giá cho admin
     */
    public function list() {
        safe_session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php');
            exit;
        }

        $reviews = $this->reviewModel->getAllReviews();
        $stats = $this->reviewModel->getReviewStats();
        
        include __DIR__ . '/../Admin/Views/ReviewList.php';
    }

    /**
     * Tìm kiếm đánh giá
     */
    public function search() {
        safe_session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php');
            exit;
        }

        $keyword = trim($_GET['keyword'] ?? '');
        if ($keyword) {
            $reviews = $this->reviewModel->searchReviews($keyword);
        } else {
            $reviews = $this->reviewModel->getAllReviews();
        }
        
        $stats = $this->reviewModel->getReviewStats();
        
        include __DIR__ . '/../Admin/Views/ReviewList.php';
    }

    /**
     * Xóa đánh giá (Admin)
     */
    public function delete() {
        safe_session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: /mvc-oop-basic-duanmau/Admin/index.php');
            exit;
        }

        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $result = $this->reviewModel->deleteReview($id);
            
            if ($result['success']) {
                set_session_message('success', $result['message'], 'review_delete_success');
            } else {
                set_session_message('error', $result['message'], 'review_delete_error');
            }
        } else {
            set_session_message('error', 'ID đánh giá không hợp lệ!', 'review_delete_error');
        }

        header('Location: /mvc-oop-basic-duanmau/Admin/index.php?controller=review&action=list');
        exit;
    }

    /**
     * Thêm đánh giá từ user
     */
    public function addReview() {
        safe_session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /mvc-oop-basic-duanmau/?act=login'); 
            exit;
        }
        
        $user_id = $_SESSION['user']['id'];
        $product_id = intval($_POST['product_id'] ?? 0);
        $rating = intval($_POST['rating'] ?? 5);
        $comment = trim($_POST['comment'] ?? '');
        
        // Validate
        if ($product_id && $rating >= 1 && $rating <= 5 && $comment !== '') {
            $result = $this->reviewModel->addReview($product_id, $user_id, $rating, $comment);
            
            if ($result['success']) {
                set_session_message('success', $result['message'], 'review_add_success');
            } else {
                set_session_message('error', $result['message'], 'review_add_error');
            }
        } else {
            set_session_message('error', 'Vui lòng điền đầy đủ thông tin đánh giá!', 'review_add_error');
        }
        
        // Redirect về trang chi tiết sản phẩm
        header('Location: /mvc-oop-basic-duanmau/?act=product_detail&id=' . $product_id); 
        exit;
    }
}
?>