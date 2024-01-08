<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cookieName = $_POST['cookie_name'];

    // 删除 cookie
    setcookie($cookieName, '', time() - 3600, '/');

    // 返回响应，可选
    echo json_encode(['success' => true]);
}
?>
