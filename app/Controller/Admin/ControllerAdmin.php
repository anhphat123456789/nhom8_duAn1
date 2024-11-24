<?php
class ControllerAdmin {
    public function __construct() {
        if (!isset($_SESSION['users'])) {
            // Nếu chưa đăng nhập, chuyển hướng về trang login
            $_SESSION['error'] = "<h4 style=color:red>Bạn phải đăng nhập trước</h4>";
            header("Location: " . BASE_URL . "?role=admin&act=login");
            exit;
        }
    }
}
