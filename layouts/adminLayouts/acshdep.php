<?php

    if(isset($_POST['addCashDeposite'])){
        addCashDepositeDetails($conn,$data['staffsId'],$_POST['datCashDepositeDate'],$_POST['txtAccountHoldersName'],$_POST['txtAccountNo'],$_POST['txtBankName'],$_POST['txtAmount']);
    }
    if(isset($_POST['deleteCashDeposite'])){
        deleteCashDepositeInformations($conn,$_POST['deleteCashDeposite']);
    }
    if(isset($_POST['editCashDeposite'])){
        editCashDepositeDetails($conn,$_POST['datCashDepositeDate'],$_POST['txtAccountHoldersName'],$_POST['txtAccountNo'],$_POST['txtBankName'],$_POST['txtAmount'],$_POST['cshdeid']);
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
            <a class="dropdown-item active" href="admin.php?cshdep"><i class="fas fa-caret-right"></i>Cash Deposite</a>
            <a class="dropdown-item" href="admin.php?chqdep">Cheque Deposite</a>
            <a class="dropdown-item" href="admin.php?voucher">Voucher</a>
        </div>
    </div>
</div>

<!-- Content Row Add Cash Deposite -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-header">
                    <?php
                        if(isset($_GET['cshde'])){
                            echo "Edit Cash Deposite";
                        }
                        else{
                            echo "Add Cash Deposite";
                        }
                    ?>
                </div>
                <div class="card-body">
                    <?php
                        if(isset($_GET['cshde'])){
                            $dataFetch = fetchCashDepositeDetails($conn,$_GET['cshde'])
                    ?>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <form action="admin.php?cshdep" method="POST" class="form-inline">

                                    <div class="row">

                                        <label class="sr-only" for="datCashDepositeDate"></label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="date" class="form-control" id="datCashDepositeDate" name="datCashDepositeDate" placeholder="Select Cash Bill Date" value="<?=$dataFetch['date'];?>">
                                        </div>

                                        <label class="sr-only" for="txtAccountHoldersName">Account Holders Name</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-money-check"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtAccountHoldersName" name="txtAccountHoldersName" placeholder="Account Holders Name" value="<?=$dataFetch['accountHolderName'];?>">
                                        </div>

                                        <label class="sr-only" for="txtAccountNo">Account No</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtAccountNo" name="txtAccountNo" placeholder="Account No" value="<?=$dataFetch['accountNo'];?>">
                                        </div>

                                        <label class="sr-only" for="txtBankName">Bank</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-piggy-bank"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtBankName" name="txtBankName" placeholder="Bank" value="<?=$dataFetch['bank'];?>">
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
                                                <input type="hidden" name="cshdeid" value="<?=$dataFetch['id'];?>" >
                                                <button type="submit" name="editCashDeposite" class="btn btn-success mb-2 mr-sm-4">Edit</button>
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
                                <form action="admin.php?cshdep" method="POST" class="form-inline">

                                    <div class="row">

                                        <label class="sr-only" for="datCashDepositeDate"></label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="date" class="form-control" id="datCashDepositeDate" name="datCashDepositeDate" placeholder="Select Cash Bill Date" value="<?=defaultDateSettingForCshDept($conn);?>" required>
                                        </div>

                                        <label class="sr-only" for="txtAccountHoldersName">Account Holders Name</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-money-check"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtAccountHoldersName" name="txtAccountHoldersName" placeholder="Account Holders Name">
                                        </div>

                                        <label class="sr-only" for="txtAccountNo">Account No</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtAccountNo" name="txtAccountNo" placeholder="Account No">
                                        </div>

                                        <label class="sr-only" for="txtBankName">Bank</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-piggy-bank"></i></div>
                                            </div>
                                            <input type="text" class="form-control" id="txtBankName" name="txtBankName" placeholder="Bank">
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
                                                <button type="submit" name="addCashDeposite" class="btn btn-success mb-2 mr-sm-4">Add</button>
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

<!-- Content Row View Cash Deposite -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-header">
                    View Cash Deposite
                </div>
                <div class="card-body">
                    <div class="row">
                            <form action="admin.php?cshdep" method="POST" class="form-inline">

                                    <label class="sr-only" for="datCashDepositeDateFrom"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datCashDepositeDateFrom" name="datCashDepositeDateFrom" placeholder="Select Cash Deposite Date From" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <label class="sr-only" for="datCashDepositeDateTo"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datCashDepositeDateTo" name="datCashDepositeDateTo" placeholder="Select Cash Deposite Date To" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <div class="input-group col-4">
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" name="findView" class="btn btn-success mb-2 mr-sm-4">View</button>
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
                                        
                                        if(isset($_POST['findView'])){
                                            findCashDepositeDetails($conn,$_POST['datCashDepositeDateFrom'],$_POST['datCashDepositeDateTo'],$data['staffsId']);
                                        }
                                        else{
                                            showCashDepositeAfterInProgressesInformations($conn,$data['staffsId']);
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