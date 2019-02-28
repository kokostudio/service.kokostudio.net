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

  $date = date('Ymd');
  $fileName = "รายงานการขอใช้บริการ{$date}.xls";
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=$fileName");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>รายงานการเบิกสวัสดิการพนักงาน</title>
  <style>
    body {
      font-family: 'ANGSA';
    }
    table {
      width: 100%;
    }
    table, th, td {
      border: 1px solid #000;
      border-collapse: collapse;
      text-align: center;
    }
    th, td {
      padding: 5px;
      font-size: 1.2em;
    }
  </style>
</head>
<body>

  <div style="text-align: center">
    <span style="font-size: 2em;">รายงานการขอใช้บริการ</span><br/>
  </div>

  <table>
    <thead>
      <tr>
        <td width="3%">#</td>
        <td>เลขที่บริการ</td>
		<td>แผนกขอใช้บริการ</td>
        <td>ผู้ขอใช้บริการ</td>
		<td>สาขา</td>
        <td>รายละเอียด</td>
		<td>ผู้รับดำเนินการ</td>
        <td>วันที่แจ้ง</td>
        <td>วันที่เสร็จ</td>
		<td>ดำเนินการ(วัน)</td>
        <td>สถานะ</td>
		<td>ผู้รับเรื่อง</td>
      </tr>
    </thead>
    <tbody>
      <?php
        @$getYear = $_GET['year'];
        @$getMonth = $_GET['month'];
        @$getCat = $_GET['cat'];
        @$getServ = $_GET['serv'];
        @$getStat = $_GET['stat'];
        @$getUser = $_GET['user'];
        $requests = getFilterRequest($getYear,$getMonth,$getCat,$getServ,$getStat,$getUser);
        foreach($requests as $key => $req):
          $date_end = getDateEnd($req['req_id']);
      ?>
      <tr>
        <td><?php echo $key+1 ?></td>
        <td><?php echo $req['req_gen'] ?></td>
		<td class="text-left" style="text-align: left"><?php echo getDepartmentName($req['req_dep']) ?></td>
        <td class="text-left" style="text-align: left"><?php echo $req['req_user_process'] ?></td>
		<td class="text-left" style="text-align: left"><?php echo getUserBranch($req['req_user']) ?></td>
        <td class="text-left" style="text-align: left"><?php echo $req['req_text'] ?></td>
		<td class="text-left" style="text-align: left"><?php echo getUserFullname($req['req_operator']) ?></td>
        <td><?php echo convertDate($req['req_create']).' '.date('H:i',strtotime($req['req_create'])).' น.' ?></td>
        <td><?php echo convertDate($req['req_update']).' '.date('H:i',strtotime($req['req_update'])).' น.'; ?><?//echo ($date_end ? convertDate($date_end) : '-') ?></td>
		<td><?php if($date_end==''){ echo '-'; }else{ echo datediff($req['req_create'],$date_end); } ?></td>
        <td class="<?php echo colorStatus($req['req_status']) ?>">
          <?php echo getStatusName($req['req_status']) ?>
        </td>
		<td><?php echo getUserFullname($req['req_user']) ?></td>
      </tr>
      <?php 
        endforeach; 
        unset($req);
      ?>
    </tbody>
  </table>
  <p align="right"><small><?php echo '<b>วันที่</b> '.date('d/m/Y').' <b>เวลา</b> '.date('H:i').' <b>น.</b>' ?></small></p>
</body>
</html>