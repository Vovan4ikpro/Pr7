<?php
class Role {
   private $title;

   public function __construct($title = '')
   {
       $this->title = $title;
   }

   public function add($conn) {
       $sql = "INSERT INTO roles (title)
           VALUES ('$this->title')";
           $res = mysqli_query($conn, $sql);
           if ($res) {
               return true;
           }
   }

   public function update($conn, $id) {
    $sql = "UPDATE roles SET title = '$this->title' WHERE id = $id";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }
    }

   public static function all($conn) {
       $sql = "SELECT * FROM roles";
       $result = $conn->query($sql); //виконання запиту
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

   public static function one($conn, $id) {
        $sql = "SELECT * FROM roles WHERE id=$id";
        $result = $conn->query($sql); //виконання запиту
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

   
    public static function delete($conn, $id) {
        $sql = "DELETE FROM roles WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            return true;
        }
    }
 
}
