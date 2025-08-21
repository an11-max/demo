<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background: #f7f7f7;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .container {
        max-width: 500px;
        margin: 60px auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px #ccc;
        padding: 32px;
    }

    h2 {
        text-align: center;
        color: #ffc107;
        margin-bottom: 24px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    label {
        font-size: 16px;
        color: #333;
    }

    input[type="text"],
    input[type="number"],
    select {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    input[type="file"] {
        margin-top: 8px;
    }

    .product-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin: 8px 0;
        border: 2px solid #ddd;
        transition: all 0.3s ease;
    }
    
    .product-img:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transform: scale(1.02);
    }
    
    #image-preview-container {
        text-align: center;
        background: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        border: 1px dashed #ccc;
    }
    
    input[type="file"] {
        margin: 8px 0;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
    }
    
    input[type="file"]:hover {
        border-color: #ffc107;
    }

    button {
        padding: 14px;
        background: #ffc107;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }

    button:hover {
        background: #e0a800;
    }

    .back-link {
        text-align: center;
        margin-top: 24px;
    }

    .back-link a {
        color: #555;
        text-decoration: underline;
        font-size: 16px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fa-solid fa-pen-to-square"></i> Sửa sản phẩm</h2>
        <?php if (empty($product) || empty($categories)): ?>
        <div style="color:red;text-align:center;margin:40px;">Không tìm thấy dữ liệu sản phẩm hoặc danh mục!</div>
        <?php else: ?>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            <label for="price">Giá:</label>
            <input type="number" name="price" id="price" value="<?= htmlspecialchars($product['price']) ?>" required>
            <label for="category_id">Danh mục:</label>
            <select name="category" id="category" required>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['code']) ?>"
                    <?= ($cat['code'] == $product['category']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="image">Ảnh sản phẩm: <span style="color: red;">*</span></label>
            
            <!-- Preview container -->
            <div id="image-preview-container" style="margin-bottom: 10px;">
                <?php if (!empty($product['image'])): ?>
                <img id="current-image" src="/mvc-oop-basic-duanmau/uploads/imgproduct/<?= htmlspecialchars($product['image']) ?>"
                    class="product-img" style="display: block;">
                <?php else: ?>
                <img id="current-image" src="" class="product-img" style="display: none;">
                <?php endif; ?>
                <img id="new-image-preview" src="" class="product-img" style="display: none;">
            </div>
            
            <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(this)">
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($product['image']) ?>">
            
            <script>
            function previewImage(input) {
                const currentImg = document.getElementById('current-image');
                const newPreview = document.getElementById('new-image-preview');
                const container = document.getElementById('image-preview-container');
                
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    
                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Vui lòng chọn file ảnh (JPG, PNG, GIF...)');
                        input.value = '';
                        return;
                    }
                    
                    // Validate file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File ảnh quá lớn! Vui lòng chọn ảnh nhỏ hơn 5MB');
                        input.value = '';
                        return;
                    }
                    
                    // Show loading
                    container.style.opacity = '0.6';
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        // Ẩn ảnh cũ, hiển thị ảnh mới
                        currentImg.style.display = 'none';
                        newPreview.src = e.target.result;
                        newPreview.style.display = 'block';
                        container.style.opacity = '1';
                        
                        // Add success effect
                        newPreview.style.border = '2px solid #28a745';
                        setTimeout(() => {
                            newPreview.style.border = '2px solid #ddd';
                        }, 1500);
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    // Nếu không chọn file, hiển thị lại ảnh cũ
                    newPreview.style.display = 'none';
                    currentImg.style.display = 'block';
                    container.style.opacity = '1';
                }
            }
            
            // Auto-submit prevention
            document.querySelector('form').addEventListener('submit', function(e) {
                const submitBtn = document.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang cập nhật...';
                submitBtn.disabled = true;
            });
            </script>
            <button type="submit"><i class="fa-solid fa-check"></i> Cập nhật</button>
        </form>
        <?php endif; ?>
        <div class="back-link">
            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=product&action=list">Quay lại danh sách sản
                phẩm</a>
        </div>
    </div>
</body>

</html>