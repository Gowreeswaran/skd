<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sivakaran Distributor - Business Management System</title>

  <!-- Custom fonts for this template-->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">

  <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="css/select2.min.css" rel="stylesheet" type="text/css"/>
  <link href="css/bootstrap-select.css" rel="stylesheet" type="text/css"/>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
  </style>

  

</head>

<?php

  session_start();
  date_default_timezone_set("Asia/Colombo");
  include_once 'config/config.php';
  include_once 'function/functions.php';

  if(!isset($_SESSION['txtUserId'])){
    header('Location: index.php');
  }
  $data = fetchUsersLoginDetails($conn,$_SESSION['txtUserId']);

  $noLoginUserInStaffTbl = chkLoginUserInStaffTbl($conn,$data['staffsId']);
  $userName = "";
  if($noLoginUserInStaffTbl >= 1){
    $dataUser = fetchStaffDetails($conn,$data['staffsId']);
    $userName = $dataUser['staffsName'];
  }
  else{
    $userName = "Super Admin";
  }

  $outputDataToShowNotification = showNotification1($conn);
  $outputDataToShowNotification2 = showNotification2($conn);
      
?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    
    <?php include_once 'layouts/adminLayouts/asidebar.php';?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include_once 'layouts/adminLayouts/atopbar.php';?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <?php

          if(isset($_GET['bb'])){
            include_once 'layouts/adminLayouts/abillboard.php';
          }
          if(isset($_GET['cd'])){
            include_once 'layouts/adminLayouts/acustomersdata.php';
          }
          if(isset($_GET['sd'])){
            include_once 'layouts/adminLayouts/astaffsdata.php';
          }
          if(isset($_GET['rd'])){
            include_once 'layouts/adminLayouts/aroutesdata.php';
          }
          if(isset($_GET['grnd'])){
            include_once 'layouts/adminLayouts/agrndata.php';
          }
          if(isset($_GET['crdsd'])){
            include_once 'layouts/adminLayouts/acrdsale.php';
          }
          if(isset($_GET['chqsd'])){
            include_once 'layouts/adminLayouts/achqsale.php';
          }
          if(isset($_GET['cahsd'])){
            include_once 'layouts/adminLayouts/achssale.php';
          }
          if(isset($_GET['acbillnrepcol'])){
            include_once 'layouts/adminLayouts/aacbirhtcol.php';
          }
          if(isset($_GET['cshdep'])){
            include_once 'layouts/adminLayouts/acshdep.php';
          }
          if(isset($_GET['chqdep'])){
            include_once 'layouts/adminLayouts/achqdep.php';
          }
          if(isset($_GET['voucher'])){
            include_once 'layouts/adminLayouts/avoucher.php';
          }
          if(isset($_GET['expensive'])){
            include_once 'layouts/adminLayouts/aexpensive.php';
          }
          if(isset($_GET['tsr'])){
            include_once 'layouts/adminLayouts/atsr.php';
          }
          if(isset($_GET['tsrcb'])){
            include_once 'layouts/adminLayouts/atsrcb.php';
          }
          if(isset($_GET['acbcr'])){
            include_once 'layouts/adminLayouts/aacbcolt.php';
          }
          if(isset($_GET['ledgerview'])){
            include_once 'layouts/adminLayouts/aledgerview.php';
          }
          if(isset($_GET['salary'])){
            include_once 'layouts/adminLayouts/asalary.php';
          }
          if(isset($_GET['salary'])){
            include_once 'layouts/adminLayouts/asalary.php';
          }
          if(isset($_GET['profit'])){
            include_once 'layouts/adminLayouts/aprofit.php';
          }
          if(!isset($_GET['bb']) && !isset($_GET['cd']) && !isset($_GET['sd']) && !isset($_GET['rd']) && !isset($_GET['grnd']) && !isset($_GET['crdsd']) && !isset($_GET['chqsd']) && !isset($_GET['cahsd']) && !isset($_GET['acbillnrepcol']) && !isset($_GET['cshdep']) && !isset($_GET['chqdep']) && !isset($_GET['voucher']) && !isset($_GET['expensive']) && !isset($_GET['tsr']) && !isset($_GET['acbcr']) && !isset($_GET['ledgerview']) && !isset($_GET['salary']) && !isset($_GET['profile']) && !isset($_GET['tsrcb']) && !isset($_GET['profit'])){
            include_once 'layouts/adminLayouts/adashboard.php';
          }

          

        ?>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include_once 'layouts/adminLayouts/afoot.php'; ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="assets/vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="assets/js/demo/chart-area-demo.js"></script>
  <script src="assets/js/demo/chart-pie-demo.js"></script>

  <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="js/select2.min.js"></script>
  <script src="js/bootstrap-select.js"></script>
  <script>
    $(document).ready(function() {
      $('#dataTable1').DataTable({
        "bStateSave": true,
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem('offersDataTables', JSON.stringify(oData));
        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse(localStorage.getItem('offersDataTables'));
        }
    });
    });
    $(document).ready(function() {
      $('#dataTable2').DataTable({
        "bStateSave": true,
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem('offersDataTables', JSON.stringify(oData));
        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse(localStorage.getItem('offersDataTables'));
        }
    });
    });
    $(document).ready(function() {
      $('.select2').select2();
    });
  </script>
  <script src="js/adminCustomeJS.js"></script>
  
  <script>
    function validateForm1(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this customer details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };
    function validateForm2(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Block this customer details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Block Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };
    function validateForm3(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Active this customer details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Active Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };
    function validateForm3_1(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Active All customer details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Active Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm4(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this Staff details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };
    function validateForm5(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Block this Staff details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Block Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };
    function validateForm6(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Active this Staff details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Active Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };
    function validateForm6_1(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Active All Staff details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Active Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm7(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this Route details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };
    function validateForm8(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Block this Route details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Block Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };
    function validateForm9(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Active this Route details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Active Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };
    function validateForm9_1(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Active All Route details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Active Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm10(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this Invoice details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm11(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this Target details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm12(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this AC Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm13(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Save all these AC Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Save Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm14(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove all these AC Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm15(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this AC Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm16(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this Cheque Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm17(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Save all these Cheque Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Save Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm18(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove all these Cheque Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm19(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this Cheque Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm20(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this Cash Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm21(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Save all these Cash Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Save Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm22(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove all these Cash Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm23(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this Cash Bill details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm24(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Delete this details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm25(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Delete this details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm26(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Remove this details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm27(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Delete this details!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Remove Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm28(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Active this account!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Active Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm29(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Delete this Detail!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Deletion Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

    function validateForm30(){
      event.preventDefault(); // prevent form submit
      var form = event.target.form; // storing the form
      swal({
          title: 'Are you sure?',
          text: 'You want to Update this Detail!',
          icon: 'warning',
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
          if (willDelete) {
              form.submit();
          } else {
              swal('Updation Process was Cancelled Successfully!', {
                  icon: 'info',
                  button: false,
                  timer: 1000,
              });
          }
      });
    };

  // Restricts input for the given textbox to the given inputFilter function.
  function setInputFilter(textbox, inputFilter) {
      ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
          if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          } else {
            this.value = "";
          }
        });
      });
  }

    <?php if(isset($_GET['cd'])){ ?>
    setInputFilter(document.getElementById("txtCustomerPhone"), function(value) {
        return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
    });
    <?php }
    if(isset($_GET['sd'])){ ?>
    setInputFilter(document.getElementById("txtStaffPhone"), function(value1) {
        return /^\d*\.?\d*$/.test(value1); // Allow digits and '.' only, using a RegExp
    });

    setInputFilter(document.getElementById("txtEditStaffPhone"), function(value2) {
        return /^\d*\.?\d*$/.test(value2); // Allow digits and '.' only, using a RegExp
    });
    <?php }
    if(isset($_GET['rd'])){ ?>
    setInputFilter(document.getElementById("txtRouteNoOfShop"), function(value1) {
        return /^\d*\.?\d*$/.test(value1); // Allow digits and '.' only, using a RegExp
    });

    setInputFilter(document.getElementById("txtRouteNoOfFC"), function(value2) {
        return /^\d*\.?\d*$/.test(value2); // Allow digits and '.' only, using a RegExp
    });

    setInputFilter(document.getElementById("txtEditRouteNoOfShop"), function(value3) {
        return /^\d*\.?\d*$/.test(value3); // Allow digits and '.' only, using a RegExp
    });

    setInputFilter(document.getElementById("txtEditRouteNoOfFC"), function(value4) {
        return /^\d*\.?\d*$/.test(value4); // Allow digits and '.' only, using a RegExp
    });
    <?php } 
    if(isset($_GET['grnd'])){ ?>
    setInputFilter(document.getElementById("txtAmount"), function(value4) {
        return /^\d*\.?\d*$/.test(value4); // Allow digits and '.' only, using a RegExp
    });

    setInputFilter(document.getElementById("txtPrimaryTarget"), function(value5) {
        return /^\d*\.?\d*$/.test(value5); // Allow digits and '.' only, using a RegExp
    });
    
    setInputFilter(document.getElementById("txtRDTarget"), function(value6) {
        return /^\d*\.?\d*$/.test(value6); // Allow digits and '.' only, using a RegExp
    });
    
    setInputFilter(document.getElementById("txtEditRDTarget"), function(value1) {
        return /^\d*\.?\d*$/.test(value1); // Allow digits and '.' only, using a RegExp
    });

    setInputFilter(document.getElementById("txtEditAmount"), function(value2) {
        return /^\d*\.?\d*$/.test(value2); // Allow digits and '.' only, using a RegExp
    });

    setInputFilter(document.getElementById("txtEditPrimaryTarget"), function(value3) {
        return /^\d*\.?\d*$/.test(value3); // Allow digits and '.' only, using a RegExp
    });
    <?php } ?>
  
    
  
  
  
  </script>

  <script>

    function titleCase(str) {
      var splitStr = str.toLowerCase().split(' ');
      for (var i = 0; i < splitStr.length; i++) {
          // You do not need to check if i is larger than splitStr length, as your for does that for you
          // Assign it back to the array
          splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
      }
      // Directly return the joined string
      return splitStr.join(' '); 
    }
  
    $(document).ready(function(){
      $("#txtRep").change(function(){
          var repTxt = $("#txtRep").val();
          $.ajax({
              url: 'js/data.php',
              method: 'post',
              data: 'repTxt=' + repTxt
          }).done(function(datas){
              console.log(datas);
              datas = JSON.parse(datas);
              $('#txtCustomerCode').empty();
              $('#txtCustomerCode').append("<option value='' selected disabled>" + "Select Customer Code" + "</option>")
              datas.forEach(function(data1){
                  $('#txtCustomerCode').append("<option value='" + data1.customerId + "'>" + data1.customerId.toUpperCase() + "</option>")
              })

              $('#txtCustomerName').empty();
              $('#txtCustomerName').append("<option value='' selected disabled>" + "Select Customer Name" + "</option>")
              datas.forEach(function(data1){
                  $('#txtCustomerName').append("<option value='" + data1.name + "'>" + titleCase(data1.name) + "</option>")
              })
          })
      });

      $("#txtCustomerCode").change(function(){
          var cstCode = $("#txtCustomerCode").val();
          var cstRepName= "";
          $.ajax({
              url: 'js/data.php',
              method: 'post',
              data: 'cstCode=' + cstCode
          }).done(function(datas){
              console.log(datas);
              datas = JSON.parse(datas);
              $('#txtCustomerName').empty();
              $('#txtCustomerName').append("<option value='' disabled>" + "Select Customer Name" + "</option>")
              datas[0].forEach(function(data11){
                  var active = '';
                  if(data11.customerId == cstCode){
                    active = 'selected';
                    cstRepName= data11.rep;
                  }
                  $('#txtCustomerName').append("<option value='" + data11.name + "' " + active + ">" + titleCase(data11.name) + "</option>")
              });

              $('#txtRep').empty();
              $('#txtRep').append("<option value='' disabled>" + "Select Rep" + "</option>")
              datas[1].forEach(function(data22){
                  var active1 = '';
                  if(data22.staffsName == datas[2]){
                    active1 = 'selected';
                  }
                  $('#txtRep').append("<option value='" + data22.staffsName + "' " + active1 + ">" + titleCase(data22.staffsName) + "</option>")
              });
          })
      })

      $("#txtCustomerName").change(function(){
          var cstName = $("#txtCustomerName").val();
          $.ajax({
              url: 'js/data.php',
              method: 'post',
              data: 'cstName=' + cstName
          }).done(function(datas){
              console.log(datas);
              datas = JSON.parse(datas);
              $('#txtCustomerCode').empty();
              $('#txtCustomerCode').append("<option value='' disabled>" + "Select Customer Code" + "</option>")
              datas[0].forEach(function(data1){
                  var active = '';
                  if(data1.name == cstName){
                    active = 'selected';
                  }
                  $('#txtCustomerCode').append("<option value='" + data1.customerId + "' " + active + ">" + data1.customerId.toUpperCase() + "</option>")
              });
              
              $('#txtRep').empty();
              $('#txtRep').append("<option value='' disabled>" + "Select Rep" + "</option>")
              datas[1].forEach(function(data22){
                  var active1 = '';
                  if(data22.staffsName == datas[2]){
                    active1 = 'selected';
                  }
                  $('#txtRep').append("<option value='" + data22.staffsName + "' " + active1 + ">" + titleCase(data22.staffsName) + "</option>")
              });
          })
      })

      var comission1 = $("#txtComission").val();
      var comissionPercentage1 = $("#txtComissionPercentage").val();
      var totalComission1 = comission1 * (comissionPercentage1 / 100);
      $("#txtTotalComission").val(totalComission1);

      var TotalSalary11 = $("#txtTotalBasicSalary").val();
      TotalSalary11 = parseFloat(TotalSalary11);
      var TotalComission11 = $("#txtTotalComission").val();
      TotalComission11 = parseFloat(TotalComission11);

      var Incentive11 = $("#txtIncentive").val();
      Incentive11 = parseFloat(Incentive11);

      var gS11 = TotalSalary11 + TotalComission11 + Incentive11;
      $("#txtTotalGrossSalary").val(gS11);

      var SortStore = $("#txtSortStore").val();
      SortStore = parseFloat(SortStore);
      var TotalAdvance = $("#txtTotalAdvance").val();
      TotalAdvance = parseFloat(TotalAdvance);
      var TotalDischargers = SortStore + TotalAdvance;
      $("#txtTotalDischargers").val(TotalDischargers);

      var totalNetSalary = gS11 - TotalDischargers;
      $("#txtNetSalary").val(totalNetSalary);

      $("#txtSalaryMonth").change(function(){
          var salaryMonth = $("#txtSalaryMonth").val();
          var salaryYear = $("#txtSalaryYear").val();
          var staffId = $("#txtSaffIdInHidden").val();
          $.ajax({
              url: 'js/data.php',
              method: 'post',
              data: {staffId1: staffId, salaryYear1: salaryYear, salaryMonth1: salaryMonth}
          }).done(function(datas){
              console.log(datas);
              datas = JSON.parse(datas);
              $('#txtComission').val("0");
              $('#txtComission').val(datas[0]);
              var comission = datas[0];
              var comissionPercentage = $("#txtComissionPercentage").val();
              var totalComission = comission * (comissionPercentage / 100);
              $("#txtTotalComission").val(totalComission);

              var TotalSalary111 = $("#txtTotalBasicSalary").val();
              TotalSalary111 = parseFloat(TotalSalary111);
              var TotalComission111 = $("#txtTotalComission").val();
              TotalComission111 = parseFloat(TotalComission111);
              var Incentive111 = $("#txtIncentive").val();
              Incentive111 = parseFloat(Incentive111);

              var gS111 = TotalSalary111 + TotalComission111 + Incentive111;
              $("#txtTotalGrossSalary").val(gS111);

              var TotalDischargers = $("#txtTotalDischargers").val();
              TotalDischargers = parseFloat(TotalDischargers);

              var totalNetSalary = gS111 - TotalDischargers;
              $("#txtNetSalary").val(totalNetSalary);
          })
      })

      $("#txtSalaryYear").change(function(){
          var salaryMonth = $("#txtSalaryMonth").val();
          var salaryYear = $("#txtSalaryYear").val();
          var staffId = $("#txtSaffIdInHidden").val();
          $.ajax({
              url: 'js/data.php',
              method: 'post',
              data: {staffId1: staffId, salaryYear1: salaryYear, salaryMonth1: salaryMonth}
          }).done(function(datas){
              console.log(datas);
              datas = JSON.parse(datas);
              $('#txtComission').val("0");
              $('#txtComission').val(datas[0]);
              var comission = datas[0];
              var comissionPercentage = $("#txtComissionPercentage").val();
              var totalComission = comission * (comissionPercentage / 100);
              $("#txtTotalComission").val(totalComission);

              var TotalSalary111 = $("#txtTotalBasicSalary").val();
              TotalSalary111 = parseFloat(TotalSalary111);
              var TotalComission111 = $("#txtTotalComission").val();
              TotalComission111 = parseFloat(TotalComission111);
              var Incentive111 = $("#txtIncentive").val();
              Incentive111 = parseFloat(Incentive111);

              var gS111 = TotalSalary111 + TotalComission111 + Incentive111;
              $("#txtTotalGrossSalary").val(gS111);

              var TotalDischargers = $("#txtTotalDischargers").val();
              TotalDischargers = parseFloat(TotalDischargers);

              var totalNetSalary = gS111 - TotalDischargers;
              $("#txtNetSalary").val(totalNetSalary);
          })
      })

      $("#txtIncentive").keyup(function(){
          var Incentive111 = $("#txtIncentive").val();
          Incentive111 = parseFloat(Incentive111);

          var TotalSalary111 = $("#txtTotalBasicSalary").val();
          TotalSalary111 = parseFloat(TotalSalary111);
          var TotalComission111 = $("#txtTotalComission").val();
          TotalComission111 = parseFloat(TotalComission111);
          

          var gS111 = TotalSalary111 + TotalComission111 + Incentive111;
          $("#txtTotalGrossSalary").val(gS111);

          var TotalDischargers = $("#txtTotalDischargers").val();
          TotalDischargers = parseFloat(TotalDischargers);

          var totalNetSalary = gS111 - TotalDischargers;
          $("#txtNetSalary").val(totalNetSalary);
      })

      $("#txtComissionPercentage").keyup(function(){
          var comission = $("#txtComission").val();
          var comissionPercentage = $("#txtComissionPercentage").val();
          var totalComission = comission * (comissionPercentage / 100);
          $("#txtTotalComission").val(totalComission);

          var TotalSalary111 = $("#txtTotalBasicSalary").val();
          TotalSalary111 = parseFloat(TotalSalary111);
          var TotalComission111 = $("#txtTotalComission").val();
          TotalComission111 = parseFloat(TotalComission111);
          var Incentive111 = $("#txtIncentive").val();
          Incentive111 = parseFloat(Incentive111);

          var gS111 = TotalSalary111 + TotalComission111 + Incentive111;
          $("#txtTotalGrossSalary").val(gS111);

          var TotalDischargers = $("#txtTotalDischargers").val();
          TotalDischargers = parseFloat(TotalDischargers);

          var totalNetSalary = gS111 - TotalDischargers;
          $("#txtNetSalary").val(totalNetSalary);
      })

      $("#txtComission").keyup(function(){
          var comission = $("#txtComission").val();
          var comissionPercentage = $("#txtComissionPercentage").val();
          var totalComission = comission * (comissionPercentage / 100);
          $("#txtTotalComission").val(totalComission);

          var TotalSalary111 = $("#txtTotalBasicSalary").val();
          TotalSalary111 = parseFloat(TotalSalary111);
          var TotalComission111 = $("#txtTotalComission").val();
          TotalComission111 = parseFloat(TotalComission111);
          var Incentive111 = $("#txtIncentive").val();
          Incentive111 = parseFloat(Incentive111);

          var gS111 = TotalSalary111 + TotalComission111 + Incentive111;
          $("#txtTotalGrossSalary").val(gS111);

          var TotalDischargers = $("#txtTotalDischargers").val();
          TotalDischargers = parseFloat(TotalDischargers);

          var totalNetSalary = gS111 - TotalDischargers;
          $("#txtNetSalary").val(totalNetSalary);
      })

      $("#txtPerDayBasic").keyup(function(){
          var PerDayBasic = $("#txtPerDayBasic").val();
          var Attandance = $("#txtAttandance").val();
          var totalSalary = PerDayBasic * Attandance;
          $("#txtTotalBasicSalary").val(totalSalary);

          var TotalSalary111 = $("#txtTotalBasicSalary").val();
          TotalSalary111 = parseFloat(TotalSalary111);
          var TotalComission111 = $("#txtTotalComission").val();
          TotalComission111 = parseFloat(TotalComission111);
          var Incentive111 = $("#txtIncentive").val();
          Incentive111 = parseFloat(Incentive111);

          var gS111 = TotalSalary111 + TotalComission111 + Incentive111;
          $("#txtTotalGrossSalary").val(gS111);

          var TotalDischargers = $("#txtTotalDischargers").val();
          TotalDischargers = parseFloat(TotalDischargers);

          var totalNetSalary = gS111 - TotalDischargers;
          $("#txtNetSalary").val(totalNetSalary);
      })

      $("#txtAttandance").keyup(function(){
          var PerDayBasic = $("#txtPerDayBasic").val();
          var Attandance = $("#txtAttandance").val();
          var totalSalary = PerDayBasic * Attandance;
          $("#txtTotalBasicSalary").val(totalSalary);

          var TotalSalary111 = $("#txtTotalBasicSalary").val();
          TotalSalary111 = parseFloat(TotalSalary111);
          var TotalComission111 = $("#txtTotalComission").val();
          TotalComission111 = parseFloat(TotalComission111);
          var Incentive111 = $("#txtIncentive").val();
          Incentive111 = parseFloat(Incentive111);

          var gS111 = TotalSalary111 + TotalComission111 + Incentive111;
          $("#txtTotalGrossSalary").val(gS111);

          var TotalDischargers = $("#txtTotalDischargers").val();
          TotalDischargers = parseFloat(TotalDischargers);

          var totalNetSalary = gS111 - TotalDischargers;
          $("#txtNetSalary").val(totalNetSalary);
      })

      $("#txtSortStore").keyup(function(){
        var SortStore = $("#txtSortStore").val();
        SortStore = parseFloat(SortStore);
        var TotalAdvance = $("#txtTotalAdvance").val();
        TotalAdvance = parseFloat(TotalAdvance);
        var TotalDischargers = SortStore + TotalAdvance;
        $("#txtTotalDischargers").val(TotalDischargers);

        var gS11 = $("#txtTotalGrossSalary").val();
        gS11 = parseFloat(gS11);

        var totalNetSalary = gS11 - TotalDischargers;
        $("#txtNetSalary").val(totalNetSalary);
      })

      $("#txtTotalAdvance").keyup(function(){
        var SortStore = $("#txtSortStore").val();
        SortStore = parseFloat(SortStore);
        var TotalAdvance = $("#txtTotalAdvance").val();
        TotalAdvance = parseFloat(TotalAdvance);
        var TotalDischargers = SortStore + TotalAdvance;
        $("#txtTotalDischargers").val(TotalDischargers);

        var gS11 = $("#txtTotalGrossSalary").val();
        gS11 = parseFloat(gS11);

        var totalNetSalary = gS11 - TotalDischargers;
        $("#txtNetSalary").val(totalNetSalary);
      })

  })
  
  </script>

  <script>
    $(document).ready(function(){
        var datACBillDate = $("#datACBillDate").val();
        var txtRep = $("#txtRep").val();
        if((datACBillDate!='') && (txtRep!='')){
            $('#txtCustomerName').focus();
        }
    })
  </script>

  <script>
    function addChequeFieldInForm(){
        var opt = document.getElementById("txtPaymentTypes").value;
        var x = '<th>Cheque No</th><th><input type="text" class="form-control" id="txtChequeNo" name="txtChequeNo" placeholder="Cheque No" required></th>';
        var y = '<th>Bank</th><th><input type="text" class="form-control" id="txtBank" name="txtBank" placeholder="Bank" required></th>';
        if(opt == 'Cheque'){
            document.getElementById("hr1").innerHTML = x;
            document.getElementById("hr2").innerHTML = y;
        }
        else{
            document.getElementById("hr1").innerHTML = '';
            document.getElementById("hr2").innerHTML = '';
        }
    }
  </script>

  <script>
    function showGrossProfit(a){
        var com = Number(a);
        var inam = Number(document.getElementById("txtInseaAmount").value);
        var gt = com + inam;
        gt = gt.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        document.getElementById("gp").innerHTML = '+' + gt;
    }
    function showTypeValueLive(){
        var inam = Number(document.getElementById("txtInseaAmount").value);
        inam = inam.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        document.getElementById("txtInseaAmount").value = inam;
    }
  </script>
  
    

</body>

</html>
