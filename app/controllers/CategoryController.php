<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

require_once('app/helpers/SessionHelper.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db            = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        if (!SessionHelper::isAdmin()) {
            header('Location: /account/login');
            return;
        }

        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }
}
?>
