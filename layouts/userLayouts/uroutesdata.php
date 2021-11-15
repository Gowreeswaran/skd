<?php

    if(isset($_POST['btnRouteAdd'])){
        addRouteDetails($conn,$data['staffsId'],$_POST['txtRouteId'],$_POST['txtRouteName'],$_POST['txtRouteItenary'],$_POST['txtRouteTown'],$_POST['txtRouteNoOfShop'],$_POST['txtRouteRef'],$_POST['txtRouteNoOfFC']);
    }
    if(isset($_POST['deleteRouteId'])){
        removeRouteDetails($conn,$_POST['deleteRouteId']);
    }
    if(isset($_POST['blockRouteId'])){
        blockRouteDetails($conn,$_POST['blockRouteId']);
    }
    if(isset($_POST['activeRouteId'])){
        activeRouteDetails($conn,$_POST['activeRouteId']);
    }
    if(isset($_POST['activeRouteIdFromPending'])){
        activeRouteDetailsFromPending($conn,$_POST['activeRouteIdFromPending']);
    }
    if(isset($_POST['btnRouteEdit'])){
        editRouteDetails($conn,$_POST['txtEditRouteId'],$_POST['txtEditRouteName'],$_POST['txtEditRouteItenary'],$_POST['txtEditRouteTown'],$_POST['txtEditRouteNoOfShop'],$_POST['txtEditRouteRef'],$_POST['txtEditRouteNoOfFC']);
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
            <a class="dropdown-item" href="user.php?sd">Routes</a>
            <a class="dropdown-item active" href="user.php?rd"><i class="fas fa-caret-right"></i>Routes</a>
            <a class="dropdown-item" href="user.php?grnd">Goods Receive Note</a>
        </div>
    </div>
</div>

<!-- Content Row Add Routes -->
<div class="row">

    <?php
        if(isset($_GET['rutid'])){
            $rutData = fetchRouteDetails($conn,$_GET['rutid']);
    ?>

        <div class="col-xl-12 col-md-12">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-header">
                    Edit Route
                </div>
                <div class="card-body">
                    <form action="user.php?rd" method="POST" class="form-inline">

                        <div class="row">
                            <label class="sr-only" for="txtEditRouteId">Route ID</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditRouteId" name="txtEditRouteId" placeholder="Route ID" value="<?=$rutData['routeId'];?>" readonly>
                            </div>

                            <label class="sr-only" for="txtEditRouteName">Name</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-road"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditRouteName" name="txtEditRouteName" placeholder="Route Name" value="<?=$rutData['routeName'];?>">
                            </div>

                            <label class="sr-only" for="txtEditRouteItenary">Itenary</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-map"></i></div>
                                </div>
                                <select class="form-control" id="txtEditRouteItenary" name="txtEditRouteItenary">
                                    <option disabled>Select Route's Itenary</option>
                                    <option <?=($rutData['routeItenary'] == '1/7') ? 'selected' : '';?> value="1/7">1/7</option>
                                    <option <?=($rutData['routeItenary'] == '1/14') ? 'selected' : '';?> value="1/14">1/14</option>
                                    <option <?=($rutData['routeItenary'] == '1/30') ? 'selected' : '';?> value="1/30">1/30</option>
                                </select>
                            </div>

                            <label class="sr-only" for="txtEditRouteTown">Town</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-route"></i></div>
                                </div>
                                <select class="form-control" id="txtEditRouteTown" name="txtEditRouteTown">
                                    <option disabled>Select Route's Town</option>
                                    <option <?=($rutData['routeTown'] == 'Kilinochchi') ? 'selected' : '';?> value="Kilinochchi">Kilinochchi</option>
                                    <option <?=($rutData['routeTown'] == 'Mullaitivu') ? 'selected' : '';?> value="Mullaitivu">Mullaitivu</option>
                                    <option <?=($rutData['routeTown'] == 'Mannar') ? 'selected' : '';?> value="Mannar">Mannar</option>
                                    <option <?=($rutData['routeTown'] == 'Vavuniya') ? 'selected' : '';?> value="Vavuniya">Vavuniya</option>
                                </select>
                            </div>

                            <label class="sr-only" for="txtEditRouteNoOfShop">No of Shops</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">#</div>
                                </div>
                                <input type="text" class="form-control" id="txtEditRouteNoOfShop" name="txtEditRouteNoOfShop" placeholder="No of Shops" value="<?=$rutData['routeNoOfShops'];?>">
                            </div>

                            <label class="sr-only" for="txtEditRouteRef">Ref</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <select class="form-control" id="txtEditRouteRef" name="txtEditRouteRef">
                                    <option disabled>Select Route's Rep</option>
                                    <?php
                                        getRepForOptionInEditRoute($conn,$rutData['routeRep']);
                                    ?>
                                </select>
                            </div>

                            <label class="sr-only" for="txtEditRouteNoOfFC">No of FC</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-ice-cream"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditRouteNoOfFC" name="txtEditRouteNoOfFC" placeholder="No of FC" value="<?=$rutData['routeNoOfFC'];?>">
                            </div>

                            
                        </div>
                        <div class="row">
                            <div class="input-group col-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="btnRouteEdit" class="btn btn-success mb-2 mr-sm-4">Edit</button>
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
        else{
    ?>

        <div class="col-xl-12 col-md-12">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-header">
                    Add Route
                </div>
                <div class="card-body">
                    <form action="user.php?rd" method="POST" class="form-inline">

                        <div class="row">
                            <label class="sr-only" for="txtRouteId">Route ID</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtRouteId" name="txtRouteId" placeholder="Route ID">
                            </div>

                            <label class="sr-only" for="txtRouteName">Name</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-road"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtRouteName" name="txtRouteName" placeholder="Route Name">
                            </div>

                            <label class="sr-only" for="txtRouteItenary">Itenary</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-map"></i></div>
                                </div>
                                <select class="form-control" id="txtRouteItenary" name="txtRouteItenary">
                                    <option selected disabled>Select Route's Itenary</option>
                                    <option value="1//7">1/7</option>
                                    <option value="1//14">1/14</option>
                                    <option value="1//30">1/30</option>
                                </select>
                            </div>

                            <label class="sr-only" for="txtRouteTown">Town</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-route"></i></div>
                                </div>
                                <select class="form-control" id="txtRouteTown" name="txtRouteTown">
                                    <option selected disabled>Select Route's Town</option>
                                    <option value="Kilinochchi">Kilinochchi</option>
                                    <option value="Mullaitivu">Mullaitivu</option>
                                    <option value="Mannar">Mannar</option>
                                    <option value="Vavuniya">Vavuniya</option>
                                </select>
                            </div>

                            <label class="sr-only" for="txtRouteNoOfShop">No of Shops</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">#</div>
                                </div>
                                <input type="text" class="form-control" id="txtRouteNoOfShop" name="txtRouteNoOfShop" placeholder="No of Shops">
                            </div>

                            <label class="sr-only" for="txtRouteRef">Ref</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <select class="form-control" id="txtRouteRef" name="txtRouteRef">
                                    <option selected disabled>Select Route's Rep</option>
                                    <?php
                                        getRepForOptionInAddCustomer($conn);
                                    ?>
                                </select>
                            </div>

                            <label class="sr-only" for="txtRouteNoOfFC">No of FC</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-ice-cream"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtRouteNoOfFC" name="txtRouteNoOfFC" placeholder="No of FC">
                            </div>

                            
                        </div>
                        <div class="row">
                            <div class="input-group col-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="btnRouteAdd" class="btn btn-success mb-2 mr-sm-4">Submit</button>
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
<!-- Content Row View Route -->
<div class="row">

    
        <div class="col-12">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-header">
                    Route Details
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Route ID</th>
                                    <th>Route Name</th>
                                    <th>Itenary</th>
                                    <th>Town</th>
                                    <th>No of Shops</th>
                                    <th>Ref</th>
                                    <th>No of FC</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    showRoutesDetailsForUser($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    

</div>



