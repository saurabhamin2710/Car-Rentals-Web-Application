<?php 
    include 'functionsignup.php';
    session_start(); 
    if($_GET['id']){
        $type = $_GET['id'];
        $offerid = $_GET['p_id'];
        $username = $_SESSION['username'];
        
        $strk = "SELECT * from users where username = '$username' ";
        $resultk = ExecuteQuery($strk);
        $rowk = mysqli_fetch_assoc($resultk);
        $useridd = $rowk['id'];

    }
    else{
    
        $mysqli = new mysqli('localhost' ,'root','', 'accounts');
        $username = $_SESSION['username'];
        
        $strk = "SELECT * from users where username = '$username' ";
        $resultk = ExecuteQuery($strk);
        $rowk = mysqli_fetch_assoc($resultk);
        $useridd = $rowk['id'];

    }
    if($_SESSION['loggedin'] == true){
        if($_SESSION['username'] == "admin" ){
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
        <link rel = "stylesheet" href = "applyoffers.css">
        <link rel = "stylesheet" href = "profile.css">
        <link rel = "stylesheet" href = "confirmpayment.css">
        <link rel="icon" href="pp.png" type="image/png" />
        
        <!-- <link rel="stylesheet" href="signup.css" type="text/css"> -->
        
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <li> <a href="#"> Payment Portal </a></li>
                            <li> <b>- - - - - - - - - - - - - - -</b><i class="arrow right"> </i>  </li>
                            <li> <a href="#"> Apply Offers </a></li>
                            <li> <b>- - - - - - - - - - - - - - -</b><i class="arrow right"> </i>  </li>
                            <li class="active"> <a href="#"> Confirm Payment </a></li>
                        </ul>
            </div>
            <div class="navbar2">
                    <ul class="nav">
                    <li><img class="image"  src = '<?= $_SESSION['avatar'] ?>' width="50" height="50" style="border: 1px solid black" > </li>    
                    <li class ="reference"><b>Currently Logged in as : </b><div class = "profilename"> <b><?= $_SESSION['username'] ?></b> </div> </li>
                        <li><a href="logout.php"> Logout </a></li>
                    </ul>
            </div>
            
            <div class="confirm">
                    <h2 class="headername"> 
                        <?php
                            if($type == 1){
                                echo "Mode : Wallet | Final Price : ";
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
        
                                $tripdist = $rowr['tripdist'];


                                if($tripdist >= 100){
                                    $price = $tripdist*4;
                                }
                                else{
                                    $price = $tripdist*5;
                                }
                                if($offerid != NULL){
                                    $strr = "SELECT * from offers where userid = '$useridd' and offerid = $offerid";
                                    $resultr = ExecuteQuery($strr);
                                    $rowr = mysqli_fetch_assoc($resultr);
                                    $discount = $rowr['discount'];
                                    if($price <= $discount){
                                        $price = 0;
                                    }
                                    else{
                                        $price -= $discount;
                                    }

                                    if($price == 0){
                                        echo $price;
                                        echo " Rs i.e Free";
                                    }
                                    else{
                                        echo $price;
                                        echo " Rs";
                                    }

                                }
                                else{
                                    echo $price;
                                    echo " Rs";
                                }
                            }
                            else{
                                echo "Mode : Cash | Final Price : ";
                                $mysqli = new mysqli('localhost' ,'root','', 'accounts');

                                //$strk = "SELECT * from users where username = '$username' ";
                                $strk = "SELECT getUserid('$username') as id";
                                $resultk = ExecuteQuery($strk);
                                $rowk = mysqli_fetch_assoc($resultk);
                                $variable = $rowk['id'];

                                $strr = "SELECT * from alltrips where userid = '$useridd' and completed = 'U' ";
                                $resultr = ExecuteQuery($strr);
                                $rowr = mysqli_fetch_assoc($resultr);
                                
                                $tripdist = $rowr['tripdist'];

                                if($tripdist >= 100){
                                    $price = $tripdist*4;
                                }
                                else{
                                    $price = $tripdist*5;
                                }

                                if($offerid != NULL){
                                    $strr = "SELECT * from offers where userid = '$useridd' and offerid = $offerid";
                                    $resultr = ExecuteQuery($strr);
                                    $rowr = mysqli_fetch_assoc($resultr);
                                    $discount = $rowr['discount'];
                                    if($price <= $discount){
                                        $price = 0;
                                    }
                                    else{
                                        $price -= $discount;
                                    }

                                    if($price == 0){
                                        echo $price;
                                        echo " Rs i.e Free";
                                    }
                                    else{
                                       echo $price;
                                        echo " Rs";
                                    }

                                }
                                else{
                                    echo $price;
                                    echo " Rs";
                                }


                            }
                            

                        ?>
                    </h2>
                    <br>
                    <hr class="hrclass" >
                    <br>
                    <br>
                    <a href="profile.php" class="btn2">Cancel</a>
                    <?php
                        echo "<a href='return.php?id=$type&p_id=$offerid&c_id=$price' class='btn1'> Confirm </a>";
                    ?>
            </div>

        </div>
        
        
    </body>

</html>



    
