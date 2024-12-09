<?php
class ProductModel{
    public $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllProduct(){
        $sql = "
        SELECT products.id, products.name, products.price, products.price_sale, products.category_id, products.stock, products.image_main, categores.name AS categoryName FROM `products` join categores on products.category_id = categores.id
        ";
        $query = $this->db->pdo->query($sql);
        $result = $query->fetchAll();
        return $result;
    }


    public function addProductToDB($destPath) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $category = isset($_POST['category']) && is_numeric($_POST['category']) ? $_POST['category'] : null;
        $price = isset($_POST['price']) && is_numeric($_POST['price']) ? $_POST['price'] : 0;
        $pricesale = isset($_POST['pricesale']) && is_numeric($_POST['pricesale']) ? $_POST['pricesale'] : null;
        $stock = isset($_POST['stock']) && is_numeric($_POST['stock']) ? $_POST['stock'] : 0;
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $now = date('Y-m-d H:i:s');
        $imageDes = $destPath;
    
        $sql = "
        INSERT INTO `products`(`name`, `category_id`, `description`, `price`, `price_sale`, `stock`, `image_main`, `created_at`, `updated_at`)
        VALUES (:name, :category_id, :description, :price, :price_sale, :stock, :image_main, :created_at, :updated_at)
        ";
    
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':price_sale', $pricesale);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':created_at', $now);
        $stmt->bindParam(':updated_at', $now);
        $stmt->bindParam(':image_main', $imageDes);
    
        if ($stmt->execute()) {
            return $this->db->pdo->lastInsertId(); // Trả về ID sản phẩm
        } else {
            return false;
        }
    }
    
    public function addGaryImage($destPathImage, $isProduct){
        $sql = "
        INSERT INTO `product_image`(`product_id`, `image`)
        VALUES (:product_id, :image)
        ";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':product_id', $isProduct);
        $stmt->bindParam(':image', $destPathImage);
        return $stmt->execute();
    }

    public function getProductByID(){
        $id = $_GET['id'];
        $sql = "
        select * from products where id = :id
        ";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()){
            return $stmt->fetch();
        }
        return false;
    }

    public function getProductImageByID(){
        $id = $_GET['id'];
        $sql = "
        select * from product_image where product_id = :product_id
        ";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':product_id', $id);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        return false;
    }
    public function deleteProductToDB(){
        $id = $_GET['id'];
        $sqlProductImage = "
        DELETE FROM `product_image` WHERE product_id = :product_id
        ";
        $stmt1 = $this->db->pdo->prepare($sqlProductImage);
        $stmt1->bindParam(':product_id', $id);
        

        $sqlProduct = "
        DELETE FROM `products` WHERE id = :id
        ";
        $stmt2 = $this->db->pdo->prepare($sqlProduct);
        $stmt2->bindParam(':id', $id);
        
        if($stmt1->execute() && $stmt2->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function updateProductToDB ($destPath){
        $id = $_GET['id'];
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $category = isset($_POST['category']) && is_numeric($_POST['category']) ? $_POST['category'] : null;
        $price = isset($_POST['price']) && is_numeric($_POST['price']) ? $_POST['price'] : 0;
        $pricesale = isset($_POST['pricesale']) && is_numeric($_POST['pricesale']) ? $_POST['pricesale'] : null;
        $stock = isset($_POST['stock']) && is_numeric($_POST['stock']) ? $_POST['stock'] : 0;
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $now = date('Y-m-d H:i:s');
        $imageDes = $destPath;
    
        $sql = "
        UPDATE `products` SET`name`= :name,`category_id`= :category_id,`description`= :description
        ,`price`= :price,`price_sale`= :price_sale,`stock`= :stock,`image_main`= :image_main,`created_at`= :created_at,`updated_at`= :updated_at WHERE id = :id
        ";
    
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':price_sale', $pricesale);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':created_at', $now);
        $stmt->bindParam(':updated_at', $now);
        $stmt->bindParam(':image_main', $imageDes);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function deleteImageGary(){
        $id = $_GET['id'];
        $sqlProductImage = "
        DELETE FROM `product_image` WHERE product_id = :product_id
        ";
        $stmt = $this->db->pdo->prepare($sqlProductImage);
        $stmt->bindParam(':product_id', $id);
        return $stmt->execute();

    }
}