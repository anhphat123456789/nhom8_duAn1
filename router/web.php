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
            $loginController = new LoginController();
            $loginController->login();
            break;
        }
         // http://localhost/du_an_1/duAn1_MVC/?role=admin&act=post-login
        case 'post-login': {
            $loginController = new LoginController();
            $loginController->postLogin();
            break;
        }
        case 'logout': {
            $loginController = new LoginController();
            $loginController->logout();
            break;
        }
        case 'all-user': {
            $userController = new UserController();
            $userController->getAllUser();
            break;
        }
        case 'add-user': {
            $userController = new UserController();
            $userController->addUser();
            break;
        }
        case 'post-add-user': {
            $userController = new UserController();
            $userController->addPostUser();
            break;
        }
        case 'update-user': {
            $userController = new UserController();
            $userController->updateUser();
            break;
        }
        case 'update-post-user': {
            $userController = new UserController();
            $userController->updatePostUser();
            break;
        }
        case 'delete-user': {
            $userController = new UserController();
            $userController->deleteUser();
            break;
        }
        case 'show-user': {
            $userController = new UserController();
            $userController->showUser();
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
