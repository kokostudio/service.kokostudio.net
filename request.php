<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
  include_once 'config/connection.php';
  include_once 'config/function.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  if(!isset($_SESSION['user_code'])){
    header('location: index.html');
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
  <title><?php echo getCompany();?></title>
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-pro/css/all.min.css">
  <link rel="stylesheet" href="node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="public/css/custom.css">
	
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
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
                <h5 class="text-center">ขอใช้บริการ</h5>
              </div>
              <div class="card-body">
                <!-- Button -->
                <?php
                  $check_level = getUserLevel($_SESSION['user_code']);

                  if($check_level == 69 || $check_level == 99):
                ?>
                <div class="row">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="category.php" class="btn btn-primary btn-sm btn-block">
                      <i class="fas fa-list mr-2"></i>หมวดหมู่
                    </a>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="service.php" class="btn btn-danger btn-sm btn-block">
                      <i class="fas fa-chart-bar mr-2"></i>บริการ
                    </a>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="status.php" class="btn btn-info btn-sm btn-block">
                      <i class="fas fa-question mr-2"></i>สถานะ
                    </a>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="manage.php" class="btn btn-warning btn-sm btn-block">
                      <i class="fas fa-file-alt mr-2"></i>จัดการ
                    </a>
                  </div>
                </div>
                <?php endif ?>

                <div class="row">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="request.php?cat=&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['cat'])) echo 'selected' ?>>--- ค้นหา หมวดหมู่ ---</option>
                      <?php
                        $categorys = getSelectCategory();
                        foreach($categorys as $cat) : 
                      ?>
                      <option value="request.php?cat=<?php echo $cat['cat_id'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['cat'] == $cat['cat_id']) echo 'selected' ?>><?php echo $cat['cat_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="request.php?cat=<?php echo @$_GET['cat'] ?>&serv=&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['serv'])) echo 'selected' ?>>--- ค้นหา บริการ ---</option>
                      <?php
                        $services = getService();
                        foreach($services as $serv) : 
                      ?>
                      <option value="request.php?cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo $serv['service_id'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['serv'] == $serv['service_id']) echo 'selected' ?>><?php echo $serv['service_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="request.php?cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat="
                        <?php if(empty(@$_GET['stat'])) echo 'selected' ?>>--- ค้นหา สถานะ ---</option>
                      <?php
                        $statuses = getStatus();
                        foreach($statuses as $status) : 
                      ?>
                      <option value="request.php?cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo $status['status_id'] ?>" <?php if(@@$_GET['stat'] == $status['status_id']) echo 'selected' ?>><?php echo $status['status_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="?act=add" class="btn btn-success btn-sm btn-block">
                      <i class="fas fa-plus mr-2"></i>ขอใช้บริการ
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
                            <th>เลขที่บริการ</th>
                            <th>ผู้ขอใช้บริการ</th>
                            <th>รายละเอียด/ผู้รับดำเนินการ</th>
                            <th>หมวดหมู่</th>
                            <th>วันที่แจ้ง/ผู้รับเรื่อง</th>
							<th>วันที่เสร็จ</th>
                            <th>สถานะ</th>
                            <th>รายละเอียด</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            @$getCat = $_GET['cat'];
                            @$getServ = $_GET['serv'];
                            @$getStat = $_GET['stat'];
                            @$getUser = $_SESSION['user_code'];
                            @$requests = getFilterRequest($getYear,$getMonth,$getCat,$getServ,$getStat,$getUser);
                            //getFilterRequestUser($getYear,$getMonth,$getCat,$getServ,$getStat,$getUser);
                            foreach($requests as $key => $req):
							 $date_end = getDateEnd($req['req_id']);
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td>
								<?php echo $req['req_gen'] ?><br>
								
								<?php if($req['req_status']==4){ 
										if($req['req_rating']<1){
											echo '<button class="btn btn-warning btn-sm " data-toggle="modal" data-target="#addRating'.$req['req_id'].'">รอประเมิน</button>';
										}else{
											echo colorRating($req['req_rating']);
										}
									}
								?>
<!-- Modal Add Rating -->
        <div class="modal fade" id="addRating<?php echo $req['req_id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">ให้คะแนน</h5>
              </div>
              <?php
                @$req_id = $req['req_id'];
                $stmt = getQueryRequest($req_id);
                $row = $stmt->fetch();
              ?>
              <div class="modal-body">
                <form action="?act=update" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ลำดับบริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="req_id" readonly
                        value="<?php echo $req['req_id'] ?>">
                    </div>
                  </div>
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้ใช้บริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="req_user" readonly
                        value="<?php echo $row['req_user'] ?>">
                    </div>
                  </div>
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสบริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="req_gen" readonly
                        value="<?php echo $row['req_gen'] ?>">
                    </div>
                  </div>
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสบริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="req_text" readonly
                        value="<?php echo $row['req_text'] ?>">
                    </div>
                  </div>
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสบริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="service_id" readonly
                        value="<?php echo $row['service_id'] ?>">
                    </div>
                  </div>
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รายละเอียด</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="user_code" readonly
                        value="<?php echo $_SESSION['user_code'] ?>">
                    </div>
                  </div>
				  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสแผนก</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="user_dep_code" readonly
                        value="<?php echo $row['req_dep'] ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เลขที่บริการ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="req_gen" readonly
                        value="<?php echo $row['req_gen'] ?>">
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-1">

<style>
	
.selected{
    box-shadow:0px 12px 22px 1px #333;
	
}
</style>	
					</div>
                    <div class="col-sm-2">
					   <img src="public\images\r1.png" style="width: 100%" value="1" id="img_rating" onclick="choose(this);"><br>
					</div>
					<div class="col-sm-2">
						 <img src="public\images\r2.png" style="width: 100%" value="2" id="img_rating" onclick="choose(this);"><br>
					</div>
					<div class="col-sm-2">
						 <img src="public\images\r3.png" style="width: 100%" value="3" id="img_rating" onclick="choose(this);"><br>
					</div>
					<div class="col-sm-2">
						 <img src="public\images\r4.png" style="width: 100%" value="4" id="img_rating" onclick="choose(this);"><br>
					</div>
					<div class="col-sm-2">
						 <img src="public\images\r5.png" style="width: 100%" value="5" id="img_rating" onclick="choose(this);"><br>
                    </div>
					<div class="col-sm-1">
					   
					</div>
                  </div>
					<input type="hidden" id="req_rate" name="req_rate" value="">
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-5 mb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate">
                        <i class="fa fa-check mr-2"></i>ยืนยัน
                      </button>
                    </div>
                    <div class="col-sm-5 mb-2">
                      <button class="btn btn-danger btn-sm btn-block" type="button" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>ยกเลิก
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
								
							</td>
                            <td class="text-left"><?php echo $req['req_user_process'] ?>(<small><?php echo getUserBranch($req['req_user']) ?>)<br>
<?php echo getDepartmentName($req['req_dep']) ?></small></td>
                            <td class="text-left"><?php echo $req['req_text'] ?><br><small class="text-primary"><?php echo getUserFullName($req['req_operator']) ?></small></td>
                            <td><?php echo $req['cat_name'] ?></td>
                            <td><?php echo convertDate($req['req_create']) ?><br><small class="text-primary"><?php echo getUserFullName($req['req_user']) ?></small></td>
							<td><?php echo (($req['req_status']==4) ? convertDate($date_end).' '.date('H:i',strtotime($req['req_create'])).' น.<br>ดำเนินการ '.datediff($req['req_create'],$date_end).' วัน' : '-') ?>
							</td>
                            <td class="<?php echo colorStatus($req['req_status']) ?>">
                              <button class="<?php echo buttonStatus($req['req_status']) ?>"><?php echo getStatusName($req['req_status']) ?></button>
                            </td>
                            <td>
                              <?php if($check_level == 69 || $check_level == 99){ ?>
                              <a href="request_view.php?id=<?php echo $req['req_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-file-alt"></i>
                              </a>
                              
                              <?php }else{ ?>
                              <button class="btn btn-info btn-sm" disabled>
                                <i class="fas fa-file-alt"></i>
                              </button>
                              <?php } ?>
                            </td>
                          </tr>
                          <?php 
                            endforeach; 
                            unset($req);
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
            <li class="breadcrumb-item active">
              ขอใช้บริการ
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">ขอใช้บริการ</h5>
              </div>
              <div class="card-body">
                <form action="?act=insert" method="POST" enctype="multipart/form-data">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">รหัสผู้ใช้บริการ</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="req_user" readonly
                        value="<?php echo $_SESSION['user_code'] ?>">
                    </div>
                  </div>
				  <div class="form-group row" style="display: none">
					<label class="col-sm-4 col-form-label text-md-right">ผู้ขอใช้บริการ</label>
					<div class="col-sm-4">
					  <select id="user" class="form-control form-control-sm" name="user_code_useปปปป">
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
					<label class="col-sm-4 col-form-label text-md-right">แผนกรับริการ</label>
					<div class="col-sm-4">
					  <select id="user" class="form-control form-control-sm" name="user_dep_use">
						<option value="">--- กรุณาเลือก ---</option>
						<?php
						  $stmt = getDep();
						  $result = $stmt->fetchAll();

						  foreach($result as $dep_use):
							$dep_name = ucfirst($dep_use['dep_name']);
							echo "<option value='{$dep_use['dep_id']}'>{$dep_name}</option>";
						  endforeach;
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
                    <label class="col-sm-4 col-form-label text-md-right">ผู้ขอใช้บริการ</label>
					<div class="col-sm-4">
                      <input type="text" class="form-control" name="user_code_use"
                        value="">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">หมวดหมู่</label>
                    <div class="col-sm-3">
                      <select class="form-control form-control-sm" name="cat_id" 
                        onChange="getServiceList(this.value);" required>
                        <option value="">--- เลือก หมวดหมู่ ---</option>
                        <?php
                          $result = getCategory();
                          foreach($result as $cat) : 
                        ?>
                        <option value="<?php echo $cat['cat_id'] ?>"><?php echo $cat['cat_name'] ?></option>
                        <?php
                          endforeach;
                          unset($cat);
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">บริการ</label>
                    <div class="col-sm-6">
                      <select class="form-control form-control-sm" name="service_id" id="service_list"
                        onChange="getBranch(this.value);" required>
                        <option value="">--- กรุณาเลือก บริการ ---</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">เพิ่มเอกสารหรือรูปประกอบ</label>
                    <div class="col-sm-4">
                      <input type="file" class="form-control" name="req_file">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">รายละเอียดเพิ่มเติม</label>
                    <div class="col-sm-6">
                      <textarea name="req_text" class="form-control" rows="5" required></textarea>
                    </div>
                  </div>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้รับดำเนินการ</label>
                    <div class="col-sm-4">
						<select id="user_operator" class="form-control form-control-sm" name="user_operator">
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
				  <hr>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">ผู้รับเรื่อง</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" readonly
                        value="<?php echo getUserFullname($_SESSION['user_code']); ?>">
                    </div>
					  
                  </div>
				  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">สาขา</label>
					<div class="col-sm-4">
                      <input type="text" class="form-control" readonly name="req_branch"
                        value="<?php echo getUserBranch($_SESSION['user_code']); ?>">
                    </div>
                  </div>
				  <div class="form-group row">
					<label class="col-sm-4 col-form-label text-md-right">แผนก</label>
					<div class="col-sm-4">
                      <input type="text" class="form-control" readonly
                        value="<?php echo getUserDepName($_SESSION['user_code']) ?>">
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
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
          endif;

          /*

          Update Item

          */
		  if($act == 'update'):
            if(!isset($_POST['btnUpdate'])){
              header('Location: index.php');
              die();
            }

            echo $req_id = $_POST['req_id'];
			echo $req_rating = $_POST['req_rate'];
            //$req_user = $_POST['req_user'];
            //$req_gen = $_POST['req_gen'];
            //$service_id = $_POST['service_id'];
            //$req_file = $_FILES['req_file']['name'];
            //$req_text = $_POST['req_text'];

            $data = [$req_rating,$req_id];

            $sql = "UPDATE ex_request SET
              req_rating = ?
              WHERE req_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','แก้ไขข้อมูลเรียบร้อยแล้วครับ',"?id={$req_id}");
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ',"?id={$req_id}");
            }

            $stmt = null;
          endif;				 
		   /*

          Insert Item

          */				 
          if($act == 'insert'):
            if(!isset($_POST['btnInsert'])){
              header('Location: index.php');
              die();
            }

            $req_user = $_POST['req_user'];
		    $req_user_process = $_POST['user_code_use'];
			$req_user_operator = $_POST['user_operator'];				 
			$req_branch = $_POST['req_branch'];
		    $req_dep = $_POST['user_dep_use'];
			$bra_id = $_POST['bra_id'];
            $service_id = $_POST['service_id'];
            $service_name = getServiceName($service_id);
            $req_file = $_FILES['req_file']['name'];
            $req_text = $_POST['req_text'];
            $req_create = date('Y-m-d H:i:s');
            $req_year = date('Y');

            $data_check_last = [$req_year];
            $sql = "SELECT req_last FROM ex_request
            WHERE req_year = ?
            ORDER BY req_last DESC 
            LIMIT 1";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute($data_check_last);
            $check_gen = $stmt->fetch();
            
            $req_last = STR_PAD(($check_gen['req_last']+1), 5, "0", STR_PAD_LEFT);
            $req_gen  = $req_year.$req_last;

            $data = [$req_year,$req_last,$req_gen,$req_user,$req_branch,$req_user_process,$req_user_operator,$req_dep,$bra_id,$service_id,$req_text,$req_create];

            // Check Service
            if(empty($service_id)){
              alertMsg('danger','กรุณาเลือกบริการด้วยครับ','?act=add');
            }

            // Check Extension
            if($req_file){
              $file_name  = $_FILES['req_file']['name'];
              $file_tmpname  = $_FILES['req_file']['tmp_name'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $file_new_name = $req_gen.'.'.$ext;
              $path_file = "public/request/";
              $allow_extension = array('jpg','jpeg','png','xls','xlsx','doc','docx','pdf');

              if(!in_array($ext, $allow_extension)):
                alertMsg('danger','กรุณาเลือกเฉพาะไฟล์รูป JPG PNG หรือไฟล์เอกสาร Excel Word PDF เท่านั้นครับ','?act=add');
              endif;
            }

            $sql = "INSERT INTO ex_request(req_year,req_last,req_gen,req_user,req_branch,req_user_process,req_operator,req_dep,bra_id,service_id,req_text,req_create)
              VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            $last_id = $dbcon->lastInsertId();
            $_SESSION["last_id"] = $last_id;

            // Update Picture
            if($req_file):
              if($ext == 'xls' || $ext == 'xlsx' || $ext == 'doc' || $ext == 'docx' || $ext == 'pdf'){
                @move_uploaded_file($file_tmpname, iconv('UTF-8','TIS-620', $path_file.$file_new_name));
              }

              if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png'){
                @$pictureSize   = getimagesize($file_tmpname);
                $pictureWidth   = 1000;
                @$pictureHeight = round($pictureWidth*$pictureSize[1]/$pictureSize[0]);
                $pictureType    = $pictureSize[2];

                if($pictureType == IMAGETYPE_PNG){

                  $pictureResource = imagecreatefrompng($file_tmpname);
                  $pictureX = imagesx($pictureResource);
                  $pictureY = imagesy($pictureResource);
                  $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                  imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                  imagepng($pictureTarget, iconv('UTF-8','TIS-620',$path_file.$file_new_name));

                } else {

                  $pictureResource = imagecreatefromjpeg($file_tmpname);
                  $pictureX = imagesx($pictureResource);
                  $pictureY = imagesy($pictureResource);
                  $pictureTarget = imagecreatetruecolor($pictureWidth, $pictureHeight);
                  imagecopyresampled($pictureTarget, $pictureResource, 0, 0, 0, 0, $pictureWidth, $pictureHeight, $pictureX, $pictureY);
                  imagejpeg($pictureTarget, iconv('UTF-8','TIS-620',$path_file.$file_new_name));

                }
              }
                
              $data_picture = [$file_new_name,$last_id];

              $sql = "UPDATE ex_request SET
                req_file = ?
                WHERE req_id = ?";
              $stmt = $dbcon->prepare($sql);
              $stmt->execute($data_picture);

            endif;

            if($result){
              $stmt = getSystem();
              $row = $stmt->fetch();

              $email = "{$row['email']}";
              $user_gmail = "{$row['gmail_username']}";
              $pass_gmail = "{$row['gmail_password']}";
              $email_send = "{$row['gmail_username']}";
              $name_send  = "{$row['gmail_name']}";
              $mail_option = "{$row['mail_option']}";
              $email_receive = getUserEmail($req_user);
              $name_receive = getUserFullname($req_user);
		      $branch_receive = getUserBranch($req_user);
			  $branch_token = getUserBranchLineToken($req_user);
			  $dep_receive = getUserDepName($req_user);
			  $name_user_process = getUserFullname($req_user_process);
			  $name_user_operator = getUserFullname($req_user_operator);
			  $name_user_branch = getUserBranch($req_user_process);
			  $name_user_dep = getDepartmentName($req_dep);
              $date_send = date('d/m/Y');
              $time_send = date('H:i');
				
			  $line_token = "{$branch_token}";

              // Load Composer's autoloader
              require 'vendor/autoload.php';
                
              try {
                
                  if($mail_option=='0'){ 
                      
                    $actual_link = "http://{$_SERVER['HTTP_HOST']}";
                    
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
                    $mail->Subject = "ระบบแจ้งขอใช้บริการ";
                    $mail->Body  = "เรียน คุณ {$name_receive} <br><br>";
                    $mail->Body .= "ระบบได้รับเรื่องการแจ้งขอใช้บริการเรียบร้อยแล้วครับ<br><br>";
                    $mail->Body .= "ขอใช้บริการ<br>";
                    $mail->Body .= "บริการ : {$service_name}<br>";
                    $mail->Body .= "รายละเอียด : {$req_text}<br>";
                    $mail->Body .= "ลิ้ง : {$actual_link}/view.php?id={$_SESSION["last_id"]}<br>";
                    $mail->Body .= "วันที่ : {$date_send}<br>";
                    $mail->Body .= "เวลา : {$time_send} น.<br>";
                    $mail->send();
                      
                              
                }
                  
                if($mail_option=='1'){
                    $to      = "{$email_receive}";
                    $subject = "ระบบแจ้งขอใช้บริการ";
                    $message = "
                        เรียน คุณ {$name_receive} <br><br>
                        ระบบได้รับเรื่องการแจ้งขอใช้บริการเรียบร้อยแล้วครับ<br><br>
                        ขอใช้บริการ<br>
                        บริการ : {$service_name}<br>
                        รายละเอียด : {$req_text}<br>
                        วันที่ : {$date_send}<br>
                        เวลา : {$time_send} น.<br>
                    ";

                    // HTML mail
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                    $headers .= "From: {$email}"."\r\n" .
                        "Reply-To: {$email}"."\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                    mail($to, $subject, $message, $headers);    
                }

$line_text = "
---------------------
แจ้งเตือนการขอใช้บริการ
---------------------
จากแผนก {$name_user_dep}
สาขา {$branch_receive}
---------------------
ขอใช้บริการ
---------------------
เลขที่บริการ : {$req_gen}
บริการ : {$service_name}
รายละเอียด : {$req_text}
ลิ้ง : {$actual_link}/view.php?id={$_SESSION["last_id"]}
วันที่ : {$date_send}
เวลา : {$time_send} น.
ผู้รับดำเนินการ : {$name_user_operator}
---------------------
ผู้รับเรื่อง {$name_receive}
---------------------
";
				  
                //echo $line_text;
                //echo $line_token;
                echo lineNotify($line_text,$line_token);

                alertMsg('success','แจ้งขอใช้บริการเรียบร้อยแล้วครับ','request.php');

              } catch (Exception $e) {
                alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','request.php');
              }
              
            } else {
              alertMsg('danger','ระบบมีปัญหา, กรุณาลองใหม่อีกครั้งครับ','request.php');
            }

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
        "pageLength": 25,
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

    function getServiceList(val) {
      $.ajax({
        type: "POST",
        url: "getService.php",
        data:'cat_id='+val,
        success: function(data){
          $("#service_list").html(data);
        }
      });
    }
  </script>
	
<script>						
$('img').click(function(){
    $('.selected').removeClass('selected');
    $(this).addClass('selected');
});		
	function choose(element){
    document.getElementById('req_rate').value = element.getAttribute('value');
}    

</script>	
</body>
</html>