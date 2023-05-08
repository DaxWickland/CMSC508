<?php

session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($conn);

$currVar = $_SESSION['user_id'];
$showTable = true;

$empQuery = "SELECT Employee_ID, Position FROM (SELECT Employee_ID, Position FROM Financial_Employees
          UNION
          SELECT Employee_ID, Position FROM regional_staff)s 
          WHERE Employee_ID = $currVar";

$result0 = mysqli_query($conn, $empQuery);
if($result0 AND mysqli_num_rows($result0) !== 0){
    $user_data = mysqli_fetch_assoc($result0);
    if (strcmp($user_data['Position'], "CEO") === 0 OR strcmp($user_data['Position'], "CFO") === 0){
        $empQuery1 = "SELECT Employee_ID, CONCAT(first_name, ' ', last_name) as 'Name', email, Position, Salary, hire_date FROM (SELECT * FROM Employees e RIGHT JOIN Salary_Employees s USING (Employee_ID)
                     JOIN Financial_Employees USING(Employee_ID, first_name, last_name)
                     UNION
                     SELECT * FROM Employees e RIGHT JOIN Salary_Employees s USING (Employee_ID)
                     JOIN regional_staff USING(Employee_ID, first_name, last_name)) s
                     UNION 
                     SELECT Employee_ID, CONCAT(e.first_name, ' ', e.last_name) as 'Name', email, Position, CONCAT(h.Hour_Rate, '/hour') as Salary, hire_date FROM Employees e RIGHT JOIN regional_staff r USING (Employee_ID)
                     JOIN Hourly_Employees h USING (Employee_ID)";
        $showTable = true;
        
        $result1 = mysqli_query($conn, $empQuery1);
    }
    elseif (strcmp($user_data['Position'], "Regional Director") === 0){
        $empQuery2 = "SELECT e.Employee_ID, CONCAT(first_name, ' ', last_name) as 'Name', e.email, r.Position, IFNULL(CONCAT(Hour_Rate, '/hour'), Salary_Employees.Salary) as 'Salary', e.hire_date FROM Employees e RIGHT JOIN regional_staff r USING (Employee_ID, first_name, last_name)
                      LEFT JOIN Hourly_Employees USING (Employee_ID) 
                      LEFT JOIN Salary_Employees USING (Employee_ID)";
        $result2 = mysqli_query($conn, $empQuery2);
        $showTable = true;
        
    }
    else{
        $empQuery3 = "SELECT e.Employee_ID, CONCAT(first_name, ' ', last_name) as 'Name', e.email, r.Position, IFNULL(CONCAT(Hour_Rate, '/hour'), Salary_Employees.Salary) as 'Salary', e.hire_date FROM Employees e RIGHT JOIN regional_staff r USING (Employee_ID, first_name, last_name)
                      LEFT JOIN Hourly_Employees USING (Employee_ID)
                      LEFT JOIN Salary_Employees USING (Employee_ID)";
        $result3 = mysqli_query($conn, $empQuery3);
        
    }
}
else{
    $showTable = false;
}
   
?>

<html>
<head>
<title>EmployeeDirectory</title>
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
		  
		  #forum{
		      border: 1px solid black;
		      border-collapse: collapse;
		      border-color: #312929;
		  
		  
		  }
		    
		</style>
	
		<div>
			<p id = "title">RICHMOND REGIONAL AIRLINE Employee Portal</p>	

		</div>
			<table id="forum" <?php if ($showTable === false){?>style="display:none"<?php } ?> width="90%" border="1" align="center"    cellpadding="2"   cellspacing="3" bgcolor="#CCCCCC">
				<?php if(strcmp($user_data['Position'], "CEO") === 0 OR strcmp($user_data['Position'], "CFO") === 0 OR strcmp($user_data['Position'], "Regional Director") === 0 ){?> 
 				<thead>

  					<tr>
   					<th width="10%" align="center" bgcolor="#E6E6E6"><strong>Employee ID</strong></td>
    				<th width="25%" align="center" bgcolor="#E6E6E6"><strong>Name</strong></td>
   					<th width="15%" align="center" bgcolor="#E6E6E6"><strong>Email</strong></td>
   					<th width="13%" align="center"  bgcolor="#E6E6E6"><strong>Position</strong></td>
   					<th width="13%" align="center"  bgcolor="#E6E6E6"><strong>Salary</strong></td>     				
    				<th width="13%" align="center" bgcolor="#E6E6E6"><strong>Hire Date</strong></td>
					</tr>
					<?php 
					if($user_data['Position'] !== NULL){
					    if (strcmp($user_data['Position'], "CEO") === 0 OR strcmp($user_data['Position'], "CFO") === 0 OR strcmp($AdminResult['name'], "Admin") === 0){
					while($row = mysqli_fetch_array($result1))
					{
					    echo "<tr>";
					    echo "<td>" . $row['Employee_ID'] . "</td>";
					    echo "<td>" . $row['Name']  . "</td>";
					    echo "<td>" . $row['email'] . "</td>";
					    echo "<td>" . $row['Position'] . "</td>";
					    echo "<td>" . $row['Salary'] . "</td>";
					    echo "<td>" . $row['hire_date'] . "</td>";
					    
					    echo "</tr>";
					}
					echo "</table>";
					}
					elseif (strcmp($user_data['Position'], "Regional Director") === 0 OR strcmp($AdminResult['name'], "Admin") === 0){
					    while($row = mysqli_fetch_array($result2))
					    {
					        echo "<tr>";
					        echo "<td>" . $row['Employee_ID'] . "</td>";
					        echo "<td>" . $row['Name']  . "</td>";
					        echo "<td>" . $row['email'] . "</td>";
					        echo "<td>" . $row['Position'] . "</td>";
					        echo "<td>" . $row['Salary'] . "</td>";
					        echo "<td>" . $row['hire_date'] . "</td>";
					        echo "</tr>";
					    }
					    echo "</table>";
					    
					    
					}
					else{
					    while($row = mysqli_fetch_array($result3))
					    {
					        echo "<tr>";
					        echo "<td>" . $row['Name']  . "</td>";
					        echo "<td>" . $row['email'] . "</td>";
					        echo "<td>" . $row['Position'] . "</td>";
					        echo "</tr>";
					    }
					    echo "</table>";
					    
					    
					}
					}
					else{
					    echo "Nothing to show.";
					}
					?>
				<?php }?>
    			</thead>
    	</table><br>
    	<a href="index.php">Go Back</a><br><br>
	</body>
</html>