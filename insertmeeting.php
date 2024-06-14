<?php
include "connect.php";
$meetingid = $_POST['meetingId'];
$token = $_POST['token'];

$query = 'INSERT INTO `meeting`( `meetingid`, `token`) VALUES ("'.$meetingid.'","'.$token.'")';
$data = mysqli_query($conn, $query);
if ($data == true) {
    $arr = [
        'success' => true,
        'message' => "Thanh cong"
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Ko thanh cong"
    ];
}
print_r(json_encode($arr));
?>