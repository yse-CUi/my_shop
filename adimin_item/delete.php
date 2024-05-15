<?php 
// TODO: データベースに接続
// TODO: 商品IDを取得
// TODO: 商品IDでitemsのレコードを削除するSQL
// TODO: SQLを実行
// TODO: 一覧画面に戻る

// データベースに接続
require_once '../db.php';

// 商品IDを取得
if(isset($_POST['id'])) {
    $productId = $_POST['id'];
} else {
    // 如果没有提供商品ID，可以进行错误处理，如跳转到错误页面或返回商品一览页
    header("Location: index.php");
    exit();
}

// 商品IDでitemsのレコードを削除するSQL
$sql = "DELETE FROM items WHERE id = :id";

// SQLを実行
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $productId, PDO::PARAM_INT);
$stmt->execute();

// 一覧画面に戻る
header("Location: index.php");
exit();

?>