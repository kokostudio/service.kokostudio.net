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
    <span style="font-size: 2em;">รายงานอุปกรณ์</span><br/>
    <span style="font-size: 1.3em;"><?php echo "อุปกรณ์ ฝ่าย{$depText}" ?></span>
  </div>

  <table>
    <thead>
      <tr>
        <td width="3%">#</td>
        <td>ชื่ออุปกรณ์</td>
        <td>ผู้ใช้งาน</td>
        <td>ฝ่าย/แผนก</td>
        <td>สถานะ</td>
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
        <td style="text-align: left"><?php echo $row['hw_name'] ?></td>
		<td style="text-align: left"><?php echo $row['hw_ip'] ?></td>
        <td><?php echo getUserFullname($row['user_code']) ?></td>
        <td><?php echo getDepartmentName($row['dep_id']) ?></td>
        <td><?php echo ($row['hw_status'] == 1 ? 'เปิดใช้งาน' : 'ปิดใช้งาน') ?></td>
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