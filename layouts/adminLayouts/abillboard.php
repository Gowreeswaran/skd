<?php

    if(isset($_POST['activeCustomerIdFromPending'])){
        activeCustomerDetailsFromPending($conn,$_POST['activeCustomerIdFromPending']);
    }
    if(isset($_POST['activeRouteIdFromPending'])){
        activeRouteDetailsFromPending($conn,$_POST['activeRouteIdFromPending']);
    }
    if(isset($_POST['activeStaffIdFromPending'])){
        activeStaffDetailsFromPending($conn,$_POST['activeStaffIdFromPending']);
    }
    if(isset($_POST['activeACBillFromPending'])){
        if(isset($_POST['activeACBillFromPendingDateFrom']) && isset($_POST['activeACBillFromPendingDateTo'])){
            activeACBillDetailsFromPending2($conn,$_POST['activeACBillFromPending'],$_POST['activeACBillFromPendingDateFrom'],$_POST['activeACBillFromPendingDateTo']);
        }
        else{
            activeACBillDetailsFromPending($conn,$_POST['activeACBillFromPending']);
        }
    }
    if(isset($_POST['activeChequeBillFromPending'])){
        if(isset($_POST['activeChequeBillFromPendingDateFrom']) && isset($_POST['activeChequeBillFromPendingDateTo'])){
            activeChequeBillDetailsFromPending2($conn,$_POST['activeChequeBillFromPending'],$_POST['activeChequeBillFromPendingDateFrom'],$_POST['activeChequeBillFromPendingDateTo']);
        }
        else{
            activeChequeBillDetailsFromPending($conn,$_POST['activeChequeBillFromPending']);
        }
    }
    if(isset($_POST['activeCashBillFromPending'])){
        if(isset($_POST['activeCashBillFromPendingDatFrom']) && isset($_POST['activeCashBillFromPendingDatTo'])){
            activeCashBillDetailsFromPending2($conn,$_POST['activeCashBillFromPending'],$_POST['activeCashBillFromPendingDatFrom'],$_POST['activeCashBillFromPendingDatTo']);
        }
        else{
            activeCashBillDetailsFromPending($conn,$_POST['activeCashBillFromPending']);
        }
    }
    if(isset($_POST['activeCashDepositeFromPending'])){
        activeCashDepositeBillDetailsFromPending($conn,$_POST['activeCashDepositeFromPending']);
    }
    if(isset($_POST['activeChequeDepositeFromPending'])){
        activeChqeueDepositeBillDetailsFromPending($conn,$_POST['activeChequeDepositeFromPending']);
    }
    if(isset($_POST['activeVoucherFromPending'])){
        activeVoucherBillDetailsFromPending($conn,$_POST['activeVoucherFromPending']);
    }
    if(isset($_POST['activeExpensiveFromPending'])){
        activeExpensivesBillDetailsFromPending($conn,$_POST['activeExpensiveFromPending']);
    }
    if(isset($_POST['activeSystemUserFromPending'])){
        activeSystemUserFromPending($conn,$_POST['activeSystemUserFromPending']);
    }

    $noOfEveryUserAdded = noOfRequestsForBillBoard($conn);

?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <div class="dropdown show">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #4e73df;">
            Boards
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="admin.php">Main Board</a>
            <a class="dropdown-item active" href="admin.php?bb"><i class="fas fa-caret-right"></i>Bill Board</a>
        </div>
    </div>
