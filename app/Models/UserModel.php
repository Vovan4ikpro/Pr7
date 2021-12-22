<?php
class User {
   private $name;
   private $email;
   private $gender;

   public function __construct($name = '', $email = '', $gender = '', $filePath = '', $password = '')
   {
       $this->name = $name;
       $this->email = $email;
       $this->gender = $gender;
       $this->filePath = $filePath;
       $this->password = $password;
   }

   public function add($conn) {
       $sql = "INSERT INTO users (email, name, gender, password, path_to_img)
           VALUES ('$this->email', '$this->name','$this->gender', '$this->password', '$this->filePath')";
           $res = mysqli_query($conn, $sql);
           if ($res) {
               return true;
           }
   }

   public function update($conn, $id) {
    $sql = "UPDATE users SET email = '$this->email', password = '$this->password', name = '$this->name', gender = '$this->gender', path_to_img = '$this->filePath' WHERE id = $id";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }
    }

   public static function all($conn) {
       $sql = "SELECT * FROM users";
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

   public static function get_user($conn, $email, $password) {
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
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

   public static function one($conn, $id) {
        $sql = "SELECT * FROM users WHERE id=$id";
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
        $sql = "DELETE FROM users WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if ($res) {
            return true;
        }
    }
 
}
