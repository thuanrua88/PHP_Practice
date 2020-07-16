<?php
session_start();
require_once 'connectdb.php';
$conn = new mysqli($hn, $un, $pw, $db);
if($conn -> connect_errno) die("Connect DB error");

if (isset($_POST['register']))
{
    $name = $_POST['name'];
    $fullname = $_POST['fullname'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $email = $_POST['email'];

    if ($pass == $cpass)
    {
        $hash = password_hash($pass,PASSWORD_DEFAULT);
        $query = "select * from register where username = '$name'";
        $result = $conn->query($query);
        $rows = $result->num_rows;
        if ($rows > 0)
        {
            echo $name . ' has exits!';
        } else
        {
            $query = "INSERT INTO register(fullname, email, username, password) VALUES ('$fullname','$email','$name','$hash')";
            $result = $conn->query($query);
            if ($result)
            {
                setcookie('username',$name,time()+3600);
                setcookie('fullname',$fullname,time()+3600);
                header('location: welcome.php');
            }
            else echo 'Register fail !';
        }
    } else echo 'password and config password is not match !';
}

?>
<!--  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .register {
            color: white;
            font-weight: 900;
            padding: 5px;

            border-radius: 10px;
            background: rgb(53, 132, 235) !important;
        }
        .register:hover {
            background: rgb(21,99,203) !important;
        }
    </style>
</head>

<body>
<div class="container d-flex align-items-center flex-column">
    <h1 class="font-weight-bold">Register</h1>

    <form action="register.php" method="post" class="form-group d-flex flex-column w-50 border p-2">
        <label for="Name">User Name</label>
        <input type="text" name="name" required><br>

        <label for="Name">Full name</label>
        <input type="text" name="fullname" required><br>

        <label for="Password">Password</label>
        <input type="password" name="password" required><br>

        <label for="conpass">Confirm password</label>
        <input type="password" name="cpassword" required><br>

        <label for="Email">Email</label>
        <input type="email" name="email" required><br>


        <input type="submit" value="Register" name="register" class="mt-3 register">
        <input type="submit" name="login" class="mt-3 register" value="Login">
    </form>
</div>
</body>

</html>