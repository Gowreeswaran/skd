<?php
    if(isset($_POST['addBillCollectionDetails'])){
        addACBillToCollectInRepHandAtInProgress($conn,$data['staffsId'],$_POST['datACBillColDate'],$_POST['txtBillNo']);
    }
    if(isset($_POST['removeACBillColtDetails'])){
        removeACBillToCollectInRepHandAtInProgress($conn,$_POST['removeACBillColtDetails']);
    }
    if(isset($_POST['addBillCollectionDetailsInOutOfProgress'])){
        addAllACBillToCollectInRepHandAtOutOfInProgress($conn,$data['staffsId']);
    }
    if(isset($_POST['deleteACBillColtDetails'])){
        deleteACBillToCollectInRepHandAtInProgress($conn,$_POST['deleteACBillColtDetails']);
    }
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sales Data</h1>
    <div class="dropdown show">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #4e73df;">
            Categories
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="user.php?crdsd">Credit Sales</a>
            <a class="dropdown-item" href="user.php?chqsd">Cheque Sales</a>
            <a class="dropdown-item" href="user.php?cahsd">Cash Sales</a>
            <a class="dropdown-item active" href="user.php?acbillnrepcol"><i class="fas fa-caret-right"></i>A/C B in R.H To Colt</a>
            <a class="dropdown-item" href="user.php?acbcr">A/C Bill Collections</a>
        </div>
    </div>
</div>

<!-- Content Row Add A/C B in R.H To Colt -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-header">
                    Add A/C B in R.H To Colt
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <form action="user.php?acbillnrepcol" method="POST" class="form-inline">

                                <div class="row">

                                    <label class="sr-only" for="datACBillColDate"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datACBillColDate" name="datACBillColDate" placeholder="Select Cash Bill Date" value="<?=defaultDateSettingForACBillInRHToColt($conn);?>" required>
                                    </div>

                                    <label class="sr-only" for="txtBillNo">Bill No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtBillNo" name="txtBillNo" placeholder="Bill No" required>
                                    </div>

                                    <div class="input-group col-4">
                                        <div class="d-flex justify-content-center">
                                            <button name="addBillCollectionDetails" type="submit" class="btn btn-success mb-2 mr-sm-4">Add</button>
                                            <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                    <p></p><p></p>
                    
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer Name</th>
                                            <th>Bill No</th>
                                            <th>Amount</th>
                                            <th>Collected Amount</th>
                                            <th>Balance</th>
                                            <th>Operation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            showACBillToCollectInRepHandAtInProgress($conn);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group col-4">
                                <div class="d-flex justify-content-center">
                                    <form action="user.php?acbillnrepcol" method="POST">
                                        <button name="addBillCollectionDetailsInOutOfProgress" type="submit" class="btn btn-success mb-2 mr-sm-4">Enter</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    
                    <p></p><p></p><p></p><p></p><p></p><p></p>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" id="dataTable1" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Bill No</th>
                                        <th>Amount</th>
                                        <th>Collected Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_GET['vid'])){
                                            showACBillToCollectInRepHandAtInProgressDetailsOfOtherBills($conn,$_GET['vid']);
                                        }
                                        elseif(isset($_POST['txtBillNo'])){
                                            showACBillToCollectInRepHandAtInProgressDetailsOfOtherBills($conn,$_POST['txtBillNo']);
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
<p></p><p></p><p></p>

<!-- Content Row View A/C B in R.H To Colt -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header">
                    A/C B in R.H To Colt View 
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <form action="user.php?acbillnrepcol" method="POST" class="form-inline">

                                <div class="row">

                                    <label class="sr-only" for="datCashBillDate"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datCashBillDate" name="datCashBillDate" placeholder="Select Cash Bill Date" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <label class="sr-only" for="txtBillNo">Bill No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtBillNo" name="txtBillNo" placeholder="Bill No">
                                    </div>

                                    <div class="input-group col-4">
                                        <div class="d-flex justify-content-center">
                                            <button name="findView" type="submit" class="btn btn-success mb-2 mr-sm-4">View</button>
                                            <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                    <p></p><p></p>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Bill No</th>
                                        <th>Amount</th>
                                        <th>Collected Amount</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST['findView'])){
                                            showACBillToCollectInRepHandAtAfterInProgressFindView($conn,$data['staffsId'],$_POST['datCashBillDate'],$_POST['txtBillNo']);
                                        }
                                        else{
                                            showACBillToCollectInRepHandAtAfterInProgress($conn,$data['staffsId']);
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
<p></p><p></p><p></p>

