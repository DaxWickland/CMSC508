<?php 

session_start();

include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $sanitized_Employee_Email = mysqli_real_escape_string($conn, $_POST['Employee_email']);
    
    if(!empty($_POST['Password']) && !empty($sanitized_Employee_Email))
    {
        $query = "SELECT * FROM user where email = '". $sanitized_Employee_Email ."'";
        $result = mysqli_query($conn, $query);
        
        if($result && mysqli_num_rows($result) > 0)
        {
            $user_data = mysqli_fetch_assoc($result);
            
            if((password_verify($_POST['Password'], $user_data['password'])))
            {
                $_SESSION['user_id'] = $user_data['ID'];
                header("Location: index.php");
                die;
            }
        echo "Incorrect login information";
        }
    }
    
    else
    {
        echo "Incorrect login information";
    }
}

?>

<html>
<head>
	<title>Login</title>
</head>
<body style="font-family: Georgia">

		<style type="text/css">
		  form{
		       margin: auto;
		       border: solid thick #aaa;
		       padding: 10px;
		       max-width: 400px;
		       max-height: 400px;
		       
		      }
		  #title{
		  background-color: grey;
		  padding: 1em;
		  text-align: center;
		  font-size: 30px;
		  
		  }
		  
		  #textbox{
		      border: solid thin #aaa;
		      margin: 5px;
		      max-height: 40px;
		      width: 98%;
		      
		  }    
		  
		</style>
		
		<form method="post">
		
			<div id = "title">Log In</div>
			<input id = "textbox" type="email" name="Employee_email" required><br><br>
			<input id = "textbox" type="password" name="Password" required><br><br>
			
			<input id="button" type="submit" value="Login" class="btn btn-primary"><br><br>
			
			<a href="signup.php">Signup</a><br><br>
		</form>
</body>
</html>