<?php

    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "projectq";

    $conn = new mysqli($servername,$username,$password,$dbname);

    if ($conn->connect_error){
        die("Connect failed: " . $conn->connect_error);
    
    }
    $date = $_REQUEST['queue_date'];
    $time = $_REQUEST['queue_time'];
    $username = $_REQUEST['username'];
    /*$type1 = $_POST['type_id'];
    $mem = $_POST['mem_id'];*/
    $cardnumber = $_REQUEST['cardnumber'];
    $type_name=$_REQUEST['type_name'];

    $a=explode("-",$date);
    if(strlen($a[0]) == 1){
        $a[0] = "0".$a[0];
    }
    if(strlen($a[1]) == 1){
        $a[1]="0".$a[1];
    }

    $date = $a[0]."-".$a[1]."-".$a[2];
    $timez="SELECT time FROM `time_list` WHERE `time_string` = '".$time."'";
    $timez = mysqli_query($conn,$timez);
    $timezz = mysqli_fetch_array($timez)[0];

    $datez="SELECT * FROM `queue_date` WHERE `ontime` = '".$timezz."' and `date` = '".$date."' ";
    $datez = mysqli_query($conn,$datez);
    $datezz = mysqli_num_rows($datez);

    $maximuminday = 18;
    if(date('N') == 5) //5 = friday
        $maximuminday = 12;
    if($datezz !== 0){
        $timezx="SELECT SUM(hasq) FROM `queue_date` WHERE `date` = '$date'";
        $timezx = mysqli_query($conn,$timezx);
        $timezzx = mysqli_fetch_array($timezx)[0];

        $hasquery="SELECT hasq FROM `queue_date` WHERE `ontime` = '".$timezz."' and `date` = '".$date."' ";
        $hasq = mysqli_query($conn,$hasquery);
        $hasqq = mysqli_fetch_array($hasq)[0];

    
       
        if($hasqq < 3 && $timezzx < $maximuminday){
            $t="SELECT type_id FROM `type_service` WHERE `type_name` = '".$type_name."'";
            $type = mysqli_query($conn,$t);

            $m="SELECT mem_id FROM `member` WHERE `username` = '".$username."'";
            $mem = mysqli_query($conn,$m);
            // Free result set
            $mem1=mysqli_fetch_array($mem);
            //echo $row[0]."<br>";

            $row=mysqli_fetch_array($type);
           
            $sql = "INSERT INTO `queue` (queue_date,queue_time,queue_status,type_id,mem_id) VALUES ('$date','$time','','$row[0]','$mem1[0]')";
            $query_sql = mysqli_query($conn,$sql);
            $sqltime = "UPDATE queue_date SET hasq = hasq+1 where `ontime` = '".$timezz."' and `date` = '$date'";
            $query_time = mysqli_query($conn,$sqltime);
            // print($sql);
            
            if($query_sql &&  $query_time){
                echo "Records inserted successfully.\n";
                

            }else{
                echo "ERROR: Could not able to execute $sql.".mysqli_error($conn);
            }
    
            mysqli_close($conn);
        }else{
            echo "Maximum";
        }
    }else{

        $sql = "INSERT INTO `queue_date` (date,ontime,hasq) VALUES ('$date','$timezz',0)";
        $query_sql = mysqli_query($conn,$sql);

        $timezx="SELECT SUM(hasq) FROM `queue_date` WHERE `date` = '".date("Y-m-d")."'";
        $timezx = mysqli_query($conn,$timezx);
        $timezzx = mysqli_fetch_array($timezx)[0];

        $hasq="SELECT hasq FROM `queue_date` WHERE `ontime` = '".$timezz."' and `date` = '$date'";
        $hasq = mysqli_query($conn,$hasq);
        $hasqq = mysqli_fetch_array($hasqq)[0];
        if($hasqq < 3 && $timezzx < $maximuminday){
            $t="SELECT type_id FROM `type_service` WHERE `type_name` = '".$type_name."'";
            $type = mysqli_query($conn,$t);

            $m="SELECT mem_id FROM `member` WHERE `username` = '".$username."'";
            $mem = mysqli_query($conn,$m);
            // Free result set
            $mem1=mysqli_fetch_array($mem);
            //echo $row[0]."<br>";

            $row=mysqli_fetch_array($type);
            
            $sql = "INSERT INTO `queue` (queue_date,queue_time,type_id,mem_id) VALUES ('$date','$time','$row[0]','$mem1[0]')";
            $query_sql = mysqli_query($conn,$sql);
            $sqltime = "update queue_date set hasq = hasq+1 where `ontime` = '".$timezz."' and `date` = '$date'";
            $query_time = mysqli_query($conn,$sqltime);
            // print($sql);
    
            if($query_sql &&  $query_time){
                echo "Records inserted successfully.";

            }else{
                echo "ERROR: Could not able to execute $sql.".mysqli_error($conn);
            }
    
            mysqli_close($conn);
        }else{
            echo "Maximum";
        }
    }

    function addQueue($date,$time,$timezz,$cardnumber,$type_name)
    {   

       
        
        //mysqli_free_result($type);


        /*$tz_object = new DateTimeZone('Asia/Bangkok');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        $olddate = strtotime($datetime->format('Y/m/d H:i:s'));
        $adddate = strtotime($datetime->format('Y/m/d H:i:s')) + 60*60;
        print('<br>');
        print(date('Y-m-d H:i:s', $olddate));
        print('<br>');
        print(date('Y-m-d H:i:s', $adddate));
        print('<br>');*/

    }
?>