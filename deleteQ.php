<?php
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "projectq";

    $conn = new mysqli($servername,$username,$password,$dbname);

    if ($conn->connect_error){
        die("Connect failed: " . $conn->connect_error);
        
    }
   
   $id = $_POST['queue_id'];


//     $sele = "SEl"


// //    $sel = "SELECT hasq FROM `queue_date` WHERE `date`='$date1' AND `ontime`='$time1'";
   

// //    //print($sel);

// //     $result_sel = mysqli_query($conn,$sel);
// //     $row = mysqli_fetch_array($result_sel);
// //     $update_value = $row['0']-1;


// //     $upd = "UPDATE `queue_date` SET `hasq`=$update_value WHERE `date`='$date1' AND `ontime`='$time1'";

// //     print($upd);
    
// //     $result=mysqli_query($conn,$upd);

// //     if($result){
// //         echo "Data Changed";
// //     }else{
// //         echo "fail";
// //     }








    

    $sql ="DELETE FROM `queue` WHERE queue_id = '".$id."'";




    print($sql);
    $result=mysqli_query($conn,$sql);
    if($result){
        echo "Data Deleted";
    }else{ 
        echo "fail";
    }

    mysqli_close($conn);
?>