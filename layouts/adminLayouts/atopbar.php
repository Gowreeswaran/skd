<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
  <i class="fa fa-bars"></i>
</button>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

  <!-- Nav Item - Alerts -->
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-bell fa-fw"></i>
      <!-- Counter - Alerts -->
      <?php
        $outputMainNotification = showMainNotification1($conn);
        if($outputMainNotification['noOfTotalNotification'] >= 1){
          echo '<span class="badge badge-danger badge-counter">'.$outputMainNotification['noOfTotalNotification'].'</span>';
        }
      ?>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
      <h6 class="dropdown-header">
        Notification Center
      </h6>
      <?php
        if($outputMainNotification['notiOutput1'] != ''){
          echo $outputMainNotification['notiOutput1'];
        }
        if($outputMainNotification['notiOutput2'] != ''){
          echo $outputMainNotification['notiOutput2'];
        }
        if($outputMainNotification['notiOutput3'] != ''){
          echo $outputMainNotification['notiOutput3'];
        }
        if($outputMainNotification['notiOutput4'] != ''){
          echo $outputMainNotification['notiOutput4'];
        }
        if($outputMainNotification['notiOutput5'] != ''){
          echo $outputMainNotification['notiOutput5'];
        }
        if($outputMainNotification['notiOutput6'] != ''){
          echo $outputMainNotification['notiOutput6'];
        }
        if($outputMainNotification['notiOutput7'] != ''){
          echo $outputMainNotification['notiOutput7'];
        }
        if($outputMainNotification['notiOutput8'] != ''){
          echo $outputMainNotification['notiOutput8'];
        }
        if($outputMainNotification['notiOutput9'] != ''){
          echo $outputMainNotification['notiOutput9'];
        }
        if($outputMainNotification['notiOutput10'] != ''){
          echo $outputMainNotification['notiOutput10'];
        }
        if($outputMainNotification['notiOutput11'] != ''){
          echo $outputMainNotification['notiOutput11'];
        }

        if(($outputMainNotification['notiOutput1'] != '') || ($outputMainNotification['notiOutput2'] != '') || ($outputMainNotification['notiOutput3'] != '') || ($outputMainNotification['notiOutput4'] != '') || ($outputMainNotification['notiOutput5'] != '') || ($outputMainNotification['notiOutput6'] != '') || ($outputMainNotification['notiOutput7'] != '') || ($outputMainNotification['notiOutput8'] != '') || ($outputMainNotification['notiOutput9'] != '') || ($outputMainNotification['notiOutput10'] != '') || ($outputMainNotification['notiOutput11'] != '')){
          echo '<a class="dropdown-item text-center small text-gray-500" href="admin.php?bb">Show All Notification</a>';
        }
        else{
          echo '<a class="dropdown-item text-center small text-gray-500" href="#">No Notification Available Now...</a>';
        }


      ?>
    </div>
  </li>

  <div class="topbar-divider d-none d-sm-block"></div>

  <!-- Nav Item - User Information -->
  <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=ucwords($userName," ");?></span>
      <img class="img-profile rounded-circle" src="<?=$data['profilePicture'];?>">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
      <a class="dropdown-item <?php if(isset($_GET['profile'])){echo 'active';}?>" href="admin.php?profile">
        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
        Profile
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="function/logout.php">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Logout
      </a>
    </div>
  </li>

</ul>

</nav>
<!-- End of Topbar -->