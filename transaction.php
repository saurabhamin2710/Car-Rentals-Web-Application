
<?php 
    include 'functionsignup.php';
    session_start(); 
    if($_GET['id']){
        // $variable = $_GET['id'];
        // //echo $variable;
        // echo $_SESSION['id'];
    }
    else{
     
        $mysqli = new mysqli('localhost' ,'root','', 'accounts');
        $username = $_SESSION['username'];
        // $useridd = $_SESSION['id'];
        // echo $username;

        $strk = "SELECT * from users where username = '$username' ";
        $resultk = ExecuteQuery($strk);
        $rowk = mysqli_fetch_assoc($resultk);
        $useridd = $rowk['id'];

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
    
    $mysqli = new mysqli('localhost' ,'root','', 'accounts');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['submitted'] == 'Submit'){
            if($_POST['value'] == $_POST['confirmvalue']){

                $value = $_POST['value'];

                $strr = "SELECT * from alltrips where userid = '$useridd' and completed = 'U' ";
                $resultr = ExecuteQuery($strr);
                $rowr = mysqli_fetch_assoc($resultr);

                $tripid = $rowr['tripid'];    
                $carid = $rowr['carid'];
                $variable = $tripid;

                $str = "SELECT * from cars where carid = '$carid'";
                $result = ExecuteQuery($str);
                $row = mysqli_fetch_assoc($result);
                $dist = $row['cardist'];
                
                
                if($value > $dist){
                    $tripdist  = $value - $dist;
                    // echo $tripdist;
                    $str = "UPDATE alltrips SET  tripdist = $tripdist where tripid = '$variable'";
                    $result = ExecuteQuery($str);

                    // $_SESSION['message'] = "Car Registration successful , Car $carname with $carnum to the database";
                    // $_SESSION['loggedin'] = true;
                    //header("location: carlist.php");
                    unset($_SESSION["message"]);
                    header("location: applyoffers.php");
                }
                else{
                    $_SESSION['message'] = "Travelled Distance Cannot be Negative";
                    header("location: transaction.php");
                }

                
        
            }
            else{
                $_SESSION['message'] = "Two Values Did Not Match";
                header("location: transaction.php");
            }
        }
        else{
            unset($_SESSION["message"]);
            header("location: profile.php");
        }
    }             
           
?>
<html>
    <head>
        <link rel = "stylesheet" href = "admin.css">
        <link rel = "stylesheet" href = "bookacar.css">
        <link rel = "stylesheet" href = "transaction.css">
        <link rel = "stylesheet" href = "profile.css">
        <link rel="icon" href="pp.png" type="image/png" />
        <!-- <link rel="stylesheet" href="signup.css" type="text/css"> -->
        
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <li class="active"><a href="#"> Payment Portal </a></li>
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
                        $timestamp = $rowr['timestampbook'];
                        $carid = $rowr['carid'];
                       
                        $strrr = "SELECT * from cars where carid = '$carid'";
                        $resultrr = ExecuteQuery($strrr);
                        $rowrr = mysqli_fetch_assoc($resultrr);
                        $cardist = $rowrr['cardist'];

                        //echo $variable;
                        if($no_rows == 1)
                        {
                            echo "<br/>";
                            echo "<h2>  Currently No of Booked Cars (Limit - 1) : ";
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

                            echo "Cardistance : ";
                            echo $cardist;
                            echo " <b>|</b> ";

                            echo "Trip Start : ";
                            echo $timestamp;
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
                            
                            // echo "<a class='bookbtn' href='transaction.php'> <b> Return </b> </a>";
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
            
            

            <div class ="add">
                <div class="module">
                    <h1 class = "create"> <b> Enter Distance meter Value </b> </h1>
                    <form class="form" action="transaction.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="alert alert-error"> <?= $_SESSION['message'] ?> </div>
                        <input type="number" placeholder="Value" name="value"  required />
                        <input type="number" placeholder="Confirm Value" name="confirmvalue"  required />
                        <div class="paymentbox">
                            <div class="xd">
                                <input type="submit" value="Cancel" name="submitted" class="btn btn-block btn-primary" />
                            </div>
                            <div class="xd">
                                <input type="submit" value="Submit" name="submitted" class="btn btn-block btn-primary" />   
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
        
        
    </body>
    
</html>



        
