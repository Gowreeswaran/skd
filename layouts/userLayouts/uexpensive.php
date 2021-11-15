<?php
    if(isset($_POST['addExpenses'])){
        addExpensivesDetails($conn,$data['staffsId'],$_POST['datExpensesDate'],$_POST['txtExpensesTypes'],$_POST['txtAmount']);
    }
    if(isset($_POST['deleteExpensives'])){
        deleteExpensivesInformations($conn,$_POST['deleteExpensives']);
    }
    if(isset($_POST['editExpenses'])){
        editExpensivesDetails($conn,$_POST['datExpensesDate'],$_POST['txtExpensesTypes'],$_POST['txtAmount'],$_POST['expe']);
    }
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Expenses</h1>
</div>

<!-- Content Row Add Expenses -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-header">
                <?php
                    if(isset($_GET['expe'])){
                        echo "Edit Expenses";
                    }
                    else{
                        echo "Add Expenses";
                    }
                ?>
                </div>
                <div class="card-body">
                    <?php
                        if(isset($_GET['expe'])){
                            $dataFetch = fetchExpensivesDetails($conn,$_GET['expe']);
                    ?>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <form action="user.php?expensive" method="POST" class="form-inline">

                                    <div class="row">

                                        <label class="sr-only" for="datExpensesDate"></label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="date" class="form-control" id="datExpensesDate" name="datExpensesDate" placeholder="Select Cheque Bill Date" value="<?=$dataFetch['date'];?>">
                                        </div>

                                        <label class="sr-only" for="txtExpensesTypes">Expenses Types</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                            </div>
                                            <select class="form-control" id="txtExpensesTypes" name="txtExpensesTypes">
                                                <option disabled>Select Expenses Types</option>
                                                <option <?=($dataFetch['type'] == "CEB") ? "selected" : "";?> value="CEB">CEB</option>
                                                <option <?=($dataFetch['type'] == "TP") ? "selected" : "";?> value="TP">TP</option>
                                                <option <?=($dataFetch['type'] == "Diesel V1") ? "selected" : "";?> value="Diesel V1">Diesel V1</option>
                                                <option <?=($dataFetch['type'] == "Diesel V2") ? "selected" : "";?> value="Diesel V2">Diesel V2</option>
                                                <option <?=($dataFetch['type'] == "Rent") ? "selected" : "";?> value="Rent">Rent</option>
                                                <option <?=($dataFetch['type'] == "Vehicle") ? "selected" : "";?> value="Vehicle">Vehicle</option>
                                                <option <?=($dataFetch['type'] == "Salary") ? "selected" : "";?> value="Salary">Salary</option>
                                                <option <?=($dataFetch['type'] == "Office Expensive") ? "selected" : "";?> value="Office Expensive">Office Expensive</option>
                                                <option <?=($dataFetch['type'] == "Other") ? "selected" : "";?> value="Other">Other</option>
                                            </select>
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
                                                <input type="hidden" name="expe" value="<?=$dataFetch['id'];?>">
                                                <button name="editExpenses" type="submit" class="btn btn-success mb-2 mr-sm-4">Edit</button>
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
                                <form action="user.php?expensive" method="POST" class="form-inline">

                                    <div class="row">

                                        <label class="sr-only" for="datExpensesDate"></label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                            </div>
                                            <input type="date" class="form-control" id="datExpensesDate" name="datExpensesDate" placeholder="Select Cheque Bill Date" value="<?=date('Y-m-d');?>" required>
                                        </div>

                                        <label class="sr-only" for="txtExpensesTypes">Expenses Types</label>
                                        <div class="input-group mb-2 col-4">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                            </div>
                                            <select class="form-control" id="txtExpensesTypes" name="txtExpensesTypes">
                                                <option selected disabled>Select Expenses Types</option>
                                                <option value="CEB">CEB</option>
                                                <option value="TP">TP</option>
                                                <option value="Diesel V1">Diesel V1</option>
                                                <option value="Diesel V2">Diesel V1</option>
                                                <option value="Rent">Rent</option>
                                                <option value="Vehicle">Vehicle</option>
                                                <option value="Salary">Salary</option>
                                                <option value="Office Expensive">Office Expensive</option>
                                                <option value="Other">Other</option>
                                            </select>
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
                                                <button name="addExpenses" type="submit" class="btn btn-success mb-2 mr-sm-4">Add</button>
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

<!-- Content Row View Expenses -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-header">
                    View Expenses
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <form action="user.php?expensive" method="POST" class="form-inline">

                                <div class="row">

                                    <label class="sr-only" for="datExpensesDateFrom"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datExpensesDateFrom" name="datExpensesDateFrom" placeholder="Select Expenses Date From" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <label class="sr-only" for="datExpensesDateTo"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datExpensesDateTo" name="datExpensesDateTo" placeholder="Select Expenses Date To" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <label class="sr-only" for="txtExpensesTypes2">Expenses Types</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user-tie"></i></div>
                                        </div>
                                        <select class="form-control" id="txtExpensesTypes2" name="txtExpensesTypes2">
                                            <option selected disabled>Select Expenses Types</option>
                                            <option value="CEB">CEB</option>
                                            <option value="TP">TP</option>
                                            <option value="Diesel V1">Diesel V1</option>
                                            <option value="Diesel V2">Diesel V1</option>
                                            <option value="Rent">Rent</option>
                                            <option value="Vehicle">Vehicle</option>
                                            <option value="Salary">Salary</option>
                                            <option value="Office Expensive">Office Expensive</option>
                                            <option value="Other">Other</option>
                                        </select>
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
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST['findView'])){
                                            findExpensivesDetails($conn,$_POST['datExpensesDateFrom'],$_POST['datExpensesDateTo'],$_POST['txtExpensesTypes2'],$data['staffsId']);
                                        }
                                        else{
                                            showExpensivesAfterInProgressesInformations($conn,$data['staffsId']);
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

