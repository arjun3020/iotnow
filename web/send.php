<?php
include 'connectionApi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $MCUId = process_input($_POST["MCUId"]);
        $userId = 0;
        $macAddress = process_input($_POST["macAddress"]);
        $deviceName = "iotnow node";
        $deviceLocation = "lab";
        $wifiSsid = "iotnow";
        $wifiPassword = "iotnowpass";
        $autoUpdate = 0;
        $programChoice = 1;
        $versionChoice =1;
        $ipAddress =$_SERVER['REMOTE_ADDR'];
        $lastActive = time();
        //check if device already exists
        $user_check_query = "SELECT * FROM devices WHERE MACAddress='$macAddress' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        $deviceId = $user['deviceId'];
        if($deviceId !=""){
            // update last
            $sql = "UPDATE devices SET lastActive =".$lastActive." WHERE deviceId='".$deviceId."'";  
            if(mysqli_query($conn, $sql))  
            {  
                echo 'Device timestamp updated on iotnow';
            }  
        }
        else{
        $sqlQuery = "INSERT INTO devices (MCUId, userId, macAddress, deviceName, deviceLocation,wifiSsid,wifiPassword,autoUpdate,programChoice,versionChoice,ipAddress,lastActive)
        VALUES ('" . $MCUId . "', '" . $userId . "', '" . $macAddress . "', '" . $deviceName . "', '" . $deviceLocation . "', '" . $wifiSsid . "', '" . $wifiPassword . "', '" . $autoUpdate . "','" . $programChoice . "','" . $versionChoice . "','" . $ipAddress . "','" . $lastActive . "')";
        
        if ($conn->query($sqlQuery) === TRUE) {
            echo "Device registered with iotnow";
        } 
        else {
            echo "Error, couldn't update device with iotnow";
        }
        }
    
        $conn->close();
}
else {
    echo "Error, data not received";
}

function process_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
