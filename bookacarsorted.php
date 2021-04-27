<link rel = "stylesheet" href = "profile.css">
<?php 
    session_start(); 
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
        <link rel = "stylesheet" href = "bookacar.css">
        <link rel="icon" href="pp.png" type="image/png" />
        <!-- <link rel = "stylesheet" href = "admin.css"> -->
        <link rel="stylesheet" href="signup.css" type="text/css">
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <li><a href="profile.php"> Profile </a></li>
                            <li class="active"><a href="bookacar.php"> Book A Car </a></li>
                            <li><a href="wallet.php"> Wallet </a></li>
                            <li><a href="viewoffers.php"> Offers </a></li>
                            <li><a href="viewtransaction.php"> Transaction History </a></li>
                        </ul>
            </div>
            <div class="navbar2">
                    <ul class="nav">
                    <li><img class="image"  src = '<?= $_SESSION['avatar'] ?>' width="50" height="50" style="border: 1px solid black" > </li>    
                    <li class ="reference"><b>Currently Logged in as : </b><div class = "profilename"> <b><?= $_SESSION['username'] ?></b> </div> </li>
                        <li><a href="logout.php"> Logout </a></li>
                    </ul>
            </div>

            <div class="sorting">
                    <div class="button1">
                        <a href="bookacar.php" class="btn1">Default</a>
                        <a href="bookacarsorted.php" class="btn1 active">Sort by Rating</a>
                        <a href="bookacarsorteddist.php" class="btn1">Sort by Distance</a>                                                                    
                    </div>
            </div>

            <div class="lists">
                <div class="carlist">
                    <?php 
                        include 'functionsignup.php';
                        session_start();
                                
                        $str = "SELECT * from cars where availability = 'A' ORDER BY carrating DESC";
                        $result=ExecuteQuery($str);
                        // $row = mysqli_fetch_assoc($result);
                        $no_rows = mysqli_num_rows($result);
                        if($result){
                            echo "<h2>  No. of Cars Available : ";
                            echo $no_rows;
                            echo "</h2>";
                            echo "<br/>";
                            echo "<hr>";
                            echo "<br/>";
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<div class='single'>";
                                $carid = $row['carid'];
                                $avail = $row['availability'];
                                $carname = $row['carname'];
                                $carnum = $row['carnum'];
                                $carimage_path = $row['carpic'];
                                $carrating = $row['carrating'];
                                $dist = $row['cardist'];

                                echo "Car ID : ";
                                echo $carid;
                                echo " <b>|</b> ";
                                echo "Car Name : ";
                                echo $carname;
                                echo " <b>|</b> ";
                                echo "Car Number Plate : ";
                                echo $carnum;
                                // echo " <b>|</b> ";
                                // echo "Car Availability (A/U) : ";
                                // echo $avail;
                                echo " <b>|</b> ";
                                echo "Dist. Travelled : ";
                                echo $dist;
                                echo " <b>|</b> ";
                                echo "Car Rating : ";
                                if($carrating == 0){
                                    echo "NULL";
                                }
                                else{
                                    echo $carrating;
                                }
                                echo " <b>|</b> ";
                                echo "<img class='carimg' src='$carimage_path' width= '50' height='50' style='border: 1px solid black'>";
                                echo " <b>|</b> ";
                                //........
                                echo "<a class='bookbtn' href='confirm.php?id=$carid'> <b> Book </b> </a>";
                                echo "<br/><br/>";
                                echo "</div>";
                                //...
                            }
                        }
                        else{
                            echo "<h2> No. of Cars Registered : 0 </h2>";
                        }
                    ?>
                </div>
            </div>
        </div>
              
            
        
        
    </body>
    
</html>
