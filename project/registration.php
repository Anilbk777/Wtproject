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
    <title>Registration Form</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/5585e6d662.js" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <div class="form login">
        <?php 
        if(isset($_POST['submit'])){
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat-password"];

            $passwordHash = password_hash($password , PASSWORD_DEFAULT);

            $error = array();


            if (empty($fullname) OR empty($email) OR empty($password) OR empty($passwordRepeat)){
               array_push($error,"All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($error," Email isnot valid");
             }
             if (strlen($password)<8){
                array_push($error,"Password must be at least 8 character long ");
             }
             if($password!==$passwordRepeat){
                array_push($error,"Password doesnot match");
             }

             require_once "database.php";
             $sql = "SELECT * FROM users WHERE email = '$email'";
             $result = mysqli_query($conn, $sql);
             $rowCount = mysqli_num_rows($result);
             if($rowCount>0){
                array_push($error, "Email already exists!");
             }

             if(count($error)>0){
                foreach($error as $err){
                    echo"<div class = 'alert alert-danger'>$err</div>";
                }
             }
             else{
                $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt, "sss",$fullname,$email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo"You are reigistered successfully";
                }
                else{
                    die("Something went wrong");
                }
             }
        }

        ?>
        <div class = "title">Registration</div>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" name = "fullname" placeholder = "Full Name" required>
                <i class="fa-solid fa-user icon"></i>
            </div>
            <div class="form-group">
                <input type="email" name = "email" placeholder = "Email" required>
                <i class="fa-solid fa-envelope icon"></i>
            </div>
            <div class="form-group">
                <input type="text" class = "Password" name = "password" placeholder = "Password" required>
                <i class="fa-solid fa-lock icon  "></i>
                <!-- <i class="fa-solid fa-eye-slash showHidepw showhidepass"></i> -->
            </div>
            <div class="form-group">
                <input type="text" class = "password" name = "repeat-password" placeholder = "Confirm Password" required>
                <i class="fa-solid fa-lock icon" ></i>
                <i class="fa-solid fa-eye-slash showHidepw"></i>

            </div>
            <div class="form-group button"> <!-- group -->
                <input type="submit" name = "submit" value="Register" name = "submit">
            </div>
        </form>
        <div class = "alreadyRegistered"><p>Already Registered?<a href="login.php">login Here</a></p></div>
        </div>
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