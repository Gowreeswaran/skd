<?php
    if(isset($_POST['addVhrDetails'])){
        addVoucherDetails($conn,$data['staffsId'],$_POST['datVoucherDate'],$_POST['txtVoucherNo'],$_POST['txtDescription'],$_POST['txtAmount']);
    }
    if(isset($_POST['deleteVoucherDeposite'])){
        deleteVoucherInformations($conn,$_POST['deleteVoucherDeposite']);
    }
    if(isset($_POST['editVhrDetails'])){
        editVoucherDetails($conn,$_POST['datVoucherDate'],$_POST['txtVoucherNo'],$_POST['txtDescription'],$_POST['txtAmount'],$_POST['vhreid']);
    }
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ledger Data</h1>
    <div class="dropdown show">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #4e73df;">
            Types
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="user.php?cshdep">Cash Deposite</a>
            <a class="dropdown-item" href="user.php?chqdep">Cheque Deposite</a>
            <a class="dropdown-item active" href="user.php?voucher"><i class="fas fa-caret-right"></i>Voucher</a>
        </div>
    </div>
</div>

<!-- Content Row Add Voucher -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-header">
                <?php
                    if(isset($_GET['vhre'])){
                        echo "Edit Voucher";
                    }
                    else{
                        echo "Add Voucher";
                    }
                ?>
                </div>
                <div class="card-body">
                    <?php
                        if(isset($_GET['vhre'])){
                            $dataFetch = fetchVoucherDetails($conn,$_GET['vhre']);
                    ?>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <form action="user.php?voucher" method="POST" class="form-inline">

                                    <div class="row">

                                        <label class="sr-only" for="datVoucherDate"></label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="date" class="form-control" id="datVoucherDate" name="datVoucherDate" placeholder="Select Cheque Bill Date" value="<?=$dataFetch['date'];?>">
                                        </div>

                                        <label class="sr-only" for="txtVoucherNo">Voucher No</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtVoucherNo" name="txtVoucherNo" placeholder="Voucher No" value="<?=$dataFetch['voucherNo'];?>">
                                        </div>

                                        <label class="sr-only" for="txtDescription">Description</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-sticky-note"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtDescription" name="txtDescription" placeholder="Description" value="<?=$dataFetch['description'];?>">
                                        </div>

                                        <label class="sr-only" for="txtAmount">Amount</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtAmount" name="txtAmount" placeholder="Amount" value="<?=$dataFetch['amount'];?>">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="input-group col-12">
                                            <div class="d-flex justify-content-center">
                                                <input type="hidden" name="vhreid" value="<?=$dataFetch['id'];?>" >
                                                <button name="editVhrDetails" type="submit" class="btn btn-success mb-2 mr-sm-4">Edit</button>
                                                <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    <?php
                        }
                        else{
                    ?>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <form action="user.php?voucher" method="POST" class="form-inline">

                                    <div class="row">

                                        <label class="sr-only" for="datVoucherDate"></label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="date" class="form-control" id="datVoucherDate" name="datVoucherDate" placeholder="Select Cheque Bill Date" value="<?=defaultDateSettingForVoucher($conn);?>" required>
                                        </div>

                                        <label class="sr-only" for="txtVoucherNo">Voucher No</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtVoucherNo" name="txtVoucherNo" placeholder="Voucher No">
                                        </div>

                                        <label class="sr-only" for="txtDescription">Description</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-sticky-note"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtDescription" name="txtDescription" placeholder="Description">
                                        </div>

                                        <label class="sr-only" for="txtAmount">Amount</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-money-bill-wave"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtAmount" name="txtAmount" placeholder="Amount" required>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="input-group col-12">
                                            <div class="d-flex justify-content-center">
                                                <button name="addVhrDetails" type="submit" class="btn btn-success mb-2 mr-sm-4">Add</button>
                                                <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>

<!-- Content Row View Voucher -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-header">
                    View Voucher
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <form action="user.php?voucher" method="POST" class="form-inline">

                                <div class="row">

                                    <label class="sr-only" for="datVoucherDateFrom"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datVoucherDateFrom" name="datVoucherDateFrom" placeholder="Select Voucher Date From" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <label class="sr-only" for="datVoucherDateTo"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datVoucherDateTo" name="datVoucherDateTo" placeholder="Select Voucher Date To" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <label class="sr-only" for="txtVoucherNo">Voucher No</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="txtVoucherNo2" name="txtVoucherNo2" placeholder="Voucher No">
                                    </div>

                                    <div class="input-group col-4">
                                        <div class="d-flex justify-content-center">
                                            <button name="findView" type="submit" class="btn btn-success mb-2 mr-sm-4">View</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                    <p></p><p></p>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" id="dataTable1" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Voucher No</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST['findView'])){
                                            findVoucherDetails($conn,$_POST['datVoucherDateFrom'],$_POST['datVoucherDateTo'],$_POST['txtVoucherNo2'],$data['staffsId']);
                                        }
                                        else{
                                            showVoucherAfterInProgressesInformations($conn,$data['staffsId']);
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

