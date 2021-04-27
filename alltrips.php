<?php 
    session_start(); 

    if($_SESSION['loggedin'] == true){
        // $avatar = $_SESSION['avatar'];       
        // $username = $_SESSION['username'];             
        // echo $avatar;
        // echo $username;
        //die();
    }
    else{   
        header("location: login.php");
    }
                                  
           
?>
<html>
    <head>
        <!-- <link rel = "stylesheet" href = "admin.css"> -->
        <link rel = "stylesheet" href = "title.css">
        <link rel = "stylesheet" href = "profile.css">
        <link rel = "stylesheet" href = "bookacar.css">
        <link rel="icon" href="pp.png" type="image/png" />
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <li><a href="admin.php"> Admin Home </a></li>
                            <li class="active"><a href="alltrips.php"> All Trips </a></li>
                            <li> <a href="addcars.php"> Add Cars </a></li>
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
            <div class="adminhome">
                <h1>ADMIN HOMEPAGE</h1>
            </div>
        
            <div class="lists">
                <div class="carlist">
                    <?php   
                        include 'functionsignup.php';
                        $strr = "SELECT * from alltrips ";
                        $resultr = ExecuteQuery($strr);
                        // $rowr = mysqli_fetch_assoc($resultr);
                        $no_rows = mysqli_num_rows($resultr);
                        echo "<br/>";
                        echo "<h2>  All Trips : ";
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

                                $sk = "SELECT username from users where id = '$userid'";
                                $res = ExecuteQuery($sk);
                                $rw = mysqli_fetch_assoc($res);
                                $name = $rw['username'];
                                
                                echo "<div class='single'>";

                                echo "BookingID : ";
                                echo $bookingid;
                                echo " <b>|</b> ";

                                echo "UserName : ";
                                echo $name;
                                echo " <b>|</b> ";

                                echo "UserID : ";
                                echo $userid;
                                echo " <b>|</b> ";

                                echo "CarID : ";
                                echo $carid;
                                echo " <b>|</b> ";

                                echo "TimeStamp : ";
                                echo $timestamp;
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

                                // echo "<a class='bookbtn' href='return.php?id=$tripid'> <b> Return </b> </a>";
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



        
