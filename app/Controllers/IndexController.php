<?php
class IndexController
{
   public function __construct($db)
   {
        $this->conn = $db->getConnect();
   }

   public function index()
   {
        include_once 'app/models/UserModel.php';

        $user = null;
        $isAdmin = false;

        if (isset($_SESSION['auth'])) {
            $authId = $_SESSION['auth'];
            $user = (new User())::one($this->conn, $authId);
        }

        if ($user['is_admin']) {
            $isAdmin = true;
        }

        $searchField = '';

        if (isset($_GET['search'])) {
            $searchField = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }

        $users = (new User())::all($this->conn, $searchField);

        include_once 'views/home.php';
   }

}
