<?php
    class Route {
        function loadPage($db, $controllerName, $actionName = 'index'){
            include_once 'app/Controllers/IndexController.php';
            include_once 'app/Controllers/UsersController.php';
            include_once 'app/Controllers/CommentsController.php';
            include_once 'app/Controllers/AdminController.php';

               switch ($controllerName) {
                   case 'users':
                       $controller = new UsersController($db);
                       break;
                    case 'comments':
                        $controller = new CommentsController($db);
                        break;
                    case 'admin':
                        $controller = new AdminController($db);
                        break;
                   default:
                       $controller = new IndexController($db);
               }
            // запускаємо необхідний метод
            $controller->$actionName();
        }
    }
