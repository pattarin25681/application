<?php
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "projectq";

    $conn = new mysqli($servername,$username,$password,$dbname);

    if ($conn->connect_error){
        die("Connect failed: " . $conn->connect_error);
        
    }
   
    $email = $_POST['email'];
    $card = $_POST['cardnumber'];
    $p = ($_POST['password']);
    $u = $_POST['username'];
    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];

    $check = "SELECT * FROM `member` WHERE `username` = '$u' OR `cardnumber`='$card' OR `email`='$email'";
    $result1 = mysqli_query($conn, $check);
    
    $num=mysqli_num_rows($result1);

    
    if($num > 0)
    {
    echo "cannot register";
    }
    else{
    $sql = "INSERT INTO `member` (email,cardnumber,password,username,f_name,l_name) VALUES ('$email','$card','$p','$u','$fname','$lname')";
    print($sql);
    $re=mysqli_query($conn,$sql);
     mysqli_close($conn);
    if($re){
        echo "Records inserted successfully.";
    }else{
        echo "not";
    }
}
     mysqli_close($conn);
?>