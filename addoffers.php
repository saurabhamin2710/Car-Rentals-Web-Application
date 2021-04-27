
<link rel = "stylesheet" href = "admin.css">
<?php 
    include 'functionsignup.php';
    session_start(); 

    if($_SESSION['loggedin'] == true){
    }
    else{   
        header("location: login.php");
    }

    
    
    // $_SESSION['message'] = '';

    $mysqli = new mysqli('localhost' ,'root','', 'accounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $offername = $mysqli->real_escape_string($_POST['offername']);
            $discount = $mysqli->real_escape_string($_POST['discount']);

            $str = " SELECT * FROM offers where offername = '$offername' ";
            $result=ExecuteQuery($str);
            $no_rows = mysqli_num_rows($result);

            if($no_rows > 0){
                $_SESSION['message'] = 'This Offer is Already Added to the Database';
            }
            else{
                $strr = "SELECT * from users ";
                $resultr = ExecuteQuery($strr);
                
                while($rowr = mysqli_fetch_assoc($resultr)){
                    $userid = $rowr['id'];
                    $sql = "INSERT INTO offers (offername , userid , discount ) " . "VALUES ('$offername' ,'$userid' , '$discount')";
                    $result = ExecuteQuery($sql);
                }
                $_SESSION['loggedin'] = true;
                header("location: offerlist.php");
            }
    }        
?>


<html>
    <head>
        <link rel = "stylesheet" href = "addcars.css">
        <link rel = "stylesheet" href = "admin.css">
        <link rel = "stylesheet" href = "bookacar.css">
        <link rel = "stylesheet" href = "profile.css">
        <link rel="icon" href="pp.png" type="image/png" />
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <li><a href="admin.php"> Admin Home </a></li>
                            <li><a href="alltrips.php"> All Trips </a></li>
                            <li ><a href="addcars.php" > Add Cars </a></li>
                            <li> <a href="carlist.php"> Cars List </a></li>
                            <li class="active"><a href="addoffers.php" > Add Offers </a></li>
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
            <!-- <div class="body-content"> -->
                <div class="module">
                    <h1 class = "create"> <b> Add an Offer </b> </h1>
                    <form class="form" action="addoffers.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="alert alert-error"> <?= $_SESSION['message'] ?> </div>
                        <input type="text" placeholder="Offer Name" name="offername" required />
                        <input type="text" placeholder="Discount Value" name="discount"  required />
                        <input type="submit" value="Add Offer" name="register" class="btn btn-block btn-primary" />
                    </form>
                </div>
            <!-- </div> -->
        </div>
        </div>

        
        
    </body>
    
</html>



        
