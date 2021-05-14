<?php

    function callAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: App 71bea0290df9100c1e22b6be03c8a20a-49febdcf-78d7-488e-8902-52d41f34e78a',
        'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }

    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "projectq";

    $conn = new mysqli($servername,$username,$password,$dbname);

    if ($conn->connect_error){
        die("Connect failed: " . $conn->connect_error);
    }

    while(true) {
        date_default_timezone_set("Asia/Bangkok");
        $today = date('d-m-Y');
        $now = date('H:i');
        $time = date('H:i', strtotime('+1 hour'));
        /*$today = getdate();*/
        //print 'sssssss'.$today;
        //$today = "03-05-2021";
        // if ($today < 10) {
        //     $today = substr($today,1);
        // }

       $sql = "SELECT * FROM `queue` WHERE `queue_date`='".$today."'  ORDER BY mem_id ASC " ;
       //$sql="SELECT * FROM `queue` WHERE `queue_date`='24-11-2020'";
        $result = mysqli_query($conn,$sql);
        //print 'aa'.$result."\n";
        //$output=array();
            while ($row = mysqli_fetch_array($result)){
               
            $output[] = $row;
        }
        //echo json_encode($output)."\n";
        mysqli_free_result($result);

        echo 'today is '.$today.' time: '.$now.' past 1 hour :'.$time."\n";
        
        
        for($i = 0;$i<count($output);$i++) {
            $formatTime = substr($output[$i]['queue_time'],0,5);
            echo 'mem.id'.$output[$i]['mem_id']."\n";
            echo ($formatTime.' '.$time)."\n";
            
            $id = $output[$i]['mem_id'];
            if($formatTime == $time) {
               
                $sql = "SELECT member.cardnumber FROM `member` 
                INNER JOIN `queue` ON queue.mem_id = member.mem_id WHERE member.mem_id= '$id' ";
                
                $result1 = mysqli_query($conn,$sql);
                //echo $sql."\n";
                
            
                while ($row = mysqli_fetch_array($result1)) {
                   
                    $output1[] = $row;
                }
        
                mysqli_free_result($result1);
                
                $tell = $output1[$i]['cardnumber'];
                $tellformat = "66".substr($output1[$i]['cardnumber'],1);

                echo "Phone :".$tellformat."\n";
                $data_array =  array(
                    "to"   => $tellformat,
                    "text" => "อีก 1 ชั่วโมงเข้าใช้บริการ",
                    "from" => "system",
                );
                $make_call = callAPI('POST', '4me931.api.infobip.com/sms/2/text/single', json_encode($data_array));
                $response = json_decode($make_call, true);
                /*$errors   = $response['response']['errors'];
                $data     = $response['response']['data'][0];*/
            }
            // echo json_encode($output[0].queue_time)."\n";
            
        }
        $output = [];
        sleep(60);
            
        //2020-11-03T16:05 xxxxx
    }
    mysqli_close($conn);
    
?>