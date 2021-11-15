<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ledger View</h1>
</div>

<!-- Content Row View Ledger -->
<div class="row">

    
        <div class="col-xl-12 col-md-12">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-header">
                    View Ledger
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-center">
                            <form action="user.php?ledgerview" method="POST" class="form-inline">

                                <div class="row">

                                    <label class="sr-only" for="datLedgerDateFrom"></label>
                                    <div class="input-group mb-2 col-5">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">From&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datLedgerDateFrom" name="datLedgerDateFrom" placeholder="Select Ledger Date From" value="<?=date('Y-m-d');?>" required>
                                    </div>

                                    <label class="sr-only" for="datLedgerDateTo"></label>
                                    <div class="input-group mb-2 col-5">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">To&nbsp;<i class="fas fa-calendar-alt"></i></div>
                                        </div>
                                        <input type="date" class="form-control" id="datLedgerDateTo" name="datLedgerDateTo" placeholder="Select Ledger Date To" value="<?=date('Y-m-d');?>" required>
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
                    <div class="row">
                        <div class="col-12">
                        
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tr>
                                        <th class="border-danger">Opening Balance</th>
                                        <th class="border-danger">Cash</th>
                                        <th class="border-danger">
                                            <?php
                                            
                                                if(isset($_POST['datLedgerDateFrom'])){
                                                    echo viewOpeningBalanceInCash($conn,$_POST['datLedgerDateFrom']);
                                                }
                                                else{
                                                    echo viewOpeningBalanceInCash($conn,date('Y-m-d'));
                                                }
                                            
                                            ?>
                                        </th>
                                        <th class="border-danger">Cheque</th>
                                        <th class="border-danger">
                                            <?php
                                                
                                                if(isset($_POST['datLedgerDateFrom'])){
                                                    echo viewOpeningBalanceInCheque($conn,$_POST['datLedgerDateFrom']);
                                                }
                                                else{
                                                    echo viewOpeningBalanceInCheque($conn,date('Y-m-d'));
                                                }
                                            
                                            ?>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Discription</th>
                                        <th>Cash</th>
                                        <th>Cheque</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($_POST['datLedgerDateFrom'])){
                                            viewLedgerBetweenTwoDays($conn,$_POST['datLedgerDateFrom'],$_POST['datLedgerDateTo']);
                                        }
                                        else{
                                            viewLedgerBetweenTwoDays($conn,date('Y-m-d'),date('Y-m-d'));
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
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <tr>
                                        <th class="border-success">Closing Balance</th>
                                        <th class="border-success">Cash</th>
                                        <th class="border-success">
                                            <?php
                                                if(isset($_POST['datLedgerDateTo'])){
                                                    echo viewClosingBalanceInCash($conn,$_POST['datLedgerDateTo']);
                                                }
                                                else{
                                                    echo viewClosingBalanceInCash($conn,date('Y-m-d'));
                                                }
                                            ?>
                                        </th>
                                        <th class="border-success">Cheque</th>
                                        <th class="border-success">
                                            <?php
                                                if(isset($_POST['datLedgerDateTo'])){
                                                    echo viewClosingBalanceInCheque($conn,$_POST['datLedgerDateTo']);
                                                }
                                                else{
                                                    echo viewClosingBalanceInCheque($conn,date('Y-m-d'));
                                                }
                                            ?>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

</div>
<p></p><p></p><p></p>

