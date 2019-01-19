<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

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
  <link rel="stylesheet" href="node_modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="public/css/custom.css">
</head>
<body>
  <?php include_once 'inc/navbar.php' ?>

  <div class="container-fluid">
    <div class="row">
      <?php include_once 'inc/sidemenu.php' ?>
  
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

        <?php 
          /*

          Index

          */
          if($act == 'index'): 
            include_once 'inc/alert.php';
        ?>

        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item active">
              <i class="fas fa-home"></i>
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">จัดการอุปกรณ์</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="software.php" class="btn btn-primary btn-sm btn-block">
                      <i class="fas fa-clipboard-list mr-2"></i>จัดการโปรแกรม
                    </a>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="computers.php?dep="
                        <?php if(empty(@$_GET['dep'])) echo 'selected' ?>>--- ค้นหา แผนก/ฝ่าย ---</option>
                      <?php
                        $departments = getDepartment();
                        foreach($departments as $dep) : 
                      ?>
                      <option value="computers.php?dep=<?php echo $dep['dep_id'] ?>" <?php if(@$_GET['dep'] == $dep['dep_id']) echo 'selected' ?>><?php echo $dep['dep_name'] ?></option> 
                      <?php
                        endforeach;
                        unset($dep);
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="report_computer.php?dep=<?php echo @$_GET['dep'] ?>" target="_blank" 
                      class="btn btn-warning btn-sm btn-block">
                      <i class="fas fa-file-pdf mr-2"></i>รายงาน
                    </a>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="?act=add" class="btn btn-success btn-sm btn-block">
                      <i class="fas fa-plus mr-2"></i>เพิ่ม
                    </a>
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
                            <th>ชื่ออุปกรณ์</th>
							<th>ip</th>
                            <th>ผู้ใช้งาน</th>
                            <th>ฝ่าย/แผนก</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            @$getDep = $_GET['dep'];
                            $computers = getFilterComputer($getDep);
                            foreach($computers as $key => $row):

                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td class="text-left"><?php echo $row['hw_name'] ?></td>
							<td class="text-left"><?php echo $row['hw_ip'] ?></td>
                            <td><?php echo getUserFullname($row['user_code']) ?></td>
                            <td><?php echo getDepartmentName($row['dep_id']) ?></td>
                            <td>
                              <?php echo ($row['hw_status'] == 1 
                                ? '<i class="fas fa-check text-success"></i>' 
                                : '<i class="fas fa-times-circle text-danger"></i>') 
                              ?>
                            </td>
                            <td>
                              <a href="?act=edit&id=<?php echo $row['hw_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a class="btn btn-danger btn-sm" href="?act=delete&id=<?php echo $row['hw_id'] ?>"
                                  onClick="return confirm('Are you sure?');">
                                  <i class="fas fa-trash-alt"></i>
                              </a>
                            </td>
                          </tr>
                          <?php 
                            endforeach; 
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
              <a href="computers.php"><i class="fas fa-desktop"></i></a>
            </li>
            <li class="breadcrumb-item active">
              อุปกรณ์
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">เพิ่มอุปกรณ์</h5>
              </div>
              <div class="card-body">
                <form action="?act=insert" method="POST" enctype="multipart/form-data">
                  <div class="card mb-2">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group row justify-content-center">
                            <div class="col-sm-4">
                              <img src="" id="hw-image-tag" class="img-fluid">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">รูปอุปกรณ์</label>
                            <div class="col-sm-4">
                              <input type="file" class="form-control" name="hw_image" id="hw-image" accept="image/*">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">ชื่ออุปกรณ์</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="hw_name" required
                                <?php if(isset($_SESSION['hw_name'])) echo "value='{$_SESSION['hw_name']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">ผู้ใช้งาน</label>
                            <div class="col-sm-4">
                              <select id="user" class="form-control form-control-sm" name="user_code">
                                <option value="">--- กรุณาเลือก ---</option>
                                <?php
                                  $stmt = getUser();
                                  $result = $stmt->fetchAll();

                                  foreach($result as $user):
                                    $name = ucfirst($user['user_name']).' '.ucfirst($user['user_surname']);
                                    echo "<option value='{$user['user_code']}'>{$name}</option>";
                                  endforeach;
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">รหัสทรัพย์สิน/เลขที่สรรพกร</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="hw_asset" required
                                <?php if(isset($_SESSION['hw_asset'])) echo "value='{$_SESSION['hw_asset']}'" ?>>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">ยี่ห้อ</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_brand" required
                                <?php if(isset($_SESSION['hw_brand'])) echo "value='{$_SESSION['hw_brand']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">รุ่น</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_model" required
                                <?php if(isset($_SESSION['hw_model'])) echo "value='{$_SESSION['hw_model']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Serial Number</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_serial_number" required
                                <?php if(isset($_SESSION['hw_serial_number'])) echo "value='{$_SESSION['hw_serial_number']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Computer Name</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="hw_computer_name" required
                                <?php if(isset($_SESSION['hw_computer_name'])) echo "value='{$_SESSION['hw_computer_name']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Domain Name</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="hw_domain_name" required
                                <?php if(isset($_SESSION['hw_domain_name'])) echo "value='{$_SESSION['hw_domain_name']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">IP Address</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_ip" required
                                <?php if(isset($_SESSION['hw_ip'])) echo "value='{$_SESSION['hw_ip']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">MAC Address</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_mac" required
                               <?php if(isset($_SESSION['hw_mac'])) echo "value='{$_SESSION['hw_mac']}'" ?>>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">CPU</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_cpu" required
                                <?php if(isset($_SESSION['hw_cpu'])) echo "value='{$_SESSION['hw_cpu']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Mainboard</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_mainboard" required
                               <?php if(isset($_SESSION['hw_mainboard'])) echo "value='{$_SESSION['hw_mainboard']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">RAM 1</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_ram_1" required
                                <?php if(isset($_SESSION['hw_ram_1'])) echo "value='{$_SESSION['hw_ram_1']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">RAM 2</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_ram_2" required
                               <?php if(isset($_SESSION['hw_ram_2'])) echo "value='{$_SESSION['hw_ram_2']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Harddisk(HDD)</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_harddisk" required
                               <?php if(isset($_SESSION['hw_harddisk'])) echo "value='{$_SESSION['hw_harddisk']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Solid State(SSD)</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_ssd" required
                               <?php if(isset($_SESSION['hw_ssd'])) echo "value='{$_SESSION['hw_ssd']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Monitor</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_monitor" required
                               <?php if(isset($_SESSION['hw_monitor'])) echo "value='{$_SESSION['hw_monitor']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Keyboard</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_keyboard" required
                               <?php if(isset($_SESSION['hw_keyboard'])) echo "value='{$_SESSION['hw_keyboard']}'" ?>>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Mouse</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_mouse" required
                               <?php if(isset($_SESSION['hw_mouse'])) echo "value='{$_SESSION['hw_mouse']}'" ?>>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mb-2">
                    <div class="card-body">
                      <div class="form-group row justify-content-center">
                        <div class="col-sm-10">
                          <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="software">
                              <tr>
                                <td>#</td>
                                <td>โปรแกรม</td>
                                <td>รหัสโปรแกรม</td>
                              </tr>
                              <tr>
                                <td>
                                  <button type="button" class="btn btn-success btn-sm" id="new">+</button>
                                </td>
                                <td>
                                  <select class="form-control" name="sw_id[]" required>
                                    <option value="">--- กรุณาเลือก ---</option>
                                    <?php
                                      $stmt = getSoftware();
                                      $softwares = $stmt->fetchAll();

                                      foreach($softwares as $sw):
                                        echo "<option value='{$sw['sw_id']}'>{$sw['sw_name']}</option>";
                                      endforeach;
                                      unset($sw);
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="sw_key[]">
                                </td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-md-right">รายละเอียดเพิ่มเติม</label>
                        <div class="col-sm-8">
                          <textarea class="form-control" name="hw_text" rows="5"><?php if(isset($_SESSION['hw_text'])) echo "{$_SESSION['hw_text']}" ?></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="computers.php">
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

            $hw_name = $_POST['hw_name'];
            $user_code = $_POST['user_code'];
            $hw_asset = $_POST['hw_asset'];
            $hw_image = $_FILES['hw_image']['name'];
            $hw_brand = $_POST['hw_brand'];
            $hw_model = $_POST['hw_model'];
            $hw_serial_number = $_POST['hw_serial_number'];
            $hw_computer_name = $_POST['hw_computer_name'];
            $conv_computer_name = preg_replace('/\s+/', '_', $hw_computer_name);
            $hw_domain_name = $_POST['hw_domain_name'];
            $hw_ip = $_POST['hw_ip'];
            $hw_mac = $_POST['hw_mac'];
            $hw_cpu = $_POST['hw_cpu'];
            $hw_mainboard = $_POST['hw_mainboard'];
            $hw_ram_1 = $_POST['hw_ram_1'];
            $hw_ram_2 = $_POST['hw_ram_2'];
            $hw_harddisk = $_POST['hw_harddisk'];
            $hw_ssd = $_POST['hw_ssd'];
            $hw_monitor = $_POST['hw_monitor'];
            $hw_keyboard = $_POST['hw_keyboard'];
            $hw_mouse = $_POST['hw_mouse'];
            $hw_text = $_POST['hw_text'];
            $hw_create = date('Y-m-d H:i:s');

            // SESSION
            $_SESSION['hw_name'] = $_POST['hw_name'];
            $_SESSION['hw_asset'] = $_POST['hw_asset'];
            $_SESSION['hw_brand'] = $_POST['hw_brand'];
            $_SESSION['hw_model'] = $_POST['hw_model'];
            $_SESSION['emp_name'] = $_POST['emp_name'];
            $_SESSION['hw_serial_number'] = $_POST['hw_serial_number'];
            $_SESSION['hw_computer_name'] = $_POST['hw_computer_name'];
            $_SESSION['hw_domain_name'] = $_POST['hw_domain_name'];
            $_SESSION['hw_ip'] = $_POST['hw_ip'];
            $_SESSION['hw_mac'] = $_POST['hw_mac'];
            $_SESSION['hw_cpu'] = $_POST['hw_cpu'];
            $_SESSION['hw_mainboard'] = $_POST['hw_mainboard'];
            $_SESSION['hw_ram_1'] = $_POST['hw_ram_1'];
            $_SESSION['hw_ram_2'] = $_POST['hw_ram_2'];
            $_SESSION['hw_harddisk'] = $_POST['hw_harddisk'];
            $_SESSION['hw_ssd'] = $_POST['hw_ssd'];
            $_SESSION['hw_monitor'] = $_POST['hw_monitor'];
            $_SESSION['hw_keyboard'] = $_POST['hw_keyboard'];
            $_SESSION['hw_mouse'] = $_POST['hw_mouse'];
            $_SESSION['hw_text'] = $_POST['hw_text'];

            // Check Name Duplicate
            $data_check_hw_name = [$hw_name,$hw_computer_name];
            $sql = "SELECT hw_id FROM ex_hardware WHERE hw_name = ? OR hw_computer_name = ?";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_check_hw_name);
            $check_hw_name = $stmt->fetch();

            if($check_hw_name){
              alertMsg('danger','พบ Hardware Name หรือ Computer Name ซ้ำกับในระบบครับ','?act=add');
            }

            // Check IP or MAC Duplicate
            $data_check_hw_network = [$hw_ip,$hw_mac];
            $sql = "SELECT hw_id FROM ex_hardware WHERE hw_name = ? OR hw_computer_name = ?";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_check_hw_network);
            $check_hw_network = $stmt->fetch();

            if($check_hw_network){
              alertMsg('danger','พบ IP Address หรือ MAC Address ซ้ำกับในระบบครับ','?act=add');
            }

            // Check Picture Extension
            if($hw_image){
              $picture_file_name  = $_FILES['hw_image']['name'];
              $picture_file_tmpname  = $_FILES['hw_image']['tmp_name'];
              $picture_ext = pathinfo($picture_file_name, PATHINFO_EXTENSION);
              $picture_file_new_name = $conv_computer_name.'.'.$picture_ext;
              $picture_file_path = "public/images/hardwares/";
              $picture_allow_extension = array('jpg','jpeg','png');

              if(!in_array($picture_ext, $picture_allow_extension)):
                alertMsg('danger','กรุณาเลือกไฟล์รุป JPG หรือ PNG เท่านั้นครับ','?act=add');
              endif;
            }

            $data_hw = [$hw_name,$user_code,$hw_asset,$hw_brand,$hw_model,$hw_serial_number,$hw_computer_name,$hw_domain_name,$hw_ip,$hw_mac,$hw_cpu,$hw_mainboard,$hw_ram_1,$hw_ram_2,$hw_harddisk,$hw_ssd,$hw_monitor,$hw_keyboard,$hw_mouse,$hw_text,$hw_create];

            // Insert DB
            $sql = "INSERT INTO ex_hardware(hw_name,user_code,hw_asset,hw_brand,hw_model,hw_serial_number,hw_computer_name,hw_domain_name,hw_ip,hw_mac,hw_cpu,hw_mainboard,hw_ram_1,hw_ram_2,hw_harddisk,hw_ssd,hw_monitor,hw_keyboard,hw_mouse,hw_text,hw_create)
              VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data_hw);

            $last_id = $dbcon->lastInsertId();

            foreach($_POST['sw_id'] as $key => $value){
              $sw_id = $_POST['sw_id'][$key];
              $sw_key = ($_POST['sw_key'][$key] ? $_POST['sw_key'][$key] : '-');

              $data_sw = [$last_id,$sw_id,$sw_key,$hw_create];
              $sql = "INSERT INTO ex_hardware_detail(hw_id,sw_id,sw_key)
                VALUES(?,?,?)";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_sw);
            }

            // Update Picture
            if($hw_image):
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
                imagepng($pictureTarget,iconv('UTF-8','TIS-620',$picture_file_path.$picture_file_new_name));

              } else {

                $pictureResource = imagecreatefromjpeg($picture_file_tmpname);
                $pictureX = imagesx($pictureResource);
                $pictureY = imagesy($pictureResource);
                $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                imagejpeg($pictureTarget,iconv('UTF-8','TIS-620',$picture_file_path.$picture_file_new_name));

              }

              $data_picture = [$picture_file_new_name,$last_id];

              $sql = "UPDATE ex_hardware SET
                hw_image = ?
                WHERE hw_id = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_picture);

            endif;

            if($result){
              unset(
                $_SESSION['hw_name'],
                $_SESSION['hw_asset'],
                $_SESSION['hw_brand'],
                $_SESSION['hw_model'],
                $_SESSION['emp_name'],
                $_SESSION['hw_serial_number'],
                $_SESSION['hw_computer_name'],
                $_SESSION['hw_domain_name'],
                $_SESSION['hw_ip'],
                $_SESSION['hw_mac'],
                $_SESSION['hw_cpu'],
                $_SESSION['hw_mainboard'],
                $_SESSION['hw_ram_1'],
                $_SESSION['hw_ram_2'],
                $_SESSION['hw_harddisk'],
                $_SESSION['hw_ssd'],
                $_SESSION['hw_monitor'],
                $_SESSION['hw_keyboard'],
                $_SESSION['hw_mouse'],
                $_SESSION['hw_text']
              );
              alertMsg('success','เพิ่มข้อมูลเรียบร้อยแล้วครับ','computers.php');
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

            @$hw_id = $_GET['id'];
            $stmt = getQueryComputer($hw_id);
            $row = $stmt->fetch();
        ?>
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="computers.php"><i class="fas fa-desktop"></i></a>
            </li>
            <li class="breadcrumb-item active">
              แก้ไขข้อมูลอุปกรณ์
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">แก้ไขข้อมูลอุปกรณ์</h5>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST" enctype="multipart/form-data">
                  <div class="card mb-2">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group row justify-content-center">
                            <div class="col-sm-3">
                              <img src="public/images/hardwares/<?php echo $row['hw_image'] ? $row['hw_image'] : 'no_picture.jpg' ?>" class="img-fluid">
                            </div>
                          </div>
                          <div class="form-group row justify-content-center">
                            <div class="col-sm-4">
                              <img src="" id="hw-image-tag" class="img-fluid">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">รูปอุปกรณ์</label>
                            <div class="col-sm-4">
                              <input type="file" class="form-control" name="hw_image" id="hw-image" accept="image/*">
                            </div>
                          </div>
                          <div class="form-group row" style="display: none">
                            <label class="col-sm-4 col-form-label text-md-right">ลำดับอุปกรณ์</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="hw_id"
                                value="<?php echo $row['hw_id'] ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">ชื่ออุปกรณ์</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="hw_name" required
                                value="<?php echo $row['hw_name'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">ผู้ใช้งาน</label>
                            <div class="col-sm-4">
                              <select class="form-control form-control-sm" name="user_code">
                                <option value="">--- กรุณาเลือก ---</option>
                                <?php
                                  $stmt = getUser();
                                  $users = $stmt->fetchAll();

                                  foreach($users as $user):
                                    $name = ucfirst($user['user_name']).' '.ucfirst($user['user_surname']);
                                ?>
                                  <option value="<?php echo $user['user_code'] ?>" <?php if($user['user_code'] == $row['user_code']) echo 'selected' ?>><?php echo $name ?></option>";
                                <?php
                                  endforeach;
                                  unset($user);
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">รหัสทรัพย์สิน/เลขที่สรรพกร</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="hw_asset" required
                                value="<?php echo $row['hw_asset'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">ยี่ห้อ</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_brand" required
                                value="<?php echo $row['hw_brand'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">รุ่น</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_model" required
                                value="<?php echo $row['hw_model'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Serial Number</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_serial_number" required
                                value="<?php echo $row['hw_serial_number'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Computer Name</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="hw_computer_name" required
                                value="<?php echo $row['hw_computer_name'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Domain Name</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="hw_domain_name" required
                                value="<?php echo $row['hw_domain_name'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">IP Address</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_ip" required
                                value="<?php echo $row['hw_ip'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">MAC Address</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_mac" required
                               value="<?php echo $row['hw_mac'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">CPU</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_cpu" required
                                value="<?php echo $row['hw_cpu'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Mainboard</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_mainboard" required
                               value="<?php echo $row['hw_mainboard'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">RAM 1</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_ram_1" required
                                value="<?php echo $row['hw_ram_1'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">RAM 2</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_ram_2" required
                               value="<?php echo $row['hw_ram_2'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Harddisk(HDD)</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_harddisk" required
                               value="<?php echo $row['hw_harddisk'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Solid State(SSD)</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_ssd" required
                               value="<?php echo $row['hw_ssd'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Monitor</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_monitor" required
                               value="<?php echo $row['hw_monitor'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Keyboard</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_keyboard" required
                               value="<?php echo $row['hw_keyboard'] ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-md-right">Mouse</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" name="hw_mouse" required
                               value="<?php echo $row['hw_mouse'] ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mb-2">
                    <div class="card-body">
                      <div class="form-group row justify-content-center">
                        <div class="col-sm-10">
                          <div class="table-responsive">
                            <table class="table table-bordered table-sm" id="software">
                              <tr>
                                <td>#</td>
                                <td>โปรแกรม</td>
                                <td>รหัสโปรแกรม</td>
                                <td>จัดการ</td>
                              </tr>
                              <?php
                                $stmt = getQueryComputerDetail($row['hw_id']);
                                $details = $stmt->fetchAll();
                                foreach($details as $key => $detail):
                              ?>
                              <tr>
                                <td><?php echo $key+1 ?></td>
                                <td class="text-left"><?php echo getSoftwareName($detail['sw_id']) ?></td>
                                <td class="text-left"><?php echo $detail['sw_key'] ?></td>
                                <td>
                                  <a class="btn btn-danger btn-sm" href="?act=del_sw&id=<?php echo $detail['detail_id'] ?>&hw_id=<?php echo $row['hw_id'] ?>"
                                      onClick="return confirm('Are you sure?');">
                                      <i class="fas fa-trash-alt"></i>
                                  </a>
                                </td>
                              </tr>
                              <?php 
                                endforeach;
                                unset($detail); 
                              ?>
                              <tr>
                                <td>
                                  <button type="button" class="btn btn-success btn-sm" id="new">+</button>
                                </td>
                                <td>
                                  <select class="form-control" name="sw_id[]">
                                    <option value="">--- กรุณาเลือก ---</option>
                                    <?php
                                      $stmt = getSoftware();
                                      $softwares = $stmt->fetchAll();

                                      foreach($softwares as $sw):
                                        echo "<option value='{$sw['sw_id']}'>{$sw['sw_name']}</option>";
                                      endforeach;
                                      unset($sw);
                                    ?>
                                  </select>
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="sw_key[]">
                                </td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label text-md-right">รายละเอียดเพิ่มเติม</label>
                        <div class="col-sm-8">
                          <textarea class="form-control" name="hw_text" rows="5"><?php echo $row['hw_text'] ?></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-md-right">สถานะ</label>
                        <div class="form-check form-check-inline">
                          <label class="form-check-label mx-3">
                            <input class="form-check-input" type="radio" name="hw_status" value="1"
                              <?php if($row['hw_status'] == '1') echo 'checked' ?>><span class="text-success">เปิดการใช้งาน</span>
                          </label>
                          <label class="form-check-label mx-3">
                            <input class="form-check-input" type="radio" name="hw_status" value="0"
                              <?php if($row['hw_status'] == '0') echo 'checked' ?>><span class="text-danger">ปิดการใช้งาน</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate">
                        <i class="fa fa-check pr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="computers.php">
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

            $hw_id = $_POST['hw_id'];
            $hw_name = $_POST['hw_name'];
            $user_code = $_POST['user_code'];
            $hw_asset = $_POST['hw_asset'];
            $hw_image = $_FILES['hw_image']['name'];
            $hw_brand = $_POST['hw_brand'];
            $hw_model = $_POST['hw_model'];
            $hw_serial_number = $_POST['hw_serial_number'];
            $hw_computer_name = $_POST['hw_computer_name'];
            $conv_computer_name = preg_replace('/\s+/', '_', $hw_computer_name);
            $hw_domain_name = $_POST['hw_domain_name'];
            $hw_ip = $_POST['hw_ip'];
            $hw_mac = $_POST['hw_mac'];
            $hw_cpu = $_POST['hw_cpu'];
            $hw_mainboard = $_POST['hw_mainboard'];
            $hw_ram_1 = $_POST['hw_ram_1'];
            $hw_ram_2 = $_POST['hw_ram_2'];
            $hw_harddisk = $_POST['hw_harddisk'];
            $hw_ssd = $_POST['hw_ssd'];
            $hw_monitor = $_POST['hw_monitor'];
            $hw_keyboard = $_POST['hw_keyboard'];
            $hw_mouse = $_POST['hw_mouse'];
            $hw_text = $_POST['hw_text'];
            $hw_status = $_POST['hw_status'];

            $data_update_hw = [$hw_name,$user_code,$hw_asset,$hw_brand,$hw_model,$hw_serial_number,$hw_computer_name,$hw_domain_name,$hw_ip,$hw_mac,$hw_cpu,$hw_mainboard,$hw_ram_1,$hw_ram_2,$hw_harddisk,$hw_ssd,$hw_monitor,$hw_keyboard,$hw_mouse,$hw_text,$hw_status,$hw_id];

            // Check Picture Extension
            if($hw_image){
              $picture_file_name  = $_FILES['hw_image']['name'];
              $picture_file_tmpname  = $_FILES['hw_image']['tmp_name'];
              $picture_ext = pathinfo($picture_file_name, PATHINFO_EXTENSION);
              $picture_file_new_name = $conv_computer_name.'.'.$picture_ext;
              $picture_file_path = "public/images/hardwares/";
              $picture_allow_extension = array('jpg','jpeg','png');

              if(!in_array($picture_ext, $picture_allow_extension)):
                alertMsg('danger','กรุณาเลือกรูป JPG หรือ PNG เท่านั้นครับ','?act=edit&id='.$hw_id.'');
              endif;
            }

            $sql = "UPDATE ex_hardware SET
              hw_name = ?,
              user_code = ?,
              hw_asset = ?,
              hw_brand = ?,
              hw_model = ?,
              hw_serial_number = ?,
              hw_computer_name = ?,
              hw_domain_name = ?,
              hw_ip = ?,
              hw_mac = ?,
              hw_cpu = ?,
              hw_mainboard = ?,
              hw_ram_1 = ?,
              hw_ram_2 = ?,
              hw_harddisk = ?,
              hw_ssd = ?,
              hw_monitor = ?,
              hw_keyboard = ?,
              hw_mouse = ?,
              hw_text = ?,
              hw_status = ?
              WHERE hw_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data_update_hw);

            // Check Empty Array
            $check_array = array_filter($_POST['sw_id']);

            if($check_array){
              foreach($_POST['sw_id'] as $key => $value){
                $sw_id = $_POST['sw_id'][$key];
                $sw_key = ($_POST['sw_key'][$key] ? $_POST['sw_key'][$key] : '-');

                // Check Name Duplicate
                $data_check_sw = [$hw_id,$sw_id];
                $sql = "SELECT detail_id FROM ex_hardware_detail WHERE hw_id = ? AND sw_id = ?";
                $stmt = $dbcon->prepare($sql);
                $stmt->execute($data_check_sw);
                $check_sw = $stmt->fetch();

                if($check_sw){
                  alertMsg('danger','มีโปรแกรมนี้แล้วครับ',"?act=edit&id={$hw_id}");
                }

                $data_sw = [$hw_id,$sw_id,$sw_key];
                $sql = "INSERT INTO ex_hardware_detail(hw_id,sw_id,sw_key)
                  VALUES(?,?,?)";
                $stmt = $dbcon->prepare($sql);
                $stmt->execute($data_sw);
              }
            }

            if($hw_image){
              $data_old_picture = [$hw_id];
              $sql = "SELECT hw_image FROM ex_hardware WHERE hw_id = ?";
              $stmt   = $dbcon->prepare($sql);
              $stmt->execute($data_old_picture);
              $check_picture_old  = $stmt->fetch();
              @unlink("public/images/hardwares/".iconv('UTF-8','TIS-620',$check_picture_old['hw_image']));

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
                imagepng($pictureTarget,iconv('UTF-8','TIS-620',$picture_file_path.$picture_file_new_name));

              } else {

                $pictureResource = imagecreatefromjpeg($picture_file_tmpname);
                $pictureX = imagesx($pictureResource);
                $pictureY = imagesy($pictureResource);
                $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                imagejpeg($pictureTarget,iconv('UTF-8','TIS-620',$picture_file_path.$picture_file_new_name));

              }

              $data_update_picture = [$picture_file_new_name,$hw_id];

              $sql = "UPDATE ex_hardware SET
                hw_image    = ?
                WHERE hw_id = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_update_picture);
            }

            if($result){
              alertMsg('success','แก้ไขข้อมูลเรียบร้อยแล้วครับ',"?act=edit&id={$hw_id}");
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ',"?act=edit&id={$hw_id}");
            }

            $stmt = null;
          endif;

          /*

          Delete Item 

          */

          if($act == 'delete'):
            @$hw_id = $_GET['id'];
            $hw_status = 0;

            $data = [$hw_status,$hw_id];
            
            $sql = "UPDATE ex_hardware SET
              hw_status = ?
              WHERE hw_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result){
              alertMsg('success','ปิดการใช้งานเรียบร้อยแล้วครับ','computers.php');
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','users.php');
            }

            $stmt = null;
          endif;

          /*

          Delete Software Item 

          */

          if($act == 'del_sw'):
            @$detail_id = $_GET['id'];
            @$hw_id = $_GET['hw_id'];

            $data = [$detail_id];
            $sql = "DELETE FROM ex_hardware_detail WHERE detail_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);
            if($result){
              alertMsg('success','ลบโปรแกรมเรียบร้อยแล้วครับ',"?act=edit&id={$hw_id}");
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ',"?act=edit&id={$hw_id}");
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
  <script src="node_modules/select2/dist/js/select2.min.js"></script>
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

    $(document).ready(function() {
      $('#user').select2();
    });

    function pictureShow(input) {
      if (input.files && input.files[0]){
          var reader = new FileReader();
          reader.onload = function(e){
              $('#hw-image-tag').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
    }
    $("#hw-image").change(function(){
      pictureShow(this);
    });

    $(document).ready(function(){
      var i = 1;
      $('#new').click(function(){
        i = i + 1;
        var html = "<tr id='row"+i+"'>";
          html += "<td><button type='button' name='remove' data-row='row"+i+"' class='btn btn-danger btn-sm remove'>-</button></td>";
          html += "<td><select class='form-control' name='sw_id[]' required><option value=''>--- กรุณาเลือก ---</option><?php 
            $stmt = getSoftware();
            $result = $stmt->fetchAll();
            foreach($result as $row):
              echo "<option value='{$row['sw_id']}'>{$row['sw_name']}</option>";
            endforeach; ?></select></td>";
          html += "<td><input type='text' class='form-control' name='sw_key[]'></td>";
          html += "</tr>";  
          $('#software').append(html);
      });

      $(document).on('click', '.remove', function(){
        var deleteRow = $(this).data("row");
          $('#' + deleteRow).remove();
      });
    });
  </script>
</body>
</html>