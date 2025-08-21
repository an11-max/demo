<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm danh mục mới</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f7f7f7; font-family: 'Segoe UI', Arial, sans-serif; }
        .container { max-width: 400px; margin: 60px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #ccc; padding: 32px; }
        h2 { text-align: center; color: #28a745; margin-bottom: 24px; }
        form { display: flex; flex-direction: column; gap: 18px; }
        label { font-size: 16px; color: #333; }
        input[type="text"] { padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 16px; }
        button { padding: 14px; background: #28a745; color: #fff; border: none; border-radius: 8px; font-size: 18px; font-weight: 500; cursor: pointer; transition: background 0.2s; }
        button:hover { background: #218838; }
        .back-link { text-align: center; margin-top: 24px; }
        .back-link a { color: #555; text-decoration: underline; font-size: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fa-solid fa-plus"></i> Thêm danh mục mới</h2>
        <form method="post">
            <label for="name">Tên danh mục:</label>
            <input type="text" name="name" id="name" required>
            <label for="code">Mã danh mục (vd: oto, xedap...):</label>
            <input type="text" name="code" id="code" required>
            <button type="submit"><i class="fa-solid fa-check"></i> Thêm danh mục</button>
        </form>
        <div class="back-link">
            <a href="/mvc-oop-basic-duanmau/Admin/index.php?controller=category&action=list">Quay lại danh sách</a>
        </div>
    </div>
</body>
</html>
