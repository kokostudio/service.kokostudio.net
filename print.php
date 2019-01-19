<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';

  $req_id = $_GET['id'];
  $stmt = getQueryRequest($req_id);
  $row = $stmt->fetch();
  $req_file = $row['req_file'];
  $file_ext = pathinfo($req_file, PATHINFO_EXTENSION);

  if(!isset($_SESSION['user_code'])){
    header('location: 404.html');
    die();
  }
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
    .form-group{
      padding: 1px;
      margin: 1px;
    }
    .container{
      width: 210mm;
    }
    input{
      border: 0;
      outline: 0;
      background: transparent;
      border-bottom: 1px solid black;
    }
    textarea{
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 py-3">
        <form>
          <div class="form-group row justify-content-center pb-3">
            <label class="col-form-label"><h5>รายละเอียดการขอใช้บริการ</h5></label>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">เลขที่บริการ</label>
            <input class="col-sm-4" value="<?php echo $row['req_gen'] ?>"></input>
          </div>
		  <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">แผนกรับริการ</label>
            <input class="col-sm-4" value="<?php echo getDepartmentName($row['req_dep']) ?>"></input>
          </div>
		  <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">ผู้ขอใช้บริการ</label>
            <input class="col-sm-4" value="<?php echo $row['req_user_process'] ?>"></input>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">บริการ</label>
            <input class="col-sm-7" value="<?php echo getServiceName($row['service_id']) ?>"></input>
          </div>

          <?php 
          if($req_file):
            if($file_ext == 'jpg' || $file_ext == 'jpeg' || $file_ext == 'png'){ ?>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">รูปประกอบ</label>
            <div class="col-sm-4">
              <img src="public/request/<?php echo $row['req_file'] ?>" class="img-fluid">
            </div>
          </div>
          <?php } endif; ?>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">รายละเอียดเพิ่มเติม</label>
            <div class="col-sm-9">
              <textarea class="form-control-plaintext" readonly rows="5"><?php echo $row['req_text'] ?></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">วันที่ใช้บริการ</label>
            <input class="col-sm-4" value="<?php echo convertDate($row['req_create']).' '.date('H:i',strtotime($row['req_create'])).' น.' ?>"></input>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">สถานะ</label>
            <input class="col-sm-7" value="<?php echo getStatusName($row['req_status']) ?>"></input>
          </div>
		  <hr>
          <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">ผู้รับเรื่อง</label>
            <input class="col-sm-4" value="<?php echo getUserFullname($row['req_user']) ?>"></input>
          </div>
		  <div class="form-group row">
            <label class="col-sm-3 col-form-label text-md-right">สาขา</label>
            <input class="col-sm-4" value="<?php echo getUserBranch($row['req_user']) ?>"></input>
          </div>
          <?php
            $stmt = getQueryManage($row['req_id']);
            $manages = $stmt->fetchAll();
            if($manages):
          ?>
          <div class="form-group row">
            <span>การดำเนินการ</span>
            <table class="table table-bordered table-hover table-sm">
              <thead>
                <tr>
                  <td>#</td>
                  <td>วันที่รับเรื่อง</td>
                  <td>รายละเอียด</td>
                  <td>วันที่แล้วเสร็จ</td>
                  <td>ผู้ดำเนินการ</td>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach($manages as $key => $manage):
                ?>
                <tr>
                  <td><?php echo $key+1 ?></td>
                  <td><?php echo convertDate($manage['manage_date_start']).' '.date('H:i',strtotime($row['req_create'])).' น.' ?></td>
                  <td class="text-left"><?php echo $manage['manage_text'] ?></td>
                  <td><?php echo convertDate($manage['manage_date_end']).' '.date('H:i',strtotime($row['req_update'])).' น.' ?></td>
                  <td><?php echo getUserFullname($manage['manage_user']) ?></td>
                </tr>
                <?php 
                  endforeach; 
                  unset($manage);
                ?>
              </tbody>
            </table>
          </div>
          <?php endif; ?>
          <div class="form-group row">
            <label class="col-sm-5"><small>วันที่ <?php echo date('d/m/Y') ?> เวลา <?php echo date('H:i') ?> น.</small></label>
          </div>
          <div class="form-group row justify-content-center d-print-none">
            <div class="col-sm-4">
              <a class="btn btn-danger btn-sm btn-block" href="javascript:history.back()">
                <i class="fa fa-arrow-left mr-2"></i>กลับหน้าหลัก
              </a>
            </div>
            <div class="col-sm-4">
              <a class="btn btn-info btn-sm btn-block" href="javascript:void(0)" onclick="window.print()">
                <i class="fa fa-print mr-2"></i>พิมพ์เอกสาร
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
</body>
</html>