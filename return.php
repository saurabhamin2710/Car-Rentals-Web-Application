<?php
    //echo $_GET['id'];
    include 'functionsignup.php';
    session_start();
    if($_GET['id']){
        $type = $_GET['id'];
        $offerid = $_GET['p_id'];
        $costoftrip = $_GET['c_id'];
        // echo $type;
        // echo $offerid;
        // echo $costoftrip;
        $username = $_SESSION['username'];

        $mysqli = new mysqli('localhost' ,'root','', 'accounts');
        $strk = "SELECT * from users where username = '$username' ";
        $resultk = ExecuteQuery($strk);
        $rowk = mysqli_fetch_assoc($resultk);
        $useridd = $rowk['id'];
    }
    else{
        //echo "dummy"
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


                <?php 

                    if($type == 1){
                        //wallet
                        $str = "SELECT * from users where id = '$useridd'";
                        $result = ExecuteQuery($str);
                        $row = mysqli_fetch_assoc($result);
                        $wallet = $row['wallet'];
                        // echo  $wallet;
                        // echo  $costoftrip;

                        $finalwallet = $wallet - $costoftrip;

                        //updated wallet balance
                        $str = "UPDATE users SET wallet = $finalwallet where id = '$useridd'";
                        $result = ExecuteQuery($str);

                        if($offerid != NULL){
                            //deleting offer since one offer can be used once
                            $sql = "DELETE FROM offers WHERE offerid = $offerid";
                            $result = ExecuteQuery($sql);

                        }

                        $strr = "SELECT getTripidFromT('$useridd','U') as tripid";
                        $resultr = ExecuteQuery($strr);
                        $rowr = mysqli_fetch_assoc($resultr);
                        
                        $bookingid = $rowr['tripid'];

                        $strr = "SELECT getCaridFromT('$useridd','U') as carid";
                        $resultr = ExecuteQuery($strr);
                        $rowr = mysqli_fetch_assoc($resultr);
                        $carid = $rowr['carid'];

                        $strr = "SELECT getDistFromT('$useridd','U') as tripdist";
                        $resultr = ExecuteQuery($strr);
                        $rowr = mysqli_fetch_assoc($resultr);

                        $dist = $rowr['tripdist'];    
                        

                        $strrr = "SELECT * from cars where carid = '$carid'";
                        $resultrr = ExecuteQuery($strrr);
                        $rowrr = mysqli_fetch_assoc($resultrr);

                        $disttravelled = $rowrr['cardist'];
                        echo $disttravelled;
                        $disttravelled += $dist; 
                        echo $disttravelled;
                        echo $dist;

                        $str = "UPDATE cars SET availability = 'A' where carid = '$carid'";
                        $result = ExecuteQuery($str);

                        $str = "UPDATE cars SET cardist = '$disttravelled' where carid = '$carid'";
                        $result = ExecuteQuery($str);

                        $sql = "INSERT INTO transaction (tripid , userid , costoftrip)" . "VALUES ( '$bookingid' , '$useridd' ,$costoftrip )";
                        $result = ExecuteQuery($sql);

                        $sql = "SELECT * FROM transaction where tripid = '$bookingid'";
                        $result = ExecuteQuery($sql);
                        $row = mysqli_fetch_assoc($result);
                        $timeend = $row['timestampTransaction'];


                        // $str = "UPDATE alltrips SET completed = 'R' , timestampreturn = '$timeend'  where userid = '$useridd' and completed = 'U'";
                        // $result = ExecuteQuery($str);
                        header("location: rating.php?id=$bookingid&p_id=$carid");
                        
                    }
                    else{
                        //cash
                        if($offerid != NULL){
                            //deleting offer since one offer can be used once
                            $sql = "DELETE FROM offers WHERE offerid = $offerid";
                            $result = ExecuteQuery($sql);

                        }

                        $strr = "SELECT * from alltrips where userid = '$useridd' and completed = 'U' ";
                        $resultr = ExecuteQuery($strr);
                        $rowr = mysqli_fetch_assoc($resultr);
                        
                        $bookingid = $rowr['tripid'];    
                        $carid = $rowr['carid'];
                        $dist = $rowr['tripdist'];    
                        
                        $strrr = "SELECT * from cars where carid = '$carid'";
                        $resultrr = ExecuteQuery($strrr);
                        $rowrr = mysqli_fetch_assoc($resultrr);
                        $disttravelled = $rowrr['cardist'];
                        $disttravelled += $dist; 
                        // echo $disttravelled;
                        // echo $dist;
   
                        $str = "UPDATE cars SET availability = 'A' where carid = '$carid'";
                        $result = ExecuteQuery($str);

                        $str = "UPDATE cars SET cardist = '$disttravelled' where carid = '$carid'";
                        $result = ExecuteQuery($str);

                        $sql = "INSERT INTO transaction (tripid , userid , costoftrip)" . "VALUES ( '$bookingid' , '$useridd' ,$costoftrip )";
                        $result = ExecuteQuery($sql);

                        $str = "UPDATE alltrips SET completed = 'R' where userid = '$useridd' and completed = 'U'";
                        $result = ExecuteQuery($str);
                        header("location: rating.php?id=$bookingid&p_id=$carid");

                    }
                   
                ?> 