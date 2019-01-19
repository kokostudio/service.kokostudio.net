<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include_once 'config/connection.php';
  include_once 'config/function.php';

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
  <link rel="stylesheet" href="node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="public/css/custom.css">
</head>
<body>
  

  <div class="container-fluid">
    <div class="row">
      
  
      <main role="main" class="col-xl-12 col-md-9 ml-sm-auto px-4">
        
        <?php       
          /*

          Add Item

          */

            include_once 'inc/alert.php';
        ?>
    
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">เพิ่มผู้ใช้งาน</h5>
              </div>
              <div class="card-body">
                <form action="?act=insert" method="POST" enctype="multipart/form-data">
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-4">
                      <img src="" id="profile-picture-tag" class="img-fluid">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เปลี่ยนรูป</label>
                    <div class="col-sm-4">
                      <input type="file" class="form-control" name="user_picture" id="profile-picture" accept="image/*">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสพนักงาน</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_code" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อ - นามสกุล</label>
                    <div class="input-group col-sm-6">
                      <input type="text" class="form-control" name="user_name" required>
                      <input type="text" class="form-control" name="user_surname" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อเล่น</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_nickname">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ฝ่าย/แผนก</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="dep_id" required>
                        <option value="">--- เลือก ฝ่าย/แผนก ---</option>
                        <?php
                          $departments = getDepartment();
                          foreach($departments as $dep) :
                        ?>
                        <option value="<?php echo $dep['dep_id'] ?>"><?php echo $dep['dep_name'] ?></option>
                        <?php 
                          endforeach;
                          unset($dep);
                        ?>
                      </select>
                    </div>
                  </div>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สาขา</label>
                    <div class="col-sm-3">
						<select class="form-control" name="bra_id" required>
                        <option value="">--- เลือก สาขา ---</option>
                        <?php
                          $branch = getBranch();
                          foreach($branch as $bra) :
                        ?>
                        <option value="<?php echo $bra['bra_id'] ?>"><?php echo $bra['bra_name'] ?></option>
                        <?php 
                          endforeach;
                          unset($bra);
                        ?>
                      </select>

                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อผู้ใช้ระบบ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_username" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">อีเมล</label>
                    <div class="col-sm-4">
                      <input type="email" class="form-control" name="user_email" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เบอร์โทรศัพท์</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_telephone">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">มือถือ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_mobile">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Line ID</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_line">
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="index.php">
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
         

          /*

          Insert Item

          */

          if($act == 'insert'):
            if(!isset($_POST['btnInsert'])){
              header('location: index.php');
              die();
            }

            $user_code = $_POST['user_code'];
            $user_name = $_POST['user_name'];
            $user_surname = $_POST['user_surname'];
            $user_picture = $_FILES['user_picture']['name'];
            $user_nickname = $_POST['user_nickname'];
            $dep_id = $_POST['dep_id'];
		    //$user_branch = $_POST['bra_name'];
		    $bra_id = $_POST['bra_id'];
            $user_username = $_POST['user_username'];
            $user_password = getPasswordDefault();
            $hash_password = password_hash($user_password,PASSWORD_DEFAULT);
            $user_email = $_POST['user_email'];
            $user_telephone = $_POST['user_telephone'];
            $user_mobile = $_POST['user_mobile'];
            $user_line = $_POST['user_line'];
            $user_create = date('Y-m-d H:i:s');

            $data_user = [$user_code,$user_name,$user_surname,$user_nickname,$dep_id,$bra_id,$user_email,$user_telephone,$user_mobile,$user_line,$user_create];

            $data_login = [$user_code,$user_username,$hash_password,$user_create];

            // Check User Duplicate
            $data_check_user_code = [$user_code];
            $sql = "SELECT user_id FROM ex_user WHERE user_code = ?";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_check_user_code);
            $check_user_code = $stmt->fetch();

            $data_check_username = [$user_username];
            $sql = "SELECT login_id FROM ex_login WHERE user_username = ?";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_check_username);
            $check_username = $stmt->fetch();

            if($check_user_code || $check_username){
              alertMsg('danger','User Code or Username already exists','?act=add');
            }

            // Check Picture Extension
            if($user_picture){
              $picture_file_name  = $_FILES['user_picture']['name'];
              $picture_file_tmpname  = $_FILES['user_picture']['tmp_name'];
              $picture_ext = pathinfo($picture_file_name, PATHINFO_EXTENSION);
              $picture_file_new_name = $user_code.'.'.$picture_ext;
              $picture_file_path = "public/images/users/";
              $picture_allow_extension = array('jpg','jpeg','png');

              if(!in_array($picture_ext, $picture_allow_extension)):
                alertMsg('danger','Please Choose JPG or PNG Only.','?act=add');
              endif;
            }

            // Insert DB
            $sql = "INSERT INTO ex_user(user_code,user_name,user_surname,user_nickname,dep_id,bra_id,user_email,user_telephone,user_mobile,user_line,user_create)
              VALUES(?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_user);

            $sql = "INSERT INTO ex_login(user_code,user_username,user_password,login_create)
              VALUES(?,?,?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data_login);

            // Update Picture
            if($user_picture):
              @$pictureSize   = getimagesize($picture_file_tmpname);
              $pictureWidth   = 500;
              @$pictureHeight = round($pictureWidth*$pictureSize[1]/$pictureSize[0]);
              $pictureType    = $pictureSize[2];

              if($pictureType == IMAGETYPE_PNG){

                $pictureResource = imagecreatefrompng($picture_file_tmpname);
                $pictureX = imagesx($pictureResource);
                $pictureY = imagesy($pictureResource);
                $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                imagepng($pictureTarget,$picture_file_path.$picture_file_new_name);

              } else {

                $pictureResource = imagecreatefromjpeg($picture_file_tmpname);
                $pictureX = imagesx($pictureResource);
                $pictureY = imagesy($pictureResource);
                $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                imagejpeg($pictureTarget,$picture_file_path.$picture_file_new_name);

              }

              $data_picture = [$picture_file_new_name,$user_code];

              $sql = "UPDATE ex_user SET
                user_picture    = ?
                WHERE user_code = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_picture);

            endif;

            if($result){
              alertMsg('success','เพิ่มข้อมูลเรียบร้อยแล้วครับ','register.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','?act=add');
            }

            $stmt = null;
          endif;

          /*

          Edit Item 

          */

          

          /*

          Update Item 

          */

          

          /*

          Delete Item 

          */

         
        ?>
      </main>
    </div>
  </div>

  
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="public/js/main.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#data').DataTable({
        "oLanguage": {
          "sLengthMenu": "แสดง _MENU_ ลำดับ ต่อหน้า",
          "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
          "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ ลำดับ",
          "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 ลำดับ",
          "sInfoFiltered": "(จากทั้งหมด _MAX_ ลำดับ)",
          "sSearch": "ค้นหา :",
          "oPaginate": {
                "sFirst":    "หน้าแรก",
                "sLast":    "หน้าสุดท้าย",
                "sNext":    "ถัดไป",
                "sPrevious": "ก่อนหน้า"
            }
        }
      });
    });

    function pictureShow(input) {
      if (input.files && input.files[0]){
          var reader = new FileReader();
          reader.onload = function(e){
              $('#profile-picture-tag').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
    }
    $("#profile-picture").change(function(){
      pictureShow(this);
    });
  </script>
</body>
</html>