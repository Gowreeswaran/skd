<?php

    if(isset($_POST['addCashBill'])){
        addCashBillDetails($conn,$data['staffsId'],$_POST['datCashBillDate'],$_POST['txtRep'],$_POST['txtCustomerCode'],$_POST['txtCustomerName'],$_POST['txtBillNo'],$_POST['txtAmount']);
    }
    if(isset($_POST['saveAllCashBill'])){
        addAllCashBillInProgressesInformations($conn,$data['staffsId']);
    }
    if(isset($_POST['removeAllCashBill'])){
        removeAllCashBillInProgressesInformations($conn);
    }
    if(isset($_POST['removeCashBill'])){
        removeCashBillInProgressesInformations($conn,$_POST['removeCashBill']);
    }
    if(isset($_POST['deleteCashBill'])){
        deleteCashBillInformations($conn,$_POST['deleteCashBill']);
    }
    if(isset($_POST['editCashBill'])){
        editCashBillDetails($conn,$_POST['datCashBillDate'],$_POST['txtRep'],$_POST['txtCustomerCode'],$_POST['txtCustomerName'],$_POST['txtBillNo'],$_POST['txtAmount']);
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
            <a class="dropdown-item" href="user.php?chqsd">Cash Sales</a>
            <a class="dropdown-item active" href="user.php?cahsd"><i class="fas fa-caret-right"></i>Cash Sales</a>
            <a class="dropdown-item" href="user.php?acbillnrepcol">A/C B in R.H To Colt</a>
            <a class="dropdown-item" href="user.php?acbcr">A/C Bill Collections</a>
        </div>
    </div>
</div>

<!-- Content Row Add Cash Sale -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-header">
                    <?php
                        if(isset($_GET['cshbe'])){
                            echo "Cash Bill Edit ";
                        }
                        else{
                            echo "Cash Bill Add ";
                        }
                    ?>
                </div>
                <div class="card-body">
                        <?php
                            if(isset($_GET['cshbe'])){
                                $dataFetch = fetchCashBillDetails($conn,$_GET['cshbe']);
                        ?>

                        <div class="row">
                            <form action="user.php?cahsd" method="POST" class="form-inline">

                                <div class="row">
                                    <label class="sr-only" for="datCashBillDate">Cash Bill Date</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datCashBillDate" name="datCashBillDate" placeholder="Select Cash Bill Date" value="<?=$dataFetch['cashBillDate'];?>">
                                    </div>

                                    <label class="sr-only" for="txtRep">Rep</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtRep" name="txtRep">
                                            <option disabled>Select Rep</option>
                                            <?php
                                                getRepForOptionInAddCustomerForEdit($conn,$dataFetch['cashBillRep']);
                                            ?>
                                        </select>
                                    </div>

                                    <label class="sr-only" for="txtCustomerCode">Customer Code</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-ruler"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtCustomerCode" name="txtCustomerCode">
                                            <option disabled>Select Customer Code</option>
                                            <?php
                                                showCustomerIDInOptionsForEdit($conn,$dataFetch['cashBillCustomerCode']);
                                            ?>
                                        </select>
                                    </div>

                                    <label class="sr-only" for="txtCustomerName">Customer Name</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtCustomerName" name="txtCustomerName">
                                            <option disabled>Select Customer Name</option>
                                            <?php
                                                showCustomerNamesInOptionsForEdit($conn,$dataFetch['cashBillCustomerName']);
                                            ?>
                                        </select>
                                    </div>

                                    <label class="sr-only" for="txtBillNo">Bill No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtBillNo" name="txtBillNo" placeholder="Bill No" value="<?=$dataFetch['cashBillNo'];?>" readonly>
                                    </div>

                                    <label class="sr-only" for="txtAmount">Amount</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-coins"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtAmount" name="txtAmount" placeholder="Amount" value="<?=$dataFetch['cashBillAmount'];?>">
                                    </div>

                                    
                                </div>
                                <div class="row">
                                    <div class="input-group col-12">
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="editCashBill" class="btn btn-success mb-2 mr-sm-4">Edit</button>
                                            <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php
                            }else{
                        ?>

                        <div class="row">
                            <form action="user.php?cahsd" method="POST" class="form-inline">

                                <div class="row">
                                    <label class="sr-only" for="datCashBillDate">Cash Bill Date</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datCashBillDate" name="datCashBillDate" placeholder="Select Cash Bill Date" value="<?=defaultDateSettingForCshSale($conn);?>" required>
                                    </div>

                                    <label class="sr-only" for="txtRep">Rep</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtRep" name="txtRep">
                                            <option selected disabled>Select Rep</option>
                                            <?php
                                                defaultRepSelectedCashBill($conn);
                                            ?>
                                        </select>
                                    </div>

                                    <label class="sr-only" for="txtCustomerCode">Customer Code</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-ruler"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtCustomerCode" name="txtCustomerCode">
                                            <option selected disabled>Select Customer Code</option>
                                            <?php
                                                showCustomerIDInOptions($conn);
                                            ?>
                                        </select>
                                    </div>

                                    <label class="sr-only" for="txtCustomerName">Customer Name</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtCustomerName" name="txtCustomerName">
                                            <option selected disabled>Select Customer Name</option>
                                            <?php
                                                showCustomerNamesInOptions($conn);
                                            ?>
                                        </select>
                                    </div>

                                    <label class="sr-only" for="txtBillNo">Bill No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtBillNo" name="txtBillNo" placeholder="Bill No">
                                    </div>

                                    <label class="sr-only" for="txtAmount">Amount</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-coins"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtAmount" name="txtAmount" placeholder="Amount" required>
                                    </div>

                                    
                                </div>
                                <div class="row">
                                    <div class="input-group col-12">
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="addCashBill" class="btn btn-success mb-2 mr-sm-4">Add</button>
                                            <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php
                            }
                        ?>
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
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        showCashBillInProgressesInformations($conn);
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


<!-- Content Row View Cash Sale -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header">
                    Cash Bill View 
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="user.php?cahsd" method="POST" class="form-inline">

                            <div class="row">
                                <label class="sr-only" for="datCashBillDateFrom">Cash Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datCashBillDateFrom" name="datCashBillDateFrom" placeholder="Select Cash Bill Date" value="<?=date('Y-m-d');?>" required>
                                </div>

                                <label class="sr-only" for="datCashBillDateTo">Cash Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datCashBillDateTo" name="datCashBillDateTo" placeholder="Select Cash Bill Date" value="<?=date('Y-m-d');?>" required>
                                </div>

                                <label class="sr-only" for="txtRep">Rep</label>
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
                                        <button type="submit" name="findView" class="btn btn-success mb-2 mr-sm-4">Find</button>
                                        <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <p></p><p></p>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" id="dataTable1" cellspacing="0">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                        if(isset($_POST['findView'])){
                                            findCashBillDetails($conn,$_POST['datCashBillDateFrom'],$_POST['datCashBillDateTo'],$_POST['txtRep2'],$data['staffsId']);
                                        }
                                        else{
                                            showCashBillAfterInProgressesInformations($conn,$data['staffsId']);
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

