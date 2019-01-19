<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';

  if(!isset($_SESSION['user_code'])){
    header('location: request.php');
    die();
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
</head>
<body>
  <?php include_once 'inc/navbar.php' ?>

  <div class="container-fluid">
    <div class="row">
      <?php include_once 'inc/sidemenu.php' ?>
  
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php 
          include_once 'inc/alert.php'; 
          $user_code = $_SESSION['user_code'];
          $stmt = getQueryUser($user_code);
          $row = $stmt->fetch();

          /*

          Index

          */
          if($act == 'index'): 
            include_once 'inc/alert.php';
        ?>

        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="request.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">
              เปลี่ยนรหัสผ่าน
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">เปลี่ยนรหัสผ่าน</h5>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ID</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="user_code" 
                        value="<?php echo $row['user_code'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผ่านเดิม</label>
                    <div class="col-sm-3">
                      <input type="password" class="form-control" name="user_password">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผ่านใหม่</label>
                    <div class="col-sm-3">
                      <input type="password" class="form-control" name="new_password" id="new_password">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ยืนยัน รหัสผ่านใหม่</label>
                    <div class="col-sm-3">
                      <input type="password" class="form-control" name="new_password_again" id="new_password_again">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4"></label>
                    <div id="checkPassword"></div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate" id="btnUpdate" disabled>
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="request.php">
                        <i class="fa fa-arrow-left pr-2"></i>กลับหน้าหลัก
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php
          $stmt = null;
          endif;

          if($act == 'update'):
            if(!isset($_POST['btnUpdate'])){
              header('location: index.php');
              die();
            }

            $user_code = $_POST['user_code'];
            $user_password = $_POST['user_password'];
            $new_password = $_POST['new_password'];
            $hash_password = password_hash($new_password, PASSWORD_DEFAULT);

            $data_check = [$user_code];

            $sql = "SELECT user_password
              FROM ex_login
              WHERE user_code = ?";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_check);
            $row = $stmt->fetch();

            $check_verify = password_verify($user_password,$row['user_password']);

            if(!$check_verify){
              alertMsg('danger','รหัสผ่านเก่าไม่ถูกต้อง กรุณาลองใหม่อีกครั้งครับ','change_pwd.php');
            }

            $data_update = [$hash_password,$user_code];

            $sql = "UPDATE ex_login SET
              user_password = ?
              WHERE user_code = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data_update);

            if($result){
              alertMsg('success','เปลี่ยนรหัสผ่านเรียบร้อยแล้วครับ','change_pwd.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','change_pwd.php');
            }

            $stmt = null;
          endif;
        ?>
      </main>
    </div>
  </div>

  
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="public/js/main.min.js"></script>
  <script>
    // Alert Password Match
    $('#new_password_again').keyup(function(){
      var new_password  = $('#new_password').val();
      var new_password_again = $('#new_password_again').val();
      $('#checkPassword').html(new_password == new_password_again 
        ? "<span class='text-success'>รหัสผ่านใหม่ตรงกัน</span>" 
        : "<span class='text-danger'>รหัสผ่านใหม่ไม่ตรงกัน</span>");
    });

    // Enable Password Match
    $('#new_password_again').keyup(function(){
      var new_password  = $('#new_password').val();
      var new_password_again = $('#new_password_again').val();
      if (new_password !== new_password_again ){
         $('#btnUpdate').attr('disabled', true);
      } else {
         $('#btnUpdate').removeAttr('disabled');
      }
    });
  </script>
</body>
</html>