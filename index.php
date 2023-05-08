<?php
session_start();

    include("connection.php");
    include("functions.php");

    $user_data = check_login($conn);
    
    $showFinDiv = false;
    $showCertDiv = false;
    $showEmpCertDiv = false;
    $currVar = $_SESSION['user_id'];
    $query1 = "SELECT * FROM (SELECT Employee_ID, Position FROM (SELECT Employee_ID, Position FROM Financial_Employees
          UNION
          SELECT Employee_ID, Position FROM regional_staff)s 
          WHERE Employee_ID = $currVar) s JOIN Employees USING (Employee_ID)";
    $AdminQuery = "SELECT name FROM user WHERE ID = $currVar";
    $result1 = mysqli_query($conn, $query1);
    $AdminResult = mysqli_query($conn, $AdminQuery);
    if(mysqli_num_rows($result1) !== 0){
    $user_data = mysqli_fetch_assoc($result1);
    if (strcmp($user_data['Position'], "CEO") === 0 OR strcmp($user_data['Position'], "CFO") === 0 OR strcmp($AdminResult['name'], "Admin") === 0){
        $showFinDiv = true;
    }
    if (strcmp($user_data['Position'], "Regional Director") === 0 OR strcmp($AdminResult['name'], "Admin") === 0){
        $showCertDiv = true;
    }
    
    if (strcmp($user_data['Position'], "Pilot") === 0 OR strcmp($user_data['Position'], "Maintanence") === 0 OR strcmp($AdminResult['name'], "Admin") === 0){
        $showEmpCertDiv = true;
    }
    
    
    }
    
    $branchQuery = "SELECT Branch_name, Branch_ID FROM branch";
    $branchResult = mysqli_query($conn, $branchQuery);
    $branch_info  = mysqli_fetch_assoc($branchResult);
    
    ?>
    

<html>
	
	<head>
		<title>WebPage</title>
	</head>
	<body style="font-family: Georgia">

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
	<p>WELCOME <?php echo $user_data['first_name'] . ' ' . $user_data['last_name']?></p>
	<p>RICHMOND REGIONAL AIRLINE - Branch: <?php echo $branch_info['Branch_name']?>, ID: <?php echo $branch_info['Branch_ID']?></p><br>
	<a href = "EmployeesPage.php">Employee Directory</a><br><br>
	
	<div id = "EmpCerts" <?php if ($showEmpCertDiv === false){?>style="display:none"<?php } ?>><br><br>	
	<a href = "EmpCerts.php">View Your Certificates</a><br><br>
	</div>
	
	<div id = "fin" <?php if ($showFinDiv === false){?>style="display:none"<?php } ?>><br><br>	
	<a href = "FinancialStatements.php">Financial Statement Page</a><br><br>
	</div>
	
	<div id = "AllCerts" <?php if ($showCertDiv === false){?>style="display:none"<?php } ?>><br><br>	
	<a href = "AllCerts.php">Regional Certificates Page</a><br><br>
	</div>
	
		<a href = "AirlinePlanes.php">Current Airline Planes</a>
	
	</body>
</html>