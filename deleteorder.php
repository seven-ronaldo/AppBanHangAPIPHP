<?php
include "connect.php";
$id = $_POST['iddonhang'];

$query = 'DELETE FROM `donhang` WHERE `id` ='.$id;
$data = mysqli_query($conn, $query);

$query1 = 'DELETE FROM `chitietdonhang` WHERE `iddonhang` ='.$id;
$data = mysqli_query($conn, $query1);

if ($data == true) {
    $arr = [
        'success' => true,
        'message' => "Thanh cong"
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Xoa ko thanh cong"
    ];
}
print_r(json_encode($arr));
?>