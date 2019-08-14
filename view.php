<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include_once 'config/connection.php';
  include_once 'config/function.php';

  @$req_id = $_GET['id'];
  $stmt = getQueryRequest($req_id);
  $row = $stmt->fetch();

  //$user_code = $_SESSION['user_code'];
  $req_user = $row['req_user'];
  $req_status = $row['req_status'];
  $req_file = $row['req_file'];
  $file_ext = pathinfo($req_file, PATHINFO_EXTENSION);

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
  <?php //include_once 'inc/navbar.php' ?>

  <div class="container-fluid">
    <div class="row">
      <?php //include_once 'inc/sidemenu.php' ?>
  
      <main role="main" class="col-md-12 ml-sm-auto col-lg-12 ">

        <?php 
          /*

          Index

          */
          if($act == 'index'): 
            include_once 'inc/alert.php';
        ?>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">รายละเอียดการขอใช้บริการ</h5>
              </div>
              <div class="card-body">
                <form action="?act=login" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผู้ใช้บริการ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="req_id" readonly
                        value="<?php echo $row['req_id'] ?>">
                    </div>
                  </div>
			 	  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เลขที่บริการ</label>
                    <div class="col-md-3 col-sm-8">
                      <input type="text" class="form-control" name="req_gen" readonly
                        value="<?php echo $row['req_gen'] ?>">
                    </div>
                  </div>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">แผนกรับริการ</label>
                    <div class="col-md-3 col-sm-8">
                      <input type="text" class="form-control" name="user_code_use" readonly
                        value="<?php echo getDepartmentName($row['req_dep']) ?>">
                    </div>
                  </div>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้ขอใช้บริการ</label>
                    <div class="col-md-3 col-sm-8">
                      <input type="text" class="form-control" name="user_code_use" readonly
                        value="<?php echo $row['req_user_process'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">บริการ</label>
                    <div class="col-md-3 col-sm-8">
                      <input type="text" class="form-control" value="<?php echo getServiceName($row['service_id']) ?>" readonly>
					  <input type="hide" name="service_id" class="form-control" value="<?php echo $row['service_id'] ?>" readonly style="display: none">
                    </div>
                  </div>
                  <?php
                    $req_file = $row['req_file'];
                    $file_ext = pathinfo($req_file, PATHINFO_EXTENSION);

                    if(!empty($req_file)):
                      if($file_ext == 'jpg' || $file_ext == 'jpeg' || $file_ext == 'png'){
                  ?>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รูปประกอบ</label>
                    <div class="col-md-3 col-sm-8">
                      <a href="public/request/<?php echo $row['req_file'] ?>" target="_blank">
                        <img src="public/request/<?php echo $row['req_file'] ?>" class="img-fluid">
                      </a>
                    </div>
                  </div>
                  <?php } else { ?>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เอกสารประกอบ</label>
                    <div class="col-md-3 col-sm-8">
                      <a href="public/request/<?php echo $row['req_file'] ?>" target="_blank">
                        <?php echo $row['req_file'] ?>
                      </a>
                    </div>
                  </div>
                  <?php 
                      }
                    endif; 

                    if($row['req_status'] == 1 || $row['req_status'] == 2):
                  ?>
                  
                  <?php endif; ?>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รายละเอียดเพิ่มเติม</label>
                    <div class="col-md-3 col-sm-8">
                      <textarea name="req_text" class="form-control" rows="5" readonly><?php echo $row['req_text'] ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">วันที่ใช้บริการ</label>
                    <div class="col-md-3 col-sm-8">
                      <input type="text" class="form-control" value="<?php echo convertDate($row['req_create']).' '.date('H:i',strtotime($row['req_create'])).' น.' ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สถานะ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" value="<?php echo getStatusName($row['req_status']) ?>" readonly>
                    </div>
                  </div>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้รับดำเนินการ</label>
                    <div class="col-md-3 col-sm-8">
                      <input type="text" class="form-control" value="<?php echo getUserFullname($row['req_operator']) ?>" readonly>
                    </div>
                  </div>
				  <hr>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้รับเรื่อง</label>
                    <div class="col-md-3 col-sm-8">
                      <input type="text" class="form-control" readonly
                        value="<?php echo getUserFullname($row['req_user']) ?>">
                    </div>
                  </div>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สาขา</label>
                    <div class="col-md-3 col-sm-8">
                      <input type="text" class="form-control" readonly
                        value="<?php echo getUserBranch($row['req_user']) ?>">
                    </div>
                  </div>
                  <?php
                    $stmt = getQueryManage($row['req_id']);
                    $manages = $stmt->fetchAll();
                    if($manages):
                  ?>
                  <div class="form-group row">
                    <span class="text-primary">การดำเนินการ</span>
                    <div class="table-responsive w-100">
                      <table class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>วันที่รับเรื่อง</th>
                            <th>รายละเอียด</th>
                            <th>วันที่แล้วเสร็จ</th>
                            <th>ผู้ดำเนินการ</th>
                            <th>ไฟล์เอกสาร</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            foreach($manages as $key => $manage):
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo convertDate($manage['manage_date_start']) ?></td>
                            <td class="text-left"><?php echo $manage['manage_text'] ?></td>
                            <td><?php echo convertDate($manage['manage_date_end']) ?></td>
                            <td><?php echo getUserFullname($manage['manage_user']) ?></td>
                            <td>
                              <?php if($manage['manage_file']) { ?>
                              <a href="public/manage/<?php echo $manage['manage_file'] ?>" target="_blank">
                                <?php echo $manage['manage_file'] ?>
                              </a>
                              <?php } else { echo '-'; } ?>
                            </td>

                            
                          </tr>
                          <?php 
                            endforeach; 
                            unset($manage);
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <?php endif; ?>
                  <div class="form-group row justify-content-center">
                    <?php /*if($row['req_status'] == 1 || $row['req_status'] == 2 || $row['req_status'] == 3): ?>
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
					  
                    <?php
                      endif;*/

                      if($row['req_status'] == 1 || $row['req_status'] == 2):
                    ?>
                    
                    <?php endif; ?>
                    <?php /*<div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="request.php?id=<?php echo $_GET["id"]?>">
                        <i class="fas fa-sign-in-alt"></i> เข้าระบบ
                      </a>
                    </div>*/?>
                    <div class="col-sm-3 pb-2">
                      <input type="hidden" name="login_req_id" value="<?php echo $_GET["id"]?>">
                      <button class="btn btn-success btn-sm btn-block" name="btnLogin">
                        <i class="fas fa-sign-in-alt"></i> เข้าระบบ
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php 
          endif;

          /*

          Login

          */
          if($act == 'login'):
            if(!isset($_POST['btnLogin'])){
              header('Location: index.php');
              die();
            }
            
            $_SESSION["login_req_id"] = $_POST["login_req_id"];
            header('Location: index.php');
            
          endif;
        ?>
      </main>
    </div>
  </div>

  
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="public/js/main.min.js"></script>
</body>
</html>