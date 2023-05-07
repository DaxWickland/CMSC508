<?php
session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($conn);
    
    $showFinDiv = false;
    $currVar = $_SESSION['user_id'];
    $query1 = "SELECT Position FROM Financial_Employees WHERE Employee_ID = $currVar";
    $result1 = mysqli_query($conn, $query1);
    if(mysqli_num_rows($result1) !== 0){
    $user_data = mysqli_fetch_assoc($result1);
    if (strcmp($user_data['Position'], "CEO") OR strcmp($user_data['Position'], "CFO")){
        $showFinDiv = true;
    } 
    }
    ?>
    

<html>
	
	<head>
		<title>WebPage</title>
	</head>
	<body style="font-family: verdana">

		<style type="text/css">
		  form{
		       margin: auto;
		       border: solid thick #bbb;
		       padding: 15px;
		       max-width: 350px;
		      }
		  #title{
		  background-color: grey;
		  padding: 1em;
		  text-align: center;
		  
		  }
		  
		  #textbox{
		      border: solid thin #aaa;
		      margin: 5px;
		      width: 98%;
		      
		  }    
		  
		  #logout{
		      text-align: right;
		  
		  }
		  
		  
		</style>
	
		<div>
			<p id = "title">RICHMOND REGIONAL AIRLINE Employee Portal</p>
		
		</div>
	<a id="logout" href="logout.php" style="float: right;">Logout</a>
	<p>Index Page</p>
	<a href = "EmployeesPage.php">Employee Directory</a>
	<div id = "fin" <?php if ($showFinDiv === false){?>style="display:none"<?php } ?>>
	<a href = "FinancialStatements.php">Financial Statement Input Page</a>
	</div>
	
	</body>
</html>