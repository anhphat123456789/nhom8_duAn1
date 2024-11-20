
<?php
session_start();
// Database
include 'app/Database/Database.php';

// Model
include 'app/Models/Admin/HomeModel.php';

//Controller
include 'app/Controller/Admin/HomeController.php';

const BASE_URL = "http://localhost/du_an_1/duAn1_MVC/";

// Router
include 'router/web.php';