<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm mới</title>
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
        color: #28a745;
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
        margin: 8px 0;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
    }
    
    input[type="file"]:hover {
        border-color: #28a745;
    }
    
    .product-img-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin: 8px 0;
        border: 2px solid #ddd;
        transition: all 0.3s ease;
        display: none;
    }
    
    .product-img-preview:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transform: scale(1.02);
    }
    
    #image-preview-container {
        text-align: center;
        background: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        border: 1px dashed #ccc;
        margin: 10px 0;
    }

    button {
        padding: 14px;
        background: #28a745;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
    }

    button:hover {
        background: #218838;
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
        <h2><i class="fa-solid fa-plus"></i> Thêm sản phẩm mới</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" name="name" id="name" required>
            <label for="price">Giá:</label>
            <input type="number" name="price" id="price" required>
            <label for="category_id">Danh mục:</label>
            <select name="category_id" id="category_id" required>
                <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['code']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="image">Ảnh sản phẩm: <span style="color: red;">*</span></label>
            
            <!-- Preview container -->
            <div id="image-preview-container">
                <img id="image-preview" src="" class="product-img-preview">
                <div id="no-image" style="color: #999; padding: 20px;">
                    <i class="fa-solid fa-image" style="font-size: 24px; margin-bottom: 8px;"></i><br>
                    Chưa chọn ảnh
                </div>
            </div>
            
            <input type="file" name="image" id="image" accept="image/*" required onchange="previewImage(this)">
            
            <script>
            function previewImage(input) {
                const preview = document.getElementById('image-preview');
                const noImage = document.getElementById('no-image');
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
                        noImage.style.display = 'none';
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        container.style.opacity = '1';
                        
                        // Add success effect
                        preview.style.border = '2px solid #28a745';
                        setTimeout(() => {
                            preview.style.border = '2px solid #ddd';
                        }, 1500);
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    // Reset to no image state
                    preview.style.display = 'none';
                    noImage.style.display = 'block';
                    container.style.opacity = '1';
                }
            }
            
            // Auto-submit prevention
            document.querySelector('form').addEventListener('submit', function(e) {
                const submitBtn = document.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang thêm...';
                submitBtn.disabled = true;
            });
            </script>
            <button type="submit"><i class="fa-solid fa-check"></i> Thêm sản phẩm</button>
        </form>
        <div class="back-link">
            <a href="../../Admin/index.php?controller=product&action=list">Quay lại danh sách</a>
        </div>
    </div>
</body>

</html>