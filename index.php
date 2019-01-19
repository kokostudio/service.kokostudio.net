<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  $user_level = getUserLevel($_SESSION['user_code']);
  if(isset($_SESSION['user_code'])){
    alertMsg('warning','เข้าระบบอยู่แล้ว','request.php');
  }

  $act = isset($_GET['act']) ? $_GET['act'] : 'index';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Document</title>
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-pro/css/all.min.css">
  <link rel="stylesheet" href="public/css/custom.css">
  <style>
    .container {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
    }
    a:hover {
      text-decoration: none;
    }
  </style>
</head>
<body>
  <?php if($act == 'index') : ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <?php include_once 'inc/alert.php'; ?>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-sm-4">
        <div class="card shadow">
          <div class="card-body">
            <h4 class="my-4 text-center">เข้าสู่ระบบ</h4>
            <form action="?act=check" method="POST">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                  </div>
                  <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้งานระบบ">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                  </div>
                  <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน">
                </div>
              </div>
              <div class="form-group">
                <button class="btn btn-success btn-sm btn-block" name="btnLogin">
                  <i class="fa fa-check pr-2"></i>เข้าสู่ระบบ
                </button>
              </div>
              <div class="form-group row justify-content-center">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#forgotModal">
                  <i class="fa fa-user-times pr-2"></i>ลืมรหัสผ่าน?
                </a>
              </div>
				<hr>
				<a href="register.php" class="btn btn-info btn-sm btn-block" name="btnLogin">
                  <i class="fa fa-plus pr-2"></i>ลงทะเบียน
                </a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
    endif;

    if($act == 'check') :
      if(!isset($_POST['btnLogin'])){
        header('Location: index.php');
        die();
      }

      $username = $_POST['username'];
      $password = $_POST['password'];
      $host     = getHost();
      $ip       = getIP();

      $data_check_username = [$username];
      $data_check_login = [$username,$password];
      

      $sql = "SELECT login_id FROM ex_login WHERE user_username = ?";
      $stmt = $dbcon->prepare($sql);
      $stmt->execute($data_check_username);
      $check_username = $stmt->fetch();

      if(!$check_username){
        alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','index.php');
      }

      $sql = "SELECT user_password,login.user_code,user_level
        FROM ex_login login
        LEFT JOIN ex_user user
        ON login.user_code = user.user_code
        WHERE (user_username = ? OR user_password = ?)";
      $stmt = $dbcon->prepare($sql);
      $stmt->execute($data_check_login);
      $row = $stmt->fetch();

      $check_login = password_verify($password,$row['user_password']);
      if($check_login){
        $_SESSION['user_code'] = $row['user_code'];
        $user_level = getUserLevel($row['user_code']);
        $status = 1;

        $data_log = [$username,$host,$ip,$status];

        $sql = "INSERT INTO ex_log(log_username,log_host,log_ip,log_status)
            VALUES(?,?,?,?)";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute($data_log);

        if($user_level == 1){
          alertMsg('success','ยินดีต้อนรับ คุณ '.getUserNickname($_SESSION['user_code']).'','request.php');
        } else {
          alertMsg('success','ยินดีต้อนรับ คุณ '.getUserNickname($_SESSION['user_code']).'','dashboard.php');
        }

      } else {
        $status = 2;

        $data_log = [$username,$host,$ip,$status];
        $sql = "INSERT INTO ex_log(log_username,log_host,log_ip,log_status)
            VALUES(?,?,?,?)";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute($data_log);

        alertMsg('danger','ชื่อผู้ใช้งานระบบ หรือ รหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้งครับ','index.php');        
      }

    endif;
  ?>

  <div class="modal fade" id="forgotModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header mx-auto">
          <h5 class="modal-title">ลืมรหัสผ่าน?</h5>
        </div>
        <div class="modal-body">
          <div class="row justify-content-center">
            <div class="col-sm-8">
              <form action="?act=forgot" method="POST">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                      </div>
                      <input type="email" class="form-control" name="email" placeholder="E-Mail">
                    </div>
                  </div>
                </div>
                <div class="form-group row justify-content-center">
                  <div class="col-sm-6 pb-2">
                    <button class="btn btn-success btn-sm btn-block" name="btnForgot">
                      <i class="fa fa-check pr-2"></i>ยืนยัน
                    </button>
                  </div>
                  <div class="col-sm-6 pb-2">
                    <button class="btn btn-danger btn-sm btn-block" data-dismiss="modal">
                      <i class="fa fa-times pr-2"></i>ปิด
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
    if($act == 'forgot'):
      if(!isset($_POST['btnForgot'])){
        header('Location: index.php');
        die();
      }

      $email = $_POST['email'];
      $code = getCodeFormEmail($email);
      $username = getUsernameFormCode($code);
      $gen_password = md5(microtime());
      $hash_password = password_hash($gen_password,PASSWORD_DEFAULT);

      $data_check_email = [$email];
      $data_update_password = [$hash_password,$code];

      $sql = "SELECT user_email FROM ex_user WHERE user_email = ? AND user_status = 1";
      $stmt = $dbcon->prepare($sql);
      $stmt->execute($data_check_email);
      $check_email = $stmt->fetch();

      if(!$check_email){
        alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','index.php');
      }

      $sql = "UPDATE ex_login SET
        user_password = ?
        WHERE user_code = ?";
      $stmt = $dbcon->prepare($sql);
      $result = $stmt->execute($data_update_password);

      $host   = getHost();
      $ip     = getIP();
      $status = 3;

      $data_log = [$username,$host,$ip,$status];
      $sql = "INSERT INTO ex_log(log_username,log_host,log_ip,log_status)
          VALUES(?,?,?,?)";
      $stmt = $dbcon->prepare($sql);
      $stmt->execute($data_log);

      if($result){
        $stmt = getSystem();
        $row = $stmt->fetch();

        $user_gmail = "{$row['gmail_username']}";
        $pass_gmail = "{$row['gmail_password']}";
        $email_send = "{$row['gmail_username']}";
        $name_send  = "{$row['gmail_name']}";
        $email_receive = $email;
        $name_receive = getUserFullname($code);
        $date_send = date('d/m/Y');
        $time_send = date('H:i');
        $line_token = "{$row['line_token']}";

        // Load Composer's autoloader
        require 'vendor/autoload.php';

        try {
          $mail = new PHPMailer(true); 

          //Server settings
          $mail->SMTPDebug = 0;                                 // Enable verbose debug output
          $mail->isSMTP();                                      // Set mailer to use SMTP
          $mail->Host = "smtp.gmail.com";                       // Specify main and backup SMTP servers
          $mail->SMTPAuth = true;                               // Enable SMTP authentication
          $mail->Username = "{$user_gmail}";                    // SMTP username
          $mail->Password = "{$pass_gmail}";                    // SMTP password
          $mail->SMTPSecure = "tls";                            // Enable TLS encryption, `ssl` also accepted
          $mail->Port = 587;                                    // TCP port to connect to
          $mail->CharSet = "UTF-8";                             // CharSet UTF-8

          $mail->SMTPOptions = array(
            'ssl' => array(
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true
            )
          );

          //Recipients
          $mail->setFrom("{$email_send}", "{$name_send}");
          $mail->addAddress("{$email_receive}", "{$name_receive}");

          //Content
          $mail->isHTML(true);
          $mail->Subject = 'ระบบแจ้งรหัสผ่านใหม่';
          $mail->Body  = "เรียน คุณ {$name_receive} <br><br>";
          $mail->Body .= "ระบบได้ทำการรีเซ็ทรหัสผ่านให้ท่านเรียบร้อยแล้ว<br>";
          $mail->Body .= "รหัสผ่านใหม่ของท่านคือ : {$gen_password} <br><br>";
          $mail->Body .= "<b style='color: red;'>*กรุณาเข้าไปเปลี่ยนรหัสผ่านใหม่ด้วยนะครับ*</b> <br><br>";
          $mail->Body .= "วันที่ดำเนินการ {$date_send} เวลา {$time_send} น.";
          $mail->send();

$line_text = "
---------------------
แจ้งเตือนการขอรหัสผ่านใหม่
---------------------
จากคุณ {$name_receive}
---------------------
ทำการขอรหัสผ่านใหม่เข้ามา
---------------------
Host : {$host}
IP : {$ip}
วันที่ : {$date_send}
เวลา : {$time_send} น.";

          echo lineNotify($line_text,$line_token);

          alertMsg('success','ระบบส่งรหัสผ่านใหม่ไปทาง E-Mail ของท่านเรียบร้อยแล้วครับ','index.php');

        } catch (Exception $e) {
          alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','index.php');
        }
        
      } else {
        alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','index.php');
      }
    endif;
  ?>
  
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="public/js/main.min.js"></script>
</body>
</html>