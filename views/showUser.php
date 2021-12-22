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
        <?php if (count($user) < 1) : ?>
            <span>User No Found</span>
        <?php else : ?>
            <!-- Form to add User -->
            <h3>Show User Form</h3>
            <form action="?controller=users&action=update" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <div class="row">
                    <div class="field">
                        <label>Name: <input type="text" name="name" value="<?php echo $user['name']; ?>"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="field">
                        <label>E-mail: <input type="email" name="email" value="<?php echo $user['email']; ?>"><br></label>
                    </div>
                </div>
                <div class="row">
                    <div class="field">
                        <label>Password: <input type="password" name="password" value="<?= $user['password']; ?>"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="field">
                        <label>
                            <input class="with-gap" type="radio" name="gender" value="female" <?php if ($user['gender'] == 'female') echo 'checked'; ?>/>
                            <span>Female</span>
                        </label>
                    </div>
                    <div class="field">
                        <label>
                            <input class="with-gap"  type="radio" name="gender" value="male" <?php if ($user['gender'] == 'male') echo 'checked'; ?>/>
                            <span>Male</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="old_path_to_img" value="<?= $user['path_to_img']; ?>">
                    <div>Current avatar:</div><br>
                    <img src="<?= $user['path_to_img']; ?>" alt="" style="height: 100px;">
                </div>
                <div class="row">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Photo</span>
                            <input type="file" name="photo"  accept="image/png, image/gif, image/jpeg">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
                <?php if (isset($_GET['error'])) : ?>
                    <span style="color: #ca2525;"><?= $_GET['error']; ?></span><br>
                <?php endif; ?>
                <input type="submit" class="btn" value="Save">
                <a href="/?controller=users" class="btn">Return to users</a>
            </form>
        <?php endif; ?>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
