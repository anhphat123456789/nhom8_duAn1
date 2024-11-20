<?php

$role = isset($_GET['role']) ? $_GET['role'] : "user";
$act = isset($_GET['act']) ? $_GET['act'] : "";

if($role == "user") {
    echo "Trang user";
}else {
    switch($act) {
          //http://localhost/du_an_1/duAn1_MVC/?role=admin&act=home
        case 'home': {
            $homeController = new HomeController();
            $homeController->dashboard();
            break;
        }

         // http://localhost/du_an_1/duAn1_MVC/?role=admin&act=login
        case 'login': {
            $homeController = new HomeController();
            $homeController->login();
            break;
        }
         // http://localhost/du_an_1/duAn1_MVC/?role=admin&act=post-login
        case 'post-login': {
            $homeController = new HomeController();
            $homeController->postLogin();
            break;
        }
        case 'product' : {
            break;
        }
        default: {
            $homeController = new HomeController();
            $homeController->dashboard();
            break;
        }
    }
}
