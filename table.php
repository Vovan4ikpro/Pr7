<!doctype html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
   <style>
       .container {
           width: 400px;
       }
   </style>
</head>
<body style="padding-top: 3rem;">

<div class="container">
<?php
    $str = file_get_contents('database/users.csv');
    $lines = explode("\n",$str);
    $tmp = array();
    $user = array();
    $users = array();
    $i = 0;
    foreach ($lines as $line){
        $tmp = explode(",",$line);
        if(count($tmp)<4){
            continue;
        }
        $user['name']  = $tmp[0];
        $user['email']  = $tmp[1];
        $user['gender']  = $tmp[2];
        $user['photo'] = "<img src='".$tmp[3]."' width = 100 height = 100/>";
        $users[$i] = $user;
        $i++;
    }
    echo "<table>";
    foreach ($users as $line){
        echo "<tr>";
        foreach ($line as $user){
            echo "<td>$user</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <hr>
<a class="btn" href="adduser.php">return back</a>
</div>
</body>
</html>