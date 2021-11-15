<?php
    if(isset($_POST['btnAdd'])){
        addProfitOrLoss($conn,$_POST['txtAddMonth'],$_POST['txtAddYear'],$_POST['txtType'],$_POST['txtDescription'],$_POST['txtAmount']);
    }
    if(isset($_POST['deletePLReportID'])){
        deleteProfitOrLoss($conn,$_POST['deletePLReportID']);
    }
    if(isset($_POST['btnEdit'])){
        editProfitOrLoss($conn,$_POST['txtID'],$_POST['txtType'],$_POST['txtDescription'],$_POST['txtAmount']);
    }
    
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profit</h1>
</div>

<!-- Content Row View Total Sale Report -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-header">
                    View Total Profit
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <form action="admin.php?profit" method="POST" class="form-inline">

                                <div class="row">

                                    <label class="sr-only" for="txtViewMonth">View Month</label>
                                    <div class="input-group mb-2 col-6">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-calendar-day"></i></div>
                                        </div>
                                        <select class="form-control" id="txtViewMonth" name="txtViewMonth">
                                            <option selected disabled>Select Month</option>
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

                                    <div class="input-group col-2">
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-success mb-2 mr-sm-4">View</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                    <p></p><p></p>
                    <?php
                        if(isset($_POST['txtViewMonth'])){
                            viewProfit($conn,$_POST['txtViewYear'],$_POST['txtViewMonth']);
                        }
                        else{
                            viewProfit($conn,date('Y'),date('m'));
                        }
                    ?>
                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>