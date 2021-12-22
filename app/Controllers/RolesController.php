<?php
class RolesController
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

       include_once 'app/Models/RoleModel.php';

       // отримання користувачів
       $roles = (new Role())::all($this->conn);

       include_once 'views/roles.php';
   }

   public function show()
   {
        if (!$this->isRestricted) header('Location: /?controller=index');

        include_once 'app/Models/RoleModel.php';
            
        // блок з валідацією
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (trim($id) !== "" && is_numeric($id)) {
            $role = (new Role())::one($this->conn, $id);

            include_once 'views/showRole.php';
        } else {
            header('Location: ?controller=roles');
        }
   }

   public function addForm() {
        if (!$this->isRestricted) header('Location: /?controller=index');

        include_once 'views/addRole.php';
   }

   public function add()
   {
        if (!$this->isRestricted) header('Location: /?controller=index');

       include_once 'app/Models/RoleModel.php';
       // блок з валідацією
       $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);



       if (trim($title) !== "") {
           // додати користувача
           $role = new Role($title);
           $role->add($this->conn);

           header('Location: ?controller=roles');
       }
   }

   public function update()
   {
        if (!$this->isRestricted) header('Location: /?controller=index');

        include_once 'app/Models/RoleModel.php';
        // блок з валідацією
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        if (trim($title) !== "" && trim($id) !== "") {
            // додати користувача
            $role = new Role($title);
            $role->update($this->conn, $id);

            header('Location: ?controller=roles');
        }
   }

    public function delete()
    {
        if (!$this->isRestricted) header('Location: /?controller=index');

        include_once 'app/Models/RoleModel.php';
        
        // блок з валідацією
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (trim($id) !== "" && is_numeric($id)) {
            (new Role())::delete($this->conn, $id);
        }

        header('Location: ?controller=roles');
    }
 
}
