<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy toàn bộ sản phẩm kèm tên danh mục và hình ảnh
    public function getProducts($search = '')
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image,
                         c.name AS category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id";

        if (!empty($search)) {
            $query .= " WHERE p.name LIKE :search OR p.description LIKE :search";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($search)) {
            $searchTerm = '%' . $search . '%';
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy sản phẩm theo ID kèm tên danh mục
    public function getProductById($id)
    {
        $query = "SELECT p.*, c.name AS category_name
                  FROM " . $this->table_name . " p
                  LEFT JOIN category c ON p.category_id = c.id
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Thêm sản phẩm mới (có hình ảnh)
    public function addProduct($name, $description, $price, $category_id, $image = '')
    {
        $errors = [];
        if (empty($name))        $errors['name']        = 'Tên sản phẩm không được để trống';
        if (empty($description)) $errors['description'] = 'Mô tả không được để trống';
        if (!is_numeric($price) || $price < 0) $errors['price'] = 'Giá sản phẩm không hợp lệ';
        if (count($errors) > 0) return $errors;

        $query = "INSERT INTO " . $this->table_name . "
                  (name, description, price, category_id, image)
                  VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        $name        = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price       = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image       = htmlspecialchars(strip_tags($image));

        $stmt->bindParam(':name',        $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price',       $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image',       $image);

        return $stmt->execute() ? true : false;
    }

    // Cập nhật sản phẩm (có hình ảnh)
    public function updateProduct($id, $name, $description, $price, $category_id, $image = '')
    {
        $query = "UPDATE " . $this->table_name . "
                  SET name=:name, description=:description, price=:price,
                      category_id=:category_id, image=:image
                  WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $name        = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price       = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $image       = htmlspecialchars(strip_tags($image));

        $stmt->bindParam(':id',          $id);
        $stmt->bindParam(':name',        $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price',       $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image',       $image);

        return $stmt->execute() ? true : false;
    }

    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute() ? true : false;
    }
}
?>
