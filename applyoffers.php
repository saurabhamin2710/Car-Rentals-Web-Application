
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
        if($_POST['submitted'] == 'Pay By Cash'){
            $type = 2;
            $offerid = $_POST['offerid'];
            if($_POST['offerid'] != NULL){
                $strr = "SELECT * from offers where userid = '$useridd' and offerid = $offerid";
                $resultr = ExecuteQuery($strr);
                $rowr = mysqli_fetch_assoc($resultr);
                $no_rows = mysqli_num_rows($resultr);

                if( $no_rows == 0){
                    $_SESSION['message'] = "INVALID CODE";
                }
                else{
                    header("location: confirmpaymentwallet.php?id=$type&p_id=$offerid");
                }

                
            }
            else{
                header("location: confirmpaymentwallet.php?id=$type&p_id=$offerid");
            }
            
        }
        else if($_POST['submitted'] == 'Pay Using Wallet'){
            $type = 1;
            $offerid = $_POST['offerid'];

            $mysqli = new mysqli('localhost' ,'root','', 'accounts');

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
            // echo $price;

            $str = "SELECT * from users where id = '$useridd'";
            $result = ExecuteQuery($str);
            $row = mysqli_fetch_assoc($result);
            $wallet = $row['wallet'];

            if($_POST['offerid'] != NULL){
                $strr = "SELECT * from offers where userid = '$useridd' and offerid = $offerid";
                $resultr = ExecuteQuery($strr);
                $rowr = mysqli_fetch_assoc($resultr);
                $no_rows = mysqli_num_rows($resultr);

                if( $no_rows == 0){
                    $_SESSION['message'] = "INVALID CODE";
                }
                else{
                    $discount = $rowr['discount'];
                
                    if($wallet + $discount >= $price){
                        unset($_SESSION["message"]);
                        header("location: confirmpaymentwallet.php?id=$type&p_id=$offerid");
                    }
                    else{
                        $_SESSION['message'] = "Wallet Doesn't Have sufficient Money , Please Try Other Options";
                        header("location: applyoffers.php");
                    }
                }
                
            }
            else{
                
                if($wallet >= $price){
                    header("location: confirmpaymentwallet.php?id=$type&p_id=$offerid");
                }
                else{
                    $_SESSION['message'] = "Wallet Doesn't Have sufficient Money , Please Try Other Options";
                    header("location: applyoffers.php");
                }
            }
        }
        else{
            header("location: profile.php");
        }
    }             
           
?>
<html>
    <head>
        <link rel = "stylesheet" href = "admin.css">
        <link rel = "stylesheet" href = "bookacar.css">
        <link rel = "stylesheet" href = "applyoffers.css">
        <link rel = "stylesheet" href = "profile.css">
        <link rel="icon" href="pp.png" type="image/png" />
        <!-- <link rel="stylesheet" href="signup.css" type="text/css"> -->
        
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <li><a href="#"> Payment Portal </a></li>
                            <li><b>- - - - - - - - - - - - - - -</b><i class="arrow right"> </i>  </li>
                            <li class="active"><a href="#"> Apply Offers </a></li>
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
                        // include 'functionsignup.php';
                        // session_start();
                        
                        $str = "SELECT * from users where id = '$useridd'";
                        $result = ExecuteQuery($str);
                        $row = mysqli_fetch_assoc($result);
                        $wallet = $row['wallet'];
                        
                        echo "<div class='single'>";
                        echo "<h2>  Current Money in Wallet : ";
                        echo $wallet;
                        echo "</h2>";
                        echo "<hr>";
                        echo "<br/>";
                        echo "</div>";
                        
                    ?>
                </div>
            </div>

            <div class="lists">
                <div class="carlist">
                    <?php   
                        
                        $mysqli = new mysqli('localhost' ,'root','', 'accounts');

                        $strk = "SELECT getUserid('$username') as id";
                        $resultk = ExecuteQuery($strk);
                        $rowk = mysqli_fetch_assoc($resultk);
                        $variable = $rowk['id'];

                        

                        $strr = "SELECT * from offers where userid = '$variable'";
                        $resultr = ExecuteQuery($strr);
                        $no_rows = mysqli_num_rows($resultr);

                        if($no_rows == 0){
                            echo "<h2>  NO Offers Currently Available : ";
                            echo $no_rows;
                            echo "</h2>";
                        }
                        else{
                            if($resultr){
                                echo "<h2> Offers Currently Available : ";
                                echo $no_rows;
                                echo "</h2>";
                                echo "<br/>";
                                echo "<hr>";
                                echo "<br/>";
    
                                while($row = mysqli_fetch_assoc($resultr)){
                                    echo "<div class='single'>";
                                    $offername = $row['offername'];
                                    $discount = $row['discount'];
                                    $offercode = $row['offerid'];
                                    
                                    echo "Offer Code : ";
                                    echo $offercode;
                                    echo " <b>|</b> ";
                                    echo "Offer Name : ";
                                    echo $offername;
                                    echo " <b>|</b> ";
                                    echo "Discount : ";
                                    echo $discount;
                                    echo "<br/><br/>";
                                    echo "</div>";
                                }
                            }
                        }
                        
                    ?>

                </div>
            </div>
            

            <div class="carlist">
                <div class ="add">
                    <div class="module">
                        <h1 class = "create"> 
                            <b> Amount to be Paid : 
                                <?php 

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
                                    echo $price;
                                ?>
                                Rs
                            </b> 
                        </h1>
                        <form class="form" action="applyoffers.php" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="alert alert-error"> <?= $_SESSION['message'] ?> </div>
                            <input type="number" placeholder="Offer Code" name="offerid"  />
                            <div class="paymentbox">
                                <div class="xd">
                                    <input type="submit" value="Pay Using Wallet" name="submitted" class="btn btn-block btn-primary" />
                                </div>
                                <div class="xd">
                                    <input type="submit" value="Pay By Cash" name="submitted" class="btn btn-block btn-primary" />   
                                </div>
                                <div class="xd">
                                    <input type="submit" value="Cancel Transaction" name="submitted" class="btn btn-block btn-primary" />   
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
        
        
    </body>
    
</html>



        
