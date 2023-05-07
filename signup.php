<?php
session_start();

    include("connection.php");
    include("functions.php");
    
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $_Sanitized_Employee_Email = mysqli_real_escape_string($conn, $_POST['Employee_email']);
        $_Sanitized_Employee_Pass = mysqli_real_escape_string($conn, $_POST['Password']);
        $_HashedPass = password_hash($_Sanitized_Employee_Pass, PASSWORD_DEFAULT);
        
        if(isset($_POST['Password']) && isset($_POST['Employee_email']))
        {
            
            $stmt = "SELECT * FROM Employees WHERE email = '$_Sanitized_Employee_Email' limit 1";
            $check = mysqli_query($conn, $stmt);
            $Info = mysqli_fetch_assoc($check);
            if($Info == NULL){
                echo "Invalid Email/Password Combination.";
            }
            
            
            if($check && mysqli_num_rows($check) > 0){
            $query = "insert into user (ID, email, password, name) values($Info[Employee_ID], '$_Sanitized_Employee_Email', '$_HashedPass', 'User')";
            mysqli_query($conn, $query);
            header("Location: login.php");
            }
 
            else
            {
                echo "Email not found, contact your hiring manager.";
            }
        }
        else
        {
            echo "Please enter Valid login info, use your employee id. If you do not know your employee id contact your hiring manager!";
        }
    }
?>

<html>
<head>
	<title>Signup</title>
</head>
<body style="font-family: Georgia">

		<style type="text/css">
		  form{
		       margin: auto;
		       border: solid thick #aaa;
		       padding: 10px;
		       max-width: 400px;
		      }
		  #title{
		  background-color: gray;
		  padding: 1em;
		  text-align: center;
		  
		  }
		  
		  #textbox{
		      border: solid thin #aaa;
		      height: 150px;
		      margin: 10px;
		      width: 98%;
		      
		  }    
		  
		  
		</style>

	<div class="container mt-3 mb-3">
		<form method="post">
			<div class="row justify-content-center">
				<div id = "title" class="col-4">
					<div class="form-group">
						<label>Email:</label>
						<input id = "textbox "type="email" class="form-control" id="email" placeholder="Enter email" name="Employee_email" required>
					</div>
					<div class="form-group">
						<label>Password:</label>
						<input id = textbox" type="password" class="form-control" id="password" placeholder="Enter password" name="Password" required>
					</div>
					<button type="submit" class="btn btn-primary">Sign Up</button>
					<a target="_blank" class="btn btn-secondary" href="login.php">Login</a><br><br>
				</div>
			</div>
		</form>
	</div>
</body>
</html>