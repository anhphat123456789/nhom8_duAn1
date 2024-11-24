
<?php
session_start();
// Database
include 'app/Database/Database.php';

// Model
include 'app/Models/Admin/HomeModel.php';

//Controller
include 'app/Controller/Admin/ControllerAdmin.php';
include 'app/Controller/Admin/HomeController.php';
include 'app/Controller/Admin/LoginController.php';

const BASE_URL = "http://localhost/du_an_1/duAn1_MVC/";

// Router
include 'router/web.php';

// echo password_hash('123456', PASSWORD_BCRYPT);