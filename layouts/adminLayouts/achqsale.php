<?php

    if(isset($_POST['addChqBill'])){
        addChqBillDetails($conn,$data['staffsId'],$_POST['datChequeBillDate'],$_POST['txtRep'],$_POST['txtCustomerCode'],$_POST['txtCustomerName'],$_POST['txtBillNo'],$_POST['txtChequeNo'],$_POST['txtBank'],$_POST['datChequeDate'],$_POST['txtAmount']);
    }
    if(isset($_POST['removeChqBill'])){
        removeChqBillInProgressesInformations($conn,$_POST['removeChqBill']);
    }
    if(isset($_POST['removeAllChqBill'])){
        removeAllChqBillInProgressesInformations($conn);
    }
    if(isset($_POST['saveAllChqBill'])){
        addAllChqBillInProgressesInformations($conn,$data['staffsId']);
    }
    if(isset($_POST['deleteChqBill'])){
        deleteChqBillInformations($conn,$_POST['deleteChqBill']);
    }
    if(isset($_POST['btnEditChqBillDetails'])){
        editChqBillDetails($conn,$_POST['datChequeBillDate'],$_POST['txtRep'],$_POST['txtCustomerCode'],$_POST['txtCustomerName'],$_POST['txtBillNo'],$_POST['txtChequeNo'],$_POST['txtBank'],$_POST['datChequeDate'],$_POST['txtAmount']);
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
            <a class="dropdown-item" href="admin.php?crdsd">Credit Sales</a>
            <a class="dropdown-item active" href="admin.php?chqsd"><i class="fas fa-caret-right"></i>Cheque Sales</a>
            <a class="dropdown-item" href="admin.php?cahsd">Cash Sales</a>
            <a class="dropdown-item" href="admin.php?acbillnrepcol">A/C B in R.H To Colt</a>
            <a class="dropdown-item" href="admin.php?acbcr">A/C Bill Collections</a>
        </div>
    </div>
</div>

<!-- Content Row Add Cheque Sale -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-header">
                    <?php
                        if(isset($_GET['chqbe'])){
                            echo "Cheque Bill Edit ";
                        }
                        else{
                            echo "Cheque Bill Add ";
                        }
                    ?>
                </div>
                <div class="card-body">
                    <?php
                        if(isset($_GET['chqbe'])){
                            $dataFetch = fetchChqBillDetails($conn,$_GET['chqbe']);
                    ?>
                        <div class="row">
                            <form action="admin.php?chqsd" method="POST" class="form-inline">

                                <div class="row">
                                    <label class="sr-only" for="datChequeBillDate">Cheque Bill Date</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">Bill Date&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datChequeBillDate" name="datChequeBillDate" placeholder="Select Cheque Bill Date" value="<?=$dataFetch['chequeBillDate']?>">
                                    </div>

                                    <label class="sr-only" for="txtRep">Rep</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtRep" name="txtRep">
                                            <option selected disabled>Select Rep</option>
                                            <?php
                                                getRepForOptionInAddCustomerForEdit($conn,$dataFetch['chequeBillRep']);
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
                                                showCustomerIDInOptionsForEdit($conn,$dataFetch['chequeBillCustomerCode']);
                                            ?>
                                        </select>
                                    </div>

                                    <label class="sr-only" for="txtCustomerName">Customer Name</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtCustomerName" name="txtCustomerName">
                                            <option value="" selected disabled>Select Customer Name</option>
                                            <?php
                                                showCustomerNamesInOptionsForEdit($conn,$dataFetch['chequeBillCustomerName']);
                                            ?>
                                        </select>
                                    </div>

                                    <label class="sr-only" for="txtBillNo">Bill No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtBillNo" name="txtBillNo" placeholder="Bill No" value="<?=$dataFetch['chequeBillNo']?>">
                                    </div>

                                    <label class="sr-only" for="txtChequeNo">Cheque No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-check-alt"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtChequeNo" name="txtChequeNo" placeholder="Cheque No" value="<?=$dataFetch['chequeNo']?>" readonly>
                                    </div>

                                    <label class="sr-only" for="txtBank">Bank</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-piggy-bank"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtBank" name="txtBank" placeholder="Bank" value="<?=$dataFetch['chequeBillBank']?>">
                                    </div>

                                    <label class="sr-only" for="datChequeDate">Cheque Date</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">Cheque Date&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datChequeDate" name="datChequeDate" placeholder="Select Cheque Date" value="<?=$dataFetch['chequeDate']?>">
                                    </div>

                                    <label class="sr-only" for="txtAmount">Amount</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-coins"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtAmount" name="txtAmount" placeholder="Amount" value="<?=$dataFetch['chequeBillAmount']?>">
                                    </div>

                                    
                                </div>
                                <div class="row">
                                    <div class="input-group col-12">
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="btnEditChqBillDetails" class="btn btn-success mb-2 mr-sm-4">Edit</button>
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
                            <form action="admin.php?chqsd" method="POST" class="form-inline">

                                <div class="row">
                                    <label class="sr-only" for="datChequeBillDate">Cheque Bill Date</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">Bill Date&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datChequeBillDate" name="datChequeBillDate" placeholder="Select Cheque Bill Date" value="<?=defaultDateSettingForChqSale($conn);?>" required>
                                    </div>

                                    <label class="sr-only" for="txtRep">Rep</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                        </div>
                                        <select class="form-control select2" id="txtRep" name="txtRep">
                                            <option selected disabled>Select Rep</option>
                                            <?php
                                                defaultRepSelectedChqBill($conn);
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

                                    <label class="sr-only" for="txtChequeNo">Cheque No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-money-check-alt"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtChequeNo" name="txtChequeNo" placeholder="Cheque No">
                                    </div>

                                    <label class="sr-only" for="txtBank">Bank</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-piggy-bank"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtBank" name="txtBank" placeholder="Bank">
                                    </div>

                                    <label class="sr-only" for="datChequeDate">Cheque Date</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">Cheque Date&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datChequeDate" name="datChequeDate" placeholder="Select Cheque Date" value="<?=defaultChqDateSettingForChqSale($conn);?>">
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
                                            <button type="submit" name="addChqBill" class="btn btn-success mb-2 mr-sm-4">Add</button>
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
                                        <th>Cheque No</th>
                                        <th>Cheque Date</th>
                                        <th>Bank</th>
                                        <th>Amount</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        showChqBillInProgressesInformations($conn);
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


<!-- Content Row View Cheque Sale -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header">
                    Cheque Bill View 
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="admin.php?chqsd" method="POST" class="form-inline">

                            <div class="row">
                                <label class="sr-only" for="datChequeBillDateFrom">Cheque Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datChequeBillDateFrom" name="datChequeBillDateFrom" placeholder="Select Cheque Bill Date" value="<?=date('Y-m-d');?>" required>
                                </div>

                                <label class="sr-only" for="datChequeBillDateTo">Cheque Bill Date</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="date" class="form-control" id="datChequeBillDateTo" name="datChequeBillDateTo" placeholder="Select Cheque Bill Date" value="<?=date('Y-m-d');?>" required>
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
                                        <th>Cheque No</th>
                                        <th>Bank</th>
                                        <th>Cheque Date</th>
                                        <th>Cheque Days</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST['findView'])){
                                            findChqBillDetails($conn,$_POST['datChequeBillDateFrom'],$_POST['datChequeBillDateTo'],$_POST['txtRep2'],$data['staffsId']);
                                        }
                                        else{
                                            showChqBillAfterInProgressesInformations($conn,$data['staffsId']);
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

