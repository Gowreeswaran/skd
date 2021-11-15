<?php

    if(isset($_POST['btnCustomersDataInsert'])){
        addCustomersDetails($conn,$data['staffsId'],$_POST['txtCustomerId'],$_POST['txtCustomerName'],$_POST['txtCustomerAddress'],$_POST['txtCustomerPhone'],$_POST['txtCustomerType'],$_POST['txtCustomerFrezerType'],$_POST['txtCustomerRoute'],$_POST['txtCustomerRep']);
    }
    if(isset($_POST['btnCustomersDataEdit'])){
        editCustomersDetails($conn,$_POST['txtCustomerId'],$_POST['txtCustomerName'],$_POST['txtCustomerAddress'],$_POST['txtCustomerPhone'],$_POST['txtCustomerType'],$_POST['txtCustomerFrezerType'],$_POST['txtCustomerRoute'],$_POST['txtCustomerRep']);
    }
    if(isset($_POST['deleteCustomerId'])){
        removeCustomerDetails($conn,$_POST['deleteCustomerId']);
    }
    if(isset($_POST['blockCustomerId'])){
        blockCustomerDetails($conn,$_POST['blockCustomerId']);
    }
    if(isset($_POST['activeCustomerId'])){
        activeCustomerDetails($conn,$_POST['activeCustomerId']);
    }
    if(isset($_POST['activeCustomerIdFromPending'])){
        activeCustomerDetailsFromPending($conn,$_POST['activeCustomerIdFromPending']);
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
            <a class="dropdown-item active" href="admin.php?cd"><i class="fas fa-caret-right"></i>Customers</a>
            <a class="dropdown-item" href="admin.php?sd">Staffs</a>
            <a class="dropdown-item" href="admin.php?rd">Routes</a>
            <a class="dropdown-item" href="admin.php?grnd">Goods Receive Note</a>
        </div>
    </div>
</div>

<!-- Content Row Add Customer -->
<?php
    if(isset($_GET['vcid'])){
        $cstData = fetchCustomerDetails($conn,$_GET['vcid']);
?>
    <div class="row">

        <div class="col-12">
            <div class="row">
                <div class="col-12">

                </div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-header">
                    Customers Full Details of <?=ucwords($cstData['name'], " ") . " (" . strtoupper($_GET['vcid'])  . ") ";?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Bill No</th>
                                    <th>A/C</th>
                                    <th>Collected</th>
                                    <th>Balance</th>
                                    <th>Cash</th>
                                    <th>Cheque</th>
                                    <th>Due Date</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //showCustomersDetails($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
<?php
    }else{
?>
    <div class="row">

        <?php
        
            if(isset($_GET['cstid'])){
                $cstData = fetchCustomerDetails($conn,$_GET['cstid']);
                
        ?>

            <div class="col-xl-12 col-md-12">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header">
                        Edit Customer
                    </div>
                    <div class="card-body">
                        <form action="admin.php?cd" method="POST" class="form-inline">

                            <div class="row">
                                <label class="sr-only" for="txtCustomerId">Customer ID</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-id-badge"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="txtCustomerId" name="txtCustomerId" readonly value="<?=$cstData['customerId'];?>">
                                </div>

                                <label class="sr-only" for="txtCustomerName">Name</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="txtCustomerName" name="txtCustomerName" value="<?=$cstData['name'];?>">
                                </div>

                                <label class="sr-only" for="txtCustomerAddress">Address</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                    </div>
                                    <input type="text" class="form-control" id="txtCustomerAddress" name="txtCustomerAddress" value="<?=$cstData['address'];?>">
                                </div>

                                <label class="sr-only" for="txtCustomerPhone">Contact No</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="txtCustomerPhone" name="txtCustomerPhone" value="<?=$cstData['contactNo'];?>">
                                </div>

                                <label class="sr-only" for="txtCustomerType">Shop Type</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-angle-double-down"></i></div>
                                    </div>
                                    <select class="form-control" id="txtCustomerType" name="txtCustomerType">
                                        <option disabled>Select Shop Type</option>
                                        <option <?=($cstData['shopType'] == 'Hotel') ? 'selected' : '';?> value="Hotel">Hotel</option>
                                        <option <?=($cstData['shopType'] == 'Super Market') ? 'selected' : '';?> value="Super Market">Super Market</option>
                                        <option <?=($cstData['shopType'] == 'Gerosary') ? 'selected' : '';?> value="Gerosary">Gerosary</option>
                                        <option <?=($cstData['shopType'] == 'Cool Bar') ? 'selected' : '';?> value="Cool Bar">Cool Bar</option>
                                        <option <?=($cstData['shopType'] == 'Other') ? 'selected' : '';?> value="Other">Other</option>
                                    </select>
                                </div>

                                <label class="sr-only" for="txtCustomerFrezerType">Frezer Type</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-ice-cream"></i></div>
                                    </div>
                                    <select class="form-control" id="txtCustomerFrezerType" name="txtCustomerFrezerType">
                                        <option disabled>Select Frezer Type</option>
                                        <option <?=($cstData['frezerType'] == 'Hard Top') ? 'selected' : '';?> value="Hard Top">Hard Top</option>
                                        <option <?=($cstData['frezerType'] == 'FC') ? 'selected' : '';?> value="FC">FC</option>
                                        <option <?=($cstData['frezerType'] == 'Double Door') ? 'selected' : '';?> value="Double Door">Double Door</option>
                                    </select>
                                </div>

                                <label class="sr-only" for="txtCustomerRoute">Route</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-road"></i></div>
                                    </div>
                                    <select class="form-control" id="txtCustomerRoute" name="txtCustomerRoute">
                                        <option disabled>Select Route</option>
                                        <?php
                                            getRouteForOptionInAddCustomerForEdit($conn,$cstData['route']);
                                        ?>
                                    </select>
                                </div>

                                <label class="sr-only" for="txtCustomerRep">Rep</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-road"></i></div>
                                    </div>
                                    <select class="form-control" id="txtCustomerRep" name="txtCustomerRep">
                                        <option disabled>Select Rep</option>
                                        <?php
                                            getRepForOptionInAddCustomerForEdit($conn,$cstData['rep']);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group col-12">
                                    <div class="d-flex justify-content-center">
                                        <button name="btnCustomersDataEdit" type="submit" class="btn btn-success mb-2 mr-sm-4">Edit</button>
                                        <a href="admin.php?cd" class="btn btn-danger mb-2 mr-sm-4">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
        <?php
            }
            else{
        
        ?>
            <div class="col-xl-12 col-md-12">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-header">
                        Add Customer
                    </div>
                    <div class="card-body">
                        <form action="admin.php?cd" method="POST" class="form-inline">

                            <div class="row">
                                <label class="sr-only" for="txtCustomerId">Customer ID</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-id-badge"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="txtCustomerId" name="txtCustomerId" placeholder="Customer ID">
                                </div>

                                <label class="sr-only" for="txtCustomerName">Name</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="txtCustomerName" name="txtCustomerName" placeholder="Customer Name">
                                </div>

                                <label class="sr-only" for="txtCustomerAddress">Address</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text">@</div>
                                    </div>
                                    <input type="text" class="form-control" id="txtCustomerAddress" name="txtCustomerAddress" placeholder="Customer Address">
                                </div>

                                <label class="sr-only" for="txtCustomerPhone">Contact No</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="txtCustomerPhone" name="txtCustomerPhone" placeholder="Customer Contact No">
                                </div>

                                <label class="sr-only" for="txtCustomerType">Shop Type</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-angle-double-down"></i></div>
                                    </div>
                                    <select class="form-control" id="txtCustomerType" name="txtCustomerType">
                                        <option selected disabled>Select Shop Type</option>
                                        <option value="Hotel">Hotel</option>
                                        <option value="Super Market">Super Market</option>
                                        <option value="Gerosary">Gerosary</option>
                                        <option value="Cool Bar">Cool Bar</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <label class="sr-only" for="txtCustomerFrezerType">Frezer Type</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-ice-cream"></i></div>
                                    </div>
                                    <select class="form-control" id="txtCustomerFrezerType" name="txtCustomerFrezerType">
                                        <option selected disabled>Select Frezer Type</option>
                                        <option value="Hard Top">Hard Top</option>
                                        <option value="FC">FC</option>
                                        <option value="Double Door">Double Door</option>
                                    </select>
                                </div>

                                <label class="sr-only" for="txtCustomerRoute">Route</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-road"></i></div>
                                    </div>
                                    <select class="form-control" id="txtCustomerRoute" name="txtCustomerRoute">
                                        <option selected disabled>Select Route</option>
                                        <?php
                                            getRouteForOptionInAddCustomer($conn);
                                        ?>
                                    </select>
                                </div>

                                <label class="sr-only" for="txtCustomerRep">Rep</label>
                                <div class="input-group mb-2 col-4">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-road"></i></div>
                                    </div>
                                    <select class="form-control" id="txtCustomerRep" name="txtCustomerRep">
                                        <option selected disabled>Select Rep</option>
                                        <?php
                                            getRepForOptionInAddCustomer($conn);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-group col-12">
                                    <div class="d-flex justify-content-center">
                                        <button name="btnCustomersDataInsert" type="submit" class="btn btn-success mb-2 mr-sm-4">Submit</button>
                                        <button type="reset" class="btn btn-danger mb-2 mr-sm-4">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        

    </div>
    <p></p><p></p><p></p>
    <!-- Content Row View Customer -->
    <div class="row">

        
            <div class="col-12">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-header">
                        Customers Details
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer ID</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Contact No</th>
                                        <th>Shop Type</th>
                                        <th>Frezer Type</th>
                                        <th>Route</th>
                                        <th>Rep</th>
                                        <th>Status</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        showCustomersDetails($conn);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        

    </div>
<?php
    }
?>
