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
    require 'db.php';
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $users[] = [
                'name' => $row['name'],
                'email' => $row['email'],
                'gender' => $row['gender'],
                'path'=>"<img src='".$row['path_to_img']."'width = 100 height = 100/>"
            ];
        }
    }
    echo "<table>";
    foreach ($users as $key=>$user){
        echo "<tr>";
        foreach ($user as $value){
            echo "<td>$value</td>";
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