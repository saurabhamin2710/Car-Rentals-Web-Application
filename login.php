<?php
    include 'functionsignup.php';
    $_SESSION['message'] = '';
    // $mysqli = new mysqli('localhost' ,'root','', 'accounts');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // $username = $mysqli->real_escape_string($_POST['username']);
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $str="SELECT * FROM users where username = '$username' and password = '$password'";
        $result=ExecuteQuery($str);
        $no_rows = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);

        
        if($no_rows < 1){
            $_SESSION['message'] = 'Invalid Credentials';
        }
        else{
            //admin and pass
            if($username == "admin" && $password == md5("pass"))
            {
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;
                $_SESSION['avatar'] = $row['avatar'];
                header("location: admin.php");
            }
            else
            {
                
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;
                $_SESSION['avatar'] = $row['avatar'];
                header("location: profile.php");
            }
            
            // echo $username;
            // die();
           
        }
    }
           
?>

<html>
    <head>
            <link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" href="signup.css" type="text/css">
            <link rel="stylesheet" href="navbar.css" type="text/css">
            <link rel="icon" href="pp.png" type="image/png" />
    </head>
    <body>
            
            <div class="navbar">
                    <ul>
                        <li><a href="homepage.html"> Home </a></li>
                        <li class="active"><a href="login.php"> Login </a></li>
                        <li ><a href="signup.php"> Sign Up </a></li>
                    </ul>
            </div>

            <div class="body-content">
                <div class="module">
                    <h1 class = "create"> <b>Login Your account </b> </h1>
                    <form class="form" action="login.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="alert alert-error"> <?= $_SESSION['message'] ?> </div>
                        <input type="text" placeholder="User Name" name="username" required />
                        <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
                        <input type="submit" value="Login" name="Login" class="btn btn-block btn-primary" />
                    </form>
                </div>
            </div>
    </body>
</html>