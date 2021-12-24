<?php

class AdminController
{
   public function __construct($db)
   {
        $this->conn = $db->getConnect();
   }

    public function addUser() {
        include_once 'views/addUser.php';
    }

    public function deleteUserAjax() {
        $data = $_POST;

        if (!empty($data)) {
            if (!isset($_SESSION['auth'])) {
                echo json_encode(['status' => 'error', 'msg' => 'You are not authorized.']);
                return;
            }

            $user = false;
            $isAdmin = false;

            include_once 'app/Models/UserModel.php';

            $userId = $_SESSION['auth'];
            $user = (new User())::one($this->conn, $userId);

            if (!$user) {
                echo json_encode(['status' => 'error', 'msg' => 'Something went wrong.']);
                return;
            }

            if ($user['is_admin']) $isAdmin = true;
            if (!$isAdmin) {
                echo json_encode(['status' => 'error', 'msg' => 'You have no access to do it.']);
                return;
            }

            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $result = (new User())::delete($this->conn, $id);

            if ($result) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Something went wrong.']);
            }
        }
    }
}