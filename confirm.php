
<?php 
    include 'functionsignup.php';
    session_start(); 
    if($_GET['id']){
        $variable = $_GET['id'];
        //echo $variable;
    }
    else{
     
        $mysqli = new mysqli('localhost' ,'root','', 'accounts');
        $username = $_SESSION['username'];
        // echo $username;

        $strk = "SELECT * from users where username = '$username' ";
        $resultk = ExecuteQuery($strk);
        $rowk = mysqli_fetch_assoc($resultk);
        //$variable = $rowk['id'];

    }
    if($_SESSION['loggedin'] == true){
        if($_SESSION['username'] == "admin" )
            {
                $_SESSION['loggedin'] = false;
                header("location: login.php");
            }
    }
    else{   
        header("location: login.php");
    }
    
                                  
           
?>
<html>
    <head>
        <link rel = "stylesheet" href = "admin.css">
        <link rel = "stylesheet" href = "bookacar.css">
        <link rel = "stylesheet" href = "profile.css">
        <link rel = "stylesheet" href = "confirm.css">
        <link rel="icon" href="pp.png" type="image/png" />
        <!-- <link rel="stylesheet" href="signup.css" type="text/css"> -->
        
    </head> 
    <body>
        <div class="mainpage">
            
            <div class="navbar">
                        <ul>
                            <!-- <li class="active"><a href="profile.php"> Profile </a></li>
                            <li><a href="bookacar.php"> Book A Car </a></li>
                            <li><a href="wallet.php"> Wallet </a></li>
                            <li><a href="viewoffers.php"> Offers </a></li>
                            <li><a href="#"> Transaction History </a></li> -->
                            <li class="active"><a href="#"> Confirm Booking </a></li>
                        </ul>
            </div>
            <div class="navbar2">
                    <ul class="nav">
                    <li><img class="image"  src = '<?= $_SESSION['avatar'] ?>' width="50" height="50" style="border: 1px solid black" > </li>    
                    <li class ="reference"><b>Currently Logged in as : </b><div class = "profilename"> <b><?= $_SESSION['username'] ?></b> </div> </li>
                        <li><a href="logout.php"> Logout </a></li>
                    </ul>
            </div>
            <div class="lists">
                <div class="carlist">
                    <?php 
                        //include 'functionsignup.php';
                        // session_start();
                         
                        $str = "call selectCar('$variable')";
                        $result = ExecuteQuery($str);
                        $no_rows = mysqli_num_rows($result);
                        if($result){
                            $row = mysqli_fetch_assoc($result);
                            $carid = $row['carid'];
                            $avail = $row['availability'];
                            $carname = $row['carname'];
                            $carnum = $row['carnum'];
                            $carimage_path = $row['carpic'];
                            $carrating = $row['carrating'];
                            $dist = $row['cardist'];

                            echo "<h2> Selected Car for Booking : Car Name = $carname & Car Num-plate = $carnum";
                            // echo $variable;
                            echo "</h2>";
                            echo "<br/>";
                            echo "<hr>";
                            echo "<br/>";
                            echo "<div class='single'>";
                            

                            echo "Car ID : ";
                            echo $carid;
                            echo " <b>|</b> ";
                            echo "Car Name : ";
                            echo $carname;
                            echo " <b>|</b> ";
                            echo "Car Number Plate : ";
                            echo $carnum;
                            
                            echo " <b>|</b> ";
                            echo "Car Rating : ";
                            if($carrating == 0){
                                echo "NULL";
                            }
                            else{
                                echo $carrating;
                            }
                            echo " <b>|</b> ";
                            echo "Dist. Travelled : ";
                            echo $dist;
                            echo " <b>|</b> ";
                            echo "<img class='carimg' src='$carimage_path' width= '50' height='50' style='border: 1px solid black'>";
                            echo "<br/><br/>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
            <div class="confirm">
                    <h2 class="headername">Confirm Your Booking</h2>
                    <br>
                    <hr class="hrclass" >
                    <br>
                    <br>
                    <a href="bookacar.php" class="btn2">Cancel</a>
                    <?php
                        echo "<a href='book.php?id=$variable' class='btn1'> Confirm </a>";
                    ?>
            </div>
        </div>
        
    </body>
    
</html>



        
