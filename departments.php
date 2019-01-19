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

  $act = isset($_GET['act']) ? $_GET['act'] : 'index';
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
            <li class="breadcrumb-item">
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item active">
              Departments
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">Departments Management</h5>
              </div>
              <div class="card-body">
                <!-- Button -->
                <div class="row justify-content-end">
                  <div class="col-xl-3 col-md-6 mb-2">
                    <a href="?act=add" class="btn btn-success btn-sm btn-block">
                      <i class="fas fa-plus mr-2"></i>Add Department
                    </a>
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
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $departments = getDepartment();
                            foreach($departments as $key => $row):
                          ?>
                          <tr>
                            <td><?php echo $key+1 ?></td>
                            <td class="text-left"><?php echo $row['dep_name'] ?></td>
                            <td>
                              <?php echo ($row['dep_status'] == 1 
                                ? '<i class="fas fa-check text-success"></i>' 
                                : '<i class="fas fa-times-circle text-danger"></i>') 
                              ?>
                            </td>
                            <td>
                              <a href="?act=edit&id=<?php echo $row['dep_id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a class="btn btn-danger btn-sm" href="?act=delete&id=<?php echo $row['dep_id'] ?>"
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
              <a href="index.php"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="users.php"><i class="fas fa-users"></i></a>
            </li>
            <li class="breadcrumb-item">
              <a href="departments.php"><i class="fas fa-building mr-2"></i></a>
            </li>
            <li class="breadcrumb-item active">
              Add Department
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">Add Department</h5>
              </div>
              <div class="card-body">
                <form action="?act=insert" method="POST">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Department Name</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="dep_name" required>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnInsert">
                        <i class="fa fa-check pr-2"></i>Confirm
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="departments.php">
                        <i class="fa fa-arrow-left pr-2"></i>Back to Home
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

            $dep_name = $_POST['dep_name'];
            $dep_create = date('Y-m-d H:i:s');

            $data = [$dep_name,$dep_create];

            $sql = "INSERT INTO ex_department(dep_name,dep_create)
              VALUES(?,?)";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','Add Successfully','departments.php');
            } else {
              alertMsg('danger','Error, Please try again.','?act=add');
            }

            $stmt = null;
          endif;

          /*

          Edit Item 

          */

          if($act == 'edit'):
            include_once 'inc/alert.php';

            @$dep_id = $_GET['id'];
            $stmt = getQueryDepartment($dep_id);
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
            <li class="breadcrumb-item">
              <a href="departments.php"><i class="fas fa-building mr-2"></i></a>
            </li>
            <li class="breadcrumb-item active">
              Edit Department
            </li>
          </ol>
        </nav>

        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5 class="text-center">Edit Department</h5>
              </div>
              <div class="card-body">
                <form action="?act=update" method="POST">
                  <div class="form-group row" style="display: none">
                    <label class="col-sm-4 col-form-label text-md-right">ID</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="dep_id" 
                        value="<?php echo $row['dep_id'] ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Department Name</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="dep_name" 
                        value="<?php echo $row['dep_name'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label text-md-right">Status</label>
                    <div class="form-check form-check-inline">
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="dep_status" value="1"
                          <?php if($row['dep_status'] == '1') echo 'checked' ?>>Enable
                      </label>
                      <label class="form-check-label mx-3">
                        <input class="form-check-input" type="radio" name="dep_status" value="2"
                          <?php if($row['dep_status'] == '2') echo 'checked' ?>>Disable
                      </label>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-sm-3 pb-2">
                      <button class="btn btn-success btn-sm btn-block" name="btnUpdate">
                        <i class="fa fa-check pr-2"></i>Confirm
                      </button>
                    </div>
                    <div class="col-sm-3 pb-2">
                      <a class="btn btn-danger btn-sm btn-block" href="departments.php">
                        <i class="fa fa-arrow-left pr-2"></i>Back to Home
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

            $dep_id = $_POST['dep_id'];
            $dep_name = $_POST['dep_name'];
            $dep_status = $_POST['dep_status'];

            $data = [$dep_name,$dep_status,$dep_id];

            $sql = "UPDATE ex_department SET
              dep_name = ?,
              dep_status = ?
              WHERE dep_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','Update Successfully','departments.php');
            } else {
              alertMsg('danger','Error, Please try again.',"?act=edit&id={$dep_id}");
            }

            $stmt = null;
          endif;

          /*

          Delete Item 

          */

          if($act == 'delete'):
            @$dep_id = $_GET['id'];
            $dep_status = 2;

            $data = [$dep_status,$dep_id];
            
            $sql = "UPDATE ex_department SET
              dep_status = ?
              WHERE dep_id = ?";
            $stmt = $dbcon->prepare($sql);
            $result = $stmt->execute($data);

            if($result) {
              alertMsg('success','Disable Successfully','departments.php');
            } else {
              alertMsg('danger','Error, Please try again.','departments.php');
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
  </script>
</body>
</html>