<?php
    include 'functionsignup.php';
    session_start();
    // $_SESSION['message'] = '';

    $mysqli = new mysqli('localhost' ,'root','', 'accounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['password'] == $_POST['confirmpassword']){
            $username = $mysqli->real_escape_string($_POST['username']);
            $email = $mysqli->real_escape_string($_POST['email']);
            $password = md5($_POST['password']); //md5 hash password security
            $avatar_path = $mysqli->real_escape_string('images/'.$_FILES['avatar']['name']);
//
// checks if username is already registered or not

            $str = " SELECT checkuser('$username','$email') as numRows ";
            $result=ExecuteQuery($str);
            $row = mysqli_fetch_assoc($result);

            $numRows = $row['numRows'];
            if($numRows > 0){
                $_SESSION['message'] = 'User Already Exist with this Credentials';
            }
            else{
//
            //make sure file type is image
                if(preg_match("!image!",$_FILES['avatar']['type'])){

                    //copy the image to the images folder
                    if(copy($_FILES['avatar']['tmp_name'] ,  $avatar_path)){

                        $_SESSION['username'] = $username;
                        $_SESSION['avatar'] = $avatar_path;
                        
                        $sql = "INSERT INTO users (username , email , password , avatar) " . "VALUES ('$username' , '$email' , '$password' , '$avatar_path')";

                        // if the query is successful redirect to welcome.php page , done!
                        if($mysqli->query($sql) === true){
                            $_SESSION['message'] = "Registration successful , added $username to the database";
                            $_SESSION['loggedin'] = true;

                            $sql = "SELECT * from users where username = '$username'";
                            $result = ExecuteQuery($sql);
                            $row = mysqli_fetch_assoc($result);
                            $idd = $row['id'];

                            $strr = "SELECT * from offers where userid = 27 ";
                            $resultr = ExecuteQuery($strr);
                            while($rowr = mysqli_fetch_assoc($resultr)){
                                $offername = $rowr['offername'];
                                $discount = $rowr['discount'];

                                $sql = "INSERT INTO offers (offername , userid , discount ) " . "VALUES ('$offername' ,'$idd' , '$discount')";
                                $result = ExecuteQuery($sql);
                            }

                            
                            header("location: profile.php");
                        }
                        else{
                            $_SESSION['message'] = "User could not be added to the database";
                        }
                    
                    }
                    else{
                        $_SESSION['message'] = "File upload FAiled";
                    }
                }
                else{
                    $_SESSION['message'] = "Please only upload jpg , png type of files";
                }
            }
        }
        else{
            $_SESSION['message'] = "two passwords did not match";
        }
    }

?>

<html>
    <head>
            <link rel="icon" href="pp.png" type="image/png" />
            <link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" href="signup.css" type="text/css">
            <link rel="stylesheet" href="navbar.css" type="text/css">
    </head>
    <body>
            
            
            <div class="navbar">
                    <ul>
                        <li><a href="homepage.html"> Home </a></li>
                        <li><a href="login.php"> Login </a></li>
                        <li class="active"><a href="signup.php"> Sign Up </a></li>
                    </ul>
            </div>

            <div class="body-content">
                <div class="module">
                    <h1 class = "create"> <b>Create an account </b> </h1>
                    <form class="form" action="signup.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="alert alert-error"> <?= $_SESSION['message'] ?> </div>
                        <input type="text" placeholder="User Name" name="username" required />
                        <input type="email" placeholder="Email" name="email" required />
                        <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
                        <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
                        <div class="avatar"><label>Select your avatar: </label><input type="file" name="avatar" accept="image/*" required /></div>
                        <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
                    </form>
                </div>
            </div>
    </body>
</html>
