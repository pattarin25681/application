<?php
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "projectq";

    $conn = new mysqli($servername,$username,$password,$dbname);

    if ($conn->connect_error){
        die("Connect failed: " . $conn->connect_error);
        
    }
    
    
    $password = $_POST['password'];
    $cardnumber = $_POST['cardnumber'];

    
    $sql = "UPDATE `member` SET `password`='".$password."' where `cardnumber`='".$cardnumber."'";

    print($sql);
    
    if(mysqli_query($conn,$sql)){
       
        echo "Records inserted successfully.";
    }else{
        echo "ERROR: Could not able to execute $sql.".mysqli_error($conn);
    }



    mysqli_close($conn);
?>