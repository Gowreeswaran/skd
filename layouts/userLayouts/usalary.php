<?php

    if(isset($_POST['btnCustomersDataInsert'])){
        if($_POST['txtSaffTypeInHidden'] == "Rep"){
            salaryAdding($conn,$data['staffsId'],$_POST['txtSaffIdInHidden'],$_POST['txtSaffNameInHidden'],$_POST['txtPerDayBasic'],$_POST['txtAttandance'],$_POST['txtTotalBasicSalary'],$_POST['txtComission'],$_POST['txtComissionPercentage'],$_POST['txtTotalComission'],$_POST['txtIncentive'],$_POST['txtTotalGrossSalary'],$_POST['txtSortStore'],$_POST['txtTotalAdvance'],$_POST['txtTotalDischargers'],$_POST['txtNetSalary'],$_POST['txtSalaryMonth'],$_POST['txtSalaryYear']);
        }
        else{
            salaryAdding($conn,$data['staffsId'],$_POST['txtSaffIdInHidden'],$_POST['txtSaffNameInHidden'],$_POST['txtPerDayBasic'],$_POST['txtAttandance'],$_POST['txtTotalBasicSalary'],$_POST['txtComission'],$_POST['txtComissionPercentage'],$_POST['txtTotalComission'],$_POST['txtIncentive'],$_POST['txtTotalGrossSalary'],$_POST['txtSortStore'],$_POST['txtTotalAdvance'],$_POST['txtTotalDischargers'],$_POST['txtNetSalary'],$_POST['txtSalaryMonth'],$_POST['txtSalaryYear']);
        }
    }

?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Salary Report</h1>
</div>

