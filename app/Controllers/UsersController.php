<?php

class UsersController
{
   public function __construct($db)
   {
        $this->conn = $db->getConnect();
   }

   public function show() {
        include_once 'app/models/UserModel.php';

        $user = null;
        $ownProfile = 0;
        $authId = false;
        $isAdmin = false;

        if (isset($_GET['user_id'])) {
            $userId = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $user = (new User())::one($this->conn, $userId);

            if (isset($_SESSION['auth'])) {
                $authId = $_SESSION['auth'];
                if ($authId == $userId) $ownProfile = 1;
            }
        } else {
            if (isset($_SESSION['auth'])) {
                $authId = $_SESSION['auth'];
                $user = (new User())::one($this->conn, $authId);
                $ownProfile = 1;
            }
        }

        if (!$user) {
            header('Location: /');
        }

        $authUser = (new User())::one($this->conn, $authId);

        if ($authUser) {
            if ($authUser['is_admin']) {
                $isAdmin = true;
            }
        }

        include_once 'app/models/CommentModel.php';
        $comments = (new Comment())::allByUser($this->conn, $user['id']);

        include_once 'views/show.php';
   }

   public function registration()
   {
       include_once 'views/signUp.php';
   }

    public function updateProfileAjax()
    {
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

            $updateId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $firstName = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lastName = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $updateUser = (new User())::one($this->conn, $updateId);
            if (empty($updateUser)) {
                echo json_encode(['status' => 'error', 'msg' => 'Something went wrong.']);
                return;
            }

            if ($updateId != $user['id'] && !$isAdmin) {
                echo json_encode(['status' => 'error', 'msg' => 'You have no access to do this.']);
                return;
            }

            if ($email != $updateUser['email'] && count((new User())::findByEmail($this->conn, $email)) >= 1) {
                echo json_encode(['status' => 'error', 'msg' => 'This email already taken.']);
                return;
            }

            $result = (new User())::updateProfile($this->conn, $updateId, [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'is_admin' => ($role == 'admin' ? 1 : 0)
            ]);

            echo json_encode(['status' => 'success']);
        }

    }

    public function updatePasswordAjax()
    {
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

            $updateId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $newPassword = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $newPasswordRepeat = filter_input(INPUT_POST, 'new_password_repeat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $oldPassword = filter_input(INPUT_POST, 'old_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($updateId != $user['id'] && !$isAdmin) {
                echo json_encode(['status' => 'error', 'msg' => 'You have no access to do this.']);
                return;
            }

            if ($user['password'] != md5($oldPassword)) {
                echo json_encode(['status' => 'error', 'msg' => 'Old password passed wrong.']);
                return;
            }

            if ($newPassword != $newPasswordRepeat) {
                echo json_encode(['status' => 'error', 'msg' => 'New password and repeat are not match.']);
                return;
            }

            $result = (new User())::updatePassword($this->conn, $updateId, md5($newPassword));

            echo json_encode(['status' => 'success']);
        }

    }

    public function updateAvatarAjax() {
        var_dump($_FILES);
        if (strlen($_FILES['avatar']['name']) > 0) {
            $userId = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $target_dir = "public/avatars/";
            $target = basename($_FILES["avatar"]["name"]);
            $target_file = $target_dir . $userId . '.' . end(explode(".", $target));
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $uploadErrorMessage = false;

            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["avatar"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadErrorMessage = "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check file size
            if ($_FILES["avatar"]["size"] > 500000) {
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
                $filePath = $target_dir . basename($_FILES["avatar"]["name"]);
                if (!move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                    $uploadOk = 0;
                    $uploadErrorMessage = "Sorry, there was an error uploading your file.";
                }
            }

            if (!$uploadOk) {
                echo $uploadErrorMessage;
                echo '<br><a href="/?controller=users&action=show&id='.$userId.'">Go Back</a>';
            } else {
                header('Location: /?controller=users&action=show&id='.$userId);
            }
        }
    }

   public function registrationAjax() {
       $data = $_POST;

       if (!empty($data)) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $rePassword = filter_input(INPUT_POST, 'rePassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $error = false;

            if (strlen($email) < 1) {
                $error = "Email cant be empty.";
            } else if (strlen($first_name) < 1) {
                $error = "First name cant be empty.";
            } else if (strlen($last_name) < 1) {
                $error = "Last name cant be empty.";
            } else if (strlen($password) < 6) {
                $error = "Password length must be at least 6 characters.";
            } else if (strlen($rePassword) < 1) {
                $error = "Repeat password cant be empty.";
            } else if ($password != $rePassword) {
                $error = "Password not equals to repeat password.";
            }

            include_once 'app/Models/UserModel.php';

            $isAdmin = 0;

            if (isset($_POST['role'])) {
                $adminId = false;

                if (isset($_SESSION['auth'])) {
                    $adminId = $_SESSION['auth'];

                    $admin = (new User())::one($this->conn, $adminId);

                    if (!empty($admin)) {

                        if ($admin['is_admin']) {
                            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
                            if ($role == 'admin') {
                                $isAdmin = 1;
                            }
                        }

                    }
                }
            }

            $user = (new User())::findByEmail($this->conn, $email);
            if (!empty($user)) {
                $error = "User with this email already registered.";
            } 

            if ($error) {
                echo json_encode(['status' => 'error', 'msg' => $error]);
            } else {
                // отримання користувачів
                $user = new User($email, $first_name, $last_name, md5($password), $isAdmin);
                $res = $user->add($this->conn);

                if ($res) {
                    if (!isset($_GET['auth'])) {
                        $_SESSION['auth'] = $res;
                    }

                    echo json_encode(['status' => 'success']);
                    copy(getcwd().'/assets/img/avatar.png', getcwd().'/public/avatars/'.$res.'.png');
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Something went wrong...']);
                }
            }
       }
   }

   public function loginAjax() {
    $data = $_POST;

    if (!empty($data)) {
         $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

         $error = false;

         include_once 'app/models/UserModel.php';
         $user = (new User())::find($this->conn, $email, md5($password));

         if (empty($user)) {
            $error = 'User with such email and password is not exists.';
         }

         if ($error) {
             echo json_encode(['status' => 'error', 'msg' => $error]);
         } else {
             $_SESSION['auth'] = $user['id'];
             echo json_encode(['status' => 'success']);
         }
    }
}

   public function logout() {
        session_unset();
        session_destroy();

        header('Location: /');
   }

}