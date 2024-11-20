<?php
class HomeController{
    public function dashboard() {
        $homeModel = new HomeModel();
        $dataUsers = $homeModel->getUser();
        include 'app/Views/Admin/index.php';
    }
    public function login() {
        include 'app/Views/Admin/layout/login.php';
    }
    public function postLogin() {
        // $_POST['name']
        // $_POST['password']
        $homeModel = new HomeModel();
        $dataUsers = $homeModel->checkLogin();
        var_dump($dataUsers);
        if($dataUsers) {
            header("location:" .BASE_URL. "?role=admin&act=home");
            exit;
        }else {
            $_SESSION['error']= "Email hoặc password ko đúng";
            header("location:" .BASE_URL. "?role=admin&act=login");
            exit;
        }   
    }
}