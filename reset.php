<?php
include "connect.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Kiểm tra xem 'email' đã được gửi trong yêu cầu POST chưa
if(isset($_POST['email'])) {
    $email = $_POST['email'];
    
    // Tiếp tục xử lý dữ liệu và gửi email
    $query = 'SELECT * FROM `user` WHERE `email`= "'.$email.'"';
    $data = mysqli_query($conn, $query);
    $result = array();
    while ($row = mysqli_fetch_assoc($data)) {
        $result[] = ($row);
        //code
    }
    if(empty($result)) {
        $arr = [
            'success' => false,
            'message' => "Mail ko chính xác.",
            'result' => $result
        ];
    } else {
        //send mail

        $email=($result[0]["email"]);
        $pass=($result[0]["pass"]);
        $link="<a href='http://192.168.1.188/banhang/reset_pass.php?key=".$email."&reset=".$pass."'>Click To Reset password</a>";
        $mail = new PHPMailer();
        $mail->CharSet =  "utf-8";
        $mail->IsSMTP();
        // enable SMTP authentication
        $mail->SMTPAuth = true;                  
        // GMAIL username
        $mail->Username = "hao7ehoathanh@gmail.com";
        // GMAIL password
        $mail->Password = "whla yzqa mmry rfsg";//pass cua mail
        $mail->SMTPSecure = "ssl";  
        // sets GMAIL as the SMTP server
        $mail->Host = "smtp.gmail.com";
        // set the SMTP port for the GMAIL server
        $mail->Port = "465";
        $mail->From= "hao7ehoathanh@gmail.com";//mail nguoi nhan
        $mail->FromName='App ban hang';
        $mail->AddAddress($email, 'reciever_name');
        $mail->Subject  =  'Reset Password';
        $mail->IsHTML(true);
        $mail->Body    = $link;
        if($mail->Send())
        {
          $arr = [
            'success' => true,
            'message' => "Vui lòng kiểm tra mail của bạn nhé!",
            'result' => $result
        ];
        }
        else
        {
          $arr = [
            'success' => false,
            'message' => "Gửi ko thành công.",
            'result' => $mail->ErrorInfo
        ];
        }
    }
} else {
    // Nếu 'email' không tồn tại trong yêu cầu POST
    $arr = [
        'success' => false,
        'message' => "Không có dữ liệu 'email' được gửi",
        'result' => null
    ];
}

print_r(json_encode($arr));
?>