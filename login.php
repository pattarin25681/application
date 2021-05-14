<?php
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "projectq";

    $conn = new mysqli($servername,$username,$password,$dbname);

    if ($conn->connect_error){
        die("Connect failed: " . $conn->connect_error);
        
    }
    
    $cardnumber = $_POST['cardnumber'];
    $password = ($_POST['password']);
    $username = $_POST['username'];
    
    $response = array();
    //$sql2 = "SELECT `mem_id` WHERE `member` ";
    $sql = "SELECT * FROM `member` WHERE `username` = '".$username."' AND `password` = '".$password."'";
    //$sql2="SELECT `mem_id` FROM `member` WHERE `cardnumber`='".$cardnumber."'";
    
    //print($sql2);

    $result = mysqli_query($conn,$sql);
    //print($result);

    if(mysqli_num_rows($result) > 0) {
       // echo "login success";
       while ($row = mysqli_fetch_assoc($result)) { 
           $response[] = $row;
        }
           
       echo json_encode($response);
        }
        else {
        echo "login not success";
        }

    mysqli_close($conn);
    

 
?>