<?php

session_start();

include("connection.php");
include("functions.php");
$user_data = check_login($conn);

$Planesview = "SELECT * FROM RegPlanes";
$resultPlanes = mysqli_query($conn, $Planesview); 

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
<h3 align="">Airline Planes currently in use</h3><br />
<div class="table-responsive">
<table id="forum" width="90%" border="1" align="center"    cellpadding="2"   cellspacing="3" bgcolor="#CCCCCC">

 				<thead>

  					<tr>
   					<th width="30%" align="center" bgcolor="#E6E6E6"><strong>Plane Model</strong></td>
					</tr>
					<?php 
					while($row = mysqli_fetch_array($resultPlanes))
					{
					    echo "<tr>";
					    echo "<td>" . $row['Plane_Model'] . "</td>";
					    
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