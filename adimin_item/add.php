<?php
// 数据库连接
require_once '../db.php';

// 如果表单已提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $code = $_POST['code'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // 检查重复商品码
    $sql_check_duplicate = "SELECT * FROM items WHERE code = :code";
    $stmt_check_duplicate = $pdo->prepare($sql_check_duplicate);
    $stmt_check_duplicate->execute(['code' => $code]);
    $existing_item = $stmt_check_duplicate->fetch();

    if ($existing_item) {
        // 如果找到重复商品码，显示错误消息
        $error = "商品コード {$code} はすでに存在します。";
    } else {
        // 否则，执行插入操作
        $sql_insert = "INSERT INTO items (code, name, price, stock) VALUES (:code, :name, :price, :stock)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute(['code' => $code, 'name' => $name, 'price' => $price, 'stock' => $stock]);

        // 显示成功消息
        $success = "商品が追加されました。";
    }
}

// 获取商品列表
$sql_select_items = "SELECT * FROM items";
$stmt_select_items = $pdo->query($sql_select_items);
$items = $stmt_select_items->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 22px); /* 考虑边框宽度 */
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>商品管理</h1>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <!-- 商品列表 -->
        <ul>
            <?php foreach ($items as $item): ?>
                <li><?php echo $item['code']; ?>: <?php echo $item['name']; ?></li>
            <?php endforeach; ?>
        </ul>

        <!-- 商品追加表单 -->
        <h2>商品追加</h2>
        <form action="" method="post">
            <label for="code">商品コード：</label>
            <input type="text" id="code" name="code" required><br>
            <label for="name">商品名：</label>
            <input type="text" id="name" name="name" required><br>
            <label for="price">価格：</label>
            <input type="number" id="price" name="price" required><br>
            <label for="stock">在庫数：</label>
            <input type="number" id="stock" name="stock" required><br>
            <input type="submit" value="追加">
        </form>
         <!-- 回到首页按钮 -->
         <div style="text-align: center; margin-top: 20px;">
            <a href="/MY_SHOP/adimin_item/index.php">ホームに戻る</a>
        </div>
    </div>
</body>
</html>