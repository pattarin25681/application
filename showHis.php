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
    $id = $_REQUEST['id'];
    $sql = "";
    //print ($sql);
    $out = array();
   $out['data'] = array();
    $result="SELECT queue.queue_id,queue.queue_date,queue.queue_time,type_service.type_name
    FROM `queue` 
  INNER JOIN `member` ON member.mem_id = queue.mem_id
  INNER JOIN `type_service` ON type_service.type_id = queue.type_id WHERE member.mem_id = '$id'";
//WHERE `cardnumber`='".$cardnumber."'
  
    //$result = $conn->query("SELECT queue_date,queue_time FROM `queue`");
    
    /*if ($result !== false){
        echo "";*/
        //$result = "SELECT * FROM `queue` WHERE mem_id= '$id'";
        $sql = mysqli_query($conn,$result);

        while ($row = mysqli_fetch_array($sql)){
            //$output[] = $row;
            $index['queue_id'] = $row['0'];
            $index['queue_date'] = $row['1'];
            $index['queue_time'] = $row['2'];
            $index['type_name'] = $row['3'];
            array_push($out['data'], $index);
        }
        $out["success"]="1";
        print json_encode($out);
        mysqli_close($conn);
        //mysqli_free_result($res);

    //}
    /*else {
        echo "Error cannot query:" . $conn->error;
    }

    $conn->close();*/
    //print (json_encode($output));
    //print (json_encode( $output, JSON_UNESCAPED_UNICODE ));
?>