<?php

class Comment {
   private $user_id;
   private $author_id;
   private $text;

   public function __construct($user_id = '', $author_id = '', $text = '')
   {
       $this->user_id = $user_id;
       $this->author_id = $author_id;
       $this->text = $text;
   }

   public function add($conn) {
        $date = date('F j, Y, g:i a');

       $sql = "INSERT INTO comments (user_id, author_id, text, date)
           VALUES ('$this->user_id', '$this->author_id','$this->text', '$date') RETURNING id";

        $comment = mysqli_query($conn, $sql);

        if ($comment) {
            return ($comment->fetch_assoc())['id'];
        } else {
            return false;
        }
   }

   public static function one($conn, $id) {
    $id = intval($id);
     $sql = "SELECT comments.id, comments.date, comments.text, usr.first_name, usr.last_name, authr.first_name as 'authr_first_name', authr.last_name as 'authr_last_name', usr.id as 'user_id' FROM comments LEFT JOIN users usr on usr.id = comments.user_id LEFT JOIN users authr on authr.id = comments.author_id WHERE comments.id = $id";

     $result = $conn->query($sql);

     if ($result->num_rows > 0) {
         $arr = [];
         while ( $db_field = $result->fetch_assoc() ) {
             $arr[] = $db_field;
         }
         return $arr[0];
     } else {
         return [];
     }
}

    public static function update($conn, $id, $text) {
        $id = intval($id);
        $sql = "UPDATE comments SET text = '$text' WHERE id = $id";

        $comment = mysqli_query($conn, $sql);

        if ($comment) {
            return true;
        } else {
            return false;
        }
    }

    public static function delete($conn, $id) {
        $id = intval($id);
        $sql = "DELETE FROM comments WHERE id = $id";

        $comment = mysqli_query($conn, $sql);

        if ($comment) {
            return true;
        } else {
            return false;
        }
    }

   public static function allByUser($conn, $user_id) {
       $user_id = intval($user_id);
        $sql = "SELECT comments.id, comments.date, comments.text, usr.first_name, usr.last_name, authr.first_name as 'authr_first_name', authr.last_name as 'authr_last_name', authr.id as 'authr_id' FROM comments LEFT JOIN users usr on usr.id = comments.user_id LEFT JOIN users authr on authr.id = comments.author_id WHERE user_id = $user_id";


        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $arr = [];
            while ( $db_field = $result->fetch_assoc() ) {
                $arr[] = $db_field;
            }
            return $arr;
        } else {
            return [];
        }
   }
 
}
