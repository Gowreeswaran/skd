<?php

    if(isset($_POST['btnAddACBillDetails'])){
        addACBillDetails($conn,$data['staffsId'],$_POST['txtBillNo'],$_POST['datACBillDate'],$_POST['txtRep'],$_POST['txtCustomerCode'],$_POST['txtCustomerName'],$_POST['txtAmount']);
    }
    if(isset($_POST['removeACBill'])){
        removeACBillInProgressesInformations($conn,$_POST['removeACBill']);
    }
    if(isset($_POST['removeAllACBill'])){
        removeAllACBillInProgressesInformations($conn);
    }
    if(isset($_POST['saveAllACBill'])){
        addAllACBillInProgressesInformations($conn,$data['staffsId']);
    }
    if(isset($_POST['deleteACBill'])){
        deleteACBillInformations($conn,$_POST['deleteACBill']);
    }
    if(isset($_POST['btnEditACBillDetails'])){
        editACBillDetails($conn,$_POST['txtBillNo'],$_POST['datACBillDate'],$_POST['txtRep'],$_POST['txtCustomerCode'],$_POST['txtCustomerName'],$_POST['txtAmount']);
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
            <a class="dropdown-item active" href="user.php?crdsd"><i class="fas fa-caret-right"></i>Credit Sales</a>
            <a class="dropdown-item" href="user.php?chqsd">Cheque Sales</a>
            <a class="dropdown-item" href="user.php?cahsd">Cash Sales</a>
            <a class="dropdown-item" href="user.php?acbillnrepcol">A/C B in R.H To Colt</a>
            <a class="dropdown-item" href="user.php?acbcr">A/C Bill Collections</a>
        </div>
    </div>
</div>


<!-- Content Row Add Creadit Sale -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-header">
                    <?php
                        if(isset($_GET['acbe'])){
                            echo "A/C Bill Edit ";
                        }
                        else{
                            echo "A/C Bill Add ";
                        }
                    ?>
                </div>
                <div class="card-body">
                    <?php
                        if(isset($_GET['acbe'])){
                            $dataFetch = fetchACBillDetails($conn,$_GET['acbe']);
                    ?>

                        <div class="row">
                            <form action="user.php?crdsd" method="POST" class="form-inline">

                                <div class="row">
                                    <label class="sr-only" for="datACBillDate">A/C Bill Date</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datACBillDate" name="datACBillDate" placeholder="Select A/C Bill Date" value="<?=$dataFetch['acbillDate'];?>">
                                    </div>

                                    <label class="sr-only" for="txtRep">Rep</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtRep" name="txtRep">
                                            <option selected disabled>Select Rep</option>
                                            <?php
                                                getRepForOptionInAddCustomerForEdit($conn,$dataFetch['rep']);
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
                                                showCustomerIDInOptionsForEdit($conn,$dataFetch['customerId']);
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
                                                showCustomerNamesInOptionsForEdit($conn,$dataFetch['custermerName']);
                                            ?>
                                        </select>
                                    </div>

                                    <label class="sr-only" for="txtBillNo">Bill No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtBillNo" name="txtBillNo" placeholder="Bill No" value="<?=$dataFetch['billNo'];?>" readonly>
                                    </div>

                                    <label class="sr-only" for="txtAmount">Amount</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-coins"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtAmount" name="txtAmount" placeholder="Amount" value="<?=$dataFetch['amount'];?>">
                                    </div>

                                    
                                </div>
                                <div class="row">
                                    <div class="input-group col-12">
                                        <div class="d-flex justify-content-center">
                                            <button name="btnEditACBillDetails" type="submit" class="btn btn-success mb-2 mr-sm-4">Edit</button>
                                            <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    <?php
                        }
                        else{
                    ?>

                        <div class="row">
                            <form action="user.php?crdsd" method="POST" class="form-inline">

                                <div class="row">
                                    <label class="sr-only" for="datACBillDate">A/C Bill Date</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datACBillDate" name="datACBillDate" placeholder="Select A/C Bill Date" value="<?=defaultDateSettingForCrdSale($conn);?>" required>
                                    </div>

                                    <label class="sr-only" for="txtRep">Rep</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtRep" name="txtRep">
                                            <option selected disabled>Select Rep</option>
                                            <?php
                                                showCustomerNamesInOptions($conn);
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
                                            <button name="btnAddACBillDetails" type="submit" class="btn btn-success mb-2 mr-sm-4">Add</button>
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
                                        <th>Amount</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        showACBillInProgressesInformations($conn);
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


<!-- Content Row View Creadit Sale -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header">
                    A/C Bill View 
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="user.php?crdsd&findView" method="POST" class="form-inline">

                            <div class="row">
                                <label class="sr-only" for="datACBillDateFrom">A/C Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datACBillDateFrom" name="datACBillDateFrom" placeholder="Select A/C Bill Date" value="<?=date('Y-m-d');?>" required>
                                </div>

                                <label class="sr-only" for="datACBillDateTo">A/C Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datACBillDateTo" name="datACBillDateTo" placeholder="Select A/C Bill Date" value="<?=date('Y-m-d');?>" required>
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
                                        <th>Due Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_GET['findView'])){
                                            findACBillDetails($conn,$_POST['datACBillDateFrom'],$_POST['datACBillDateTo'],$_POST['txtRep2'],$data['staffsId']);
                                        }
                                        else{
                                            showACBillAfterInProgressesInformations($conn,$data['staffsId']);
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

