<?php
    if(isset($_POST['addCollectedInformation'])){
        if($_POST['txtPaymentTypes']=="Cash"){
            addACBillCollectionsDataByCash($conn,$data['staffsId'],$_POST['datColleted'],$_POST['txtBillNo2'],$_POST['txtReceptNo'],$_POST['txtPaymentTypes'],"NULL","NULL",$_POST['txtAmount']);
        }
        else{
            addACBillCollectionsDataByCash($conn,$data['staffsId'],$_POST['datColleted'],$_POST['txtBillNo2'],$_POST['txtReceptNo'],$_POST['txtPaymentTypes'],$_POST['txtChequeNo'],$_POST['txtBank'],$_POST['txtAmount']);
        }
    }
    if(isset($_POST['deleteACBillColtedDetails'])){
        deleteACBillToCollectedDetails($conn,$_POST['deleteACBillColtedDetails']);
    }
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">A/C Bills Collections</h1>
    <div class="dropdown show">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #4e73df;">
            Categories
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="user.php?crdsd">Credit Sales</a>
            <a class="dropdown-item" href="user.php?chqsd">Cheque Sales</a>
            <a class="dropdown-item" href="user.php?cahsd">Cash Sales</a>
            <a class="dropdown-item" href="user.php?acbillnrepcol">A/C B in R.H To Colt</a>
            <a class="dropdown-item active" href="user.php?acbcr"><i class="fas fa-caret-right"></i>A/C Bill Collections</a>
        </div>
    </div>
</div>

<!-- Content Row Add A/C Bill Collection -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-header">
                    Add A/C Bill Collection
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <form action="user.php?acbcr" method="POST" class="form-inline">

                                <div class="row">

                                    <label class="sr-only" for="datACBillCollectionDate">AC Bill Collection Date</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datACBillCollectionDate" name="datACBillCollectionDate" placeholder="Select AC Bill Collection Date" value="<?=date('Y-m-d');?>" requied>
                                    </div>

                                    <label class="sr-only" for="txtBillNo">Bill No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtBillNo" name="txtBillNo" placeholder="Bill No" requied>
                                    </div>

                                    <div class="input-group col-4">
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-success mb-2 mr-sm-4">View</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                    <p></p><p></p>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0" id="dataTable1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Billing Date</th>
                                        <th>Bill No</th>
                                        <th>Bill Amount</th>
                                        <th>Collected Date</th>
                                        <th>Recipt No</th>
                                        <th>Collected Amount</th>
                                        <th>Balance Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST['txtBillNo'])){ 
                                            readyToInsertACBillCollectionsData($conn,$_POST['txtBillNo']);
                                        }
                                        if(isset($_GET['abcbidv'])){ 
                                            readyToInsertACBillCollectionsData($conn,$_GET['abcbidv']);
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-12">
                        
                            <div class="table-responsive">
                                <form action="" method="POST">
                                    <table class="table table-bordered" style="border: 2px black solid;" width="100%" cellspacing="0">
                                        <tr style="border: 2px black solid;">
                                            <th>Collecting Amount</th>
                                            <th>
                                                <input type="text" class="form-control" id="txtCollectingAmount" name="txtCollectingAmount" placeholder="Collecting Amount" <?php if(isset($_POST['txtBillNo'])){ echo "value='".viewCollectingAmount($conn,$_POST['txtBillNo'])."'";}?> readonly>
                                            </th>
                                        </tr>
                                        <tr style="border: 2px black solid;">
                                            <th>Collecting Date</th>
                                            <th>
                                                <input type="date" class="form-control" id="datColleted" name="datColleted" placeholder="Collecting Date" <?php if(isset($_POST['datACBillCollectionDate'])){ echo "value='".$_POST['datACBillCollectionDate']."'";}?>>
                                            </th>
                                        </tr>
                                        <tr style="border: 2px black solid;">
                                            <th>Bill No</th>
                                            <th>
                                                <select class="form-control" name="txtBillNo2" id="txtBillNo2">
                                                    <option value="" diabled>Select Bill No</option>
                                                    <?php
                                                        if(isset($_POST['txtBillNo'])){
                                                            sltOptForACBillColt($conn,$_POST['txtBillNo']);
                                                        }
                                                    ?>
                                                </select>
                                            </th>
                                        </tr>
                                        <tr style="border: 2px black solid;">
                                            <th>Recept No</th>
                                            <th>
                                                <input type="text" class="form-control" id="txtReceptNo" name="txtReceptNo" placeholder="Recept No" required>
                                            </th>
                                        </tr>
                                        <tr style="border: 2px black solid;">
                                            <th>Payment Method</th>
                                            <th>
                                                <select class="form-control" id="txtPaymentTypes" name="txtPaymentTypes" onchange="addChequeFieldInForm()" required>
                                                    <option selected disabled>Select Payment Types</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Cheque">Cheque</option>
                                                </select>
                                            </th>
                                        </tr>
                                        <tr id="hr1" style="border: 2px black solid;">
                                        </tr>
                                        <tr id="hr2" style="border: 2px black solid;">
                                        </tr>
                                        <tr style="border: 2px black solid;">
                                            <th>Amount</th>
                                            <th>
                                                <input type="text" class="form-control" id="txtAmount" name="txtAmount" placeholder="Amount" required>
                                            </th>
                                        </tr>
                                        <tr style="border: 2px black solid;">
                                            <th colspan="2">
                                                <center>
                                                    <button name="addCollectedInformation" type="submit" class="btn btn-success mb-2 mr-sm-4">Add</button>
                                                    <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                                </center>
                                            </th>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>

<!-- Content Row View A/C Bill Collection -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header">
                    View A/C Bill Collection
                </div>
                <div class="card-body">
                    <p></p><p></p>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0" id="dataTable2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Billing Date</th>
                                        <th>Bill No</th>
                                        <th>Recipt No</th>
                                        <th>Discription</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        viewACBillCollectionSetails($conn,$data['staffsId']);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>