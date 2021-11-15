<?php

    if(isset($_POST['btnAddStaffs'])){
        if(isset($_POST['btnAddStaffs'])){
            if(isset($_POST['txtStaffEmail'])){
                $txtStaffEmail = $_POST['txtStaffEmail'];
            }
            else{
                $txtStaffEmail = '';
            }
            if($_FILES['txtStaffPicture']['name'] && $_FILES['txtStaffPicture']['tmp_name']){
                $txtStaffPictureName = $_FILES['txtStaffPicture']['name'];
                $txtStaffPictureTmpName = $_FILES['txtStaffPicture']['tmp_name'];
            }
            else{
                $txtStaffPictureName = '';
                $txtStaffPictureTmpName = '';
            }
            addStaffsDetails($conn,$data['staffsId'],$_POST['txtStaffId'],$_POST['txtStaffName'],$_POST['txtStaffAddress'],$_POST['txtStaffNICNo'],$_POST['txtStaffPhone'],$_POST['txtStaffType'],$txtStaffPictureName,$txtStaffPictureTmpName,$txtStaffEmail);
        }
    }

    if(isset($_POST['deleteStaffId'])){
        removeStaffDetails($conn,$_POST['deleteStaffId']);
    }
    if(isset($_POST['blockStaffId'])){
        blockStaffDetails($conn,$_POST['blockStaffId']);
    }
    if(isset($_POST['activeStaffId'])){
        activeStaffDetails($conn,$_POST['activeStaffId']);
    }
    if(isset($_POST['activeStaffIdFromPending'])){
        activeStaffDetailsFromPending($conn,$_POST['activeStaffIdFromPending']);
    }

    if(isset($_POST['btnEditStaffs'])){
        if(isset($_POST['txtEditStaffEmail'])){
            $txtStaffEmail = $_POST['txtEditStaffEmail'];
        }
        else{
            $txtStaffEmail = '';
        }
        if($_FILES['txtEditStaffPicture']['name'] && $_FILES['txtEditStaffPicture']['tmp_name']){
            $txtStaffPictureName = $_FILES['txtEditStaffPicture']['name'];
            $txtStaffPictureTmpName = $_FILES['txtEditStaffPicture']['tmp_name'];
        }
        else{
            $txtStaffPictureName = '';
            $txtStaffPictureTmpName = '';
        }
        editStaffsDetails($conn,$_POST['txtEditStaffId'],$_POST['txtEditStaffName'],$_POST['txtEditStaffAddress'],$_POST['txtEditStaffNICNo'],$_POST['txtEditStaffPhone'],$_POST['txtEditStaffType'],$txtStaffPictureName,$txtStaffPictureTmpName,$txtStaffEmail);
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
            <a class="dropdown-item active" href="user.php?sd"><i class="fas fa-caret-right"></i>Staffs</a>
            <a class="dropdown-item" href="user.php?rd">Routes</a>
            <a class="dropdown-item" href="user.php?grnd">Goods Receive Note</a>
        </div>
    </div>
</div>

<!-- Content Row Add Staffs -->
<div class="row">

    <?php
        if(isset($_GET['stfid'])){
            $stfData = fetchStaffDetails($conn,$_GET['stfid']);
    ?>

        <div class="col-xl-12 col-md-12">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-header">
                    Edit Staffs
                </div>
                <div class="card-body">
                    <form action="user.php?sd" method="POST" class="form-inline" enctype="multipart/form-data">

                        <div class="row">
                            <label class="sr-only" for="txtEditStaffId">Staff ID</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-id-badge"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditStaffId" name="txtEditStaffId" placeholder="Staff ID" value="<?=$stfData['staffsId'];?>" readonly>
                            </div>

                            <label class="sr-only" for="txtEditStaffName">Name</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditStaffName" name="txtEditStaffName" placeholder="Staff Name" value="<?=$stfData['staffsName'];?>">
                            </div>

                            <label class="sr-only" for="txtEditStaffNICNo">NIC No</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-fingerprint"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditStaffNICNo" name="txtEditStaffNICNo" placeholder="Staff NIC No" value="<?=$stfData['staffsNIC'];?>">
                            </div>

                            <label class="sr-only" for="txtEditStaffAddress">Address</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                                </div>
                                <input type="text" class="form-control" id="txtEditStaffAddress" name="txtEditStaffAddress" placeholder="Staff Address" value="<?=$stfData['staffsAddress'];?>">
                            </div>

                            <label class="sr-only" for="txtEditStaffPhone">Contact No</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtEditStaffPhone" name="txtEditStaffPhone" placeholder="Staff Contact No" value="<?=$stfData['staffsContactNo'];?>">
                            </div>

                            <label class="sr-only" for="txtEditStaffType">Staff Type</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-angle-double-down"></i></div>
                                </div>
                                <select class="form-control" id="txtEditStaffType" name="txtEditStaffType" onchange="addEmailFieldInFormForCO2()">
                                    <option selected disabled>Select Staff's Type</option>
                                    <option <?=($stfData['staffsType'] == 'Rep') ? 'selected' : '';?> value="Rep">Rep</option>
                                    <option <?=($stfData['staffsType'] == 'Driver') ? 'selected' : '';?> value="Driver">Driver</option>
                                    <option <?=($stfData['staffsType'] == 'Computer Operator') ? 'selected' : '';?> value="Computer Operator">Computer Operator</option>
                                    <option <?=($stfData['staffsType'] == 'Cash Collector') ? 'selected' : '';?> value="Cash Collector">Cash Collector</option>
                                    <option <?=($stfData['staffsType'] == 'Labour') ? 'selected' : '';?> value="Labour">Labour</option>
                                </select>
                            </div>

                            <label class="sr-only" for="txtEditStaffPicture">Staff Picture</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-images"></i></div>
                                </div>
                                <input type="file" class="form-control" id="txtEditStaffPicture" name="txtEditStaffPicture" placeholder="Select Staff Picture" accept="image/*" value="<?=$stfData['staffsPicture'];?>">
                            </div>

                            <?php
                                if($stfData['staffsType'] == 'Computer Operator'){
                                    $stfLoginDetails = fetchStaffLoginDetails($conn,$stfData['staffsId']);
                            ?>
                            <label class="sr-only" for="txtEditStaffEmail">Email</label>
                            <div id="extraFit2" class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-envelope-open-text"></i></div>
                                </div>
                                <input type="email" class="form-control" id="txtEditStaffEmail" name="txtEditStaffEmail" placeholder="Staff Email" value="<?=$stfLoginDetails['email'];?>">
                            </div>
                            <?php
                                }
                                else{
                            ?>
                            <label class="sr-only" for="txtEditStaffEmail">Email</label>
                            <div id="extraFit" class="input-group mb-2 col-4">
                            </div>
                            <?php
                                }
                            ?>

                            
                        </div>
                        <div class="row">
                            <div class="input-group col-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="btnEditStaffs" class="btn btn-success mb-2 mr-sm-4">Edit</button>
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
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-header">
                    Add Staffs
                </div>
                <div class="card-body">
                    <form action="user.php?sd" method="POST" class="form-inline" enctype="multipart/form-data">

                        <div class="row">
                            <label class="sr-only" for="txtStaffId">Staff ID</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-id-badge"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtStaffId" name="txtStaffId" placeholder="Staff ID">
                            </div>

                            <label class="sr-only" for="txtStaffName">Name</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtStaffName" name="txtStaffName" placeholder="Staff Name">
                            </div>

                            <label class="sr-only" for="txtStaffNICNo">NIC No</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-fingerprint"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtStaffNICNo" name="txtStaffNICNo" placeholder="Staff NIC No">
                            </div>

                            <label class="sr-only" for="txtStaffAddress">Address</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                                </div>
                                <input type="text" class="form-control" id="txtStaffAddress" name="txtStaffAddress" placeholder="Staff Address">
                            </div>

                            <label class="sr-only" for="txtStaffPhone">Contact No</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                </div>
                                <input type="text" class="form-control" id="txtStaffPhone" name="txtStaffPhone" placeholder="Staff Contact No">
                            </div>

                            <label class="sr-only" for="txtStaffType">Staff Type</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-angle-double-down"></i></div>
                                </div>
                                <select class="form-control" id="txtStaffType" name="txtStaffType" onchange="addEmailFieldInFormForCO()">
                                    <option selected disabled>Select Staff's Type</option>
                                    <option value="Rep">Rep</option>
                                    <option value="Driver">Driver</option>
                                    <option value="Computer Operator">Computer Operator</option>
                                    <option value="Cash Collector">Cash Collector</option>
                                    <option value="Labour">Labour</option>
                                </select>
                            </div>

                            <label class="sr-only" for="txtStaffPicture">Staff Picture</label>
                            <div class="input-group mb-2 col-4">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-images"></i></div>
                                </div>
                                <input type="file" class="form-control" id="txtStaffPicture" name="txtStaffPicture" placeholder="Select Staff Picture" accept="image/*">
                            </div>

                            <label class="sr-only" for="txtStaffEmail">Email</label>
                            <div id="extraFit" class="input-group mb-2 col-4">
                            </div>

                            
                        </div>
                        <div class="row">
                            <div class="input-group col-12">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="btnAddStaffs" class="btn btn-success mb-2 mr-sm-4">Submit</button>
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
<!-- Content Row View Staff -->
<div class="row">

    
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    showStaffsDetailsForUser($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    

</div>

