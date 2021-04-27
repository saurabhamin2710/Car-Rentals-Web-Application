<!-- <link rel = "stylesheet" href = "signup.css"> -->
<link rel = "stylesheet" href = "admin.css">
<?php 
    session_start(); 
    include 'functionsignup.php';
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
        <link rel = "stylesheet" href = "admin.css">
        <link rel = "stylesheet" href = "bookacar.css">
        <link rel = "stylesheet" href = "profile.css">
        <link rel="icon" href="pp.png" type="image/png" />
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <li class="active"><a href="admin.php"> Admin Home </a></li>
                            <li><a href="alltrips.php"> All Trips </a></li>
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
            <h1>ADMIN HOMEPAGE</h1>

            <div class="sorting2">
                    <div class="button2">
                        <b>
                            <a href="admin.php" class="btn2 "> (Default ALL ) Total Money Earned : 
                                <?php 
                                    $mysqli = new mysqli('localhost' ,'root','', 'accounts');
                                    $strr = "SELECT SUM(costoftrip) as cash FROM transaction";
                                    $resultr = ExecuteQuery($strr);
                                    $row = mysqli_fetch_assoc($resultr);
                                    $cash = $row['cash'];
                                    echo $cash;
                                ?>
                            </a>  
                        </b>   
                            <a href="admintoday.php" class="btn2 ">Today</a>
                            <a href="adminweek.php" class="btn2 ">Last Week</a> 
                            <a href="adminmonth.php" class="btn2 active2">Last month</a>                                                            
                    </div>
            </div>

            <div class="lists">
                <div class="carlist">
                    <?php   
                        
                        $mysqli = new mysqli('localhost' ,'root','', 'accounts');

                        $strr = "call adminDisplayTransaction(30)";
                        $resultr = ExecuteQuery($strr);
                        $no_rows = mysqli_num_rows($resultr);

                        if($no_rows == 0){
                            echo "<h2>  NO Transactions : ";
                            echo $no_rows;
                            echo "</h2>";
                        }
                        else{
                            if($resultr){
                                echo "<h2> Previous Transactions : ";
                                echo $no_rows;
                                echo "</h2>";
                                echo "<br/>";
                                echo "<hr>";
                                echo "<br/>";
    
                                while($row = mysqli_fetch_assoc($resultr)){
                                    echo "<div class='single'>";
                                    
                                    $tid = $row['tid'];
                                    $tripid = $row['tripid'];
                                    $cost = $row['costoftrip'];
                                    $time = $row['timestampTransaction'];
                                    $id = $row['userid'];
                                    
                                    echo "Transaction ID : ";
                                    echo $tid;
                                    echo " <b>|</b> ";

                                    echo "Booking ID : ";
                                    echo $tripid;
                                    echo " <b>|</b> ";

                                    echo "User ID : ";
                                    echo $id;
                                    echo " <b>|</b> ";

                                    echo "Transaction Timestamp : ";
                                    echo $time;
                                    echo " <b>|</b> ";

                                    echo "Cost of Trip : ";
                                    echo $cost;
                                    echo "<br/><br/>";
                                    
                                    echo "</div>";
                                }
                            }
                        }
                        
                    ?>

                </div>
            </div>
        </div>
        
    </body>
    
</html>



        
