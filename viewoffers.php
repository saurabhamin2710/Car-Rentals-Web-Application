
<?php 
    include 'functionsignup.php';
    session_start(); 
    if($_GET['id']){
        $variable = $_GET['id'];
        // echo $variable;
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
                            <li><a href="profile.php"> Profile </a></li>
                            <li><a href="bookacar.php"> Book A Car </a></li>
                            <li><a href="wallet.php"> Wallet </a></li>
                            <li class="active"><a href="viewoffers.php"> Offers </a></li>
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
        </div>
    </body>
</html>



        
