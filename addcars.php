<link rel = "stylesheet" href = "addcars.css">
<link rel = "stylesheet" href = "admin.css">
<link rel="icon" href="pp.png" type="image/png" />
<?php 
    include 'functionsignup.php';
    session_start(); 

    if($_SESSION['loggedin'] == true){
    }
    else{   
        header("location: login.php");
    }

    
    
    $_SESSION['message'] = '';

    $mysqli = new mysqli('localhost' ,'root','', 'accounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['carnum'] == $_POST['confirmcarnum']){
            echo $carnum;
            $carname = $mysqli->real_escape_string($_POST['carname']);
            $carimage_path = $mysqli->real_escape_string('cars/'.$_FILES['carimage']['name']);
            $carnum = $mysqli->real_escape_string($_POST['carnum']);

            $str = " SELECT * FROM cars where carnum = '$carnum' ";
            $result=ExecuteQuery($str);
            $no_rows = mysqli_num_rows($result);
            if($no_rows > 0){
                $_SESSION['message'] = 'Car Already Exist with this Credentials num-plate';
            }
            else{
//
            //make sure file type is image
                if(preg_match("!image!",$_FILES['carimage']['type'])){

                    //copy the image to the images folder
                    if(copy($_FILES['carimage']['tmp_name'] ,  $carimage_path)){

                        $_SESSION['username'] = $username;
                        // $_SESSION['avatar'] = $avatar_path;
                        
                        $sql = "INSERT INTO cars (carname , availability , carpic , carnum ) " . "VALUES ('$carname' ,'A'  ,'$carimage_path' , '$carnum' )";
                       
                        if($mysqli->query($sql) === true){
                            $_SESSION['message'] = "Car Registration successful , Car $carname with $carnum to the database";
                            $_SESSION['loggedin'] = true;
                            header("location: carlist.php");
                        }
                        else{
                            $_SESSION['message'] = "Car could not be added to the database";
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
            $_SESSION['message'] = "Two Car Number Plates did not match";
        }
    }


                                  
           
?>
<html>
    <head>
        <link rel = "stylesheet" href = "admin.css">
        <link rel = "stylesheet" href = "bookacar.css">
        <link rel = "stylesheet" href = "profile.css">
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <li><a href="admin.php"> Admin Home </a></li>
                            <li><a href="alltrips.php"> All Trips </a></li>
                            <li class="active"><a href="addcars.php" > Add Cars </a></li>
                            <li> <a href="carlist.php"> Cars List </a></li>
                            <li> <a href="addoffers.php"> Add Offers </a></li>
                            <li> <a href="offerlist.php"> Offers List </a></li>
                        </ul>
            </div>
            <div class="navbar2">
                    <ul class="nav">
                        <li><img class="image"  src = '<?= $_SESSION['avatar'] ?>' width="50" height="50" style="border: 1px solid black" > </li>    
                        <li class ="reference"><b>Currently Logged in as : </b><div class = "profilename"> <b><?= $_SESSION['username'] ?></b> </div> </li>
                        <li><a href="logout.php"> Logout </a></li>
                    </ul>
            </div>
            <h1>ADMIN HOMEPAGE</h1>
            <div class ="add">
                <div class="module">
                    <h1 class = "create"> <b> Add Car </b> </h1>
                    <form class="form" action="addcars.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="alert alert-error"> <?= $_SESSION['message'] ?> </div>
                        <input type="text" placeholder="Car Name" name="carname" required />
                        <input type="text" placeholder="Car Number Plate" name="carnum"  required />
                        <input type="text" placeholder="Confirm Car Number Plate" name="confirmcarnum"  required />
                        <div class="avatar"><label>Add Car Image : </label><input type="file" name="carimage" accept="image/*" required /></div>
                        <input type="submit" value="Register car" name="register" class="btn btn-block btn-primary" />
                    </form>
                </div>
            </div>
        </div>

        
        
    </body>
    
</html>



        
