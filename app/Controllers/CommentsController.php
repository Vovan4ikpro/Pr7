<?php

class CommentsController
{
   public function __construct($db)
   {
        $this->conn = $db->getConnect();
   }

    public function update()
    {
        if (!isset($_GET['comment_id'])) header('Location: /');
        $commentId = filter_input(INPUT_GET, 'comment_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        include_once 'app/Models/UserModel.php';
        
        $userId = false;
        $isAdmin = false;

        if (isset($_SESSION['auth'])) {
            $userId = $_SESSION['auth'];
        } else {
            header('Location: /');
        }

        $user = (new User())::one($this->conn, $userId);
        if (empty($user)) {
            header('Location: /');
        }

        if ($user['is_admin']) $isAdmin = true;

        include_once 'app/Models/CommentModel.php';

        $comment = (new Comment())::one($this->conn, $commentId);
        if (empty($comment)) {
            header('Location: /');
        }

        if ($comment['user_id'] != $userId && !$isAdmin) {
            header('Location: /');
        }


        include_once 'views/editComment.php';
    } 

    public function insertAjax()
    {
        $data = $_POST;

       if (!empty($data)) {
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $author_id = filter_input(INPUT_POST, 'author_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $userId = false;

            if (isset($_SESSION['auth'])) {
                $userId = $_SESSION['auth'];

                if ($userId != $author_id) {
                    echo json_encode(['status' => 'error', 'msg' => 'You are not authorized.']);
                    return;
                }
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'You are not authorized.']);
                return;
            }

            $error = false;

            if (strlen($text) < 10) {
                $error = "Comment text length must be at least 10 characters.";
            }

            include_once 'app/Models/UserModel.php';

            $user = (new User())::one($this->conn, $user_id);
            if (empty($user)) {
                $error = "Something went wrong.";
            }

            $author = (new User())::one($this->conn, $author_id);
            if (empty($author)) {
                $error = "Something went wrong.";
            }

            if ($user['id'] == $author['id']) {
                $error = "Something went wrong.";
            }

            if ($error) {
                echo json_encode(['status' => 'error', 'msg' => $error]);
            } else {
                include_once 'app/Models/CommentModel.php';

                $comment = new Comment($user_id, $author_id, $text);
                $res = $comment->add($this->conn);

                if ($res) {
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Something went wrong...']);
                }
            }
       }
    }

    public function updateAjax()
    {
        $userId = false;
        $isAdmin = false;

        if (isset($_SESSION['auth'])) {
            $userId = $_SESSION['auth']; 
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'You are not authorized.']);
            return;
        }

        include_once 'app/Models/UserModel.php';

        $user = (new User())::one($this->conn, $userId);
        if (empty($user)) {
            echo json_encode(['status' => 'error', 'msg' => 'Something went wrong.']);
            return;
        }

        if ($user['is_admin']) $isAdmin = true;

        $data = $_POST;

       if (!empty($data)) {
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            include_once 'app/Models/CommentModel.php';
            $comment = (new Comment())::one($this->conn, $comment_id);

            if ($comment['user_id'] != $userId && !$isAdmin) {
                echo json_encode(['status' => 'error', 'msg' => 'Something went wrong.']);
                return;
            }

            $res = (new Comment())::update($this->conn, $comment_id, $text);
            if ($res) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Something went wrong.']);
            }

       }
            
    }

    public function deleteAjax()
    {
        $userId = false;

        if (isset($_SESSION['auth'])) {
            $userId = $_SESSION['auth']; 
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'You are not authorized.']);
            return;
        }

        include_once 'app/Models/UserModel.php';

        $user = (new User())::one($this->conn, $userId);
        if (empty($user)) {
            echo json_encode(['status' => 'error', 'msg' => 'Something went wrong.']);
            return;
        }

        $data = $_POST;

       if (!empty($data)) {
            $text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $comment_id = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            include_once 'app/Models/CommentModel.php';
            $comment = (new Comment())::one($this->conn, $comment_id);

            if ($comment['user_id'] != $userId) {
                echo json_encode(['status' => 'error', 'msg' => 'Something went wrong.']);
                return;
            }

            $res = (new Comment())::delete($this->conn, $comment_id);
            if ($res) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Something went wrong.']);
            }

       }
            
    }

}