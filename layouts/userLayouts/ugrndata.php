<?php

    if(isset($_POST['btnGoodsDetailsAdd'])){
        addRouteGoodsDetails($conn,$data['staffsId'],$_POST['datInvocingDate'],$_POST['datDelevaryDate'],$_POST['txtInvocingNo'],$_POST['txtAmount'],$_POST['datChequeDate']);
    }
    if(isset($_POST['btnTargetAdd'])){
        addTargetsDetails($conn,$data['staffsId'],$_POST['txtMonth'],$_POST['txtPrimaryTarget'],$_POST['txtRDTarget']);
    }

    if(isset($_POST['btnGoodsDetailsEdit'])){
        editRouteGoodsDetails($conn,$_POST['datEditInvocingDate'],$_POST['datEditDelevaryDate'],$_POST['txtEditInvocingNo'],$_POST['txtEditAmount'],$_POST['datEditChequeDate']);
    }
    if(isset($_POST['deleteInvoinvocingNo'])){
        removeInvioceDetails($conn,$_POST['deleteInvoinvocingNo']);
    }
    if(isset($_POST['deleteTargetYear'])){
        removeTargetDetails($conn,$_POST['deleteTargetYear'],$_POST['deleteTargetMonth']);
    }
    if(isset($_POST['btnTargetEdit'])){
        editTargetsDetails($conn,$_POST['editTargetYear'],$_POST['editTargetMonth'],$_POST['txtEditPrimaryTarget'],$_POST['txtEditRDTarget']);
    }

    if(isset($_POST['clearInvoinvocingNo'])){
        makeClearInvoiceDetails($conn,$_POST['clearInvoinvocingNo']);
    }
    if(isset($_POST['notClearInvoinvocingNo'])){
        makeNotClearInvoiceDetails($conn,$_POST['notClearInvoinvocingNo']);
    }

?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Master Data</h1>
    <div class="dropdown show">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #4e73df;">
            Data
        </a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="user.php?cd">Customers</a>
            <a class="dropdown-item" href="user.php?sd">Staffs</a>
            <a class="dropdown-item" href="user.php?rd">Routes</a>
            <a class="dropdown-item active" href="user.php?grnd"><i class="fas fa-caret-right"></i>Goods Receive Note</a>
        </div>
    </div>
</div>

