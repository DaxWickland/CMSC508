<?php 

//create check login function to check if user is logged in
function check_login($conn)
{
    
    if(isset($_SESSION['user_id']))
    {
        $id = $_SESSION['user_id'];
    
        $query = "select * from user where ID = '$id' limit 1";
        
        $result = mysqli_query($conn, $query);
        if($result && mysqli_num_rows($result) > 0)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
        
    }
    
    //goto login
    header("Location: login.php");
    die;
    
}



?>