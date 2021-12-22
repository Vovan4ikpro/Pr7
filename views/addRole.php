<!doctype html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
   <style>
       body{
           padding-top: 3rem;
       }
       .container {
           width: 400px;
       }
   </style>
</head>
<body>
<div class="container">
            <!-- Form to add Role -->
            <h3>Add New Role</h3>
            <form action="?controller=roles&action=add" method="post">
                <div class="row">
                    <div class="field">
                        <label>Title: <input type="text" name="title"></label>
                    </div>
                </div>
                <input type="submit" class="btn" value="Add">
                <a href="/?controller=roles" class="btn">Table</a>
   <a class="btn" href="?controller=index&action=logout">Logout</a>
                <?php if (isset($_GET['error'])) : ?>
                    <span style="color: #ca2525;"><?= $_GET['error']; ?></span>
                <?php endif; ?>
            </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
