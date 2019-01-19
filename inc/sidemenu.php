<nav class="col-xl-2 col-md-3 d-none d-md-block sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <img class="nav-link img-fluid picture-profile mx-auto d-block" 
          src="public/images/users/<?php echo getUserPicture($_SESSION['user_code']) ?>" alt="">
      </li>
      <li class="nav-item">
        <h4 class="nav-link text-center">
          <?php echo getUserNickname($_SESSION['user_code']); ?>
        </h4>
      </li>
      <?php
		$approve = strpos($_SERVER['PHP_SELF'], "approve.php");
        $request = strpos($_SERVER['PHP_SELF'], "request.php");
        $view = strpos($_SERVER['PHP_SELF'], "view.php");
        $manage = strpos($_SERVER['PHP_SELF'], "manage.php");
        $category = strpos($_SERVER['PHP_SELF'], "category.php");
        $service = strpos($_SERVER['PHP_SELF'], "service.php");
        $status = strpos($_SERVER['PHP_SELF'], "status.php");
        $dashboard = strpos($_SERVER['PHP_SELF'], "dashboard.php");
        $profile = strpos($_SERVER['PHP_SELF'], "profile.php");
        $chgpwd = strpos($_SERVER['PHP_SELF'], "change_pwd.php");
        $departments = strpos($_SERVER['PHP_SELF'], "departments.php");
        $log = strpos($_SERVER['PHP_SELF'], "log.php");
        $users = strpos($_SERVER['PHP_SELF'], "users.php");
        $computers = strpos($_SERVER['PHP_SELF'], "computers.php");
        $software = strpos($_SERVER['PHP_SELF'], "software.php");
        $system = strpos($_SERVER['PHP_SELF'], "system.php");
        $check_level = getUserLevel($_SESSION['user_code']);
		$check_approve = getUserApprove($_SESSION['user_code']);
      ?>
      <li class="nav-item <?php if($request || $category || $service || $status || $view || $manage) echo 'active' ?>">
        <a class="nav-link" href="request.php">
          <i class="fas fa-home px-2"></i>
          จัดการคำขอใช้บริการ
        </a>
      </li>
	  <?php if($check_approve == 1 && $check_level == 1): ?>
	  <li class="nav-item <?php if($approve) echo 'active' ?>">
        <a class="nav-link" href="approve.php">
          <i class="fas fa-check px-2"></i>
          จัดการอนุมัติ
        </a>
      </li>
	  <?php endif ?>
      <?php if($check_level == 69 || $check_level == 99): ?>
      <li class="nav-item <?php if($dashboard) echo 'active' ?>">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-tachometer-alt px-2"></i>
          แผงควบคุม
        </a>
      </li>
      <?php endif ?>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#sub_dashboard">
          <i class="fas fa-user-circle px-2"></i>
          ผู้ใช้งาน
          <i class="fas fa-angle-<?php echo ($profile || $chgpwd ? 'down' : 'left') ?> px-3"></i>
        </a>
        <div id="sub_dashboard" class="collapse <?php if($profile || $chgpwd) echo 'show'; ?>">
          <ul class="nav flex-column">
            <li class="nav-item <?php if($profile) echo 'active' ?>">
              <a class="nav-link sub-menu" href="profile.php">
                <small>
                  <i class="fas fa-user px-2"></i>
                  โปรไฟล์
                </small>
              </a>
            </li>
            <li class="nav-item <?php if($chgpwd) echo 'active' ?>">
              <a class="nav-link sub-menu" href="change_pwd.php">
                <small>
                  <i class="fas fa-key px-2"></i>
                  เปลี่ยนรหัสผ่าน
                </small>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <?php if($check_level == 69 || $check_level == 99): ?>
      <li class="nav-item <?php if($users || $departments || $log) echo 'active' ?>">
        <a class="nav-link" href="users.php">
          <i class="fas fa-users px-2"></i>
          จัดการผู้ใช้งาน
        </a>
      </li>
      <li class="nav-item <?php if($computers || $software) echo 'active' ?>">
        <a class="nav-link" href="computers.php">
          <i class="fas fa-desktop px-2"></i>
          จัดการคอมพิวเตอร์
        </a>
      </li>
      <?php
        endif;
        if($check_level == 99):
      ?>
      <li class="nav-item <?php if($system) echo 'active' ?>">
        <a class="nav-link" href="system.php">
          <i class="fas fa-cogs px-2"></i>
          จัดการระบบ
        </a>
      </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" href="logout.php" onClick="return confirm('Are you sure?');">
          <i class="fas fa-sign-out px-2"></i>
          ออกจากระบบ
        </a>
      </li>
    </ul>
  </div>
</nav>