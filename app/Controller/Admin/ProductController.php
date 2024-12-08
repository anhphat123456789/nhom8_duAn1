<?php

class ProductController extends ControllerAdmin
{
    public function showAllProduct()
    {
        $productModel = new ProductModel();
        $listProduct = $productModel->getAllProduct();
        include 'app/Views/Admin/Product-admin/products.php';
    }

    public function addProduct()
    {
        $CategoryModel = new CategoryModel();
        $listCategory = $CategoryModel->allCategory();
        include 'app/Views/Admin/Product-admin/add-product.php';
    }

    public function checkValidate()
    {
        $name = $_POST['name'] ?? null;
        $category = $_POST['category'] ?? null;
        $price = $_POST['price'] ?? null;
        $stock = $_POST['stock'] ?? null;

        if ($name != "" && $category != "" && $price != "" && $stock != "") {
            return true;
        } else {
            $_SESSION['error'] = "Bạn nhập thiếu thông tin";
            return false;
        }
    }

    public function addPostProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->checkValidate()) {
                header("Location: " . BASE_URL . "?role=admin&act=add-product");
                exit;
            }

            // Thêm ảnh main
            $uploadDir = 'assets/Admin/upload/product-admin/';
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $destPath = "";

            if (!empty($_FILES['image_main']['name'])) {
                $fileTmpPath = $_FILES['image_main']['tmp_name'];
                $fileType = mime_content_type($fileTmpPath);
                $fileName = basename($_FILES['image_main']['name']);
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $newFileName = uniqid() . '.' . $fileExtension;  // Sửa cú pháp nối chuỗi

                if (in_array($fileType, $allowedTypes)) {
                    $destPath = $uploadDir . $newFileName;
                    if (!move_uploaded_file($fileTmpPath, $destPath)) {
                        $destPath = "";
                    }
                }
            }

            $productModel = new ProductModel();
            $idProduct = $productModel->addProductToDB($destPath);  // Truyền đường dẫn ảnh nếu cần

            if (!$idProduct) {
                $_SESSION['message'] = 'Thêm mới thành công';
                header("Location: " . BASE_URL . "?role=admin&act=add-product");
                exit;
            }
            //thêm thư viện ảnh
            if (isset($_FILES['image'])) {
                foreach ($_FILES['image']['name'] as $key => $name) {
                    $destPathImage = "";
                    if (!empty($name)) {
                        $fileTmpPath = $_FILES['image']['tmp_name'][$key];
                        $fileType = mime_content_type($fileTmpPath);
                        $fileName = basename($name);
                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        $newFileName = uniqid() . '.' . $fileExtension;

                        if (in_array($fileType, $allowedTypes)) {
                            $destPathImage = $uploadDir . $newFileName;

                            if (!move_uploaded_file($fileTmpPath, $destPathImage)) {
                                $destPathImage = "";
                            }
                        }
                    }
                    $productModel->addGalleryImage($destPathImage, $idProduct);
                }
            }
            // die;      
            $_SESSION['message'] = 'Thêm mới thành công';
            header("Location: " . BASE_URL . "?role=admin&act=all-product");
            exit;


            // Tạo đối tượng ProductModel và thêm sản phẩm vào DB

        }
    }

    public function deleteProduct()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['message'] = 'Vui lòng chọn Product cần xóa';
            header("Location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }

        $id = $_GET['id'];
        $productModel = new ProductModel();

        // Xóa ảnh chính của sản phẩm
        $product = $productModel->getProductById($id);
        if ($product && $product->image_main != null) {
            unlink($product->image_main);
        }

        // Xóa các ảnh trong thư viện ảnh
        $listImage = $productModel->getProductImageByID($id);
        foreach ($listImage as $key => $value) {
            if ($value->image != null) {
                unlink($value->image);
            }
        }


        // Xóa sản phẩm
        $message = $productModel->deleteProductToDB($id);

        if ($message) {
            $_SESSION['message'] = 'Xóa thành công';
            header("Location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        } else {
            $_SESSION['message'] = 'Xóa không thành công';
            header("Location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }
    }

    public function updateProduct()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['message'] = 'Vui lòng chọn Product cần sửa';
            header("Location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }

        $id = $_GET['id']; // Lấy ID của sản phẩm từ URL

        $categoryModel = new CategoryModel();
        $listCategory = $categoryModel->allCategory(); // Lấy danh sách tất cả danh mục

        $productModel = new ProductModel();
        $product = $productModel->getProductByID($id); // Gọi hàm đúng từ `$productModel`
        $listProductImage = $productModel->getProductImageById($id);

        if (!$product) {
            $_SESSION['message'] = 'Sản phẩm không tồn tại';
            header("Location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }

        include "app/Views/Admin/Product-admin/update-product.php"; // Hiển thị giao diện cập nhật sản phẩm
    }

    public function updatePostProduct()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['message'] = 'Vui lòng chọn Product cần sửa';
            header("Location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_GET['id'])) {
                $_SESSION['message'] = 'Vui lòng chọn Product cần sửa';
                header("Location: " . BASE_URL . "?role=admin&act=all-product");
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (!$this->checkValidate()) {
                    header("Location: " . BASE_URL . "?role=admin&act=update-product" . $_GET['id']);
                    exit;
                }

                // chỉnh sửa ảnh
                $productModel = new ProductModel();
                $product = $productModel->getProductByID($id);
                $uploadDir = 'assets/Admin/upload/product-admin/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $destPath = $product->image_main;


                if (!empty($_FILES['image_main']['name'])) {
                    $fileTmpPath = $_FILES['image_main']['tmp_name'];
                    $fileType = mime_content_type($fileTmpPath);
                    $fileName = basename($_FILES['image_main']['name']);
                    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $newFileName = uniqid() . '.' . $fileExtension;  // Sửa cú pháp nối chuỗi

                    if (in_array($fileType, $allowedTypes)) {
                        $destPath = $uploadDir . $newFileName;
                        if (!move_uploaded_file($fileTmpPath, $destPath)) {
                            $destPath = "";
                        }
                        unlink($product->image_main);

                    }
                }
                $productModel = new ProductModel();
                $messega = $productModel->updateProductToDB($destPath);  // Truyền đường dẫn ảnh nếu cần

                if (!$messega) {
                    $_SESSION['message'] = 'Chỉnh sửa k thành công';
                    header("Location: " . BASE_URL . "?role=admin&act=update-product&id=" . $_GET['id']);
                    exit;
                }

                if (isset($_FILES['image']) && count($_FILES['image']) >0) {
                    $listImage = $productModel->getProductImageByID($id);
                    foreach ($listImage as $key => $value) {
                        if ($value->image != null) {
                            unlink($value->image);
                        }
                    }
                    $productModel->deleteImageGallary($_GET['id']);
                    foreach ($_FILES['image']['name'] as $key => $name) {
                        $destPathImage = "";
                        if (!empty($name)) {
                            $fileTmpPath = $_FILES['image']['tmp_name'][$key];
                            $fileType = mime_content_type($fileTmpPath);
                            $fileName = basename($name);
                            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                            $newFileName = uniqid() . '.' . $fileExtension;
    
                            if (in_array($fileType, $allowedTypes)) {
                                $destPathImage = $uploadDir . $newFileName;
    
                                if (!move_uploaded_file($fileTmpPath, $destPathImage)) {
                                    $destPathImage = "";
                                }
                            }
                        }
                        $productModel->addGalleryImage($destPathImage, $_GET['id']);
                    }
                }
                
                $_SESSION['message'] = 'Chỉnh sửa thành công';
                header("Location: " . BASE_URL . "?role=admin&act=all-product");
                exit;


                // // Tạo đối tượng ProductModel và thêm sản phẩm vào DB

            }
        }

    }

    public function showProduct(): void
    {
        if (!isset($_GET['id'])) {
            $_SESSION['message'] = 'Vui lòng chọn Product cần xem';
            header("Location: " . BASE_URL . "?role=admin&act=all-product");
            exit;
        }
        
        $id = $_GET['id']; // Gán giá trị $_GET['id'] cho biến $id
    
        $productModel = new ProductModel();
        $product = $productModel->getProductByID($id); // Sử dụng biến $id đã gán
    
        include 'app/Views/Admin/Product-admin/show-product.php';
    }
    
}