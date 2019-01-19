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

  /*$user_level = getUserLevel($_SESSION['user_code']);
  if(!isset($_SESSION['user_code']) || ($user_level == 1 || empty($user_level))){
    alertMsg('danger','ไม่พบหน้านี้ในระบบ','request.php');
  }*/
  if(!isset($_SESSION['user_code'])){
    header('location: 404.html');
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
            <li class="breadcrumb-item">
              <a href="request.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active">
              จัดการอนุมัติ
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">รายการที่ต้องอนุมัติ</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="approve.php?year=&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['year'])) echo 'selected' ?>>--- ค้นหา ปี ---</option>
                      <?php
                        $years = getYear();
                        foreach($years as $year) : 
                      ?>
                      <option value="approve.php?year=<?php echo $year ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['year'] == $year) echo 'selected' ?>><?php echo $year ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="approve.php?year=<?php echo @$_GET['year'] ?>&month=&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['month'])) echo 'selected' ?>>--- ค้นหา เดือน ---</option>
                      <?php
                        $months = getMonth();
                        foreach($months as $key => $month) : 
                      ?>
                      <option value="approve.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo $key ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['month'] == $key) echo 'selected' ?>><?php echo $month ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="approve.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['cat'])) echo 'selected' ?>>--- ค้นหา หมวดหมู่ ---</option>
                      <?php
                        $categorys = getCategory();
                        foreach($categorys as $cat) : 
                      ?>
                      <option value="approve.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo $cat['cat_id'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['cat'] == $cat['cat_id']) echo 'selected' ?>><?php echo $cat['cat_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="approve.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=&stat=<?php echo @$_GET['stat'] ?>"
                        <?php if(empty(@$_GET['serv'])) echo 'selected' ?>>--- ค้นหา บริการ ---</option>
                      <?php
                        $services = getService();
                        foreach($services as $serv) : 
                      ?>
                      <option value="approve.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo $serv['service_id'] ?>&stat=<?php echo @$_GET['stat'] ?>" <?php if(@@$_GET['serv'] == $serv['service_id']) echo 'selected' ?>><?php echo $serv['service_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="approve.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat="
                        <?php if(empty(@$_GET['stat'])) echo 'selected' ?>>--- ค้นหา สถานะ ---</option>
                      <?php
                        $statuses = getStatus();
                        foreach($statuses as $status) : 
                      ?>
                      <option value="approve.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo $status['status_id'] ?>" <?php if(@@$_GET['stat'] == $status['status_id']) echo 'selected' ?>><?php echo $status['status_name'] ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="report_request.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" target="_blank" 
                      class="btn btn-danger btn-sm btn-block">
                      <i class="fas fa-file-pdf mr-2"></i>รายงาน PDF
                    </a>
                  </div>
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="report_excel.php?year=<?php echo @$_GET['year'] ?>&month=<?php echo @$_GET['month'] ?>&cat=<?php echo @$_GET['cat'] ?>&serv=<?php echo @$_GET['serv'] ?>&stat=<?php echo @$_GET['stat'] ?>" target="_blank" 
                      class="btn btn-success btn-sm btn-block">
                      <i class="fas fa-file-excel mr-2"></i>รายงาน Excel
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
                            <th>รายละเอียด</th>
                            <th>วันที่แจ้ง/ผู้รับเรื่อง</th>
                            <th>วันที่เสร็จ</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            @$getYear = $_GET['year'];
                            @$getMonth = $_GET['month'];
                            @$getCat = $_GET['cat'];
                            @$getServ = $_GET['serv'];
                            @$getStat = $_GET['stat'];
					   		//@$getUser = $_SESSION['user_code'];
					        @$getUserDep = getUserApproveDep($_SESSION['user_code']);
							@$getUserBra = getUserApproveBra($_SESSION['user_code']);
                            @$requests = getFilterApprove($getYear,$getMonth,$getCat,$getServ,$getStat,$getUser,$getUserDep,$getUserBra);
                            foreach($requests as $key => $req):
                              $todate = strtotime(date('Y-m-d'));
                              $date_end = getDateEnd($req['req_id']);
                              $conv_date_end = strtotime(getDateEnd($req['req_id']));
                              $check_expire = $todate - $conv_date_end;
                          ?>
                          <tr <?php if($check_expire >= 0 && ($req['req_status'] == 2 || $req['req_status'] == 3)) echo "class='table-danger'" ?>>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo $req['req_gen'] ?></td>
                            <td class="text-left"><?php echo $req['req_user_process'] ?>(<small><?php echo getUserBranch($req['req_user']) ?>)<br>
<?php echo getDepartmentName($req['req_dep']) ?></small></td>
                            <td class="text-left"><?php echo $req['req_text'] ?></td>
                            <td><?php echo convertDate($req['req_create']) ?><br><small class="text-primary"><?php echo getUserFullName($req['req_user']) ?></small></td>
                            <td><?php echo ($date_end ? convertDate($date_end) : '-') ?></td>
                            <td class="<?php echo colorStatus($req['req_status']) ?>">
                              <button class="<?php echo buttonStatus($req['req_status']) ?>"><?php echo getStatusName($req['req_status']) ?></button>
                            </td>
                            <td>
                              <a href="request_approve.php?id=<?php echo $req['req_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-file-alt"></i>
                              </a>
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
        <?php endif; ?>
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
</body>
</html>