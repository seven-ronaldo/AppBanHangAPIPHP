<?php
include "connect.php";

$sdt = $_POST['sdt'];
$email = $_POST['email'];
$tongtien = $_POST['tongtien'];
$iduser = $_POST['iduser'];
$diachi = $_POST['diachi'];
$chitiet = $_POST['chitiet'];

$query = 'INSERT INTO `donhang`(`iduser`, `diachi`, `sodienthoai`, `email`, `tongtien`) VALUES ("'.$iduser.'","'.$diachi.'","'.$sdt.'","'.$email.'","'.$tongtien.'")';
$data = mysqli_query($conn, $query);
$result = array();
if($data == true){
    $query = 'SELECT id AS iddonhang FROM `donhang` WHERE `iduser` = "'.$iduser.'" ORDER BY id DESC LIMIT 1';
    $data = mysqli_query($conn, $query);
    if($data) {
        $row = mysqli_fetch_array($data);
        $iddonhang = $row['iddonhang'];
        if(!empty($iddonhang)){
            //co don hang
            $chitiet = json_decode($chitiet, true);
            if(is_array($chitiet) && !empty($chitiet)) {
                foreach($chitiet as $value){
                    $truyvan = 'INSERT INTO `chitietdonhang`(`iddonhang`, `idsp`, `soluong`, `gia`) VALUES ("'.$iddonhang.'","'.$value["idsp"].'","'.$value["soluong"].'","'.$value["giasp"].'")';
                    $data = mysqli_query($conn, $truyvan);

                    //xu li tru so luong trong kho
                    $truyvankho = 'SELECT `sltonkho` FROM `sanphammoi` WHERE `id`='.$value["idsp"];
                    $data1 = mysqli_query($conn, $truyvankho);
                    $sltrenkho = mysqli_fetch_assoc($data1);

                    $sl_moi = $sltrenkho["sltonkho"] - $value["soluong"];
                    $truyvankho2 = 'UPDATE `sanphammoi` SET `sltonkho`='.$sl_moi.' WHERE `id`=' .$value["idsp"];
                    $data2 = mysqli_query($conn, $truyvankho2);
                    if($data2 == false){
                        $arr = [
                            'success' => false,
                            'message' => "Cập nhật số lượng sản phẩm thất bại",
                            'result' => $result
                        ];
                        print_r(json_encode($arr));
                        exit; // Dừng việc xử lý nếu có lỗi
                    }
                }
                // Nếu không có lỗi, trả về thông báo thành công
                $arr = [
                    'success' => true,
                    'message' => "Đặt hàng thành công",
                    'result' => $result
                ];
                print_r(json_encode($arr));
            } else {
                $arr = [
                    'success' => false,
                    'message' => "Dữ liệu chi tiết không hợp lệ hoặc rỗng",
                    'result' => $result
                ];
                print_r(json_encode($arr));
            }
        } else {
            $arr = [
                'success' => false,
                'message' => "Không tìm thấy đơn hàng",
                'result' => $result
            ];
            print_r(json_encode($arr));
        }
    } else {
        $arr = [
            'success' => false,
            'message' => "Lỗi truy vấn tạo ID đơn hàng",
            'result' => $result
        ];
        print_r(json_encode($arr));
    }
} else {
    $arr = [
        'success' => false,
        'message' => "Lỗi truy vấn tạo đơn hàng",
        'result' => $result
    ];
    print_r(json_encode($arr));
}
?>
