<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db           = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // ==================== HIỂN THỊ DANH SÁCH ====================

    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $products = $this->productModel->getProducts($search);
        $categories = (new CategoryModel($this->db))->getCategories();
        $currentCategoryId = null;
        $searchQuery = $search;
        include 'app/views/product/list.php';
    }

    public function category($id)
    {
        $products = $this->productModel->getProductsByCategory($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        $currentCategoryId = $id;
        include 'app/views/product/list.php';
    }

    public function list()
    {
        $this->index();
    }

    // ==================== CHI TIẾT SẢN PHẨM ====================

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    // ==================== THÊM SẢN PHẨM ====================

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name        = $_POST['name']        ?? '';
            $description = $_POST['description'] ?? '';
            $price       = $_POST['price']       ?? '';
            $category_id = $_POST['category_id'] ?? null;

            // Xử lý upload hình ảnh
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                try {
                    $image = $this->uploadImage($_FILES['image']);
                } catch (Exception $e) {
                    $errors = ['image' => $e->getMessage()];
                    $categories = (new CategoryModel($this->db))->getCategories();
                    include 'app/views/product/add.php';
                    return;
                }
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors     = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /Product');
            }
        }
    }

    // ==================== SỬA SẢN PHẨM ====================

    public function edit($id)
    {
        $product    = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id          = $_POST['id'];
            $name        = $_POST['name'];
            $description = $_POST['description'];
            $price       = $_POST['price'];
            $category_id = $_POST['category_id'];

            // Giữ lại ảnh cũ nếu không upload ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                try {
                    $image = $this->uploadImage($_FILES['image']);
                } catch (Exception $e) {
                    echo "Lỗi upload ảnh: " . $e->getMessage();
                    return;
                }
            } else {
                $image = $_POST['existing_image'] ?? '';
            }

            $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            if ($result) {
                header('Location: /Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    // ==================== XÓA SẢN PHẨM ====================

    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    // ==================== UPLOAD ẢNH (helper) ====================

    private function uploadImage($file)
    {
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        // Kiểm tra file có phải hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        // Kiểm tra kích thước (tối đa 10 MB)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn (tối đa 10MB).");
        }

        // Chỉ cho phép jpg, jpeg, png, gif
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }

        // Đặt tên file unique để tránh trùng
        $uniqueName  = uniqid('img_', true) . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueName;

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    // ==================== GIỎ HÀNG (Bài 3) ====================

    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        if ($quantity < 1) {
            $quantity = 1;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $quantity,
                'image'    => $product->image
            ];
        }

        header('Location: /Product/cart');
    }

    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /Product/cart');
    }

    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    public function orders()
    {
        $orders = [];
        $detailsByOrder = [];

        $query = "SELECT * FROM orders ORDER BY created_at DESC";
        $stmt  = $this->db->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (!empty($orders)) {
            $query = "SELECT od.order_id, od.quantity, od.price, p.name AS product_name
                      FROM order_details od
                      LEFT JOIN product p ON od.product_id = p.id
                      ORDER BY od.order_id";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $details = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($details as $item) {
                $detailsByOrder[$item['order_id']][] = $item;
            }
        }

        include 'app/views/product/orders.php';
    }

    // ==================== THANH TOÁN (Bài 3) ====================

    public function checkout()
    {
        if (empty($_SESSION['cart'])) {
            header('Location: /Product/cart');
            return;
        }
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name           = trim($_POST['name']           ?? '');
            $phone          = trim($_POST['phone']          ?? '');
            $address        = trim($_POST['address']        ?? '');
            $payment_method = trim($_POST['payment_method'] ?? 'cod');

            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống."; return;
            }

            $this->db->beginTransaction();
            try {
                $query = "INSERT INTO orders (name, phone, address)
                          VALUES (:name, :phone, :address)";
                $stmt  = $this->db->prepare($query);
                $stmt->bindParam(':name',    $name);
                $stmt->bindParam(':phone',   $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                foreach ($_SESSION['cart'] as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price)
                              VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt  = $this->db->prepare($query);
                    $stmt->bindParam(':order_id',   $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity',   $item['quantity']);
                    $stmt->bindParam(':price',      $item['price']);
                    $stmt->execute();
                }

                $this->db->commit();

                // Tính tổng tiền để truyền sang trang thanh toán
                $total = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $_SESSION['cart']));
                $_SESSION['order_total']    = $total;
                $_SESSION['order_name']     = $name;
                $_SESSION['payment_method'] = $payment_method;

                // Xóa giỏ hàng
                unset($_SESSION['cart']);

                // Điều hướng theo phương thức thanh toán
                if ($payment_method === 'momo') {
                    header('Location: /Product/paymentMomo');
                } elseif ($payment_method === 'bank') {
                    header('Location: /Product/paymentBank');
                } elseif ($payment_method === 'vnpay') {
                    header('Location: /Product/paymentVNPay');
                } else {
                    header('Location: /Product/orderConfirmation');
                }

            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }

    public function paymentMomo()
    {
        $total      = $_SESSION['order_total'] ?? 0;
        $order_name = $_SESSION['order_name']  ?? '';
        include 'app/views/product/paymentMomo.php';
    }

    public function paymentBank()
    {
        $total      = $_SESSION['order_total'] ?? 0;
        $order_name = $_SESSION['order_name']  ?? '';
        include 'app/views/product/paymentBank.php';
    }

    public function paymentVNPay()
    {
        $total      = $_SESSION['order_total'] ?? 0;
        $order_name = $_SESSION['order_name']  ?? '';
        include 'app/views/product/paymentVNPay.php';
    }

    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }
}
?>