</div>
<?php
    if($noOfEveryUserAdded['noOfCustomers']>=1){
?>
<!-- Content Row -->
<div class="row">
        <div class="col-12">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-header">
                    Customers Request &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfCustomers'];?></span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact No</th>
                                    <th>Shop Type</th>
                                    <th>Frezer Type</th>
                                    <th>Route</th>
                                    <th>Rep</th>
                                    <th>Status</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    showCustomersDetailsForBillBoard($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfStaffs']>=1){
?>
<!-- Content Row View Staff -->
<div class="row">
        <div class="col-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-header">
                    Staffs Requests &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfStaffs'];?></span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Picture</th>
                                    <th>Staff ID</th>
                                    <th>NIC No</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact No</th>
                                    <th>Staff Type</th>
                                    <th>Status</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    showStaffsDetailsForBillBoard($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfRoutes']>=1){
?>
<!-- Content Row View Route -->
<div class="row">
        <div class="col-12">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header">
                    Route Request &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfRoutes'];?></span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Route ID</th>
                                    <th>Route Name</th>
                                    <th>Itenary</th>
                                    <th>Town</th>
                                    <th>No of Shops</th>
                                    <th>Ref</th>
                                    <th>No of FC</th>
                                    <th>Status</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    showRoutesDetailsForBillBoard($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfACBill']>=1){
?>
<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-header">
                A/C Bill Request  &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfACBill'];?></span>
            </div>
            <div class="card-body">
                <div class="row">
                    <form action="admin.php?bb&findView1" method="POST" class="form-inline">

                        <div class="row">
                            <label class="sr-only" for="datACBillDateFrom1">A/C Bill Date</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                </div>
                                <input type="date" class="form-control" id="datACBillDateFrom1" name="datACBillDateFrom1" placeholder="Select A/C Bill Date" value="<?=date('Y-m-d');?>" required>
                            </div>

                            <label class="sr-only" for="datACBillDateTo1">A/C Bill Date</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                </div>
                                <input type="date" class="form-control" id="datACBillDateTo1" name="datACBillDateTo1" placeholder="Select A/C Bill Date" value="<?=date('Y-m-d');?>" required>
                            </div>

                            <label class="sr-only" for="txtRep1">Rep</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                </div>
                                <select class="form-control select2" id="txtRep1" name="txtRep1">
                                    <option value="all" selected>All</option>
                                    <?php
                                        getRepForOptionInAddCustomer($conn);
                                    ?>
                                </select>
                            </div>
                                
                        </div>
                        <div class="row">
                            <div class="input-group col-4">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success mb-2 mr-sm-4">Find</button>
                                    <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <p></p><p></p>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Customer Code</th>
                                    <th>Name</th>
                                    <th>Bill No</th>
                                    <th>Route</th>
                                    <th>Rep</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($_GET['findView1'])){
                                        showFindACBillAfterInProgressesInformationsForBillBoard($conn,$_POST['datACBillDateFrom1'],$_POST['datACBillDateTo1'],$_POST['txtRep1'],$data['staffsId']);
                                    }
                                    else{
                                        showACBillAfterInProgressesInformationsForBillBoard($conn,$data['staffsId']);
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfChqBill']>=1){
?>
<!-- Content Row View Cheque Sale -->
<div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header">
                    Cheque Bill Request  &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfChqBill'];?></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="admin.php?bb&findView2" method="POST" class="form-inline">

                            <div class="row">
                                <label class="sr-only" for="datACBillDateFrom2">A/C Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datACBillDateFrom2" name="datACBillDateFrom2" placeholder="Select A/C Bill Date" value="<?=date('Y-m-d');?>" required>
                                </div>

                                <label class="sr-only" for="datACBillDateTo2">A/C Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datACBillDateTo2" name="datACBillDateTo2" placeholder="Select A/C Bill Date" value="<?=date('Y-m-d');?>" required>
                                </div>

                                <label class="sr-only" for="txtRep2">Rep</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                    </div>
                                    <select class="form-control select2" id="txtRep2" name="txtRep2">
                                        <option value="all" selected>All</option>
                                        <?php
                                            getRepForOptionInAddCustomer($conn);
                                        ?>
                                    </select>
                                </div>
                                    
                            </div>
                            <div class="row">
                                <div class="input-group col-4">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success mb-2 mr-sm-4">Find</button>
                                        <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <p></p><p></p>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th>Date</th>
                                        <th>Customer Code</th>
                                        <th>Name</th>
                                        <th>Bill No</th>
                                        <th>Route</th>
                                        <th>Rep</th>
                                        <th>Cheque No</th>
                                        <th>Bank</th>
                                        <th>Cheque Days</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_GET['findView2'])){
                                            showFindChqBillAfterInProgressesInformationsForBillBoard($conn,$_POST['datACBillDateFrom2'],$_POST['datACBillDateTo2'],$_POST['txtRep2'],$data['staffsId']);
                                        }
                                        else{
                                            showChqBillAfterInProgressesInformationsForBillBoard($conn,$data['staffsId']);
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfCshBill']>=1){
?>
<!-- Content Row View Cash Sale -->
<div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header">
                    Cash Bill Request  &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfCshBill'];?></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="admin.php?bb&findView3" method="POST" class="form-inline">

                            <div class="row">
                                <label class="sr-only" for="datACBillDateFrom3">A/C Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datACBillDateFrom3" name="datACBillDateFrom3" placeholder="Select A/C Bill Date" value="<?=date('Y-m-d');?>" required>
                                </div>

                                <label class="sr-only" for="datACBillDateTo3">A/C Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datACBillDateTo3" name="datACBillDateTo3" placeholder="Select A/C Bill Date" value="<?=date('Y-m-d');?>" required>
                                </div>

                                <label class="sr-only" for="txtRep3">Rep</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                    </div>
                                    <select class="form-control select2" id="txtRep3" name="txtRep3">
                                        <option value="all" selected>All</option>
                                        <?php
                                            getRepForOptionInAddCustomer($conn);
                                        ?>
                                    </select>
                                </div>
                                    
                            </div>
                            <div class="row">
                                <div class="input-group col-4">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-success mb-2 mr-sm-4">Find</button>
                                        <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <p></p><p></p>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th>Date</th>
                                        <th>Customer Code</th>
                                        <th>Name</th>
                                        <th>Bill No</th>
                                        <th>Route</th>
                                        <th>Rep</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_GET['findView3'])){
                                            showFindCashBillAfterInProgressesInformationsForBillBoard($conn,$_POST['datACBillDateFrom3'],$_POST['datACBillDateTo3'],$_POST['txtRep3'],$data['staffsId']);
                                        }
                                        else{
                                            showCashBillAfterInProgressesInformationsForBillBoard($conn,$data['staffsId']);
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfCshDeposit']>=1){
?>
<!-- Content Row View Cash Deposite -->
<div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-header">
                    Cash Deposite Request &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfCshDeposit'];?></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Account Holders Name</th>
                                        <th>Account No</th>
                                        <th>Bank</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        showCashDepositeAfterInProgressesInformationsForBillBoard($conn,$data['staffsId']);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfChqDeposit']>=1){
?>
<!-- Content Row View Cheque Deposite -->
<div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-header">
                    Cheque Deposite Request &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfChqDeposit'];?></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Account Holders Name</th>
                                        <th>Account No</th>
                                        <th>Cheque No</th>
                                        <th>Bank</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        showChqeueDepositeAfterInProgressesInformationsForBillBoard($conn,$data['staffsId']);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfVoucher']>=1){
?>
<!-- Content Row View Voucher -->
<div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-header">
                    Voucher Request &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfVoucher'];?></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Voucher No</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        showVoucherAfterInProgressesInformationsForBillBoard($conn,$data['staffsId']);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfExpensive']>=1){
?>
<!-- Content Row View Expenses -->
<div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-header">
                    Expenses Request &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfExpensive'];?></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Operations</option>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        showExpensivesAfterInProgressesInformationsForBillBoard($conn,$data['staffsId']);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
    if($noOfEveryUserAdded['noOfSystemUser']>=1){
?>
<!-- Content Row View System User -->
<div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-header">
                    System User Request &nbsp; <span style="background-color: red;color: white;border-radius: 5px;"><?=$noOfEveryUserAdded['noOfSystemUser'];?></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>profile Picture</th>
                                        <th>Staff ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Operations</option>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        showSystemUserRequest($conn);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
    }
?>


