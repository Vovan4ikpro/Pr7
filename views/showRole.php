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
        <?php if (count($role) < 1) : ?>
            <span>Role No Found</span>
        <?php else : ?>
            <!-- Form to add Role -->
            <h3>Show Role Form</h3>
            <form action="?controller=roles&action=update" method="post">
                <input type="hidden" name="id" value="<?php echo $role['id']; ?>">
                <div class="row">
                    <div class="field">
                        <label>Title: <input type="text" name="title" value="<?php echo $role['title']; ?>"></label>
                    </div>
                </div>
                <?php if (isset($_GET['error'])) : ?>
                    <span style="color: #ca2525;"><?= $_GET['error']; ?></span><br>
                <?php endif; ?>
                <input type="submit" class="btn" value="Save">
                <a href="/?controller=roles" class="btn">Return to roles</a>
            </form>
        <?php endif; ?>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
