
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

    $_SESSION['message'] = '';
    // $mysqli = new mysqli('localhost' ,'root','', 'accounts');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['wallet']>=0){
            $wallet = $_POST['wallet'];

            $strk = "SELECT getUserid('$username') as id";
            $resultk = ExecuteQuery($strk);
            $rowk = mysqli_fetch_assoc($resultk);
            $variable = $rowk['id'];

            $str = "SELECT * from users where id = $variable";
            $result=ExecuteQuery($str);
            $row = mysqli_fetch_assoc($result);
            $total = $row['wallet'];

            $total += $wallet;
            
            // $str = "UPDATE cars SET availability ='B' where carid = '$variable'";

            $sql = "UPDATE users SET wallet = $total  where id = $variable";
            $result = ExecuteQuery($sql);
            header("location: wallet.php");
        }
        else{
            $_SESSION['message'] = "Amount Cannot be Negative";
        }

    }
    
                                  
           
?>
<html>
    <head>
        <link rel = "stylesheet" href = "wallet.css">
        <link rel = "stylesheet" href = "admin.css">
        <link rel = "stylesheet" href = "bookacar.css">
        <link rel = "stylesheet" href = "profile.css">
        <link rel="icon" href="pp.png" type="image/png" />
    </head> 
    <body>
        <div class="mainpage">
            <div class="navbar">
                        <ul>
                            <!-- <li><a href="homepage.html"> Home </a></li> -->
                            <li ><a href="profile.php"> Profile </a></li>
                            <li><a href="bookacar.php"> Book A Car </a></li>
                            <li class="active"><a href="wallet.php"> Wallet </a></li>
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
                        // include 'functionsignup.php';
                        // session_start();
                        
                        $str = "SELECT * from users where id = '$variable'";
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
            <div class="addmoney">
                <div class="body-content">
                    <div class="module">
                        <h3 class = "create"> <b> Add Amount to Wallet </b> </h3>
                        <form class="form" action="wallet.php" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="alert alert-error"> <?= $_SESSION['message'] ?> </div>
                            <input type="number" placeholder="Amount to be Added" name="wallet" required />
                            <input type="submit" value="Pay Using Cash" name="Login" class="btn btn-block btn-primary" />
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
        
    </body>
    
</html>



        
