<?php
class User {
   private $email;
   private $first_name;
   private $last_name;
   private $password;
   private $isAdmin;

   public function __construct($email = '', $first_name = '', $last_name = '', $password = '', $isAdmin = 0)
   {
       $this->email = $email;
       $this->first_name = $first_name;
       $this->last_name = $last_name;
       $this->password = $password;
       $this->isAdmin = $isAdmin;
   }

   public function add($conn) {
       $sql = "INSERT INTO users (email, first_name, last_name, is_admin, password)
           VALUES ('$this->email', '$this->first_name','$this->last_name', '$this->isAdmin', '$this->password') RETURNING id";

        $user = mysqli_query($conn, $sql);

        if ($user) {
            return ($user->fetch_assoc())['id'];
        } else {
            return false;
        }
   }

    public static function delete($conn, $id) {
        $sql = "DELETE FROM users WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

   public static function all($conn, $searchField = '') {
        $sql = "SELECT * FROM users";

        if ($searchField) {
            $searchField = strtolower($searchField);
            $sql .= " WHERE LOWER(first_name) LIKE '%$searchField%' OR LOWER(last_name) LIKE '%$searchField%'";
        }

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

   public static function one($conn, $id) {
       $id = intval($id);
        $sql = "SELECT * FROM users WHERE id = $id";

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

   public static function find($conn, $email, $password) {
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

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

   public static function findByEmail($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = '$email'";

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

    public static function updateProfile($conn, $id, $data) {
        if (!isset($data['first_name']) || !isset($data['last_name']) || !isset($data['email']) || !isset($data['is_admin'])) return false;

        $firstName = $data['first_name'];
        $lastName = $data['last_name'];
        $email = $data['email'];
        $isAdmin = intval($data['is_admin']);

        $sql = "UPDATE users SET first_name = '$firstName', last_name = '$lastName', email = '$email', is_admin = $isAdmin WHERE id = $id";

        $res = mysqli_query($conn, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }        
    }

    public static function updatePassword($conn, $id, $newPassword) {
        $sql = "UPDATE users SET password = '$newPassword' WHERE id = $id";

        $res = mysqli_query($conn, $sql);

        if ($res) {
            return true;
        } else {
            return false;
        }        
    }
 
}
