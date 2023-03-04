<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'poppins', sans-serif;
}
body{
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-image: url(dashboard.png.jpg);
	background-position: center;
	background-size: cover;
}
.container{
    position: relative;
    bottom: 30px;
}
a{
    text-decoration: none;
}
button {
    border-radius: 4px;
    position: relative;
    left: 142px;
    top: 10px;
    height: 40px;
    width: 70px;
    font-size: 17px;
    font-weight: 500;
    background-color: transparent;
    color: #c8abab;
}
}

    </style>
</head>
<body>
    <div class="container">
        <h1>welcome to Dashboard</h1>
        <button><a href="logout.php" class = "btn btn-warning" >logout</a></button>
    </div>

    
</body>
</html>