<?php
    if(isset($_GET['incid'])){
        $GRNData1 = fetchGRN1Details($conn,$_GET['incid']);
?>

<!-- Content Row Edit GRN -->
<div class="row">

        <div class="col-xl-12 col-md-12">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-header">
                    Goods 
                </div>
                <div class="card-body">
                    <form action="user.php?grnd" method="POST" class="form-inline">

                        <div class="row">
                            <label class="sr-only" for="datEditInvocingDate">Invocing Date</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Invocing Date&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                </div>
                                <input type="date" class="form-control" id="datEditInvocingDate" name="datEditInvocingDate" placeholder="Select Invocing Date" value="<?=$GRNData1['invoinvocingDate']?>">
                            </div>

                            <label class="sr-only" for="datEditDelevaryDate">Delevary Date</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Delevary Date&nbsp;<i class="fas fa-calendar-week"></i></div>
                                </div>
                                <input type="date" class="form-control" id="datEditDelevaryDate" name="datEditDelevaryDate" placeholder="Select Delevary Date" value="<?=$GRNData1['delevaryDate']?>">
                            </div>

                            <label class="sr-only" for="txtEditInvocingNo">Invocing No</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditInvocingNo" name="txtEditInvocingNo" placeholder="Invocing No" value="<?=$GRNData1['invoinvocingNo']?>" readonly>
                            </div>

                            <label class="sr-only" for="txtEditAmount">Amount</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-coins"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditAmount" name="txtEditAmount" placeholder="Amount" value="<?=$GRNData1['invoinvocingAmount']?>">
                            </div>

                            <label class="sr-only" for="datEditChequeDate">Cheque Date</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Cheque Date&nbsp;<i class="fas fa-calendar"></i></div>
                                </div>
                                <input type="date" class="form-control" id="datEditChequeDate" name="datEditChequeDate" placeholder="Select Cheque Date" value="<?=$GRNData1['chequeDate']?>">
                            </div>

                            
                        </div>
                        <div class="row">
                            <div class="input-group col-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="btnGoodsDetailsEdit" class="btn btn-success mb-2 mr-sm-4">Edit</button>
                                    <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>

<?php
    }
    elseif(isset($_GET['ty']) && isset($_GET['tm'])){
        $GRNData2 = fetchGRN2Details($conn,$_GET['tm'],$_GET['ty']);
?>

<!-- Content Row Edit Target -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-header">
                    Target 
                </div>
                <div class="card-body">
                    <form action="user.php?grnd" method="POST" class="form-inline">

                        <div class="row">
                            <label class="sr-only" for="txtMonth">Month</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-calendar-day"></i></div>
                                </div>
                                <select class="form-control" id="txtMonth" name="txtMonth" readonly>
                                    <option disabled>Select Month</option>
                                    <option <?=($GRNData2['targetMonth'] == 'January') ? 'selected' : '';?> value="January">January</option>
                                    <option <?=($GRNData2['targetMonth'] == 'February') ? 'selected' : '';?> value="February">February</option>
                                    <option <?=($GRNData2['targetMonth'] == 'March') ? 'selected' : '';?> value="March">March</option>
                                    <option <?=($GRNData2['targetMonth'] == 'April') ? 'selected' : '';?> value="April">April</option>
                                    <option <?=($GRNData2['targetMonth'] == 'May') ? 'selected' : '';?> value="May">May</option>
                                    <option <?=($GRNData2['targetMonth'] == 'June') ? 'selected' : '';?> value="June">June</option>
                                    <option <?=($GRNData2['targetMonth'] == 'July') ? 'selected' : '';?> value="July">July</option>
                                    <option <?=($GRNData2['targetMonth'] == 'August') ? 'selected' : '';?> value="August">August</option>
                                    <option <?=($GRNData2['targetMonth'] == 'September') ? 'selected' : '';?> value="September">September</option>
                                    <option <?=($GRNData2['targetMonth'] == 'October') ? 'selected' : '';?> value="October">October</option>
                                    <option <?=($GRNData2['targetMonth'] == 'November') ? 'selected' : '';?> value="November">November</option>
                                    <option <?=($GRNData2['targetMonth'] == 'December') ? 'selected' : '';?> value="December">December</option>
                                </select>
                            </div>

                            <label class="sr-only" for="txtEditPrimaryTarget">Primary Target</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-dot-circle"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditPrimaryTarget" name="txtEditPrimaryTarget" placeholder="Primary Target" value="<?=$GRNData2['primaryTarget'];?>">
                            </div>

                            <label class="sr-only" for="txtEditRDTarget">R/D Target</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-bullseye"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditRDTarget" name="txtEditRDTarget" placeholder="R/D Target" value="<?=$GRNData2['RDTarget'];?>">
                            </div>

                            
                        </div>
                        <div class="row">
                            <div class="input-group col-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="btnTargetEdit" class="btn btn-success mb-2 mr-sm-4">Edit</button>
                                    <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                    <input type='hidden' name='editTargetMonth' value="<?=$GRNData2['targetMonth'];?>">
                                    <input type='hidden' name='editTargetYear' value="<?=$GRNData2['targetYear'];?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>    

<?php
    }
    else{
?>

<!-- Content Row Add GRN -->
<div class="row">

        <div class="col-xl-12 col-md-12">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-header">
                    Goods 
                </div>
                <div class="card-body">
                    <form action="user.php?grnd" method="POST" class="form-inline">

                        <div class="row">
                            <label class="sr-only" for="datInvocingDate">Invocing Date</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Invocing Date&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                </div>
                                <input type="date" class="form-control" id="datInvocingDate" name="datInvocingDate" placeholder="Select Invocing Date" value="<?=date('Y-m-d');?>" required>
                            </div>

                            <label class="sr-only" for="datDelevaryDate">Delevary Date</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Delevary Date&nbsp;<i class="fas fa-calendar-week"></i></div>
                                </div>
                                <input type="date" class="form-control" id="datDelevaryDate" name="datDelevaryDate" placeholder="Select Delevary Date" value="<?=date('Y-m-d');?>" required>
                            </div>

                            <label class="sr-only" for="txtInvocingNo">Invocing No</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-sort-numeric-down"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtInvocingNo" name="txtInvocingNo" placeholder="Invocing No">
                            </div>

                            <label class="sr-only" for="txtAmount">Amount</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-coins"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtAmount" name="txtAmount" placeholder="Amount" required>
                            </div>

                            <label class="sr-only" for="datChequeDate">Cheque Date</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Cheque Date&nbsp;<i class="fas fa-calendar"></i></div>
                                </div>
                                <input type="date" class="form-control" id="datChequeDate" name="datChequeDate" placeholder="Select Cheque Date" value="<?=date('Y-m-d');?>" required>
                            </div>

                            
                        </div>
                        <div class="row">
                            <div class="input-group col-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="btnGoodsDetailsAdd" class="btn btn-success mb-2 mr-sm-4">Submit</button>
                                    <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>


<!-- Content Row Add Target -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-header">
                    Target 
                </div>
                <div class="card-body">
                    <form action="user.php?grnd" method="POST" class="form-inline">

                        <div class="row">
                            <label class="sr-only" for="txtMonth">Month</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-calendar-day"></i></div>
                                </div>
                                <select class="form-control" id="txtMonth" name="txtMonth">
                                    <option selected disabled>Select Month</option>
                                    <option value="January" <?=(date('m') == '01') ? 'selected' : '';?>>January</option>
                                    <option value="February" <?=(date('m') == '02') ? 'selected' : '';?>>February</option>
                                    <option value="March" <?=(date('m') == '03') ? 'selected' : '';?>>March</option>
                                    <option value="April" <?=(date('m') == '04') ? 'selected' : '';?>>April</option>
                                    <option value="May" <?=(date('m') == '05') ? 'selected' : '';?>>May</option>
                                    <option value="June" <?=(date('m') == '06') ? 'selected' : '';?>>June</option>
                                    <option value="July" <?=(date('m') == '07') ? 'selected' : '';?>>July</option>
                                    <option value="August" <?=(date('m') == '08') ? 'selected' : '';?>>August</option>
                                    <option value="September" <?=(date('m') == '09') ? 'selected' : '';?>>September</option>
                                    <option value="October" <?=(date('m') == '10') ? 'selected' : '';?>>October</option>
                                    <option value="November" <?=(date('m') == '11') ? 'selected' : '';?>>November</option>
                                    <option value="December" <?=(date('m') == '12') ? 'selected' : '';?>>December</option>
                                </select>
                            </div>

                            <label class="sr-only" for="txtPrimaryTarget">Primary Target</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-dot-circle"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtPrimaryTarget" name="txtPrimaryTarget" placeholder="Primary Target">
                            </div>

                            <label class="sr-only" for="txtRDTarget">R/D Target</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-bullseye"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtRDTarget" name="txtRDTarget" placeholder="R/D Target">
                            </div>

                            
                        </div>
                        <div class="row">
                            <div class="input-group col-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="btnTargetAdd" class="btn btn-success mb-2 mr-sm-4">Submit</button>
                                    <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>          

<?php
    }
