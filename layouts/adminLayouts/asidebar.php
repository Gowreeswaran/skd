<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
  <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-laugh-wink"></i>
  </div>
  <div class="sidebar-brand-text mx-3">SKD - BMS </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?php if(!isset($_GET['cd']) && !isset($_GET['sd']) && !isset($_GET['rd']) && !isset($_GET['grnd']) && !isset($_GET['crdsd']) && !isset($_GET['chqsd']) && !isset($_GET['cahsd']) && !isset($_GET['acbillnrepcol']) && !isset($_GET['cshdep']) && !isset($_GET['chqdep']) && !isset($_GET['voucher']) && !isset($_GET['expensive']) && !isset($_GET['tsr']) && !isset($_GET['acbcr']) && !isset($_GET['ledgerview']) && !isset($_GET['salary']) && !isset($_GET['profile']) && !isset($_GET['profit']) && !isset($_GET['tsrcb'])){echo 'active';}?>">
  <a class="nav-link" href="admin.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Data
</div>

<!-- Nav Item - Master Data Collapse Menu -->
<li class="nav-item <?php if(isset($_GET['cd']) || isset($_GET['sd']) || isset($_GET['rd']) || isset($_GET['grnd'])){echo 'active';}?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMD" aria-expanded="true" aria-controls="collapseMD">
    <i class="fas fa-fw fa-folder"></i>
    <span>Master Data</span><?=$outputDataToShowNotification['showNotificationOnMasterData'];?>
  </a>
  <div id="collapseMD" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Master Data Components:</h6>
      <a class="collapse-item <?php if(isset($_GET['cd'])){echo 'active';}?>" href="admin.php?cd">Customers <?=$outputDataToShowNotification2['showNotificationOnMasterData1'];?></a>
      <a class="collapse-item <?php if(isset($_GET['sd'])){echo 'active';}?>" href="admin.php?sd">Staffs <?=$outputDataToShowNotification2['showNotificationOnMasterData2'];?></a>
      <a class="collapse-item <?php if(isset($_GET['rd'])){echo 'active';}?>" href="admin.php?rd">Routes <?=$outputDataToShowNotification2['showNotificationOnMasterData3'];?></a>
      <a class="collapse-item <?php if(isset($_GET['grnd'])){echo 'active';}?>" href="admin.php?grnd">Goods Receive Note</a>
    </div>
  </div>
</li>

<!-- Nav Item - Sales Data Collapse Menu -->
<li class="nav-item <?php if(isset($_GET['crdsd']) || isset($_GET['chqsd']) || isset($_GET['cahsd']) || isset($_GET['acbillnrepcol'])){echo 'active';}?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSD" aria-expanded="true" aria-controls="collapseSD">
    <i class="fas fa-fw fa-dollar-sign"></i>
    <span>Sales</span><?=$outputDataToShowNotification['showNotificationOnSales'];?>
  </a>
  <div id="collapseSD" class="collapse" aria-labelledby="collapseSales" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Sales Utilities:</h6>
      <a class="collapse-item <?php if(isset($_GET['crdsd'])){echo 'active';}?>" href="admin.php?crdsd">Credit Sales <?=$outputDataToShowNotification2['showNotificationOnSales1'];?></a>
      <a class="collapse-item <?php if(isset($_GET['chqsd'])){echo 'active';}?>" href="admin.php?chqsd">Cheque Sales <?=$outputDataToShowNotification2['showNotificationOnSales2'];?></a>
      <a class="collapse-item <?php if(isset($_GET['cahsd'])){echo 'active';}?>" href="admin.php?cahsd">Cash Sales <?=$outputDataToShowNotification2['showNotificationOnSales3'];?></a>
      <a class="collapse-item <?php if(isset($_GET['acbillnrepcol'])){echo 'active';}?>" href="admin.php?acbillnrepcol">A/C B in R.H To Colt</a>
      <a class="collapse-item <?php if(isset($_GET['acbcr'])){echo 'active';}?>" href="admin.php?acbcr">A/C Bill Collections</a>
    </div>
  </div>
</li>

<!-- Nav Item - Ledger Data Collapse Menu -->
<li class="nav-item <?php if(isset($_GET['cshdep']) || isset($_GET['chqdep']) || isset($_GET['voucher'])){echo 'active';}?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLD" aria-expanded="true" aria-controls="collapseLD">
    <i class="fas fa-fw fa-balance-scale"></i>
    <span>Ledger</span><?=$outputDataToShowNotification['showNotificationOnLedger'];?>
  </a>
  <div id="collapseLD" class="collapse" aria-labelledby="headingLD" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Ledger Utilities:</h6>
      <a class="collapse-item <?php if(isset($_GET['cshdep'])){echo 'active';}?>" href="admin.php?cshdep">Cash Deposite <?=$outputDataToShowNotification2['showNotificationOnLedger1'];?></a>
      <a class="collapse-item <?php if(isset($_GET['chqdep'])){echo 'active';}?>" href="admin.php?chqdep">Cheque Deposite <?=$outputDataToShowNotification2['showNotificationOnLedger2'];?></a>
      <a class="collapse-item <?php if(isset($_GET['voucher'])){echo 'active';}?>" href="admin.php?voucher">Voucher <?=$outputDataToShowNotification2['showNotificationOnLedger3'];?></a>
    </div>
  </div>
</li>

<!-- Nav Item - Expenses -->
<li class="nav-item <?php if(isset($_GET['expensive'])){echo 'active';}?>">
  <a class="nav-link" href="admin.php?expensive">
    <i class="fas fa-fw fa-dolly"></i>
    <span>Expenses <?=$outputDataToShowNotification['showNotificationOnExpenses'];?></span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Reports
</div>

<!-- Nav Item - Sales Report Collapse Menu -->
<li class="nav-item <?php if(isset($_GET['tsr']) || isset($_GET['tsrcb'])){echo 'active';}?>">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTSR" aria-expanded="true" aria-controls="collapseTSR">
    <i class="fas fa-fw fa-dollar-sign"></i>
    <span>Sales Report</span>
  </a>
  <div id="collapseTSR" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <h6 class="collapse-header">Sales Report Components:</h6>
      <a class="collapse-item <?php if(isset($_GET['tsr'])){echo 'active';}?>" href="admin.php?tsr">Total Sales Report</a>
      <a class="collapse-item <?php if(isset($_GET['tsrcb'])){echo 'active';}?>" href="admin.php?tsrcb">Custermer Based Report</a>
    </div>
  </div>
</li>

<!-- Nav Item - Ledger View -->
<li class="nav-item <?php if(isset($_GET['ledgerview'])){echo 'active';}?>">
  <a class="nav-link" href="admin.php?ledgerview">
    <i class="fas fa-fw fa-chart-pie"></i>
    <span>Ledger View</span></a>
</li>

<!-- Nav Item - Salary -->
<li class="nav-item <?php if(isset($_GET['salary'])){echo 'active';}?>">
  <a class="nav-link" href="admin.php?salary">
    <i class="fas fa-fw fa-project-diagram"></i>
    <span>Salary</span></a>
</li>

<!-- Nav Item - Profit -->
<li class="nav-item <?php if(isset($_GET['profit'])){echo 'active';}?>">
  <a class="nav-link" href="admin.php?profit">
    <i class="fas fa-fw fa-cash-register"></i>
    <span>Profit</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->