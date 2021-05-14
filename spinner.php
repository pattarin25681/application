
<?php
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "projectq";

    $conn = new mysqli($servername,$username,$password,$dbname);
   
    //header('Content-Type: text/html; charset=utf-8');
    
    if ($conn->connect_error){
        die("Connect failed: " . $conn->connect_error);
        
    }
    mysqli_query($conn,"set character set utf8");
   
    $sql = "";
    print ($sql);
    
    $result = $conn->query("SELECT * FROM `type_service`");

    if ($result !== false){
        echo "";
        while ($row = mysqli_fetch_assoc($result)){
            $output[] = $row;
        }
        mysqli_free_result($res);
    }
    else {
        echo "Error cannot query:" . $conn->error;
    }

    $conn->close();
    print (json_encode($output,JSON_UNESCAPED_UNICODE));
?>