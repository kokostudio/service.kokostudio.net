<?php
  ob_start();
  session_start();
  date_default_timezone_set("Asia/Bangkok");
  include_once 'config/connection.php';
  include_once 'config/function.php';

  $user_level = getUserLevel($_SESSION['user_code']);
  if(!isset($_SESSION['user_code']) || ($user_level == 1 || empty($user_level))){
    alertMsg('danger','ไม่พบหน้านี้ในระบบ','request.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo getCompany()?></title>
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
        
        <?php include_once 'inc/alert.php'; ?>
        
        <nav>
          <ol class="breadcrumb bg-white border">
            <li class="breadcrumb-item">
              <a href="request.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item active">
              Log
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">Log Action</h5>
              </div>
              <div class="card-body">
                <!-- Filter -->
                <div class="row">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <select class="form-control form-control-sm"
                      onChange="location = this.options[this.selectedIndex].value;">
                      <option value="log.php?status="
                        <?php if(empty(@$_GET['dep'])) echo 'selected' ?>>--- Please Select ---</option>
                      <?php
                        $status = ['1' => 'Login Success','2' => 'Login Fail','3' => 'Change Password'];
                        foreach($status as $key => $value) : 
                      ?>
                      <option value="log.php?status=<?php echo $key ?>" 
                        <?php if(@$_GET['status'] == $key) echo 'selected' ?>><?php echo $value ?></option> 
                      <?php
                        endforeach;
                      ?>
                    </select>
                  </div>
                </div>

                <!-- Table -->
                <div class="row justify-content-center">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="data" class="table table-bordered table-hover table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Host</th>
                            <th>IP</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            @$getStatus = $_GET['status'];
                            $logs = getFilterLog($getStatus);
                            foreach($logs as $key => $row):
                              $log_date = date('d/m/Y', strtotime($row['log_create']));
                              $log_time = date('H:i', strtotime($row['log_create']));
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td class="text-left"><?php echo $row['log_username'] ?></td>
                            <td>
                              <?php echo ($row['log_status'] == 1 
                                ? '<i class="fas fa-check text-success"></i>' 
                                : ($row['log_status'] == 2
                                ? '<i class="fas fa-times-circle text-danger"></i>'
                                : '<i class="fas fa-exchange-alt text-primary"></i>'))
                              ?>
                            </td>
                            <td><?php echo $row['log_host'] ?></td>
                            <td><?php echo $row['log_ip'] ?></td>
                            <td><?php echo 'วันที่ '.$log_date.' เวลา '.$log_time.' น.' ?></td>
                          </tr>
                          <?php 
                            endforeach; 
                            unset($row);
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-sm-3 pb-2">
                    <a class="btn btn-danger btn-sm btn-block" href="users.php">
                      <i class="fa fa-arrow-left pr-2"></i>Back to Home
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
      $('#data').DataTable();
    });
  </script>
</body>
</html>