<!-- Content Row -->
<div class="row">
        <?php
            if(isset($_GET['vsid'])){
                $dataUser = fetchStaffDetails($conn,$_GET['vsid']);
        ?>
        <div class="col-12">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-header">
                    Add Salary Details of <?=ucwords($dataUser['staffsName'], " ") . " (" . strtoupper($_GET['vsid']) . ") ";?>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <input type="hidden" name="txtSaffIdInHidden" id="txtSaffIdInHidden" value="<?=$_GET['vsid'];?>"/>
                        <input type="hidden" name="txtSaffNameInHidden" id="txtSaffNameInHidden" value="<?=$dataUser['staffsName'];?>"/>
                        <input type="hidden" name="txtSaffTypeInHidden" id="txtSaffTypeInHidden" value="<?=$dataUser['staffsType'];?>"/>
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <tbody>
                                <tr class="table-secondary">
                                        <td>Salary Month</td>
                                        <td>
                                            <label class="sr-only" for="txtSalaryMonth">Salary Month</label>
                                            <div class="input-group mb-2 col-12">
                                                <select class="form-control" id="txtSalaryMonth" name="txtSalaryMonth">
                                                <option value="">Select Salary Month</option>
                                                <option value="01" <?=(date('m')==1)?'selected':'';?>>January</option>
                                                <option value="02" <?=(date('m')==2)?'selected':'';?>>February</option>
                                                <option value="03" <?=(date('m')==3)?'selected':'';?>>March</option>
                                                <option value="04" <?=(date('m')==4)?'selected':'';?>>April</option>
                                                <option value="05" <?=(date('m')==5)?'selected':'';?>>May</option>
                                                <option value="06" <?=(date('m')==6)?'selected':'';?>>June</option>
                                                <option value="07" <?=(date('m')==7)?'selected':'';?>>July</option>
                                                <option value="08" <?=(date('m')==8)?'selected':'';?>>August</option>
                                                <option value="09" <?=(date('m')==9)?'selected':'';?>>September</option>
                                                <option value="10" <?=(date('m')==10)?'selected':'';?>>October</option>
                                                <option value="11" <?=(date('m')==11)?'selected':'';?>>November</option>
                                                <option value="12" <?=(date('m')==12)?'selected':'';?>>December</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>Salary Year</td>
                                        <td>
                                            <label class="sr-only" for="txtSalaryYear">Salary Year</label>
                                            <div class="input-group mb-2 col-12">
                                                <select class="form-control" id="txtSalaryYear" name="txtSalaryYear">
                                                    <option disabled>Select Salary Year</option>
                                                    <option value="2020" <?=(date('Y')==2020)?'selected':'';?>>2020</option>
                                                    <option value="2021" <?=(date('Y')==2021)?'selected':'';?>>2021</option>
                                                    <option value="2022" <?=(date('Y')==2022)?'selected':'';?>>2022</option>
                                                    <option value="2023" <?=(date('Y')==2023)?'selected':'';?>>2023</option>
                                                    <option value="2024" <?=(date('Y')==2024)?'selected':'';?>>2024</option>
                                                    <option value="2025" <?=(date('Y')==2025)?'selected':'';?>>2025</option>
                                                    <option value="2026" <?=(date('Y')==2026)?'selected':'';?>>2026</option>
                                                    <option value="2027" <?=(date('Y')==2027)?'selected':'';?>>2027</option>
                                                    <option value="2028" <?=(date('Y')==2028)?'selected':'';?>>2028</option>
                                                    <option value="2029" <?=(date('Y')==2029)?'selected':'';?>>2029</option>
                                                    <option value="2030" <?=(date('Y')==2030)?'selected':'';?>>2030</option>
                                                    <option value="2031" <?=(date('Y')==2031)?'selected':'';?>>2031</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="table-success">
                                        <td>Basic Salary</td>
                                        <td>
                                            <label class="sr-only" for="txtPerDayBasic">Per Day Salary</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;" id="txtPerDayBasic" name="txtPerDayBasic" placeholder="Enter Per Day Basic" value="350.00">
                                            </div>
                                        </td>
                                        <td>
                                            <label class="sr-only" for="txtAttandance">Attandance</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;" id="txtAttandance" name="txtAttandance" placeholder="Enter Attandance" value="0">
                                            </div>
                                        </td>
                                        <td>
                                            <label class="sr-only" for="txtTotalBasicSalary">Total Basic Salary</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;color:green;" id="txtTotalBasicSalary" name="txtTotalBasicSalary" placeholder="Total Basic Salary" value="0" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                        if($dataUser['staffsType']=="Rep"){
                                    ?>
                                    <tr class="table-success">
                                        <td>Comission</td>
                                        <td>
                                            <label class="sr-only" for="txtComission">Comission</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;" id="txtComission" name="txtComission" placeholder="Enter Comission" value="<?=getCommissionForInitial($conn,$_GET['vsid']);?>">
                                            </div>
                                        </td>
                                        <td>
                                            <label class="sr-only" for="txtComissionPercentage">Comission Percentage</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;" id="txtComissionPercentage" name="txtComissionPercentage" placeholder="Enter Comission Percentage" value="1">
                                            </div>
                                        </td>
                                        <td>
                                            <label class="sr-only" for="txtTotalComission">Total Comission</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;color:green;" id="txtTotalComission" name="txtTotalComission" placeholder="Total Comission" value="0" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                        else{
                                    ?>
                                    <tr class="table-success" style="display:none;">
                                        <td>Comission</td>
                                        <td>
                                            <label class="sr-only" for="txtComission">Comission</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;" id="txtComission" name="txtComission" placeholder="Enter Comission" value="0">
                                            </div>
                                        </td>
                                        <td>
                                            <label class="sr-only" for="txtComissionPercentage">Comission Percentage</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;" id="txtComissionPercentage" name="txtComissionPercentage" placeholder="Enter Comission Percentage" value="0">
                                            </div>
                                        </td>
                                        <td>
                                            <label class="sr-only" for="txtTotalComission">Total Comission</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;color:green;" id="txtTotalComission" name="txtTotalComission" placeholder="Total Comission" value="0" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                    <tr class="table-success">
                                        <td>Incentive</td>
                                        <td colspan="3">
                                            <label class="sr-only" for="txtIncentive">Incentive</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;color:green;" id="txtIncentive" name="txtIncentive" placeholder="Enter Incentive" value="0">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Gross Salary</td>
                                        <td colspan="2">
                                            <center><font color="green">+</font></center>
                                        </td>
                                        <td>
                                            <label class="sr-only" for="txtTotalGrossSalary">Gross Salary</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;color:green;" id="txtTotalGrossSalary" name="txtTotalGrossSalary" placeholder="Total Gross Salary" value="0" readonly>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="table-danger">
                                        <td>Sort Store</td>
                                        <td colspan="3">
                                            <label class="sr-only" for="txtSortStore">Sort Store</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;color:red;" id="txtSortStore" name="txtSortStore" placeholder="Total Sort Store" value="0">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>Total Advance</td>
                                        <td colspan="3">
                                            <label class="sr-only" for="txtTotalAdvance">Total Advance</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;color:red;" id="txtTotalAdvance" name="txtTotalAdvance" placeholder="Total Advance" value="0">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>Total Dischargers</td>
                                        <td colspan="2">
                                            <center><font color="red">+</font></center>
                                        </td>
                                        <td>
                                            <label class="sr-only" for="txtTotalDischargers">Total Dischargers</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;color:red;" id="txtTotalDischargers" name="txtTotalDischargers" placeholder="Total Dischargers" value="0" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Net Salary</td>
                                        <td colspan="3">
                                            <label class="sr-only" for="txtNetSalary">Net Salary</label>
                                            <div class="input-group mb-2 col-12">
                                                <input type="text" class="form-control" style="text-align: right;color:blue;" id="txtNetSalary" name="txtNetSalary" placeholder="Net Salary" value="0" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="table-dark">
                                        <td colspan="4">
                                            <div class="input-group mb-2 col-12">
                                                <center>
                                                    <button name="btnCustomersDataInsert" type="submit" class="btn btn-success mb-2 mr-sm-4">Submit</button>
                                                    <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                                </center>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br><br><br><br><br>
        <div class="col-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-header">
                    Salary Details of <?=ucwords($dataUser['staffsName'], " ") . " (" . strtoupper($_GET['vsid']) . ") ";?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Salary Year</th>
                                    <th>Salary Month</th>
                                    <th>Basic Per Day</th>
                                    <th>Attendance</th>
                                    <th>Basic Total</th>
                                    <th>Comission Amount</th>
                                    <th>Comission Persentage</th>
                                    <th>Total Comission</th>
                                    <th>Gross Salary</th>
                                    <th>Sort Store</th>
                                    <th>Advances</th>
                                    <th>Total Discharges</th>
                                    <th>Net Salary</th>
                                    <th>Status</th>
                                    <th>Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    salaryViewing($conn,$data['staffsId'],$_GET['vsid']);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
            else{
        ?>
        <div class="col-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-header">
                    Staffs Details
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
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
                                    viewStaffsForSalary($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        ?>

</div>

