<?php 

session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
		{

			//read from database
			$query = "select * from users where user_name = '$user_name' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id'];
						header("Location: index.php");
						die;
					}
				}
			}
			
			echo "wrong username or password!";
		}else
		{
			echo "wrong username or password!";
		}
	}

?>


<!-- <!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>

	<style type="text/css">
	
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}

	#button{

		padding: 10px;
		width: 100px;
		color: white;
		background-color: lightblue;
		border: none;
	}

	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	</style>

	<div id="box">
		
		<form method="post">
			<div style="font-size: 20px;margin: 10px;color: white;">Login</div>

			<input id="text" type="text" name="user_name"><br><br>
			<input id="text" type="password" name="password"><br><br>

			<input id="button" type="submit" value="Login"><br><br>

			<a href="signup.php">Click to Signup</a><br><br>
		</form>
	</div>
</body> -->
<!-- </html> -->

<html>
    <head>
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />	
        <!-- <meta http-equiv="refresh" content="3"> -->
        <title>
            Homepage
        </title>
    </head>
    <body>
        <link rel="stylesheet" href="stylesheet.css" type="text/css">
        <link rel="stylesheet" href="register.css" type="text/css">
            <div class="container">    
                <div class="child">

                <div class="navbar">
                    <ul>
                        <li><a href="#home"> Home </a></li>
                        <li><a href="#"> About </a></li>
                        <li><a href="#"> Reviews </a></li>
                        <li><a href="#"> Conatct Us </a></li>
                        <li><a href="#"> Developer Team</a></li>
                    </ul>
                </div>

        
                <div class="first" >
                    <a id="home">
                        <div class="logo">
                            <img src="logo_transparent.png" alt="lolololo">
                        </div>
                        <div class="button1">
                            <a href="#login/register" class="btn1">LOGIN</a>
                            <a href="#login/register" class="btn1">REGISTER</a>                                                                    
                        </div>
                    </a>
                </div>
            </div>

            <div class="child" >
                <a id="login/register" >
                    <div class="second" >
                        <div class="secondleft">
                            <div class="module1">
                                <h1>Create an account</h1>
                                <form class="form" action="form.php" method="post" enctype="multipart/form-data" autocomplete="off">
                                  <div class="alert alert-error"></div>
                                  <input type="text" placeholder="User Name" name="username" required />
                                  <input type="email" placeholder="Email" name="email" required />
                                  <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
                                  <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
                                  <div class="avatar"><label>Select your avatar: </label><input type="file" name="avatar" accept="image/*" required /></div>
                                  <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
                                </form>
                              </div>
                        </div>
                        <div class="secondright">
                            <div class="module2">
                                <!-- <h1>Login</h1>
                                <form class="form" action="form.php" method="post" enctype="multipart/form-data" autocomplete="off">
                                  <div class="alert alert-error"></div>
                                  <input type="text" placeholder="User Name" name="username" required />
                                  <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
                                  <input type="submit" value="Login" name="Login" class="btn btn-block btn-primary" />
                                </form> -->
                              </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="child">
                <div class="third">
                    <div class="thirdleft">

                    </div>
                    <div class="thirdright">

                    </div>
                </div>
            </div>

            <div class="child">
                <div class="endbar">

                </div>
            </div>
        </div>
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    </body>
</html>