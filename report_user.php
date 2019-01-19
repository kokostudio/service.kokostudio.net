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

  $depText = (empty($_GET['dep']) ? 'ทั้งหมด' : getDepartmentName($_GET['dep']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="public/css/custom.css">
  <title>Report Users</title>
  <style>
    body {
      font-family: 'ANGSA';
    }
    table {
      width: 100%;
    }
    table, td {
      border: 1px solid #000;
      border-collapse: collapse;
      text-align: center;
    }
    .text-left {
      text-align: left;
    }
  </style>
</head>
<body>

  <div style="text-align: center">
    <span style="font-size: 2em;">รายงานผู้ใช้งานระบบ</span><br/>
    <span style="font-size: 1.3em;"><?php echo "รายชื่อพนักงาน ฝ่าย{$depText}" ?></span>
  </div>

  <table>
    <thead>
      <tr>
        <td width="3%">#</td>
        <td>Code</td>
        <td>Name</td>
        <td>Department</td>
        <td>E-Mail</td>
        <td>Level</td>
        <td>Status</td>
        <td>Create</td>
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
        <td class="text-left"><?php echo $row['user_code'] ?></td>
        <td class="text-left"><?php echo getUserFullname($row['user_code']) ?></td>
        <td class="text-left"><?php echo getDepartmentName($row['dep_id']) ?></td>
        <td class="text-left"><?php echo $row['user_email'] ?></td>
        <td><?php getUserLevelName($row['user_level']) ?></td>
        <td><?php echo ($row['user_status'] == 1 ? 'Active' : 'Inactive') ?></td>
        <td><?php echo convertDate($row['user_create']) ?></td>
      </tr>
      <?php 
        endforeach; 
      ?>
    </tbody>
  </table>

</body>
</html>
<?php
  $html = ob_get_contents();
  ob_end_clean();

  require_once 'vendor/autoload.php';

  $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);

  $today = date('Ymd');
  $date = date('d/m/Y');
  $time = date('H:i');

  $fileName = "Report_Users_{$today}.pdf";

  $footer = "<span style='font-weight: normal; font-size: 1.3em;'>วันที่ {$date} เวลา {$time} น.</span>";

  $mpdf->WriteHTML($html);

  $mpdf->SetFooter($footer);

  $mpdf->Output();
?>