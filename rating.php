<?php 
    include 'functionsignup.php';
    session_start(); 
    if($_SESSION['loggedin'] == true){
        if($_SESSION['username'] == "admin" ){
                $_SESSION['loggedin'] = false;
                header("location: login.php");
            }
    }
    else{   
        header("location: login.php");
    }
    // if($_GET['id']){
        $tripid = $_GET['id'];
        $carid = $_GET['p_id'];

        

    //     $username = $_SESSION['username'];
        
    //     $strk = "SELECT * from users where username = '$username' ";
    //     $resultk = ExecuteQuery($strk);
    //     $rowk = mysqli_fetch_assoc($resultk);
    //     $useridd = $rowk['id'];

    // }
    // else{
    
    //     $mysqli = new mysqli('localhost' ,'root','', 'accounts');
    //     $username = $_SESSION['username'];
        
    //     $strk = "SELECT * from users where username = '$username' ";
    //     $resultk = ExecuteQuery($strk);
    //     $rowk = mysqli_fetch_assoc($resultk);
    //     $useridd = $rowk['id'];

    // }
    

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //$mysqli = new mysqli('localhost' ,'root','', 'accounts');
        $rating = $_POST['rating'];
        // echo $rating;
        // echo $tripid;
        // echo $carid;

        $sql = "UPDATE alltrips SET triprating = $rating WHERE tripid = $tripid";
        $result = ExecuteQuery($sql);
        
        // trigger updates the rating
        
        // $sql = "SELECT AVG(triprating) as average FROM alltrips WHERE carid = '$carid'";
        // $result = ExecuteQuery($sql);
        // $row = mysqli_fetch_assoc($result);

        // //echo $rating;
        // $avg = $row['average'];
        // //echo $avg;


        // $sql = "UPDATE cars SET carrating = $avg WHERE carid = $carid";
        // $result = ExecuteQuery($sql);

        header("location: viewtransaction.php");

    }


?>

<head>
    <link rel="stylesheet" href="rating.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link rel="icon" href="pp.png" type="image/png" />
</head>
<body>
    <div class="dabba">
        <div class="row">
    
            <form action="rating.php?id=<?= $tripid ?>&p_id=<?= $carid ?>" method="post">
            
                <div>
                    <h3>Please Rate Your Trip</h3>
                </div>
            <hr class="new">
                    
                    <div class="rateyo" id= "rating"
                        data-rateyo-rating="4"
                        data-rateyo-num-stars="5"
                        data-rateyo-score="3">
                    </div>
                    <b>
                    <span class='result'>0</span>
                    <input type="hidden" name="rating">
                    </b>
                    <br><br>
                    <div class="ratingbutton"><input type="submit" name="add" class="submittext"> </div>
            
                </div>
            
                
            
            </form>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
 
<script>
 
 
    $(function () {
        $(".rateyo").rateYo().on("rateyo.change", function (e, data) {
            var rating = data.rating;
            $(this).parent().find('.score').text('score :'+ $(this).attr('data-rateyo-score'));
            $(this).parent().find('.result').text('rating :'+ rating);
            $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
        });
    });
 
</script>
</body>
</html>
