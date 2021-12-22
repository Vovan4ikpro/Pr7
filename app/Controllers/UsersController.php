<?php
class UsersController
{
   private $conn;
   public function __construct($db)
   {
       $this->conn = $db->getConnect();

        $isRestricted = false;

        if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
            $isRestricted = true;
        }

        $this->isRestricted = $isRestricted;
   }

   public function index()
   {
        if (!$this->isRestricted) header('Location: /?controller=index');

       include_once 'app/Models/UserModel.php';

       // отримання користувачів
       $users = (new User())::all($this->conn);

       include_once 'views/users.php';
   }

   public function show()
   {
        if (!$this->isRestricted) header('Location: /?controller=index');

        include_once 'app/Models/UserModel.php';
            
        // блок з валідацією
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (trim($id) !== "" && is_numeric($id)) {
            $user = (new User())::one($this->conn, $id);

            include_once 'views/showUser.php';
        } else {
            header('Location: ?controller=users');
        }
   }

   public function addForm() {
        if (!$this->isRestricted) header('Location: /?controller=index');

        include_once 'views/addUser.php';
   }

   public function add()
   {
        if (!$this->isRestricted) header('Location: /?controller=index');

       include_once 'app/Models/UserModel.php';
       // блок з валідацією
       $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
       $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

       $uploadOk = 1;
       $filePath = '';
       $uploadErrorMessage = false;

        if (strlen($_FILES['photo']['name']) > 0) {
            $target_dir = "public/uploads/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $uploadErrorMessage = false;

            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["photo"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadErrorMessage = "File is not an image.";
                    $uploadOk = 0;
                }
            }

            if (file_exists($target_file)) {
                $uploadErrorMessage = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["photo"]["size"] > 500000) {
                $uploadErrorMessage = "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $uploadErrorMessage = "Sorry,onlyJPG,JPEG,PNG&GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 1) {
                $filePath = $target_dir . basename($_FILES["photo"]["name"]);
                if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $uploadOk = 0;
                    $uploadErrorMessage = "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $filePath = '/assets/img/avatar.png';
        }


       if (trim($name) !== "" && trim($email) !== "" && trim($gender) !== "" && $uploadOk == 1 && trim($password) !== "") {
           // додати користувача
           $user = new User($name, $email, $gender, $filePath, $password);
           $user->add($this->conn);

           header('Location: ?controller=users');
       } else {
            header('Location: ?controller=users&action=addForm&error='.$uploadErrorMessage);
       }
   }

   public function update()
   {
        if (!$this->isRestricted) header('Location: /?controller=index');

        include_once 'app/Models/UserModel.php';
        // блок з валідацією
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $old_path = filter_input(INPUT_POST, 'old_path_to_img', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $uploadOk = 1;
        $filePath = '';
        $uploadErrorMessage = false;

        if (strlen($_FILES['photo']['name']) > 0) {
            $target_dir = "public/uploads/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $uploadErrorMessage = false;

            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["photo"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadErrorMessage = "File is not an image.";
                    $uploadOk = 0;
                }
            }

            if (file_exists($target_file)) {
                $uploadErrorMessage = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["photo"]["size"] > 500000) {
                $uploadErrorMessage = "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $uploadErrorMessage = "Sorry,onlyJPG,JPEG,PNG&GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 1) {
                $filePath = $target_dir . basename($_FILES["photo"]["name"]);
                if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $uploadOk = 0;
                    $uploadErrorMessage = "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $filePath = $old_path;
        }

        if (trim($name) !== "" && trim($email) !== "" && trim($gender) !== "" && trim($id) !== "" && $uploadOk && trim($password) !== "") {
            // додати користувача
            $user = new User($name, $email, $gender, $filePath, $password);
            $user->update($this->conn, $id);
            if ($filePath != $old_path) {
                unlink($old_path);
            }
            header('Location: ?controller=users');
        } else {
            header('Location: ?controller=users&action=show&error='.$uploadErrorMessage.'&id='.$id);
        }
   }

    public function delete()
    {
        if (!$this->isRestricted) header('Location: /?controller=index');

        include_once 'app/Models/UserModel.php';
        
        // блок з валідацією
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (trim($id) !== "" && is_numeric($id)) {
            (new User())::delete($this->conn, $id);
        }

        header('Location: ?controller=users');
    }
 
}
