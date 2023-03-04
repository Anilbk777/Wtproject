<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/5585e6d662.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="form login">
        <?php
        if (isset($_POST["login"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($user){
                if(password_verify($password, $user["password"])){
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                }
                else{
                    echo"Password doesnot match";
                }
            }else{
                echo"Email doesnot match";
            }
        } ?>
     <div class = "title">Login</div>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" name = "email" placeholder = " Enter Email"  required>
                <i class="fa-solid fa-envelope icon"></i>
            </div>
            <div class="form-group">
                <input type="text" name = "password" class = "password" placeholder = " Enter Password"   required>
                <i class="fa-solid fa-lock icon  "></i>
                <i class="fa-solid fa-eye-slash showHidepw"></i>
            </div>
            <div class="form-group button">
                <input type="submit" value="Log In" name="login" class="btn btn-primary">
            </div>
        </form>
        </div>

        <div class = "notregistered"><p>Not registered yet? <a href="registration.php">Register Here</a></p></div>

    </div>
    


    <script>
        const container = document.querySelector(".container"),
        pwShowHide = document.querySelectorAll(".showHidepw"),
        pwFields = document.querySelectorAll(".password");

        pwShowHide.forEach(eyeIcon =>{
            eyeIcon.addEventListener("click",()=>{
                pwFields.forEach(pwField =>{
                    if(pwField.type == "password"){
                        pwField.type = "text";

                        pwShowHide.forEach(icon =>{
                            icon.classList.replace("fa-eye-slash","fa-eye")
                        })
                    }
                    else{
                        pwField.type = "password";
                        pwShowHide.forEach(icon =>{
                            icon.classList.replace("fa-eye","fa-eye-slash")
                        })
                    }
                })
            })
        })

</script>
        
</body>
</html>