<?php
include 'connectionApi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $MCUId = process_input($_POST["MCUId"]);
        // echo $MCUId;
        // $userId = 0;
        $macAddress = process_input($_POST["macAddress"]);
        // $deviceName = "iotnow node";
        // $deviceLocation = "lab";
        // $wifiSsid = "iotnow";
        // $wifiPassword = "iotnowpass";
        // $autoUpdate = 1;
        $programChoice = process_input($_POST["programId"]);
        $versionChoice = process_input($_POST["versionId"]);
        $ipAddress =$_SERVER['REMOTE_ADDR'];
        $lastActive = time();


        //check if device already exists
        $user_check_query = "SELECT * FROM devices WHERE MACAddress='$macAddress' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        $programChoiceToSet = $user['programChoice'];
        $versionChoiceToSet = $user['versionChoice'];
        $autoUpdate = $user['autoUpdate'];

        if($autoUpdate=='1'){
            //check max version number
            $user_check_query = "SELECT MAX(versionId) AS max_versionId FROM programVersions WHERE programId=".$programChoiceToSet." AND MCUId=".$MCUId." LIMIT 1";
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);
            $latestVersionId = $user['max_versionId'];
            $versionChoiceToSet=$latestVersionId;
        }

        if($programChoiceToSet != $programChoice || $versionChoiceToSet != $versionChoice){
            echo $programChoiceToSet."_".$versionChoiceToSet;
        }
        else{
            echo "0";
        }
        $conn->close();
}
else {
    // echo "Data not received";
    echo "E2";
}

function process_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
