<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  include_once 'config/connection.php';
  include_once 'config/function.php';

  $user_level = getUserLevel($_SESSION['user_code']);
  if(!isset($_SESSION['user_code']) || ($user_level == 1 || empty($user_level))){
    alertMsg('danger','ไม่พบหน้านี้ในระบบ','request.php');
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
  <link rel="stylesheet" href="node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="public/css/custom.css">
</head>
<body>
  <?php include_once 'inc/navbar.php' ?>

  <div class="container-fluid">
    <div class="row">
      <?php include_once 'inc/sidemenu.php' ?>
  
      <main role="main" class="col-xl-10 col-md-9 ml-sm-auto px-4">
        
        <?php 
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
              ผู้ใช้งาน
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">จัดการผู้ใช้งาน</h5>
              </div>
              <div class="card-body">
                <!-- Button -->
                <div class="row">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="departments.php" class="btn btn-primary btn-sm btn-block">
                      <i class="fas fa-building mr-2"></i>ฝ่าย/แผนก
                    </a>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="log.php" class="btn btn-danger btn-sm btn-block">
                      <i class="fas fa-file-alt mr-2"></i>Log
                    </a>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="report_user.php?dep=<?php echo @$_GET['dep'] ?>" target="_blank" 
                      class="btn btn-warning btn-sm btn-block">
                      <i class="fas fa-file-pdf mr-2"></i>รายงาน
                    </a>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="branch.php" class="btn btn-info btn-sm btn-block">
                      <i class="fas fa-warehouse mr-2"></i>สาขา
                    </a>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="users.php?dep="
                        <?php if(empty($_GET['dep'])) echo 'selected' ?>>--- ค้นหา แผนก/ฝ่าย ---</option>
                      <?php
                        $departments = getDepartment();
                        foreach($departments as $dep): 
                      ?>
                      <option value="users.php?dep=<?php echo $dep['dep_id'] ?>" <?php if(@$_GET['dep'] == $dep['dep_id']) echo 'selected' ?>><?php echo $dep['dep_name'] ?></option> 
                      <?php
                        endforeach;
                        unset($dep);
                      ?>
                    </select>
                  </div>
				  <div class="col-xl-3 col-md-6 mb-2">
				  </div>
				  <div class="col-xl-3 col-md-6 mb-2">
				  </div>
				  <div class="col-xl-3 col-md-6 mb-2">
				  	<a href="?act=add" class="btn btn-success btn-sm btn-block">
					  <i class="fas fa-plus mr-2"></i>เพิ่ม
					</a>
                  </div>
				  </div>
                </div>

                <!-- Table -->
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="data" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>รูป</th>
                            <th>รหัส</th>
                            <th>ชื่อ</th>
                            <th>ผ่าย/แผนก</th>
                            <th>อีเมล</th>
                            <th>ระดับ</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            @$getDep = $_GET['dep'];
                            $users = getFilterUser($getDep);
                            foreach($users as $key => $row):

                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td>
                              <img src="public/images/users/<?php echo $row['user_picture'] ? $row['user_picture'] : 'no_picture.jpg' ?>" alt="" class="picture-show img-fluid">
                            </td>
                            <td class="text-left"><?php echo $row['user_code'] ?></td>
                            <td class="text-left">
								<?php echo getUserFullname($row['user_code']) ?>(<?php echo getUserBranch($row['user_code']) ?>)
							</td>
                            <td class="text-left"><?php echo getDepartmentName($row['dep_id']) ?></td>
                            <td class="text-left"><?php echo $row['user_email'] ?></td>
                            <td><?php echo getUserLevelName($row['user_level']) ?>
								<?php echo ($row['user_approve'] == 1
                                ? getUserApproveName($row['user_approve'])
                                : '') 
                              	?>  
							</td>
                            <td>
                              <?php echo ($row['user_status'] == 1 
                                ? '<i class="fas fa-check text-success"></i>' 
                                : '<i class="fas fa-times-circle text-danger"></i>') 
                              ?>
                            </td>
                            <td>
                              <a href="?act=edit&id=<?php echo $row['user_code'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a class="btn btn-danger btn-sm" href="?act=delete&id=<?php echo $row['user_code'] ?>"
                                  onClick="return confirm('Are you sure?');">
                                  <i class="fas fa-trash-alt"></i>
                              </a>
                            </td>
                          </tr>
                          <?php 
                            endforeach;
                            unset($row); 
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php 
          endif; 

          /*

          Add Item

          */

          if($act == 'add'):
            include_once 'inc/alert.php';
        ?>
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="request.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item active">
              เพิ่มผู้ใช้งาน
            </li>
          </ol>
        </nav>

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
                      <a class="btn btn-danger btn-sm btn-block" href="users.php">
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
          endif;

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
              alertMsg('success','เพิ่มข้อมูลเรียบร้อยแล้วครับ','users.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','?act=add');
            }

            $stmt = null;
          endif;

          /*

          Edit Item 

          */

          if($act == 'edit'):
            include_once 'inc/alert.php';

            $user_code = @$_GET['id'];
            $stmt = getQueryUser($user_code);
            $row = $stmt->fetch();
        ?>
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item active">
              Edit User
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">Edit User</h5>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ID</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="user_id" 
                        value="<?php echo $row['user_id'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3">
                      <img src="public/images/users/<?php echo $row['user_picture'] ? $row['user_picture'] : 'no_picture.jpg' ?>" class="img-fluid">
                    </div>
                  </div>
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
                      <input type="text" class="form-control" name="user_code"
                        value="<?php echo $row['user_code'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อ - นามสกุล</label>
                    <div class="input-group col-sm-6">
                      <input type="text" class="form-control" name="user_name" 
                        value="<?php echo $row['user_name'] ?>" required>
                      <input type="text" class="form-control" name="user_surname" 
                        value="<?php echo $row['user_surname'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อเล่น</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_nickname" 
                        value="<?php echo $row['user_nickname'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ฝ่าย/แผนก</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="dep_id" required>
                        <option value="">--- เลือก ฝ่าย/แผนก ---</option>
                        <?php
                          $result = getDepartment();
                          foreach($result as $dep) :
                        ?>
                        <option value="<?php echo $dep['dep_id'] ?>" 
                          <?php if($dep['dep_id'] == $row['dep_id']) echo 'selected' ?>><?php echo $dep['dep_name'] ?></option>
                        <?php 
                          endforeach;
                        ?>
                      </select>
                    </div>
                  </div>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สาขา</label>
                    <div class="col-sm-4">
                      <select class="form-control" name="bra_id" required>
                        <option value="">--- เลือก สาขา ---</option>
                        <?php
                          $result = getBranch();
                          foreach($result as $bra) :
                        ?>
                        <option value="<?php echo $bra['bra_id'] ?>" 
                          <?php if($bra['bra_id'] == $row['bra_id']) echo 'selected' ?>><?php echo $bra['bra_name'] ?></option>
                        <?php 
                          endforeach;
                        ?>
                      </select>
                    </div>
                  </div>
					
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ชื่อผู้ใช้ระบบ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_username" 
                        value="<?php echo $row['user_username'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">อีเมล</label>
                    <div class="col-sm-4">
                      <input type="email" class="form-control" name="user_email" required
                        value="<?php echo $row['user_email'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เบอร์โทรศัพท์</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_telephone"
                        value="<?php echo $row['user_telephone'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">มือถือ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_mobile"
                        value="<?php echo $row['user_mobile'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Line ID</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="user_line" 
                        value="<?php echo $row['user_line'] ?>">
                    </div>
                  </div>
                  <?php if($user_level == 69) : ?>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ระดับ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control"
                        value="<?php echo getUserLevelName($row['user_level']) ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สถานะ</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control"
                        value="<?php echo ($row['user_status'] == 1 ? 'เปิดการใช้งาน' : 'ระงับการใช้งาน') ?>" readonly>
                    </div>
                  </div>
                  <?php 
                    endif; 
                    if($user_level == 99) :
                  ?>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ระดับ</label>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="user_level" value="99"
                          <?php if($row['user_level'] == '99') echo 'checked' ?>>ผู้ดูแลระบบ
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="user_level" value="69"
                          <?php if($row['user_level'] == '69') echo 'checked' ?>>ผู้ดำเนินการ
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="user_level" value="1"
                          <?php if($row['user_level'] == '1') echo 'checked' ?>>ผู้ใช้ระบบ
                      </label>
                    </div>
                  </div>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">จัดการอนุมัติ</label>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="user_approve" value="1"
                          <?php if($row['user_approve'] == '1') echo 'checked' ?>>ผู้อนุมัติ
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="user_approve" value="0"
                          <?php if($row['user_approve'] == '0') echo 'checked' ?>>ผู้ดำเนินการ
                      </label>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สถานะ</label>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="user_status" value="1"
                          <?php if($row['user_status'] == '1') echo 'checked' ?>><span class="text-success">เปิดการใช้งาน</span>
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="user_status" value="0"
                          <?php if($row['user_status'] == '0') echo 'checked' ?>><span class="text-danger">ระงับการใช้งาน</span>
                      </label>
                    </div>
                  </div>
                  <?php endif ?>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="users.php">
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

          /*

          Update Item 

          */

          if($act == 'update'):
            if(!isset($_POST['btnUpdate'])){
              header('location: index.php');
              die();
            }

            $user_id = $_POST['user_id'];
            $user_code = $_POST['user_code'];
            $user_name = $_POST['user_name'];
            $user_surname = $_POST['user_surname'];
            $user_picture = $_FILES['user_picture']['name'];
            $user_nickname = $_POST['user_nickname'];
            $dep_id = $_POST['dep_id'];
			$bra_id = $_POST['bra_id'];
            $user_email = $_POST['user_email'];
            $user_telephone = $_POST['user_telephone'];
            $user_mobile = $_POST['user_mobile'];
            $user_line = $_POST['user_line'];
            $user_level = $_POST['user_level'];
			$user_approve = $_POST['user_approve'];
            $user_status = $_POST['user_status'];

            $data_update_user = [$user_name,$user_surname,$user_nickname,$dep_id,$bra_id,$user_email,$user_telephone,$user_mobile,$user_line,$user_level,$user_approve,$user_status,$user_id];

            // Check Picture Extension
            if($user_picture){
              $picture_file_name  = $_FILES['user_picture']['name'];
              $picture_file_tmpname  = $_FILES['user_picture']['tmp_name'];
              $picture_ext = pathinfo($picture_file_name, PATHINFO_EXTENSION);
              $picture_file_new_name = $user_code.'.'.$picture_ext;
              $picture_file_path = "public/images/users/";
              $picture_allow_extension = array('jpg','jpeg','png');

              if(!in_array($picture_ext, $picture_allow_extension)):
                alertMsg('danger','กรุณาเลือกรูป JPG หรือ PNG เท่านั้นครับ','?act=edit&id='.$user_code.'');
              endif;
            }

            $sql = "UPDATE ex_user SET
              user_name = ?,
              user_surname = ?,
              user_nickname = ?,
              dep_id = ?,
			  bra_id = ?,
              user_email = ?,
              user_telephone = ?,
              user_mobile = ?,
              user_line = ?,
              user_level = ?,
			  user_approve = ?,
              user_status = ?
              WHERE user_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data_update_user);

            if($user_picture){
              $data_old_picture = [$user_id];
              $sql = "SELECT user_picture FROM ex_user WHERE user_id = ?";
              $stmt   = $dbcon->prepare($sql);
              $stmt->execute($data_old_picture);
              $check_picture_old  = $stmt->fetch();
              @unlink("public/images/users/".$check_picture_old['user_picture']);

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

              $data_update_picture = [$picture_file_new_name,$user_code];

              $sql = "UPDATE ex_user SET
                user_picture    = ?
                WHERE user_code = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_update_picture);
            }

            if($result){
              alertMsg('success','แก้ไขข้อมูลเรียบร้อยแล้วครับ','users.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ',"?act=edit&id={$user_code}");
            }

            $stmt = null;
          endif;

          /*

          Delete Item 

          */

          if($act == 'delete'):
            $user_code = @$_GET['id'];
            $user_status = 0;

            $data = [$user_status,$user_code];
            
            $sql = "UPDATE ex_user SET
              user_status = ?
              WHERE user_code = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result){
              alertMsg('success','ระงับการใช้งานเรียบร้อยแล้วครับ','users.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','users.php');
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