<?php

    require_once("vendor/autoload.php");
    require_once("app/DB/config.php");
    require_once("app/DB/result.php");
    require_once("app/DB/account.php");
    
    function RedirectToLogin(){
        header("Location: login.php");
        die();
    }

    if(isset($_POST["username"])){
        if($_POST["username"] != null && $_POST["password"] != null){
            $authDB = new AuthDB(new DBConfig());
            $findResult = $authDB->GetUserByLogin($_POST["username"]);
            if($findResult != null){
                echo "User already exists";
            }
            else{
                $registerResult = $authDB->RegisterUser($_POST["username"], $_POST["password"]);
                if($registerResult != null){
                    echo "User registered";
                    RedirectToLogin();
                }
                else{
                    echo "User not registered";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
    <body>
        <div class="container">
            <form action="#" method="POST">
                <div class="mb-3">
                    <label for="usernameInput" class="form-label">Username</label>
                    <input name="username" type="text" class="form-control" id="usernameInput">
                </div>
                <div class="mb-3">
                    <label for="passwordInput" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="passwordInput"></input>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">Register</button>
                </div>
            </form>
            <a class="btn btn-secondary" href="login.php">Login</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>
