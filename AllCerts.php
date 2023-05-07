<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($conn);

$Cert_Query = "SELECT * FROM ALL_CERTS";
$Cert_Result = mysqli_query($conn, $Cert_Query);
$Cert_Info = mysqli_fetch_assoc($Cert_Result);

?>

<html>

<head>

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
<p id = "title">RICHMOND REGIONAL AIRLINE Employee Portal</p>
<br />
<div class="container" style="width:500px;">
<h3 align="">Current Certifications of Pilots and Maintanence</h3><br />

<div class="table-responsive">
<table id="forum" width="90%" border="1" align="center"    cellpadding="2"   cellspacing="3" bgcolor="#CCCCCC">

 				<thead>

  					<tr>
   					<th width="30%" align="center" bgcolor="#E6E6E6"><strong>Employee ID</strong></td>
   					<th width="30%" align="center" bgcolor="#E6E6E6"><strong>Certification</strong></td>
   					<th width="30%" align="center" bgcolor="#E6E6E6"><strong>Certification ID</strong></td>
   					<th width="30%" align="center" bgcolor="#E6E6E6"><strong>Name</strong></td>
   					<th width="30%" align="center" bgcolor="#E6E6E6"><strong>Position</strong></td>
					</tr>
					<?php 
					while($row = mysqli_fetch_array($Cert_Result))
					{
					    echo "<tr>";
					    echo "<td>" . $row['Employee_ID'] . "</td>";
					    echo "<td>" . $row['Certification'] . "</td>";
					    echo "<td>" . $row['Certification_ID'] . "</td>";
					    echo "<td>" . $row['First_Name']. " " . $row['Last_Name'] . "</td>";
					    echo "<td>" . $row['Position'] . "</td>";
					    
					    echo "</tr>";
					}
					echo "</table>";
                    ?>
    			</thead>
    	</table><br>
                </div>  
           </div>  
           <br />  
           <a href="index.php">Go Back</a><br><br>
      </body>  
 </html>  