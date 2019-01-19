<?php
	$check_level = getUserLevel($_SESSION['user_code']);
?>
<nav class="navbar navbar-expand-lg bg-white fixed-top flex-md-nowrap shadow">
  <div class="container">
    <span class="navbar-brand"><?php echo getCompany() ?></span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu">
      <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="request.php">
            <i class="fas fa-home"></i>
          </a>
        </li>
		<?php if($check_level == 69 || $check_level == 99): ?>
		<li class="nav-item">
		  <a class="nav-link" href="users.php">
            <i class="fas fa-users"></i>
          </a>
        </li>
		<li class="nav-item">
		  <a class="nav-link" href="computers.php">
            <i class="fas fa-desktop"></i>
          </a>
        </li>
		<?php endif ?>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link" href="javascript:void(0)" data-toggle="dropdown">
            <?php echo getUserNickname($_SESSION['user_code']); ?>
            <i class="fa fa-angle-down px-2"></i>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="profile.php">
              <small>
                <i class="fas fa-user px-2"></i>
                โปรไฟล์
              </small>
            </a>
            <a class="dropdown-item" href="change_pwd.php">
              <small>
                <i class="fas fa-key px-2"></i>
                เปลี่ยนรหัสผ่าน
              </small>
            </a>
            <a class="dropdown-item" href="logout.php" onClick="return confirm('Are you sure?');">
              <small>
                <i class="fas fa-sign-out px-2"></i>
                ออกระบบ
              </small>
            </a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>