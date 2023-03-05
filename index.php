<?php

    require_once("vendor/autoload.php");
    require_once("app/DB/config.php");
    require_once("app/DB/result.php");
    require_once("app/DB/account.php");

    function RedirectToLogin(){
        header("Location: login.php");
        die();
    }

    $config = new DBConfig();
    $authDB = new AuthDB($config);
    if($_POST["username"] != null && $_POST["password"] != null){
        $result = $authDB->AuthDBLogin($_POST["username"], $_POST["password"]);
        if($result == null){
            RedirectToLogin();
        }
        echo "Hello, " . $result["username"];
    }
    else{
        RedirectToLogin();
    }

    if(isset($_POST["deleteId"])){
        if($_POST["deleteId"] != null){
            $result = DBResult::FromConfigSql($config, "DELETE FROM workers WHERE id = '$_POST[deleteId]'");
            if($result == null){
                RedirectToLogin();
            }
            echo "User deleted";  
        }
    }

    if(isset($_POST["addWorkerName"])){
        if($_POST["editWorkerId"] == null){
            $result = DBResult::FromConfigSql($config, "INSERT INTO workers (name, age, number, salary) VALUES ('$_POST[addWorkerName]', '$_POST[addWorkerAge]', '$_POST[addWorkerNumber]', '$_POST[addWorkerSalary]')");
            echo "Worker added";
        }
        else{
            $result = DBResult::FromConfigSql($config, "UPDATE workers SET name = '$_POST[addWorkerName]', age = '$_POST[addWorkerAge]', number = '$_POST[addWorkerNumber]', salary = '$_POST[addWorkerSalary]' WHERE id = '$_POST[editWorkerId]'");
            echo "Worker edited";
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <a href="login.php" class="btn btn-danger">Logout</a>
                <br>
                <form action="index.php" method="POST">
                    <input id="username" name="username" type="text" class="form-control d-none" id="usernameInput">
                    <input id="password" name="password" type="password" class="form-control d-none" id="passwordInput"></input>
                    <div class="mb-3">
                        <label for="idInput" class="form-label">Id</label>
                        <input id="editWorkerId" name="editWorkerId" type="text" class="form-control" id="idInput">
                    </div>
                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Name</label>
                        <input id="addWorkerName" name="addWorkerName" type="text" class="form-control" id="nameInput">
                    </div>
                    <div class="mb-3">
                        <label for="ageInput" class="form-label">Age</label>
                        <input id="addWorkerAge" name="addWorkerAge" type="text" class="form-control" id="ageInput">
                    </div>
                    <div class="mb-3">
                        <label for="numberInput" class="form-label">Number</label>
                        <input id="addWorkerNumber" name="addWorkerNumber" type="text" class="form-control" id="numberInput">
                    </div>
                    <div class="mb-3">
                        <label for="salaryInput" class="form-label">Salary</label>
                        <input id="addWorkerSalary" name="addWorkerSalary" type="text" class="form-control" id="salaryInput">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-3">Submit</button>
                    </div>
                    <?php

                    echo "<script defer>document.getElementById('username').value = '$_POST[username]';</script>";
                    echo "<script defer>document.getElementById('password').value = '$_POST[password]';</script>";
                    if(!isset($_POST["addWorkerName"])){
                        if(isset($_POST["editWorkerId"])){
                            $result = DBResult::FromConfigSql($config, "SELECT * FROM workers WHERE id = '$_POST[editWorkerId]'");
                            $row = $result->DBResultFetch();
                            echo "<script defer>document.getElementById('editWorkerId').value = '$row[id]';</script>";
                            echo "<script defer>document.getElementById('addWorkerName').value = '$row[name]';</script>";
                            echo "<script defer>document.getElementById('addWorkerAge').value = '$row[age]';</script>";
                            echo "<script defer>document.getElementById('addWorkerNumber').value = '$row[number]';</script>";
                            echo "<script defer>document.getElementById('addWorkerSalary').value = '$row[salary]';</script>";
                        }
                    }

                    ?>
                </form>
                <br>

                    <?php

                        $result = DBResult::FromConfigSql($config, "SELECT * FROM workers");

                    ?>

                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Age</th>
                                <th scope="col">Number</th>
                                <th scope="col">Salary</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                while($row = $result->DBResultFetch()){
                                    echo "<tr>";
                                    echo "<th scope='row'>" . $row['id'] . "</th>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['age'] . "</td>";
                                    echo "<td>" . $row['number'] . "</td>";
                                    echo "<td>" . $row['salary'] . "</td>";
                                    echo "<td><form action='index.php' method='POST'><input name='editWorkerId' type='text' class='form-control d-none' value='" . $row['id'] . "'><input name='username' type='text' class='form-control d-none' value='" . $_POST["username"] . "'><input name='password' type='text' class='form-control d-none' value='" . $_POST["password"] . "'><button type='submit' class='btn btn-warning'>Edit</button></form></td>";
                                    echo "<td><form action='index.php' method='POST'><input name='deleteId' type='text' class='form-control d-none' value='" . $row['id'] . "'><input name='username' type='text' class='form-control d-none' value='" . $_POST["username"] . "'><input name='password' type='text' class='form-control d-none' value='" . $_POST["password"] . "'><button type='submit' class='btn btn-danger'>Delete</button></form></td>";
                                    echo "</tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>