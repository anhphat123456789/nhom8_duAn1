<?php
    class ProductUserModel {
        public $db;
        public function __construct()
        {
            $this->db = new Database();
        }

        public function getProductDashboard(){
            $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 8";
            $query = $this->db->pdo->query($sql);
            $result = $query->fetchAll();
            return $result;
        }
        public function getDataShop(){
            $sql = "SELECT * FROM `products`";
            if(isset($_GET['category_id'])){
                $sql=$sql. " WHERE category_id = :category_id";
                $stmt = $this->db->pdo->prepare($sql);
                $stmt->bindParam(':category_id',$_GET['category_id']);
        }else{
            $stmt = $this->db->pdo->prepare($sql);
        }
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    public function getProductStock(){
        $sql1 = "SELECT COUNT(id) as instock FROM `products` WHERE stock > 0";
        $query1 = $this->db->pdo->query($sql1);
        $inStock = $query1->fetch();

        $sql2 = "SELECT COUNT(id) as outstock FROM `products` WHERE stock = 0";
        $query2 = $this->db->pdo->query($sql2);
        $outStock = $query2->fetch();
        return [$inStock,$outStock];
    }
    public function getDataShopName(){
        $productName = $_GET['product-name'];
        $sql = "SELECT * FROM `products` WHERE name LIKE '%$productName%'";
        $query = $this->db->pdo->prepare($sql);
        $result=$query->fetchAll();
        return $result;
    }
    public function getProductById(){
        if(isset($_GET['product_id'])){
            $sql = "SELECT * FROM `products` WHERE id = :id";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindParam(':id',$_GET['product_id']);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        }
       
}
public function getProductImageById(){
    if(isset($_GET['product_id'])){
        $sql = "SELECT * FROM `product_image` WHERE product_id = :id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':id',$_GET['product_id']);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

}

    public function getOtherProduct($categoryId, $productId){
        $sql = "SELECT * FROM `products` WHERE category_id = :category_id and id != :productId";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getComment($productId){
        $sql = "SELECT product_comment.*, users.name, users.image 
                FROM `product_comment` 
                JOIN users ON product_comment.user_id = users.id 
                WHERE product_comment.product_id = :product_id";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    
}  
?>