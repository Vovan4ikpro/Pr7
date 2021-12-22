<?php
class IndexController
{
   public function __construct($db)
   {
        $this->conn = $db->getConnect();
   }

   public function index()
   {
        $error = false;

        if (!empty($_POST)) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            include_once 'app/Models/UserModel.php';

            $user = (new User())::get_user($this->conn, $email, $password);


            if (count($user) < 1) {
                $error = 'Wrong user email or password!';
            } else {
                $_SESSION['auth'] = true;
                header('Location: /?controller=users&action=addForm');
            }
        }
    

       include_once 'views/home.php';
   }

   public function logout()
   {
        session_unset();
        session_destroy();
        
        header('Location: /?controller=index');
   }
}
