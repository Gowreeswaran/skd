<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sales Reports</h1>
</div>

<!-- Content Row View Total Sale Report -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-header">
                    View Total Sale Report
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <form action="user.php?tsr" method="POST" class="form-inline">

                                <div class="row">

                                    <label class="sr-only" for="datTotalSaleReportDateFrom"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datTotalSaleReportDateFrom" name="datTotalSaleReportDateFrom" placeholder="Select Total Sale Report Date From" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <label class="sr-only" for="datTotalSaleReportDateTo"></label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datTotalSaleReportDateTo" name="datTotalSaleReportDateTo" placeholder="Select Total Sale Report Date To" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <label class="sr-only" for="txtCustomerRep">Rep</label>
                                    <div class="input-group mb-2 col-4">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-road"></i></div>
                                        </div>
                                        <select class="form-control" id="txtCustomerRep" name="txtCustomerRep">
                                            <option disabled>Select Rep</option>
                                            <option value="All" selected>All Rep</option>
                                            <?php
                                                getRepForOptionInAddCustomer($conn);
                                            ?>
                                        </select>
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
                            <table class="table table-bordered" width="100%" id="dataTable1" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>A/C</th>
                                        <th>Cash</th>
                                        <th>Cheque</th>
                                        <th>Total</option>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST['datTotalSaleReportDateFrom'])){
                                            viewBasicSaleReport($conn,$_POST['datTotalSaleReportDateFrom'],$_POST['datTotalSaleReportDateTo'],$_POST['txtCustomerRep']);
                                        }
                                        else{
                                            viewBasicSaleReport($conn,date('Y-m-d'),date('Y-m-d'),'All');
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