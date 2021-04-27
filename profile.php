
<?php 
    include 'functionsignup.php';
    session_start(); 
    if($_GET['id']){
        $variable = $_GET['id'];
        echo $variable;
    }
    else{
     
        $mysqli = new mysqli('localhost' ,'root','', 'accounts');
        $username = $_SESSION['username'];
        // echo $username;

        $strk = "SELECT * from users where username = '$username' ";
        $resultk = ExecuteQuery($strk);
        $rowk = mysqli_fetch_assoc($resultk);
        $variable = $rowk['id'];

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
        <link rel="icon" href="pp.png" type="image/png" />
        <!-- <link rel="stylesheet" href="signup.css" type="text/css"> -->
        
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <!-- <li><a href="homepage.html"> Home </a></li> -->
                            <li class="active"><a href="profile.php"> Profile </a></li>
                            <li><a href="bookacar.php"> Book A Car </a></li>
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
            
            <div class="lists">
                <div class="carlist">
                    <?php   
                        
                        // $mysqli = new mysqli('localhost' ,'root','', 'accounts');
                        // $username = $_SESSION['username'];
    

                        // $str = "SELECT bookingid from trips where completed = 'U'";
                        // $result = ExecuteQuery($str);

                        // while($row = mysqli_fetch_assoc($result)){

                        // }

                        $mysqli = new mysqli('localhost' ,'root','', 'accounts');

                        //$strk = "SELECT * from users where username = '$username' ";
                        $strk = "SELECT getUserid('$username') as id";
                        $resultk = ExecuteQuery($strk);
                        $rowk = mysqli_fetch_assoc($resultk);
                        $variable = $rowk['id'];

                        

                        $strr = "SELECT * from alltrips where userid = '$variable' and completed = 'U' ";
                        $resultr = ExecuteQuery($strr);
                        $rowr = mysqli_fetch_assoc($resultr);
                        $no_rows = mysqli_num_rows($resultr);

                        $bookingid = $rowr['tripid'];    
                        $userid = $rowr['userid'];
                        $tripstart = $rowr['timestampbook'];
                        $tripend = $rowr['timestampreturn'];
                        $carid = $rowr['carid'];

                        //echo $variable;
                        if($no_rows == 1)
                        {
                            echo "<br/>";
                            echo "<h2>  Currently Number of Booked Cars (Limit - 1) : ";
                            echo $no_rows;
                            echo "</h2>";
                            echo "<br/>";
                            echo "<hr>";
                            echo "<br/>";
                            echo "<div class='single'>";

                            echo "BookingID : ";
                            echo $bookingid;
                            echo " <b>|</b> ";

                            // echo "UserName : ";
                            // echo $username;
                            // echo " <b>|</b> ";

                            echo "UserID : ";
                            echo $userid;
                            echo " <b>|</b> ";

                            echo "CarID : ";
                            echo $carid;
                            echo " <b>|</b> ";

                            echo "Trip Start : ";
                            echo $tripstart;
                            echo " <b>|</b> ";

                            echo "Trip End : ";
                            echo $tripend;
                            echo " <b>|</b> ";

                            $strsk = "SELECT * from cars where carid = '$carid' ";
                            $resultsk = ExecuteQuery($strsk);
                            $rowsk = mysqli_fetch_assoc($resultsk);
                            
                            $carname = $rowsk['carname'];
                            $carnum = $rowsk['carnum'];
                            $carpic = $rowsk['carpic'];
                            $avail = $rowsk['availability'];

                            echo "Car Name : ";
                            echo $carname;
                            echo " <b>|</b> ";

                            echo "Car Num : ";
                            echo $carnum;
                            echo " <b>|</b> ";

                            echo "Availability : ";
                            echo $avail;
                            echo " <b>|</b> ";

                            echo "Car Pic : ";
                            echo "<img class='carimg' src='$carpic' width= '50' height='50' style='border: 1px solid white'>";
                            echo " <b>|</b> ";
                            
                            echo "<a class='bookbtn' href='transaction.php'> <b> Return </b> </a>";
                            //echo "<a class='bookbtn' href='.php?id=$bookingid'> <b> Return </b> </a>";
                            echo "</div>";
                            echo "<br/><br/>";
                            
                            // echo "dummy";
                            
                        }
                        else
                        {
                            echo "<br/>";
                            echo "<h2>  Currently No Cars are Booked by '$username' user :  ";
                            echo $no_rows;
                            echo "</h2>";
                        }
                    ?>
                </div>
            </div>

            <div class="lists">
                <div class="carlist">
                    <?php   
                        $strr = "SELECT * from alltrips where userid = '$variable' and completed != 'U' ";
                        $resultr = ExecuteQuery($strr);
                        // $rowr = mysqli_fetch_assoc($resultr);
                        $no_rows = mysqli_num_rows($resultr);
                        echo "<br/>";
                        echo "<h2>  Total Trips Taken : ";
                        echo $no_rows;
                        // echo $variable;
                        echo "</h2>";
                        echo "<br/>";
                        echo "<hr>";
                        echo "<br/>";
                        

                        //echo $variable;
                        if($no_rows >= 1)
                        {
                            while($rowr = mysqli_fetch_assoc($resultr)){
                                $bookingid = $rowr['tripid'];    
                                $userid = $rowr['userid'];
                                $timestamp = $rowr['timestampbook'];
                                $carid = $rowr['carid'];
                                $tripdist = $rowr['tripdist'];
                                
                                echo "<div class='single'>";

                                echo "BookingID : ";
                                echo $bookingid;
                                echo " <b>|</b> ";

                                // echo "UserName : ";
                                // echo $username;
                                // echo " <b>|</b> ";

                                // echo "UserID : ";
                                // echo $userid;
                                // echo " <b>|</b> ";

                                echo "CarID : ";
                                echo $carid;
                                echo " <b>|</b> ";

                                echo "TripDist : ";
                                echo $tripdist;
                                echo " Km <b>|</b> ";

                                echo "Journey Start : ";
                                echo $timestamp;
                                echo " <b>|</b> ";

                                echo "End time: ";
                               
                                echo " <b>|</b> ";

                                $strsk = "SELECT * from cars where carid = '$carid' ";
                                $resultsk = ExecuteQuery($strsk);
                                $rowsk = mysqli_fetch_assoc($resultsk);
                                
                                $carname = $rowsk['carname'];
                                $carnum = $rowsk['carnum'];
                                $carpic = $rowsk['carpic'];
                                // $avail = $rowsk['availability'];

                                echo "Car Name : ";
                                echo $carname;
                                echo " <b>|</b> ";

                                echo "Car Num : ";
                                echo $carnum;
                                echo " <b>|</b> ";

                                // echo "Availability : ";
                                // echo $avail;
                                // echo " <b>|</b> ";

                                echo "Car Pic : ";
                                echo "<img class='carimg' src='$carpic' width= '50' height='50' style='border: 1px solid white'>";
                                // echo " <b>|</b> ";

                                
                                echo "</div>";
                                echo "<br/><br/>";
                                
                                // echo "dummy";
                            }
                            
                            

                        }
                        else
                        {
                            echo "<br/>";
                            echo "<h2>  No Trips Taken :  ";
                            echo $no_rows;
                            echo "</h2>";
                        }
                    
                    ?>
                </div>
            </div>
        </div>
        
    </body>
    
</html>



        
