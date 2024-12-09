<?php
    class CategoryModel{
        public $db;
        public function __construct()
        {
            $this->db = new Database();
        }

        public function allCategory(){
            $sql = "select * from categores";
            $query = $this->db->pdo->query($sql);
            $result = $query->fetchAll();
            return $result;
        }

        public function addCategory() {
            try {
                // Kiểm tra dữ liệu đầu vào
                if (!isset($_POST['name']) || empty(trim($_POST['name']))) {
                    throw new Exception("Tên danh mục không được để trống");
                }

                // Làm sạch dữ liệu đầu vào
                $name = htmlspecialchars(trim($_POST['name']));

                // Truy vấn thêm danh mục
                $sql = "INSERT INTO categores(name) VALUES (:name)";
                $stmt = $this->db->pdo->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->execute();

                return true;
            } catch (Exception $e) {
                return ['error' => $e->getMessage()];
            }
        }

        public function deleteCategory() {
            $id = $_GET['id'];
            $sql = "DELETE FROM categores WHERE id = :id";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        public function getCategoryByID(){
            $id = $_GET['id'];
            $sql = "select * from categores WHERE id = :id";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            if ($stmt->execute()) {
                return $stmt->fetch();
            }
            return false;
        }

        public function updateCategoryToDB() {
            $id = $_GET['id'];
            if (!isset($_POST['name']) || empty(trim($_POST['name']))) {
                throw new Exception("Tên danh mục không được để trống");
            }

            // Làm sạch dữ liệu đầu vào
            $name = htmlspecialchars(trim($_POST['name']));

            // Truy vấn thêm danh mục
            $sql = "UPDATE categores SET name=:name WHERE id = :id";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return true;
        }
    }
?>