?>


<!-- Content Row Add Target -->
<div class="row" style="width: 100%;">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-warning shadow h-100 py-2" style="width: 100%;">
                <div class="card-header">
                    Target 
                </div>
                <div class="card-body">
                    <form action="user.php?grnd" method="POST" class="form-inline">
                        <div class="row">
                                <label class="sr-only" for="txtViewMonth">View Month</label>
                                <div class="input-group mb-2 col-6">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-calendar-day"></i></div>
                                    </div>
                                    <select class="form-control" id="txtViewMonth" name="txtViewMonth">
                                        <option selected disabled>Select Month</option>
                                        <option value="01" <?=(date('m') == '01') ? 'selected' : '';?>>January</option>
                                        <option value="02" <?=(date('m') == '02') ? 'selected' : '';?>>February</option>
                                        <option value="03" <?=(date('m') == '03') ? 'selected' : '';?>>March</option>
                                        <option value="04" <?=(date('m') == '04') ? 'selected' : '';?>>April</option>
                                        <option value="05" <?=(date('m') == '05') ? 'selected' : '';?>>May</option>
                                        <option value="06" <?=(date('m') == '06') ? 'selected' : '';?>>June</option>
                                        <option value="07" <?=(date('m') == '07') ? 'selected' : '';?>>July</option>
                                        <option value="08" <?=(date('m') == '08') ? 'selected' : '';?>>August</option>
                                        <option value="09" <?=(date('m') == '09') ? 'selected' : '';?>>September</option>
                                        <option value="10" <?=(date('m') == '10') ? 'selected' : '';?>>October</option>
                                        <option value="11" <?=(date('m') == '11') ? 'selected' : '';?>>November</option>
                                        <option value="12" <?=(date('m') == '12') ? 'selected' : '';?>>December</option>
                                    </select>
                                </div>

                                <label class="sr-only" for="txtViewYear">View Year</label>
                                <div class="input-group mb-2 col-6">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-calendar-day"></i></div>
                                    </div>
                                    <select class="form-control" id="txtViewYear" name="txtViewYear">
                                        <option disabled>Select Year</option>
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

                                <button type="submit" name="btnGRNView" class="btn btn-success mb-2 mr-sm-4">Submit</button>
                                <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                        </div>  
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bill Date</th>
                                    <th>Delevery Date</th>
                                    <th>Invoice No</th>
                                    <th>Amount</th>
                                    <th>Cheque Date</th>
                                    <td>Operations</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($_POST['btnGRNView'])){
                                        showGRNDetails($conn,$_POST['txtViewMonth'],$_POST['txtViewYear']);
                                    }
                                    else{
                                        showGRNDetails($conn,date('m'),date('Y'));
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">

                        <?php
                            if(isset($_POST['btnGRNView'])){
                                showPTAndRDT($conn,$_POST['txtViewMonth'],$_POST['txtViewYear']);
                            }
                            else{
                                showPTAndRDT($conn,date('m'),date('Y'));
                            }
                        ?>

                    </div>

                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>

