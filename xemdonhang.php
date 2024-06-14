<?php
include "connect.php";
$iduser = $_POST['iduser'];

if ($iduser == 0) {
    // Lấy tất cả đơn hàng và thông tin người dùng
    $query = 'SELECT donhang.id, donhang.diachi, donhang.sodienthoai, donhang.email, donhang.soluong, donhang.tongtien, donhang.trangthai, donhang.momo, donhang.ngaydat, user.username 
              FROM `donhang` 
              INNER JOIN user ON donhang.iduser = user.id 
              ORDER BY donhang.id DESC';
} else {
    // Lấy đơn hàng của một người dùng cụ thể
    $query = 'SELECT * FROM `donhang` WHERE `iduser` = '.$iduser.' ORDER BY id DESC';
}

$data = mysqli_query($conn, $query);
$result = array();
while ($row = mysqli_fetch_assoc($data)) {
    $truyvan = 'SELECT chitietdonhang.*, sanphammoi.* 
                FROM `chitietdonhang` 
                INNER JOIN sanphammoi ON chitietdonhang.idsp = sanphammoi.id 
                WHERE chitietdonhang.iddonhang = '.$row['id'];
    $data1 = mysqli_query($conn, $truyvan);
    $item = array();
    while ($row1 = mysqli_fetch_assoc($data1)) {
        $item[] = $row1;
    }
    $row['item'] = $item;
    $result[] = $row;
}

if (!empty($result)) {
    $arr = [
        'success' => true,
        'message' => "Thành công",
        'result' => $result
    ];
} else {
    $arr = [
        'success' => false,
        'message' => "Không có dữ liệu",
        'result' => $result
    ];
}

print_r(json_encode($arr));
?>
