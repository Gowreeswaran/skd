<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php

    function checkUsersPasswordAndId($conn,$txtUserId,$txtPassword){
        $txtHashedPwd = md5($txtPassword);
        $isUserAvailable = false;
        if (strpos($txtUserId, '@') > 0) {
            $sql = "SELECT * FROM `tbllogin` WHERE email='".$txtUserId."' AND password='".$txtHashedPwd ."'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==1){
                $isUserAvailable = true;
            }
            else{
                $isUserAvailable = false;
            }
        }
        else{
            $sql = "SELECT * FROM `tbllogin` WHERE staffsId='".$txtUserId."' AND password='".$txtHashedPwd ."'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)==1){
                $isUserAvailable = true;
            }
            else{
                $isUserAvailable = false;
            }
        }
        return $isUserAvailable;
    }

    function fetchUsersLoginDetails($conn,$txtUserId){
        if (strpos($txtUserId, '@') !== false) {
            $sql = "SELECT * FROM `tbllogin` WHERE email='".$txtUserId."'";
            $result = mysqli_query($conn,$sql);
            $data = $result->fetch_assoc();
            return $data;
        }
        else{
            $sql = "SELECT * FROM `tbllogin` WHERE staffsId='".$txtUserId."'";
            $result = mysqli_query($conn,$sql);
            $data = $result->fetch_assoc();
            return $data;
        }
    }

    function login($conn,$txtUserId,$txtPassword){
        $isUserAvailable = checkUsersPasswordAndId($conn,$txtUserId,$txtPassword);
        if($isUserAvailable){
            $data = fetchUsersLoginDetails($conn,$txtUserId);
            $_SESSION['txtUserId'] = $txtUserId;
            if($data['type']=='admin'){
                header('Location: admin.php');
            }
            if($data['type']=='user'){
                header('Location: user.php');
            }
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Email or Password is wrong!',icon: 'error',button: false, timer: 1000});},25);
                </script> ";
        }
    }

    function chkCustomerAvailable($conn,$txtCustomerId){
        $sql = "SELECT * FROM `tblcustomers` WHERE customerId='".$txtCustomerId."'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)==1){
            $isCustomerAvailable = false;
        }
        else{
            $isCustomerAvailable = true;
        }
        return $isCustomerAvailable;
    }

    function addCustomersDetails($conn,$txtUserId,$txtCustomerId,$txtCustomerName,$txtCustomerAddress,$txtCustomerContactNo,$txtCustomerShopType,$txtCustomerFrezerType,$txtCustomerRoute,$txtCustomerRep){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        $isCustomerAvailable = chkCustomerAvailable($conn,$txtCustomerId);
        if($isCustomerAvailable){
            $sql = "INSERT INTO `tblcustomers`(`customerId`, `name`, `address`, `contactNo`, `shopType`, `frezerType`, `route`, `rep`, `addedBy`, `status`) VALUES ('".$txtCustomerId."','".$txtCustomerName."','".$txtCustomerAddress."','".$txtCustomerContactNo."','".$txtCustomerShopType."','".$txtCustomerFrezerType."','".$txtCustomerRoute."','".$txtCustomerRep."','".$data['staffsId']."','".$txtStatus."')";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Customer Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Sorry!',text: 'Customer ID is Already Available!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }


    function chkStaffAvailable($conn,$txtStaffId){
        $sql = "SELECT * FROM `tblstaffs` WHERE staffsId='".$txtStaffId."'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)==1){
            $isStaffAvailable = false;
        }
        else{
            $isStaffAvailable = true;
        }
        return $isStaffAvailable;
    }

    function addStaffsDetails($conn,$txtUserId,$txtStaffId,$txtStaffName,$txtStaffAddress,$txtStaffNICNo,$txtStaffPhone,$txtStaffType,$txtStaffPictureName,$txtStaffPictureTmpName,$txtStaffEmail){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        $isStaffAvailable = chkStaffAvailable($conn,$txtStaffId);
        if($txtStaffPictureName != '' && $txtStaffPictureTmpName != ''){
            $parts = explode(".", $txtStaffPictureName);
            $txtStaffPictureName = $txtStaffId;
            $txtStaffPicturePath = "assets/img/profilePicture/" . $txtStaffPictureName . "." . $parts[1];
            $boolFileUploaded = move_uploaded_file($txtStaffPictureTmpName, $txtStaffPicturePath);
        }
        else{
            $boolFileUploaded = true;
            $txtStaffPicturePath = 'assets/img/profilePicture/default.png';
        }
        if($txtStaffEmail != ''){
            $boolLoginDetailsAdding = addLoginDetails($conn,$txtStaffId,$txtStaffEmail,$txtStaffPicturePath,$txtStaffType);
        }
        else{
            $boolLoginDetailsAdding = true;
        }
        if($isStaffAvailable){
            if($boolFileUploaded && $boolLoginDetailsAdding){
                $sql = "INSERT INTO `tblstaffs`(`staffsId`, `staffsName`, `staffsNIC`, `staffsAddress`, `staffsContactNo`, `staffsType`, `staffsPicture`, `addedBy`, `status`) VALUES ('".$txtStaffId."','".$txtStaffName."','".$txtStaffNICNo."','".$txtStaffAddress."','".$txtStaffPhone."','".$txtStaffType."','".$txtStaffPicturePath."','".$data['staffsId']."','".$txtStatus."')";
                $result = mysqli_query($conn,$sql);
                if($result){
                    echo " <script>
                                setTimeout(function(){ swal({title: 'Success!',text: 'Staff Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                            </script> ";
                }
                else{
                    echo " <script>
                                setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                            </script> ";
                }
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Problem with Profile Picture!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Sorry!',text: 'Customer ID is Already Available!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function addLoginDetails($conn,$txtStaffId,$txtStaffEmail,$txtStaffPicturePath,$txtStaffType){
        if($txtStaffType=='Computer Operator'){
            $txtHashedPwd = md5($txtStaffId);
            if($txtStaffPicturePath != ''){
                $sql = "INSERT INTO `tbllogin`(`staffsId`, `password`, `email`, `status`, `type`, `profilePicture`) VALUES ('".$txtStaffId."','".$txtHashedPwd."','".$txtStaffEmail."','Waiting','user','".$txtStaffPicturePath."')";
            }
            else{
                $sql = "INSERT INTO `tbllogin`(`staffsId`, `password`, `email`, `status`, `type`) VALUES ('".$txtStaffId."','".$txtHashedPwd."','".$txtStaffEmail."','Pending','user')";
            }
            $result = mysqli_query($conn,$sql);
            if($result){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return true;
        }
    }

    function chkRouteAvailable($conn,$txtRouteId){
        $sql = "SELECT * FROM `tblroutes` WHERE routeId='".$txtRouteId."'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)==1){
            $isRouteAvailable = false;
        }
        else{
            $isRouteAvailable = true;
        }
        return $isRouteAvailable;
    }

    function addRouteDetails($conn,$txtUserId,$txtRouteId,$txtRouteName,$txtRouteItenary,$txtRouteTown,$txtRouteNoOfShop,$txtRouteRef,$txtRouteNoOfFC){
        $isRouteAvailable = chkRouteAvailable($conn,$txtRouteId);
        if($isRouteAvailable){
            $data = fetchUsersLoginDetails($conn,$txtUserId);
            $txtStatus = '';
            if($data['type']=='admin'){
                $txtStatus = 'active';
            }
            if($data['type']=='user'){
                $txtStatus = 'pending';
            }
            $sql = "INSERT INTO `tblroutes`(`routeId`, `routeName`, `routeItenary`, `routeTown`, `routeNoOfShops`, `routeRep`, `routeNoOfFC`, `addedBy`, `status`) VALUES ('".$txtRouteId."','".$txtRouteName."','".$txtRouteItenary."','".$txtRouteTown."','".$txtRouteNoOfShop."','".$txtRouteRef."','".$txtRouteNoOfFC."','".$data['staffsId']."','".$txtStatus."')";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Route Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Sorry!',text: 'Route ID is Already Available!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function addRouteGoodsDetails($conn,$txtUserId,$datInvocingDate,$datDelevaryDate,$txtInvocingNo,$txtAmount,$datChequeDate){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        $sql = "INSERT INTO `tblgoods`(`invoinvocingDate`, `delevaryDate`, `invoinvocingNo`, `invoinvocingAmount`, `chequeDate`, `addedBy`, `status`) VALUES ('".$datInvocingDate."','".$datDelevaryDate."','".$txtInvocingNo."','".$txtAmount."','".$datChequeDate."','".$data['staffsId']."','".$txtStatus."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Goods Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function addTargetsDetails($conn,$txtUserId,$txtMonth,$txtPrimaryTarget,$txtRDTarget){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        $txtYear = date("Y");
        $sql = "INSERT INTO `tbltarget`(`targetYear`, `targetMonth`, `primaryTarget`, `RDTarget`, `addedBy`, `status`) VALUES ('".$txtYear."','".$txtMonth."','".$txtPrimaryTarget."','".$txtRDTarget."','".$data['staffsId']."','".$txtStatus."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Target Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function getRouteForOptionInAddCustomer($conn){
        $sql = "SELECT * FROM `tblroutes`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                echo "<option value=\"".$row['routeName']."\">".ucwords($row['routeName'], " ")."</option>";
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Some Routes</option>";
        }
    }

    function getRepForOptionInAddCustomer($conn){
        $sql = "SELECT * FROM `tblstaffs` WHERE staffsType='Rep'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                echo "<option value=\"".$row['staffsName']."\">".ucwords($row['staffsName'], " ")."</option>";
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function showCustomersDetails($conn){
        $sql = "SELECT * FROM `tblcustomers`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".strtoupper($row['customerId'])."</td>";
                    echo "<td>".ucwords($row['name'], " ")."</td>";
                    echo "<td>".ucwords($row['address'], " ")."</td>";
                    echo "<td>".$row['contactNo']."</td>";
                    echo "<td>".$row['shopType']."</td>";
                    echo "<td>".$row['frezerType']."</td>";
                    echo "<td>".ucwords($row['route'], " ")."</td>";
                    echo "<td>".ucwords($row['rep'], " ")."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }                        
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteCustomer' class='btn btn-danger btn-sm' title='Delete Customer' onclick='validateForm1()'>
                                            <i class='fas fa-trash-alt'></i>
                                        </button>
                                        <input type='hidden' name='deleteCustomerId' value='".$row['customerId']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <a href='admin.php?cd&cstid=".$row['customerId']."' class='btn btn-warning btn-sm' title='Edit Customer'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </div>";
                            if($row['status']=='active'){
                                echo "<div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnBlockCustomer' class='btn btn-secondary btn-sm' title='Block Customer' onclick='validateForm2()'>
                                                <i class='fas fa-ban'></i>
                                            </button>
                                            <input type='hidden' name='blockCustomerId' value='".$row['customerId']."'>
                                        </form>
                                    </div>";
                            }
                            if($row['status']=='blocked'){
                                echo "<div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnActiveCustomer' class='btn btn-success btn-sm' title='Active Customer' onclick='validateForm3()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeCustomerId' value='".$row['customerId']."'>
                                        </form>
                                    </div>";
                            }
                            if($row['status']=='pending'){
                                echo "<div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnActiveCustomerFromPending' class='btn btn-success btn-sm' title='Active Customer' onclick='validateForm3()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeCustomerIdFromPending' value='".$row['customerId']."'>
                                        </form>
                                    </div>";
                            }
                            echo "<div class='col-3'>
                                    <a href='admin.php?cd&vcid=".$row['customerId']."' class='btn btn-primary btn-sm' title='View Customer'>
                                        <i class='fas fa-binoculars'></i>
                                    </a>
                                </div>
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
            }
        }
    }

    function showCustomersDetailsForUser($conn){
        $sql = "SELECT * FROM `tblcustomers`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".strtoupper($row['customerId'])."</td>";
                    echo "<td>".ucwords($row['name'], " ")."</td>";
                    echo "<td>".ucwords($row['address'], " ")."</td>";
                    echo "<td>".$row['contactNo']."</td>";
                    echo "<td>".$row['shopType']."</td>";
                    echo "<td>".$row['frezerType']."</td>";
                    echo "<td>".ucwords($row['route'], " ")."</td>";
                    echo "<td>".ucwords($row['rep'], " ")."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }
                echo "</tr>";
                $no++;
            }
        }
    }

    function editCustomersDetails($conn,$txtCustomerId,$txtCustomerName,$txtCustomerAddress,$txtCustomerContactNo,$txtCustomerShopType,$txtCustomerFrezerType,$txtCustomerRoute,$txtCustomerRep){
        $sql = "UPDATE `tblcustomers` SET `name`='".$txtCustomerName."',`address`='".$txtCustomerAddress."',`contactNo`='".$txtCustomerContactNo."',`shopType`='".$txtCustomerShopType."',`frezerType`='".$txtCustomerFrezerType."',`route`='".$txtCustomerRoute."',`rep`='".$txtCustomerRep."' WHERE `customerId`='".$txtCustomerId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Customer Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function fetchCustomerDetails($conn,$cstid){
        $sql = "SELECT * FROM `tblcustomers` WHERE customerId='".$cstid."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            $data = $result->fetch_assoc();
        }
        return $data;
    }

    function blockCustomerDetails($conn,$blockCustomerId){
        $sql = "UPDATE `tblcustomers` SET `status`='blocked' WHERE customerId='".$blockCustomerId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Custemer Details Blocked Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function activeCustomerDetails($conn,$activeCustomerId){
        $sql = "UPDATE `tblcustomers` SET `status`='active' WHERE customerId='".$activeCustomerId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Custemer Details Blocked Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function activeCustomerDetailsFromPending($conn,$activeCustomerIdFromPending){
        if($activeCustomerIdFromPending == "all"){
            $sql = "UPDATE `tblcustomers` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblcustomers` SET `status`='active' WHERE customerId='".$activeCustomerIdFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function removeCustomerDetails($conn,$deleteCustomerId){
        $sql = "DELETE FROM `tblcustomers` WHERE customerId='".$deleteCustomerId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Custemer Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }
    
    function getRouteForOptionInAddCustomerForEdit($conn,$cstDataRoute){
        $sql = "SELECT * FROM `tblroutes`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $conditionActive = ($cstDataRoute == $row['routeName'] ) ? "selected" : "";
                echo "<option ". $conditionActive ." value=\"".$row['routeName']."\">".ucwords($row['routeName'], " ")."</option>";
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Some Routes</option>";
        }
    }

    function getRepForOptionInAddCustomerForEdit($conn,$cstDataRep){
        $sql = "SELECT * FROM `tblstaffs` WHERE staffsType='Rep'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $conditionActive = ($cstDataRep == $row['staffsName'] ) ? "selected" : "";
                echo "<option ". $conditionActive ." value=\"".$row['staffsName']."\">".ucwords($row['staffsName'], " ")."</option>";
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function showStaffsDetails($conn){
        $sql = "SELECT * FROM `tblstaffs`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td><center><img src='".$row['staffsPicture']."' width='50px' height='50px'></center></td>";
                    echo "<td>".strtoupper($row['staffsId'])."</td>";
                    echo "<td>".ucwords($row['staffsNIC'], " ")."</td>";
                    echo "<td>".ucwords($row['staffsName'], " ")."</td>";
                    echo "<td>".ucwords($row['staffsAddress'], " ")."</td>";
                    echo "<td>".$row['staffsContactNo']."</td>";
                    echo "<td>".$row['staffsType']."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }                        
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteStaff' class='btn btn-danger btn-sm' title='Delete Staff' onclick='validateForm4()'>
                                            <i class='fas fa-trash-alt'></i>
                                        </button>
                                        <input type='hidden' name='deleteStaffId' value='".$row['staffsId']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <a href='admin.php?sd&stfid=".$row['staffsId']."' class='btn btn-warning btn-sm' title='Edit Staff'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </div>";
                            if($row['status']=='active'){
                                echo "<div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnBlockStaff' class='btn btn-secondary btn-sm' title='Block Staff' onclick='validateForm5()'>
                                                <i class='fas fa-ban'></i>
                                            </button>
                                            <input type='hidden' name='blockStaffId' value='".$row['staffsId']."'>
                                        </form>
                                    </div>";
                            }
                            if($row['status']=='blocked'){
                                echo "<div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnActiveStaff' class='btn btn-success btn-sm' title='Active Staff' onclick='validateForm6()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeStaffId' value='".$row['staffsId']."'>
                                        </form>
                                    </div>";
                            }
                            if($row['status']=='pending'){
                                echo "<div class='col-3'>
                                        <form action='#' method='POST'>
                                            <button name='btnActiveStaffFromPending' class='btn btn-success btn-sm' title='Active Staff' onclick='validateForm6()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeStaffIdFromPending' value='".$row['staffsId']."'>
                                        </form>
                                    </div>";
                            }
                            echo "<div class='col-3'>
                                    <a href='admin.php?sd&vsid=".$row['staffsId']."' class='btn btn-primary btn-sm' title='View Staff'>
                                        <i class='fas fa-binoculars'></i>
                                    </a>
                                </div>
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
            }
        }
    }

    function showStaffsDetailsForUser($conn){
        $sql = "SELECT * FROM `tblstaffs`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td><center><img src='".$row['staffsPicture']."' width='50px' height='50px'></center></td>";
                    echo "<td>".strtoupper($row['staffsId'])."</td>";
                    echo "<td>".ucwords($row['staffsNIC'], " ")."</td>";
                    echo "<td>".ucwords($row['staffsName'], " ")."</td>";
                    echo "<td>".ucwords($row['staffsAddress'], " ")."</td>";
                    echo "<td>".$row['staffsContactNo']."</td>";
                    echo "<td>".$row['staffsType']."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }
                echo "</tr>";
                $no++;
            }
        }
    }

    function editStaffsDetails($conn,$txtStaffId,$txtStaffName,$txtStaffAddress,$txtStaffNICNo,$txtStaffPhone,$txtStaffType,$txtStaffPictureName,$txtStaffPictureTmpName,$txtStaffEmail){
        $dataUsersLogin = fetchUsersLoginDetails($conn,$txtStaffId);
        $datataff = fetchStaffDetails($conn,$txtStaffId);

        if($txtStaffPictureName != '' && $txtStaffPictureTmpName != ''){
            $parts = explode(".", $txtStaffPictureName);
            $txtStaffPictureName = $txtStaffId;
            $txtStaffPicturePath = "assets/img/profilePicture/" . $txtStaffPictureName . "." . $parts[1];
            $boolFileUploaded = move_uploaded_file($txtStaffPictureTmpName, $txtStaffPicturePath);
        }
        else{
            $boolFileUploaded = true;
            $txtStaffPicturePath = $datataff['staffsPicture'];
        }
        if($txtStaffEmail != ''){
            if($txtStaffEmail != $dataUsersLogin['email']){
                $boolLoginDetailsEditing = editLoginDetails($conn,$txtStaffId,$txtStaffEmail);
            }            
        }
        else{
            $boolLoginDetailsEditing = true;
        }
        if($boolFileUploaded && $boolLoginDetailsEditing){
            $sql = "UPDATE `tblstaffs` SET `staffsName`='".$txtStaffName."', `staffsNIC`='".$txtStaffNICNo."', `staffsAddress`='".$txtStaffAddress."', `staffsContactNo`='".$txtStaffPhone."', `staffsType`='".$txtStaffType."', `staffsPicture`='".$txtStaffPicturePath."' WHERE `staffsId`='".$txtStaffId."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Staff Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Problem with Profile Picture!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function editLoginDetails($conn,$txtStaffId,$txtStaffEmail){
        $sql = "UPDATE `tbllogin` SET `email`='".$txtStaffEmail."' WHERE staffsId='".$txtStaffId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }

    function fetchStaffLoginDetails($conn,$stfid){
        $sql = "SELECT * FROM `tbllogin` WHERE staffsId='".$stfid."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            $data = $result->fetch_assoc();
        }
        return $data;
    }

    function fetchStaffDetails($conn,$stfid){
        $sql = "SELECT * FROM `tblstaffs` WHERE staffsId='".$stfid."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            $data = $result->fetch_assoc();
        }
        return $data;
    }

    function blockStaffDetails($conn,$blockStaffId){
        $sql = "UPDATE `tblstaffs` SET `status`='blocked' WHERE staffsId='".$blockStaffId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Staff Details Blocked Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function activeStaffDetails($conn,$activeStaffId){
        $sql = "UPDATE `tblstaffs` SET `status`='active' WHERE staffsId='".$activeStaffId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Staff Details Blocked Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function activeStaffDetailsFromPending($conn,$activeStaffIdFromPending){
        if($activeStaffIdFromPending == "all"){
            $sql = "UPDATE `tblstaffs` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblstaffs` SET `status`='active' WHERE staffsId='".$activeStaffIdFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function removeStaffDetails($conn,$deleteStaffId){
        $sql = "DELETE FROM `tblstaffs` WHERE staffsId='".$deleteStaffId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Staff Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showRoutesDetails($conn){
        $sql = "SELECT * FROM `tblroutes`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".strtoupper($row['routeId'])."</td>";
                    echo "<td>".ucwords($row['routeName'], " ")."</td>";
                    echo "<td>".$row['routeItenary']."</td>";
                    echo "<td>".ucwords($row['routeTown'], " ")."</td>";
                    echo "<td>".$row['routeNoOfShops']."</td>";
                    echo "<td>".ucwords($row['routeRep'], " ")."</td>";
                    echo "<td>".$row['routeNoOfFC']."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }                        
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteRoute' class='btn btn-danger btn-sm' title='Delete Route' onclick='validateForm7()'>
                                            <i class='fas fa-trash-alt'></i>
                                        </button>
                                        <input type='hidden' name='deleteRouteId' value='".$row['routeId']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <a href='admin.php?rd&rutid=".$row['routeId']."' class='btn btn-warning btn-sm' title='Edit Route'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </div>";
                            if($row['status']=='active'){
                                echo "<div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnBlockRoute' class='btn btn-secondary btn-sm' title='Block Route' onclick='validateForm8()'>
                                                <i class='fas fa-ban'></i>
                                            </button>
                                            <input type='hidden' name='blockRouteId' value='".$row['routeId']."'>
                                        </form>
                                    </div>";
                            }
                            if($row['status']=='blocked'){
                                echo "<div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnActiveRoute' class='btn btn-success btn-sm' title='Active Route' onclick='validateForm9()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeRouteId' value='".$row['routeId']."'>
                                        </form>
                                    </div>";
                            }
                            if($row['status']=='pending'){
                                echo "<div class='col-3'>
                                        <form action='#' method='POST'>
                                            <button name='btnActiveRouteFromPending' class='btn btn-success btn-sm' title='Active Route' onclick='validateForm9()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeRouteIdFromPending' value='".$row['routeId']."'>
                                        </form>
                                    </div>";
                            }
                        echo "</div>
                        </td>";
                echo "</tr>";
                $no++;
            }
        }
    }

    function showRoutesDetailsForUser($conn){
        $sql = "SELECT * FROM `tblroutes`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".strtoupper($row['routeId'])."</td>";
                    echo "<td>".ucwords($row['routeName'], " ")."</td>";
                    echo "<td>".$row['routeItenary']."</td>";
                    echo "<td>".ucwords($row['routeTown'], " ")."</td>";
                    echo "<td>".$row['routeNoOfShops']."</td>";
                    echo "<td>".ucwords($row['routeRep'], " ")."</td>";
                    echo "<td>".$row['routeNoOfFC']."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }
                echo "</tr>";
                $no++;
            }
        }
    }

    function editRouteDetails($conn,$txtRouteId,$txtRouteName,$txtRouteItenary,$txtRouteTown,$txtRouteNoOfShop,$txtRouteRef,$txtRouteNoOfFC){
        $sql = "UPDATE `tblroutes` SET `routeName`='".$txtRouteName."' , `routeItenary`='".$txtRouteItenary."' , `routeTown`='".$txtRouteTown."' , `routeNoOfShops`='".$txtRouteNoOfShop."' , `routeRep`='".$txtRouteRef."' , `routeNoOfFC`='".$txtRouteNoOfFC."' WHERE `routeId`='".$txtRouteId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Route Details Edit Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function getRepForOptionInEditRoute($conn,$txtRouteRef){
        $sql = "SELECT * FROM `tblstaffs` WHERE staffsType='Rep'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $conditionActive = ($row['staffsName'] == $txtRouteRef) ? "selected" : "";
                echo "<option ". $conditionActive ." value=\"".$row['staffsName']."\">".ucwords($row['staffsName'], " ")."</option>";
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function fetchRouteDetails($conn,$rutid){
        $sql = "SELECT * FROM `tblroutes` WHERE routeId='".$rutid."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            $data = $result->fetch_assoc();
        }
        return $data;
    }

    function blockRouteDetails($conn,$blockRouteId){
        $sql = "UPDATE `tblroutes` SET `status`='blocked' WHERE routeId='".$blockRouteId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Route Details Blocked Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function activeRouteDetails($conn,$activeRouteId){
        $sql = "UPDATE `tblroutes` SET `status`='active' WHERE routeId='".$activeRouteId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Route Details Blocked Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function activeRouteDetailsFromPending($conn,$activeRouteIdFromPending){
        if($activeRouteIdFromPending == "all"){
            $sql = "UPDATE `tblroutes` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblroutes` SET `status`='active' WHERE routeId='".$activeRouteIdFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function removeRouteDetails($conn,$deleteRouteId){
        $sql = "DELETE FROM `tblroutes` WHERE routeId='".$deleteRouteId."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Route Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showGRNDetails($conn,$txtViewMonth,$txtViewYear){
        $startDate = $txtViewYear . "-" . $txtViewMonth . "-" . '01';
        $endDate = $txtViewYear . "-" . $txtViewMonth . "-" . '31';
        $sql = "SELECT * FROM `tblgoods` WHERE `invoinvocingDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                $colColour = "";
                if($row['amountStatus'] == 'Clear' || $row['amountStatus'] == "Clear"){
                    $colColour = " class='table-success'";
                }
                echo "<tr".$colColour.">";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['invoinvocingDate']."</td>";
                    echo "<td>".$row['delevaryDate']."</td>";
                    echo "<td>".ucwords($row['invoinvocingNo'])."</td>";
                    echo "<td>".number_format($row['invoinvocingAmount'],2)." Rs</td>";
                    echo "<td>".$row['chequeDate']."</td>";
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Invoinvoce' onclick='validateForm10()'>
                                            <i class='fas fa-trash-alt'></i>
                                        </button>
                                        <input type='hidden' name='deleteInvoinvocingNo' value='".$row['invoinvocingNo']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <a href='admin.php?grnd&incid=".$row['invoinvocingNo']."' class='btn btn-warning btn-sm' title='Edit Invoinvoce'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </div>";
                    if($row['amountStatus'] == NULL || $row['amountStatus'] == null || $row['amountStatus'] == '' || $row['amountStatus'] == "" || $row['amountStatus'] == 'Not Clear' || $row['amountStatus'] == "Not Clear"){
                            echo "<div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnClearInvoinvocing' class='btn btn-success btn-sm' title='Invoinvoce Clear' onclick='validateForm30()'>
                                            <i class='fas fa-thumbs-up'></i>
                                        </button>
                                        <input type='hidden' name='clearInvoinvocingNo' value='".$row['invoinvocingNo']."'>
                                    </form>
                                </div>";
                    }
                    else{
                            echo "<div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnNotClearInvoinvocing' class='btn btn-secondary btn-sm' title='Invoinvoce Clear' onclick='validateForm30()'>
                                            <i class='fas fa-thumbs-down'></i>
                                        </button>
                                        <input type='hidden' name='notClearInvoinvocingNo' value='".$row['invoinvocingNo']."'>
                                    </form>
                                </div>";
                    }
                    echo    "</div>
                        </td>";
                echo "</tr>";
                $no++;
            }
        }        
    }

    function makeClearInvoiceDetails($conn,$clearInvoinvocingNo){
        $sql = "UPDATE `tblgoods` SET `amountStatus`='Clear' WHERE `invoinvocingNo`='".$clearInvoinvocingNo."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Goods Details Updated Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function makeNotClearInvoiceDetails($conn,$notClearInvoinvocingNo){
        $sql = "UPDATE `tblgoods` SET `amountStatus`='Not Clear' WHERE `invoinvocingNo`='".$notClearInvoinvocingNo."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Goods Details Updated Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function removeInvioceDetails($conn,$deleteInvoinvocingNo){
        $sql = "DELETE FROM `tblgoods` WHERE invoinvocingNo='".$deleteInvoinvocingNo."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Invioce Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function editRouteGoodsDetails($conn,$datInvocingDate,$datDelevaryDate,$txtInvocingNo,$txtAmount,$datChequeDate){
        $sql = "UPDATE `tblgoods` SET `invoinvocingDate`='".$datInvocingDate."', `delevaryDate`='".$datDelevaryDate."', `invoinvocingAmount` ='".$txtAmount."', `chequeDate`='".$datChequeDate."' WHERE `invoinvocingNo`='".$txtInvocingNo."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Goods Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function fetchGRN1Details($conn,$invid){
        $sql = "SELECT * FROM `tblgoods` WHERE invoinvocingNo='".$invid."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            $data = $result->fetch_assoc();
        }
        return $data;
    }

    function showPTAndRDT($conn,$txtViewMonth,$txtViewYear){
        $txtViewMonthOld = $txtViewMonth;
        if($txtViewMonth=='01'){
            $txtViewMonth='January';
        }
        if($txtViewMonth=='02'){
            $txtViewMonth='February';
        }
        if($txtViewMonth=='03'){
            $txtViewMonth='March';
        }
        if($txtViewMonth=='04'){
            $txtViewMonth='April';
        }
        if($txtViewMonth=='05'){
            $txtViewMonth='May';
        }
        if($txtViewMonth=='06'){
            $txtViewMonth='June';
        }
        if($txtViewMonth=='07'){
            $txtViewMonth='July';
        }
        if($txtViewMonth=='08'){
            $txtViewMonth='August';
        }
        if($txtViewMonth=='09'){
            $txtViewMonth='September';
        }
        if($txtViewMonth=='10'){
            $txtViewMonth='October';
        }
        if($txtViewMonth=='11'){
            $txtViewMonth='November';
        }
        if($txtViewMonth=='12'){
            $txtViewMonth='December';
        }
        $targetYear = $txtViewYear;
        $sql1 = "SELECT * FROM `tbltarget` WHERE `targetMonth`='".$txtViewMonth."' AND `targetYear`='".$targetYear."'";
        $result1 = mysqli_query($conn,$sql1);
        $data1 = $result1->fetch_assoc();
        echo "<div class='col-5'>
                <table class='table table-bordered' cellspacing='0' style='border: 2px solid #f6c23e;'>
                    <tbody>
                        <tr style='border: 2px solid #f6c23e;'>
                            <td>Primary Target</td>
                            <td>".number_format($data1['primaryTarget'],2)." Rs</td>
                        </tr>
                        <tr style='border: 2px solid #f6c23e;'>
                            <td>Achievement</td>
                            <td>";
        $startDate = $txtViewYear . "-" . $txtViewMonthOld . "-" . '01';
        $endDate = $txtViewYear . "-" . $txtViewMonthOld . "-" . '31';
        $sql2 = "SELECT SUM(`invoinvocingAmount`) AS `totalInvoinvocingAmount` FROM `tblgoods` WHERE `invoinvocingDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result2 = mysqli_query($conn,$sql2);
        $data2 = $result2->fetch_assoc();
        echo number_format($data2['totalInvoinvocingAmount'],2);
        echo               " RS</td>
                        </tr>
                        <tr style='border: 2px solid #f6c23e;'>
                            <td>Balance</td>
                            <td>";
        $balanceAmount = $data1['primaryTarget'] - $data2['totalInvoinvocingAmount'];
        echo               number_format($balanceAmount,2) . " Rs</td>
                        </tr>
                        <tr style='border: 2px solid #f6c23e;'>
                            <td>Achieved Percentage</td>
                            <td>";
        $achievedPercentage = ($data2['totalInvoinvocingAmount'] / $data1['primaryTarget']) * 100;
        echo               number_format($achievedPercentage,2) . "%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class='col-5'>
                <table class='table table-bordered' cellspacing='0' style='border: 2px solid #f6c23e;'>
                    <tbody>
                        <tr style='border: 2px solid #f6c23e;'>
                            <td>R/D Target</td>
                            <td>".number_format($data1['RDTarget'],2)." Rs</td>
                        </tr>
                        <tr style='border: 2px solid #f6c23e;'>
                            <td>Achievement</td>
                            <td>";
        $sql3 = "SELECT SUM(`amount`) AS `totalACAmount` FROM `tblacbill` WHERE `acbillDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result3 = mysqli_query($conn,$sql3);
        $data3 = $result3->fetch_assoc();

        $sql4 = "SELECT SUM(`cashBillAmount`) AS `totalCashAmount` FROM `tblcashbilldetails` WHERE `cashBillDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result4 = mysqli_query($conn,$sql4);
        $data4 = $result4->fetch_assoc();

        $sql5 = "SELECT SUM(`chequeBillAmount`) AS `totalChequeAmount` FROM `tblchequebilldetails` WHERE `chequeBillDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result5 = mysqli_query($conn,$sql5);
        $data5 = $result5->fetch_assoc();

        $achievement = $data3['totalACAmount'] + $data4['totalCashAmount'] + $data5['totalChequeAmount'];
        echo               number_format($achievement,2) . " Rs</td>
                        </tr>
                        <tr style='border: 2px solid #f6c23e;'>
                            <td>Balance</td>
                            <td>";
        $balance2 = $data1['RDTarget'] - $achievement;
        echo               number_format($balance2,2) . " Rs</td>
                        </tr>
                        <tr style='border: 2px solid #f6c23e;'>
                            <td>Achieved Percentage</td>
                            <td>";
        $achievedPercentage2 = ($achievement / $data1['RDTarget']) * 100;
        echo               number_format($achievedPercentage2,2) . "%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class='col-2'>
                <table class='table table-bordered' cellspacing='0' style='border: 2px solid #f6c23e;'>
                    <tbody>
                        <tr style='border: 2px solid #f6c23e;'>
                            <td rowspan='2'>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteTarget' class='btn btn-danger btn-sm' title='Delete Targets' onclick='validateForm11()'>
                                            <i class='fas fa-trash-alt'></i>
                                        </button>
                                        <input type='hidden' name='deleteTargetMonth' value='".$data1['targetMonth']."'>
                                        <input type='hidden' name='deleteTargetYear' value='".$data1['targetYear']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <a href='admin.php?grnd&ty=".$data1['targetYear']."&tm=".$data1['targetMonth']."' class='btn btn-warning btn-sm' title='Edit Targets'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </div>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>";
    }

    function removeTargetDetails($conn,$deleteTargetYear,$deleteTargetMonth){
        $sql = "DELETE FROM `tbltarget` WHERE targetYear='".$deleteTargetYear."' AND targetMonth='".$deleteTargetMonth."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Target Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function fetchGRN2Details($conn,$tm,$ty){
        $sql = "SELECT * FROM `tbltarget` WHERE targetYear='".$ty."' AND targetMonth='".$tm."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            $data = $result->fetch_assoc();
        }
        return $data;
    }

    function editTargetsDetails($conn,$txtYear,$txtMonth,$txtPrimaryTarget,$txtRDTarget){
        $sql = "UPDATE `tbltarget` SET `primaryTarget`='".$txtPrimaryTarget."', `RDTarget`='".$txtRDTarget."' WHERE `targetYear`='".$txtYear."' AND `targetMonth`='".$txtMonth."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Target Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function addACBillDetails($conn,$txtUserId,$billNo,$acbillDate,$rep,$customerId,$custermerName,$amount){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "INSERT INTO `tblACBill`(`billNo`, `acbillDate`, `rep`, `customerId`, `custermerName`, `amount`, `addedBy`, `status`) VALUES ('".$billNo."','".$acbillDate."','".$rep."','".$customerId."','".$custermerName."','".$amount."','".$data['staffsId']."','In Progress')";
        $result = mysqli_query($conn,$sql);
    }

    function showCustomerNamesInOptions($conn){
        $sql = "SELECT * FROM `tblcustomers`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                echo "<option value=\"".$row['name']."\">".ucwords($row['name'], " ")."</option>";
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function showCustomerIDInOptions($conn){
        $sql = "SELECT * FROM `tblcustomers`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                echo "<option value=\"".$row['customerId']."\">".ucwords($row['customerId'], " ")."</option>";
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function showACBillInProgressesInformations($conn){
        $sql = "SELECT * FROM `tblacbill` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            $total = 0;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['acbillDate']."</td>";
                    echo "<td>".strtoupper($row['customerId'])."</td>";
                    echo "<td>".ucwords($row['custermerName'])."</td>";
                    echo "<td>".strtoupper($row['billNo'])."</td>";
                    echo "<td>".ucwords($row['rep'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Remove Bill' onclick='validateForm12()'>
                                            <i class='fas fa-minus'></i>
                                        </button>
                                        <input type='hidden' name='removeACBill' value='".$row['billNo']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <a href='admin.php?crdsd&acbe=".$row['billNo']."' class='btn btn-warning btn-sm' title='Edit Invoinvoce'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </div>
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
                $total = $total + $row['amount'];
            }
            echo "<tr>";
                echo "<td colspan='6'>
                        Total
                    </td>";
                echo "<td>
                    <strong>".number_format($total,2)." Rs<strong>
                    </td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td colspan='8'>
                        <div class='row' style='float: right;'>
                            <div class='col-3'>
                                <form action='' method='POST'>
                                    <button name='btnSaveAll' class='btn btn-success btn-sm' title='Save All Bills' onclick='validateForm13()'>
                                        <i class='fas fa-check'></i>
                                    </button>
                                    <input type='hidden' name='saveAllACBill' value=''>
                                </form>
                            </div>
                            <div class='col-3'>
                                <form action='' method='POST'>
                                    <button name='btnRemoveAll' class='btn btn-danger btn-sm' title='Remove All Bills' onclick='validateForm14()'>
                                        <i class='fas fa-eraser'></i>
                                    </button>
                                    <input type='hidden' name='removeAllACBill' value=''>
                                </form>
                            </div>
                        </div>
                    </td>";
            echo "</tr>";
        }
    }

    function removeACBillInProgressesInformations($conn,$removeACBill){
        $sql = "DELETE FROM `tblacbill` WHERE billNo='".$removeACBill."'";
        $result = mysqli_query($conn,$sql);
    }

    function removeAllACBillInProgressesInformations($conn){
        $sql = "DELETE FROM `tblacbill` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);
    }

    function addAllACBillInProgressesInformations($conn,$txtUserId){

        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        
        $sql = "SELECT * FROM `tblacbill` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_assoc($result)){
            $sql1 = "UPDATE `tblacbill` SET `status`='".$txtStatus."' WHERE `billNo`='".$row['billNo']."'";
            $result1 = mysqli_query($conn,$sql1); 
        }
    }

    function showACBillAfterInProgressesInformations($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblacbill` WHERE status<>'In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                $dataCst = fetchCustomerDetails($conn,$row['customerId']);

                $collectedAmounts = 0;
                $sql0 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
                $result0 = mysqli_query($conn,$sql0);
                if(mysqli_num_rows($result0)>=1){
                    while($row0 = mysqli_fetch_assoc($result0)){
                        $collectedAmounts += $row0['amount'];
                    }
                }

                if($collectedAmounts < $row['amount']){

                    $date1=date_create($row['acbillDate']);
                    $date2=date_create(date('Y-m-d'));
                    $diff=date_diff($date1,$date2);
                    $diff2=$diff->format("%R%a");

                    if($diff2 <= 30){

                        echo "<tr class='table-danger'>";
                            echo "<td>".$no."</td>";
                            echo "<td>".$row['acbillDate']."</td>";
                            echo "<td>".strtoupper($row['customerId'])."</td>";
                            echo "<td>".ucwords($row['custermerName'])."</td>";
                            echo "<td>".strtoupper($row['billNo'])."</td>";
                            echo "<td>".$dataCst['route']."</td>";
                            echo "<td>".ucwords($row['rep'])."</td>";
                            echo "<td>".number_format($row['amount'],2)." Rs</td>";
                            $diff2=$diff->format("%a");
                            echo "<td style='color: green'>".$diff2." Days Left</td>";
                            if($row['status'] == 'active'){
                                echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                            }
                            if($row['status'] == 'pending'){
                                echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                            }
                            if($dataUser['type']=='admin'){
                                echo "<td>
                                        <div class='row'>
                                            <div class='col-3'>
                                                <form action='' method='POST'>
                                                    <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm15()'>
                                                        <i class='fas fa-trash-alt'></i>
                                                    </button>
                                                    <input type='hidden' name='deleteACBill' value='".$row['billNo']."'>
                                                </form>
                                            </div>
                                            <div class='col-3'>
                                                <a href='admin.php?crdsd&acbe=".$row['billNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>";
                            }
                                
                        echo "</tr>";

                    }
                    else{

                        echo "<tr class='table-warning'>";
                            echo "<td>".$no."</td>";
                            echo "<td>".$row['acbillDate']."</td>";
                            echo "<td>".strtoupper($row['customerId'])."</td>";
                            echo "<td>".ucwords($row['custermerName'])."</td>";
                            echo "<td>".strtoupper($row['billNo'])."</td>";
                            echo "<td>".$dataCst['route']."</td>";
                            echo "<td>".ucwords($row['rep'])."</td>";
                            echo "<td>".number_format($row['amount'],2)." Rs</td>";
                            $diff2=$diff->format("%a");
                            echo "<td style='color: red'>".$diff2." Days Late</td>";
                            if($row['status'] == 'active'){
                                echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                            }
                            if($row['status'] == 'pending'){
                                echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                            }
                            if($dataUser['type']=='admin'){
                                echo "<td>
                                        <div class='row'>
                                            <div class='col-3'>
                                                <form action='' method='POST'>
                                                    <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm15()'>
                                                        <i class='fas fa-trash-alt'></i>
                                                    </button>
                                                    <input type='hidden' name='deleteACBill' value='".$row['billNo']."'>
                                                </form>
                                            </div>
                                            <div class='col-3'>
                                                <a href='admin.php?crdsd&acbe=".$row['billNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>";
                            }
                                
                        echo "</tr>";

                    }

                }
                else{

                    echo "<tr class='table-success'>";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['acbillDate']."</td>";
                        echo "<td>".strtoupper($row['customerId'])."</td>";
                        echo "<td>".ucwords($row['custermerName'])."</td>";
                        echo "<td>".strtoupper($row['billNo'])."</td>";
                        echo "<td>".$dataCst['route']."</td>";
                        echo "<td>".ucwords($row['rep'])."</td>";
                        echo "<td>".number_format($row['amount'],2)." Rs</td>";
                        echo "<td style='color: green'><strong>Collected</strong></td>";
                        if($row['status'] == 'active'){
                            echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($row['status'] == 'pending'){
                            echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($dataUser['type']=='admin'){
                            echo "<td>
                                    <div class='row'>
                                        <div class='col-3'>
                                            <form action='' method='POST'>
                                                <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm15()'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                                <input type='hidden' name='deleteACBill' value='".$row['billNo']."'>
                                            </form>
                                        </div>
                                        <div class='col-3'>
                                            <a href='admin.php?crdsd&acbe=".$row['billNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>";
                        }
                            
                    echo "</tr>";

                }
                $no++;
            }
        }
    }

    function deleteACBillInformations($conn,$deleteACBill){
        $sql = "DELETE FROM `tblacbill` WHERE billNo='".$deleteACBill."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'AC Bill Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function fetchACBillDetails($conn,$acbe){
        $sql = "SELECT * FROM `tblacbill` WHERE `billNo`='".$acbe."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    function showCustomerNamesInOptionsForEdit($conn,$custermerName){
        $sql = "SELECT * FROM `tblcustomers`";
        $result = mysqli_query($conn,$sql);
        $active = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                if($custermerName == $row['name']){
                    $active = 'selected';
                }
                echo "<option value=\"".$row['name']."\" $active>".ucwords($row['name'], " ")."</option>";
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function showCustomerIDInOptionsForEdit($conn,$customerId){
        $sql = "SELECT * FROM `tblcustomers`";
        $result = mysqli_query($conn,$sql);
        $active = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                if($customerId == $row['customerId']){
                    $active = 'selected';
                }
                echo "<option value=\"".$row['customerId']."\" $active>".ucwords($row['customerId'], " ")."</option>";
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function editACBillDetails($conn,$billNo,$acbillDate,$rep,$customerId,$custermerName,$amount){
        $sql = "UPDATE `tblACBill` SET `acbillDate`='".$acbillDate."', `rep`='".$rep."', `customerId`='".$customerId."', `custermerName`='".$custermerName."', `amount`='".$amount."' WHERE `billNo`='".$billNo."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'AC Bill Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function findACBillDetails($conn,$datFrom,$datTo,$txtRep,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($txtRep == 'all')){
            $sql = "SELECT * FROM `tblacbill` WHERE status<>'In Progress' AND acbillDate=".$datFrom."";
        }
        elseif(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL)){
            $sql = "SELECT * FROM `tblacbill` WHERE status<>'In Progress' AND (acbillDate='".$datFrom."') AND rep='".$txtRep."'";
        }
        elseif(($txtRep == 'all')){
            $sql = "SELECT * FROM `tblacbill` WHERE status<>'In Progress' AND (acbillDate BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        else{
            $sql = "SELECT * FROM `tblacbill` WHERE status<>'In Progress' AND (acbillDate BETWEEN '".$datFrom."' AND '".$datTo."') AND (rep='".$txtRep."')";
        }
        
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                $dataCst = fetchCustomerDetails($conn,$row['customerId']);
                $collectedAmounts = 0;
                $sql0 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
                $result0 = mysqli_query($conn,$sql0);
                if(mysqli_num_rows($result0)>=1){
                    while($row0 = mysqli_fetch_assoc($result0)){
                        $collectedAmounts += $row0['amount'];
                    }
                }

                if($collectedAmounts < $row['amount']){

                    $date1=date_create($row['acbillDate']);
                    $date2=date_create(date('Y-m-d'));
                    $diff=date_diff($date1,$date2);
                    $diff2=$diff->format("%R%a");

                    if($diff2 <= 30){

                        echo "<tr class='table-danger'>";
                            echo "<td>".$no."</td>";
                            echo "<td>".$row['acbillDate']."</td>";
                            echo "<td>".strtoupper($row['customerId'])."</td>";
                            echo "<td>".ucwords($row['custermerName'])."</td>";
                            echo "<td>".strtoupper($row['billNo'])."</td>";
                            echo "<td>".$dataCst['route']."</td>";
                            echo "<td>".ucwords($row['rep'])."</td>";
                            echo "<td>".number_format($row['amount'],2)." Rs</td>";
                            $diff2=$diff->format("%a");
                            echo "<td style='color: green'>".$diff2." Days Left</td>";
                            if($row['status'] == 'active'){
                                echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                            }
                            if($row['status'] == 'pending'){
                                echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                            }
                            if($dataUser['type']=='admin'){
                                echo "<td>
                                        <div class='row'>
                                            <div class='col-3'>
                                                <form action='' method='POST'>
                                                    <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm15()'>
                                                        <i class='fas fa-trash-alt'></i>
                                                    </button>
                                                    <input type='hidden' name='deleteACBill' value='".$row['billNo']."'>
                                                </form>
                                            </div>
                                            <div class='col-3'>
                                                <a href='admin.php?crdsd&acbe=".$row['billNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>";
                            }
                                
                        echo "</tr>";

                    }
                    else{

                        echo "<tr class='table-warning'>";
                            echo "<td>".$no."</td>";
                            echo "<td>".$row['acbillDate']."</td>";
                            echo "<td>".strtoupper($row['customerId'])."</td>";
                            echo "<td>".ucwords($row['custermerName'])."</td>";
                            echo "<td>".strtoupper($row['billNo'])."</td>";
                            echo "<td>".$dataCst['route']."</td>";
                            echo "<td>".ucwords($row['rep'])."</td>";
                            echo "<td>".number_format($row['amount'],2)." Rs</td>";
                            $diff2=$diff->format("%a");
                            echo "<td style='color: red'>".$diff2." Days Late</td>";
                            if($row['status'] == 'active'){
                                echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                            }
                            if($row['status'] == 'pending'){
                                echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                            }
                            if($dataUser['type']=='admin'){
                                echo "<td>
                                        <div class='row'>
                                            <div class='col-3'>
                                                <form action='' method='POST'>
                                                    <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm15()'>
                                                        <i class='fas fa-trash-alt'></i>
                                                    </button>
                                                    <input type='hidden' name='deleteACBill' value='".$row['billNo']."'>
                                                </form>
                                            </div>
                                            <div class='col-3'>
                                                <a href='admin.php?crdsd&acbe=".$row['billNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>";
                            }
                                
                        echo "</tr>";

                    }

                }
                else{

                    echo "<tr class='table-success'>";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['acbillDate']."</td>";
                        echo "<td>".strtoupper($row['customerId'])."</td>";
                        echo "<td>".ucwords($row['custermerName'])."</td>";
                        echo "<td>".strtoupper($row['billNo'])."</td>";
                        echo "<td>".$dataCst['route']."</td>";
                        echo "<td>".ucwords($row['rep'])."</td>";
                        echo "<td>".number_format($row['amount'],2)." Rs</td>";
                        echo "<td style='color: green'><strong>Collected</strong></td>";
                        if($row['status'] == 'active'){
                            echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($row['status'] == 'pending'){
                            echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($dataUser['type']=='admin'){
                            echo "<td>
                                    <div class='row'>
                                        <div class='col-3'>
                                            <form action='' method='POST'>
                                                <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm15()'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                                <input type='hidden' name='deleteACBill' value='".$row['billNo']."'>
                                            </form>
                                        </div>
                                        <div class='col-3'>
                                            <a href='admin.php?crdsd&acbe=".$row['billNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>";
                        }
                            
                    echo "</tr>";

                }
                $no++;
            }
        }

    }

    function addChqBillDetails($conn,$txtUserId,$chequeBillDate,$chequeBillRep,$chequeBillCustomerCode,$chequeBillCustomerName,$chequeBillNo,$chequeNo,$chequeBillBank,$chequeDate,$chequeBillAmount){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "INSERT INTO `tblChequeBillDetails`(`chequeBillDate`, `chequeBillRep`, `chequeBillCustomerCode`, `chequeBillCustomerName`, `chequeBillNo`, `chequeNo`, `chequeBillBank`, `chequeDate`, `chequeBillAmount`, `addedBy`, `status`) VALUES ('".$chequeBillDate."','".$chequeBillRep."','".$chequeBillCustomerCode."','".$chequeBillCustomerName."','".$chequeBillNo."','".$chequeNo."','".$chequeBillBank."','".$chequeDate."','".$chequeBillAmount."','".$data['staffsId']."','In Progress')";
        $result = mysqli_query($conn,$sql);
    }

    function editChqBillDetails($conn,$chequeBillDate,$chequeBillRep,$chequeBillCustomerCode,$chequeBillCustomerName,$chequeBillNo,$chequeNo,$chequeBillBank,$chequeDate,$chequeBillAmount){
        $sql = "UPDATE `tblChequeBillDetails` SET `chequeBillDate`='".$chequeBillDate."', `chequeBillRep`='".$chequeBillRep."', `chequeBillCustomerCode`='".$chequeBillCustomerCode."', `chequeBillCustomerName`='".$chequeBillCustomerName."', `chequeBillNo`='".$chequeBillNo."', `chequeBillBank`='".$chequeBillBank."', `chequeDate`='".$chequeDate."', `chequeBillAmount`='".$chequeBillAmount."' WHERE `chequeNo`='".$chequeNo."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Cheque Bill Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showChqBillInProgressesInformations($conn){
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            $total = 0;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['chequeBillDate']."</td>";
                    echo "<td>".strtoupper($row['chequeBillCustomerCode'])."</td>";
                    echo "<td>".ucwords($row['chequeBillCustomerName'])."</td>";
                    echo "<td>".strtoupper($row['chequeBillNo'])."</td>";

                    $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['chequeBillRep']."'";
                    $result2 = mysqli_query($conn,$sql2);
                    $data2 = $result2->fetch_assoc();

                    echo "<td>".ucwords($data2['routeName'])."</td>";

                    echo "<td>".ucwords($row['chequeBillRep'])."</td>";
                    echo "<td>".strtoupper($row['chequeNo'])."</td>";
                    echo "<td>".$row['chequeDate']."</td>";
                    echo "<td>".ucwords($row['chequeBillBank'])."</td>";
                    echo "<td>".number_format($row['chequeBillAmount'],2)." Rs</td>";
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Remove Bill' onclick='validateForm16()'>
                                            <i class='fas fa-minus'></i>
                                        </button>
                                        <input type='hidden' name='removeChqBill' value='".$row['chequeNo']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <a href='admin.php?chqsd&chqbe=".$row['chequeNo']."' class='btn btn-warning btn-sm' title='Edit Invoinvoce'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </div>
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
                $total = $total + $row['chequeBillAmount'];
            }
            echo "<tr>";
                echo "<td colspan='10'>
                        Total
                    </td>";
                echo "<td>
                        <strong>".number_format($total,2)." Rs</strong>
                    </td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td colspan='12'>
                        <div class='row' style='float: right;'>
                            <div class='col-3'>
                                <form action='' method='POST'>
                                    <button name='btnSaveAll' class='btn btn-success btn-sm' title='Save All Bills' onclick='validateForm17()'>
                                        <i class='fas fa-check'></i>
                                    </button>
                                    <input type='hidden' name='saveAllChqBill' value=''>
                                </form>
                            </div>
                            <div class='col-3'>
                                <form action='' method='POST'>
                                    <button name='btnRemoveAll' class='btn btn-danger btn-sm' title='Remove All Bills' onclick='validateForm18()'>
                                        <i class='fas fa-eraser'></i>
                                    </button>
                                    <input type='hidden' name='removeAllChqBill' value=''>
                                </form>
                            </div>
                        </div>
                    </td>";
            echo "</tr>";
        }
    }

    function removeChqBillInProgressesInformations($conn,$removeChqNo){
        $sql = "DELETE FROM `tblchequebilldetails` WHERE chequeNo='".$removeChqNo."'";
        $result = mysqli_query($conn,$sql);
    }

    function removeAllChqBillInProgressesInformations($conn){
        $sql = "DELETE FROM `tblchequebilldetails` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);
    }

    function fetchChqBillDetails($conn,$chqbe){
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE `chequeNo`='".$chqbe."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    function addAllChqBillInProgressesInformations($conn,$txtUserId){

        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_assoc($result)){
            $sql1 = "UPDATE `tblchequebilldetails` SET `status`='".$txtStatus."' WHERE `chequeNo`='".$row['chequeNo']."'";
            $result1 = mysqli_query($conn,$sql1); 
        }
    }

    function showChqBillAfterInProgressesInformations($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE status<>'In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){

                $sql0 = "SELECT * FROM `tblchequedeposite` WHERE `chequeNo`='".$row['chequeNo']."'";
                $result0 = mysqli_query($conn,$sql0);
                if(mysqli_num_rows($result0)==1){

                    echo "<tr class='table-success'>";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['chequeBillDate']."</td>";
                        echo "<td>".strtoupper($row['chequeBillCustomerCode'])."</td>";
                        echo "<td>".ucwords($row['chequeBillCustomerName'])."</td>";
                        echo "<td>".strtoupper($row['chequeBillNo'])."</td>";

                        $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['chequeBillRep']."'";
                        $result2 = mysqli_query($conn,$sql2);
                        $data2 = $result2->fetch_assoc();

                        echo "<td>".ucwords($data2['routeName'])."</td>";

                        echo "<td>".ucwords($row['chequeBillRep'])."</td>";
                        echo "<td>".strtoupper($row['chequeNo'])."</td>";
                        echo "<td>".ucwords($row['chequeBillBank'])."</td>";
                        echo "<td>".$row['chequeDate']."</td>";

                        $date1=date_create($row['chequeDate']);
                        $date2=date_create(date("Y-m-d"));
                        $diff=date_diff($date2,$date1);
                        if($diff->format("%R%a days")>=0){
                            echo "<td style='color: green;'><strong>".$diff->format("%R%a days")."</strong></td>";
                        }
                        else{
                            echo "<td style='color: red;'><strong>".$diff->format("%R%a days")."</strong></td>";
                        }

                        echo "<td>".number_format($row['chequeBillAmount'],2)." Rs</td>";
                        if($row['status'] == 'active'){
                            echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($row['status'] == 'pending'){
                            echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($dataUser['type']=='admin'){
                            echo "<td>
                                    <div class='row'>
                                        <div class='col-3'>
                                            <form action='' method='POST'>
                                                <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm19()'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                                <input type='hidden' name='deleteChqBill' value='".$row['chequeNo']."'>
                                            </form>
                                        </div>
                                        <div class='col-3'>
                                            <a href='admin.php?chqsd&chqbe=".$row['chequeNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>";
                        }
                            
                    echo "</tr>";

                }
                else{

                    $date1=date_create($row['chequeDate']);
                    $date2=date_create(date("Y-m-d"));
                    $diff=date_diff($date2,$date1);
                    $trClass = ($diff->format("%R%a days")>=0) ? " class='table-warning'" : " class='table-danger'";
                    echo "<tr" . $trClass . ">";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['chequeBillDate']."</td>";
                        echo "<td>".strtoupper($row['chequeBillCustomerCode'])."</td>";
                        echo "<td>".ucwords($row['chequeBillCustomerName'])."</td>";
                        echo "<td>".strtoupper($row['chequeBillNo'])."</td>";

                        $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['chequeBillRep']."'";
                        $result2 = mysqli_query($conn,$sql2);
                        $data2 = $result2->fetch_assoc();

                        echo "<td>".ucwords($data2['routeName'])."</td>";

                        echo "<td>".ucwords($row['chequeBillRep'])."</td>";
                        echo "<td>".strtoupper($row['chequeNo'])."</td>";
                        echo "<td>".ucwords($row['chequeBillBank'])."</td>";
                        echo "<td>".$row['chequeDate']."</td>";

                        if($diff->format("%R%a days")>=0){
                            echo "<td style='color: green;'><strong>".$diff->format("%R%a days")."</strong></td>";
                        }
                        else{
                            echo "<td style='color: red;'><strong>".$diff->format("%R%a days")."</strong></td>";
                        }

                        echo "<td>".number_format($row['chequeBillAmount'],2)." Rs</td>";
                        if($row['status'] == 'active'){
                            echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($row['status'] == 'pending'){
                            echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($dataUser['type']=='admin'){
                            echo "<td>
                                    <div class='row'>
                                        <div class='col-3'>
                                            <form action='' method='POST'>
                                                <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm19()'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                                <input type='hidden' name='deleteChqBill' value='".$row['chequeNo']."'>
                                            </form>
                                        </div>
                                        <div class='col-3'>
                                            <a href='admin.php?chqsd&chqbe=".$row['chequeNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>";
                        }
                            
                    echo "</tr>";

                }

                $no++;
            }
        }
    }

    function deleteChqBillInformations($conn,$deleteChqBill){
        $sql = "DELETE FROM `tblchequebilldetails` WHERE chequeNo='".$deleteChqBill."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Cheque Bill Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function findChqBillDetails($conn,$datFrom,$datTo,$txtRep,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($txtRep == 'all')){
            $sql = "SELECT * FROM `tblchequebilldetails` WHERE status<>'In Progress' AND chequeBillDate=".$datFrom."";
        }
        elseif(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL)){
            $sql = "SELECT * FROM `tblchequebilldetails` WHERE status<>'In Progress' AND (chequeBillDate='".$datFrom."') AND chequeBillRep='".$txtRep."'";
        }
        elseif(($txtRep == 'all')){
            $sql = "SELECT * FROM `tblchequebilldetails` WHERE status<>'In Progress' AND (chequeBillDate BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        else{
            $sql = "SELECT * FROM `tblchequebilldetails` WHERE status<>'In Progress' AND (chequeBillDate BETWEEN '".$datFrom."' AND '".$datTo."') AND (chequeBillRep='".$txtRep."')";
        }
        
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                $sql0 = "SELECT * FROM `tblchequedeposite` WHERE `chequeNo`='".$row['chequeNo']."'";
                $result0 = mysqli_query($conn,$sql0);
                if(mysqli_num_rows($result0)==1){

                    echo "<tr class='table-success'>";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['chequeBillDate']."</td>";
                        echo "<td>".strtoupper($row['chequeBillCustomerCode'])."</td>";
                        echo "<td>".ucwords($row['chequeBillCustomerName'])."</td>";
                        echo "<td>".strtoupper($row['chequeBillNo'])."</td>";

                        $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['chequeBillRep']."'";
                        $result2 = mysqli_query($conn,$sql2);
                        $data2 = $result2->fetch_assoc();

                        echo "<td>".ucwords($data2['routeName'])."</td>";

                        echo "<td>".ucwords($row['chequeBillRep'])."</td>";
                        echo "<td>".strtoupper($row['chequeNo'])."</td>";
                        echo "<td>".ucwords($row['chequeBillBank'])."</td>";
                        echo "<td>".$row['chequeDate']."</td>";

                        $date1=date_create($row['chequeDate']);
                        $date2=date_create(date("Y-m-d"));
                        $diff=date_diff($date2,$date1);
                        if($diff->format("%R%a days")>=0){
                            echo "<td style='color: green;'><strong>".$diff->format("%R%a days")."</strong></td>";
                        }
                        else{
                            echo "<td style='color: red;'><strong>".$diff->format("%R%a days")."</strong></td>";
                        }

                        echo "<td>".number_format($row['chequeBillAmount'],2)." Rs</td>";
                        if($row['status'] == 'active'){
                            echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($row['status'] == 'pending'){
                            echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($dataUser['type']=='admin'){
                            echo "<td>
                                    <div class='row'>
                                        <div class='col-3'>
                                            <form action='' method='POST'>
                                                <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm19()'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                                <input type='hidden' name='deleteChqBill' value='".$row['chequeNo']."'>
                                            </form>
                                        </div>
                                        <div class='col-3'>
                                            <a href='admin.php?chqsd&chqbe=".$row['chequeNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>";
                        }
                            
                    echo "</tr>";

                }
                else{

                    $date1=date_create($row['chequeDate']);
                    $date2=date_create(date("Y-m-d"));
                    $diff=date_diff($date2,$date1);
                    $trClass = ($diff->format("%R%a days")>=0) ? " class='table-warning'" : " class='table-danger'";
                    echo "<tr" . $trClass . ">";
                        echo "<td>".$no."</td>";
                        echo "<td>".$row['chequeBillDate']."</td>";
                        echo "<td>".strtoupper($row['chequeBillCustomerCode'])."</td>";
                        echo "<td>".ucwords($row['chequeBillCustomerName'])."</td>";
                        echo "<td>".strtoupper($row['chequeBillNo'])."</td>";

                        $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['chequeBillRep']."'";
                        $result2 = mysqli_query($conn,$sql2);
                        $data2 = $result2->fetch_assoc();

                        echo "<td>".ucwords($data2['routeName'])."</td>";

                        echo "<td>".ucwords($row['chequeBillRep'])."</td>";
                        echo "<td>".strtoupper($row['chequeNo'])."</td>";
                        echo "<td>".ucwords($row['chequeBillBank'])."</td>";
                        echo "<td>".$row['chequeDate']."</td>";

                        if($diff->format("%R%a days")>=0){
                            echo "<td style='color: green;'><strong>".$diff->format("%R%a days")."</strong></td>";
                        }
                        else{
                            echo "<td style='color: red;'><strong>".$diff->format("%R%a days")."</strong></td>";
                        }

                        echo "<td>".number_format($row['chequeBillAmount'],2)." Rs</td>";
                        if($row['status'] == 'active'){
                            echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($row['status'] == 'pending'){
                            echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                        }
                        if($dataUser['type']=='admin'){
                            echo "<td>
                                    <div class='row'>
                                        <div class='col-3'>
                                            <form action='' method='POST'>
                                                <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm19()'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                                <input type='hidden' name='deleteChqBill' value='".$row['chequeNo']."'>
                                            </form>
                                        </div>
                                        <div class='col-3'>
                                            <a href='admin.php?chqsd&chqbe=".$row['chequeNo']."' class='btn btn-warning btn-sm' title='Edit AC Bill'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>";
                        }
                            
                    echo "</tr>";

                }
                $no++;
            }
        }

    }

    function addCashBillDetails($conn,$txtUserId,$cashBillDate,$cashBillRep,$cashBillCustomerCode,$cashBillCustomerName,$cashBillNo,$cashBillAmount){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "INSERT INTO `tblcashbilldetails`(`cashBillDate`, `cashBillRep`, `cashBillCustomerCode`, `cashBillCustomerName`, `cashBillNo`, `cashBillAmount`, `addedBy`, `status`) VALUES ('".$cashBillDate."','".$cashBillRep."','".$cashBillCustomerCode."','".$cashBillCustomerName."','".$cashBillNo."','".$cashBillAmount."','".$data['staffsId']."','In Progress')";
        $result = mysqli_query($conn,$sql);
    }

    function editCashBillDetails($conn,$cashBillDate,$cashBillRep,$cashBillCustomerCode,$cashBillCustomerName,$cashBillNo,$cashBillAmount){
        $sql = "UPDATE `tblcashbilldetails` SET `cashBillDate`='".$cashBillDate."', `cashBillRep`='".$cashBillRep."', `cashBillCustomerCode`='".$cashBillCustomerCode."', `cashBillCustomerName`='".$cashBillCustomerName."', `cashBillAmount`='".$cashBillAmount."' WHERE `cashBillNo`='".$cashBillNo."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Cash Bill Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showCashBillInProgressesInformations($conn){
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            $total = 0;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['cashBillDate']."</td>";
                    echo "<td>".strtoupper($row['cashBillCustomerCode'])."</td>";
                    echo "<td>".ucwords($row['cashBillCustomerName'])."</td>";
                    echo "<td>".strtoupper($row['cashBillNo'])."</td>";

                    $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['cashBillRep']."'";
                    $result2 = mysqli_query($conn,$sql2);
                    $data2 = $result2->fetch_assoc();

                    echo "<td>".ucwords($data2['routeName'])."</td>";

                    echo "<td>".ucwords($row['cashBillRep'])."</td>";
                    echo "<td>".number_format($row['cashBillAmount'],2)." Rs</td>";
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Remove Bill' onclick='validateForm20()'>
                                            <i class='fas fa-minus'></i>
                                        </button>
                                        <input type='hidden' name='removeCashBill' value='".$row['cashBillNo']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <a href='admin.php?cahsd&cshbe=".$row['cashBillNo']."' class='btn btn-warning btn-sm' title='Edit Invoinvoce'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </div>
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
                $total = $total + $row['cashBillAmount'];
            }
            echo "<tr>";
                echo "<td colspan='7'>
                        Total
                    </td>";
                echo "<td>
                        <strong>".number_format($total,2)." Rs</strong>
                    </td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td colspan='12'>
                        <div class='row' style='float: right;'>
                            <div class='col-3'>
                                <form action='' method='POST'>
                                    <button name='btnSaveAll' class='btn btn-success btn-sm' title='Save All Bills' onclick='validateForm21()'>
                                        <i class='fas fa-check'></i>
                                    </button>
                                    <input type='hidden' name='saveAllCashBill' value=''>
                                </form>
                            </div>
                            <div class='col-3'>
                                <form action='' method='POST'>
                                    <button name='btnRemoveAll' class='btn btn-danger btn-sm' title='Remove All Bills' onclick='validateForm22()'>
                                        <i class='fas fa-eraser'></i>
                                    </button>
                                    <input type='hidden' name='removeAllCashBill' value=''>
                                </form>
                            </div>
                        </div>
                    </td>";
            echo "</tr>";
        }
    }

    function removeCashBillInProgressesInformations($conn,$removeCashNo){
        $sql = "DELETE FROM `tblcashbilldetails` WHERE cashBillNo='".$removeCashNo."'";
        $result = mysqli_query($conn,$sql);
    }

    function removeAllCashBillInProgressesInformations($conn){
        $sql = "DELETE FROM `tblcashbilldetails` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);
    }

    function fetchCashBillDetails($conn,$cshbe){
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE `cashBillNo`='".$cshbe."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    function addAllCashBillInProgressesInformations($conn,$txtUserId){

        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_assoc($result)){
            $sql1 = "UPDATE `tblcashbilldetails` SET `status`='".$txtStatus."' WHERE `cashBillNo`='".$row['cashBillNo']."'";
            $result1 = mysqli_query($conn,$sql1); 
        }
    }

    function showCashBillAfterInProgressesInformations($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE status<>'In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['cashBillDate']."</td>";
                    echo "<td>".strtoupper($row['cashBillCustomerCode'])."</td>";
                    echo "<td>".ucwords($row['cashBillCustomerName'])."</td>";
                    echo "<td>".strtoupper($row['cashBillNo'])."</td>";

                    $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['cashBillRep']."'";
                    $result2 = mysqli_query($conn,$sql2);
                    $data2 = $result2->fetch_assoc();

                    echo "<td>".ucwords($data2['routeName'])."</td>";

                    echo "<td>".ucwords($row['cashBillRep'])."</td>";
                    echo "<td>".number_format($row['cashBillAmount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm23()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteCashBill' value='".$row['cashBillNo']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <a href='admin.php?cahsd&cshbe=".$row['cashBillNo']."' class='btn btn-warning btn-sm' title='Edit Cash Bill'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
        }
    }

    function deleteCashBillInformations($conn,$deleteCashBill){
        $sql = "DELETE FROM `tblcashbilldetails` WHERE cashBillNo='".$deleteCashBill."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Cash Bill Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function findCashBillDetails($conn,$datFrom,$datTo,$txtRep,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($txtRep == 'all')){
            $sql = "SELECT * FROM `tblcashbilldetails` WHERE status<>'In Progress' AND cashBillDate=".$datFrom."";
        }
        elseif(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL)){
            $sql = "SELECT * FROM `tblcashbilldetails` WHERE status<>'In Progress' AND (cashBillDate='".$datFrom."') AND cashBillRep='".$txtRep."'";
        }
        elseif(($txtRep == 'all')){
            $sql = "SELECT * FROM `tblcashbilldetails` WHERE status<>'In Progress' AND (cashBillDate BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        else{
            $sql = "SELECT * FROM `tblcashbilldetails` WHERE status<>'In Progress' AND (cashBillDate BETWEEN '".$datFrom."' AND '".$datTo."') AND (cashBillRep='".$txtRep."')";
        }
        
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['cashBillDate']."</td>";
                    echo "<td>".strtoupper($row['cashBillCustomerCode'])."</td>";
                    echo "<td>".ucwords($row['cashBillCustomerName'])."</td>";
                    echo "<td>".strtoupper($row['cashBillNo'])."</td>";

                    $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['cashBillRep']."'";
                    $result2 = mysqli_query($conn,$sql2);
                    $data2 = $result2->fetch_assoc();

                    echo "<td>".ucwords($data2['routeName'])."</td>";

                    echo "<td>".ucwords($row['cashBillRep'])."</td>";
                    echo "<td>".number_format($row['cashBillAmount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm23()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteCashBill' value='".$row['cashBillNo']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <a href='admin.php?cahsd&cshbe=".$row['cashBillNo']."' class='btn btn-warning btn-sm' title='Edit Cash Bill'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
        }

    }

    function addCashDepositeDetails($conn,$txtUserId,$date,$accountHolderName,$accountNo,$bank,$amount){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        $sql = "INSERT INTO `tblcashdeposite`(`date`, `accountHolderName`, `accountNo`, `bank`, `amount`, `addedBy`, `status`) VALUES ('".$date."','".$accountHolderName."','".$accountNo."','".$bank."','".$amount."','".$data['staffsId']."','".$txtStatus."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showCashDepositeAfterInProgressesInformations($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblcashdeposite` WHERE status<>'In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['accountHolderName'])."</td>";
                    echo "<td>".$row['accountNo']."</td>";
                    echo "<td>".ucwords($row['bank'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Ledger' onclick='validateForm24()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteCashDeposite' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <a href='admin.php?cshdep&cshde=".$row['id']."' class='btn btn-warning btn-sm' title='Edit Cash Deposite'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
        }
    }

    function findCashDepositeDetails($conn,$datFrom,$datTo,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL)){
            $sql = "SELECT * FROM `tblcashdeposite` WHERE status<>'In Progress' AND (date='".$datFrom."')";
        }
        else{
            $sql = "SELECT * FROM `tblcashdeposite` WHERE status<>'In Progress' AND (date BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['accountHolderName'])."</td>";
                    echo "<td>".$row['accountNo']."</td>";
                    echo "<td>".ucwords($row['bank'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Ledger' onclick='validateForm24()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteCashDeposite' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <a href='admin.php?cshdep&cshde=".$row['id']."' class='btn btn-warning btn-sm' title='Edit Cash Deposite'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
        }

    }

    function deleteCashDepositeInformations($conn,$deleteCashDeposite){
        $sql = "DELETE FROM `tblcashdeposite` WHERE id='".$deleteCashDeposite."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Cash Deposite Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function fetchCashDepositeDetails($conn,$cshde){
        $sql = "SELECT * FROM `tblcashdeposite` WHERE `id`='".$cshde."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    function editCashDepositeDetails($conn,$date,$accountHolderName,$accountNo,$bank,$amount,$cshde){
        $sql = "UPDATE `tblcashdeposite` SET `date`='".$date."', `accountHolderName`='".$accountHolderName."', `accountNo`='".$accountNo."', `bank`='".$bank."', `amount`='".$amount."' WHERE `id`='".$cshde."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Cash Deposite Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function addChequeDepositeDetails($conn,$txtUserId,$date,$accountHolderName,$accountNo,$chequeNo,$bank,$amount){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        $sql = "INSERT INTO `tblchequedeposite`(`date`, `accountHolderName`, `accountNo`, `chequeNo`, `bank`, `amount`, `addedBy`, `status`) VALUES ('".$date."','".$accountHolderName."','".$accountNo."','".$chequeNo."','".$bank."','".$amount."','".$data['staffsId']."','".$txtStatus."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showChqeueDepositeAfterInProgressesInformations($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblchequedeposite` WHERE status<>'In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['accountHolderName'])."</td>";
                    echo "<td>".$row['accountNo']."</td>";
                    echo "<td>".$row['chequeNo']."</td>";
                    echo "<td>".ucwords($row['bank'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Ledger' onclick='validateForm24()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteChqeueDeposite' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <a href='admin.php?chqdep&chqde=".$row['id']."' class='btn btn-warning btn-sm' title='Edit Cash Deposite'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
        }
    }

    function findChqeueDepositeDetails($conn,$datFrom,$datTo,$txtChequeNo,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($txtChequeNo == "")){
            $sql = "SELECT * FROM `tblchequedeposite` WHERE status<>'In Progress' AND (date='".$datFrom."')";
        }
        elseif(($txtChequeNo == "")){
            $sql = "SELECT * FROM `tblchequedeposite` WHERE status<>'In Progress' AND (date BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        elseif(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($datFrom == '' && $datFrom == "" && $datFrom = null && $datFrom == NULL)){
            $sql = "SELECT * FROM `tblchequedeposite` WHERE status<>'In Progress' AND (chequeNo='".$txtChequeNo."')";
        }
        else{
            $sql = "SELECT * FROM `tblchequedeposite` WHERE status<>'In Progress' AND (date BETWEEN '".$datFrom."' AND '".$datTo."') AND (chequeNo='".$txtChequeNo."')";
        }
        
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['accountHolderName'])."</td>";
                    echo "<td>".$row['accountNo']."</td>";
                    echo "<td>".$row['chequeNo']."</td>";
                    echo "<td>".ucwords($row['bank'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Ledger' onclick='validateForm25()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteChqeueDeposite' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <a href='admin.php?chqdep&chqde=".$row['id']."' class='btn btn-warning btn-sm' title='Edit Cash Deposite'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
        }

    }

    function deleteChequeDepositeInformations($conn,$deleteChequeDeposite){
        $sql = "DELETE FROM `tblchequedeposite` WHERE id='".$deleteChequeDeposite."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Cheque Deposite Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function fetchChequeDepositeDetails($conn,$chqde){
        $sql = "SELECT * FROM `tblchequedeposite` WHERE `id`='".$chqde."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    function editChequeDepositeDetails($conn,$date,$accountHolderName,$accountNo,$chequeNo,$bank,$amount,$chqde){
        $sql = "UPDATE `tblchequedeposite` SET `date`='".$date."', `accountHolderName`='".$accountHolderName."', `accountNo`='".$accountNo."', `chequeNo`='".$chequeNo."', `bank`='".$bank."', `amount`='".$amount."' WHERE `id`='".$chqde."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Cheque Deposite Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }


    function addVoucherDetails($conn,$txtUserId,$date,$voucherNo,$description,$amount){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        $sql = "INSERT INTO `tblvoucher`(`date`, `voucherNo`, `description`, `amount`, `addedBy`, `status`) VALUES ('".$date."','".$voucherNo."','".$description."','".$amount."','".$data['staffsId']."','".$txtStatus."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showVoucherAfterInProgressesInformations($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblvoucher` WHERE status<>'In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['voucherNo'])."</td>";
                    echo "<td>".ucwords($row['description'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Ledger' onclick='validateForm25()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteVoucherDeposite' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <a href='admin.php?voucher&vhre=".$row['id']."' class='btn btn-warning btn-sm' title='Edit Voucher'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
        }
    }

    function findVoucherDetails($conn,$datFrom,$datTo,$txtVoucherNo,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($txtVoucherNo == "")){
            $sql = "SELECT * FROM `tblvoucher` WHERE status<>'In Progress' AND (date='".$datFrom."')";
        }
        elseif(($txtVoucherNo == "")){
            $sql = "SELECT * FROM `tblvoucher` WHERE status<>'In Progress' AND (date BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        elseif(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($datFrom == '' && $datFrom == "" && $datFrom = null && $datFrom == NULL)){
            $sql = "SELECT * FROM `tblvoucher` WHERE status<>'In Progress' AND (chequeNo='".$txtVoucherNo."')";
        }
        else{
            $sql = "SELECT * FROM `tblvoucher` WHERE status<>'In Progress' AND (date BETWEEN '".$datFrom."' AND '".$datTo."') AND (voucherNo='".$txtVoucherNo."')";
        }
        
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$row['date']."</td>";
                echo "<td>".ucwords($row['voucherNo'])."</td>";
                echo "<td>".ucwords($row['description'])."</td>";
                echo "<td>".number_format($row['amount'],2)." Rs</td>";
                if($row['status'] == 'active'){
                    echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                }
                if($row['status'] == 'pending'){
                    echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                }
                if($dataUser['type']=='admin'){
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Ledger' onclick='validateForm25()'>
                                            <i class='fas fa-trash-alt'></i>
                                        </button>
                                        <input type='hidden' name='deleteVoucherDeposite' value='".$row['id']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <a href='admin.php?voucher&vhre=".$row['id']."' class='btn btn-warning btn-sm' title='Edit Voucher'>
                                        <i class='fas fa-edit'></i>
                                    </a>
                                </div>
                            </div>
                        </td>";
                }
                    
                echo "</tr>";
                $no++;
            }
        }

    }

    function deleteVoucherInformations($conn,$deleteVoucherDeposite){
        $sql = "DELETE FROM `tblvoucher` WHERE id='".$deleteVoucherDeposite."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Voucher Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function fetchVoucherDetails($conn,$vhre){
        $sql = "SELECT * FROM `tblvoucher` WHERE `id`='".$vhre."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    function editVoucherDetails($conn,$date,$voucherNo,$description,$amount,$vhre){
        $sql = "UPDATE `tblvoucher` SET `date`='".$date."', `voucherNo`='".$voucherNo."', `description`='".$description."', `amount`='".$amount."' WHERE `id`='".$vhre."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Voucher Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }


    function addExpensivesDetails($conn,$txtUserId,$date,$type,$amount){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        $sql = "INSERT INTO `tblexpensives`(`date`, `type`, `amount`, `addedBy`, `status`) VALUES ('".$date."','".$type."','".$amount."','".$data['staffsId']."','".$txtStatus."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showExpensivesAfterInProgressesInformations($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblexpensives` WHERE status<>'In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['type'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Ledger' onclick='validateForm25()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteExpensives' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <a href='admin.php?expensive&expe=".$row['id']."' class='btn btn-warning btn-sm' title='Edit Expensive'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
        }
    }

    function findExpensivesDetails($conn,$datFrom,$datTo,$txtExpensive,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($txtExpensive == "")){
            $sql = "SELECT * FROM `tblexpensives` WHERE status<>'In Progress' AND (date='".$datFrom."')";
        }
        elseif(($txtExpensive == "")){
            $sql = "SELECT * FROM `tblexpensives` WHERE status<>'In Progress' AND (date BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        elseif(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($datFrom == '' && $datFrom == "" && $datFrom = null && $datFrom == NULL)){
            $sql = "SELECT * FROM `tblexpensives` WHERE status<>'In Progress' AND (chequeNo='".$txtExpensive."')";
        }
        else{
            $sql = "SELECT * FROM `tblexpensives` WHERE status<>'In Progress' AND (date BETWEEN '".$datFrom."' AND '".$datTo."') AND (type='".$txtExpensive."')";
        }
        
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['type'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Ledger' onclick='validateForm25()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteExpensives' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <a href='admin.php?expensive&expe=".$row['id']."' class='btn btn-warning btn-sm' title='Edit Expensive'>
                                            <i class='fas fa-edit'></i>
                                        </a>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
        }

    }

    function deleteExpensivesInformations($conn,$deleteExpensives){
        $sql = "DELETE FROM `tblexpensives` WHERE id='".$deleteExpensives."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Expensives Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function fetchExpensivesDetails($conn,$expe){
        $sql = "SELECT * FROM `tblexpensives` WHERE `id`='".$expe."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    function editExpensivesDetails($conn,$date,$type,$amount,$expe){
        $sql = "UPDATE `tblexpensives` SET `date`='".$date."', `type`='".$type."', `amount`='".$amount."' WHERE `id`='".$expe."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Expensives Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function addACBillToCollectInRepHandAtInProgress($conn,$txtUserId,$date,$billNo){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = 'In Progress';
        $sql = "INSERT INTO `tblacbilltocollectinrephand`(`date`, `billNo`, `addedBy`, `status`) VALUES ('".$date."','".$billNo."','".$data['staffsId']."','".$txtStatus."')";
        $result = mysqli_query($conn,$sql);
    }

    function showACBillToCollectInRepHandAtInProgress($conn){
        $sql = "SELECT * FROM `tblacbilltocollectinrephand` WHERE `status`='In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            $total1 = 0;
            $total2 = 0;
            $total3 = 0;
            while($row = mysqli_fetch_assoc($result)){
                $billAmount = 0;
                $sql1 = "SELECT * FROM `tblacbill` WHERE `billNo`='".$row['billNo']."'";
                $result1 = mysqli_query($conn,$sql1);
                $data1 = $result1->fetch_assoc();
                if(mysqli_num_rows($result1)==1){
                    $billAmount = $data1['amount'];
                }
                $billCollectedAmount = 0;
                $sql2 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
                $result2 = mysqli_query($conn,$sql2);
                if(mysqli_num_rows($result2)>=1){
                    while($row1 = mysqli_fetch_assoc($result2)){
                        $billCollectedAmount = $billCollectedAmount + $row1['amount'];
                    }
                }
                $balanceCollection = $billAmount - $billCollectedAmount;
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".ucwords($data1['custermerName'])."</td>";
                    echo "<td>".strtoupper($row['billNo'])."</td>";
                    echo "<td>".number_format($billAmount,2)." Rs</td>";
                    echo "<td>".number_format($billCollectedAmount,2)." Rs</td>";
                    echo "<td>".number_format($balanceCollection,2)." Rs</td>";
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Remove Bill' onclick='validateForm26()'>
                                            <i class='fas fa-minus'></i>
                                        </button>
                                        <input type='hidden' name='removeACBillColtDetails' value='".$row['id']."'>
                                    </form>
                                </div>
                                <div class='col-3'>
                                    <form action='' method='POST'>
                                        <a href='".$_SERVER['PHP_SELF']."?acbillnrepcol&vid=".$row['billNo']."' class='btn btn-primary btn-sm' title='View Other Details'>
                                            <i class='fas fa-eye'></i>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
                $total1 = $total1 + $billAmount;
                $total2 = $total2 + $billCollectedAmount;
                $total3 = $total3 + $balanceCollection;
            }
            echo "<tr>";
                echo "<td colspan='3'>Total</td>";
                echo "<td><strong>".number_format($total1,2)." Rs</strong></td>";
                echo "<td><strong>".number_format($total2,2)." Rs</strong></td>";
                echo "<td><strong>".number_format($total3,2)." Rs</strong></td>";
            echo "</tr>";
        }
    }

    function removeACBillToCollectInRepHandAtInProgress($conn,$removeACBillColtDetails){
        $sql = "DELETE FROM `tblacbilltocollectinrephand` WHERE `id`='".$removeACBillColtDetails."'";
        $result = mysqli_query($conn,$sql);
    }

    function addAllACBillToCollectInRepHandAtOutOfInProgress($conn,$txtUserId){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        
        $sql = "SELECT * FROM `tblacbilltocollectinrephand` WHERE status='In Progress'";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_assoc($result)){
            $sql1 = "UPDATE `tblacbilltocollectinrephand` SET `status`='".$txtStatus."' WHERE `id`='".$row['id']."'";
            $result1 = mysqli_query($conn,$sql1); 
        }
    }

    function showACBillToCollectInRepHandAtInProgressDetailsOfOtherBills($conn,$vid){
        $sql = "SELECT * FROM `tblacbill` WHERE `billNo`='".$vid."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        $sql0 = "SELECT * FROM `tblacbill` WHERE `customerId`='".$data['customerId']."'";
        $result0 = mysqli_query($conn,$sql0);
        if(mysqli_num_rows($result0)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result0)){
                $billAmount = 0;
                $sql1 = "SELECT * FROM `tblacbill` WHERE `billNo`='".$row['billNo']."'";
                $result1 = mysqli_query($conn,$sql1);
                $data1 = $result1->fetch_assoc();
                if(mysqli_num_rows($result1)==1){
                    $billAmount = $data1['amount'];
                }
                $billCollectedAmount = 0;
                $sql2 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
                $result2 = mysqli_query($conn,$sql2);
                if(mysqli_num_rows($result2)>=1){
                    while($row1 = mysqli_fetch_assoc($result2)){
                        $billCollectedAmount = $billCollectedAmount + $row1['amount'];
                    }
                }
                $balanceCollection = $billAmount - $billCollectedAmount;
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".ucwords($data1['custermerName'])."</td>";
                    echo "<td>".strtoupper($row['billNo'])."</td>";
                    echo "<td>".number_format($billAmount)."</td>";
                    echo "<td>".number_format($billCollectedAmount)."</td>";
                    echo "<td>".number_format($balanceCollection)."</td>";
                echo "</tr>";
                $no++;
            }
        }
    }

    function showACBillToCollectInRepHandAtAfterInProgress($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblacbilltocollectinrephand` WHERE `status`<>'In Progress'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                $billAmount = 0;
                $sql1 = "SELECT * FROM `tblacbill` WHERE `billNo`='".$row['billNo']."'";
                $result1 = mysqli_query($conn,$sql1);
                $data1 = $result1->fetch_assoc();
                if(mysqli_num_rows($result1)==1){
                    $billAmount = $data1['amount'];
                }
                $billCollectedAmount = 0;
                $sql2 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
                $result2 = mysqli_query($conn,$sql2);
                if(mysqli_num_rows($result2)>=1){
                    while($row1 = mysqli_fetch_assoc($result2)){
                        $billCollectedAmount = $billCollectedAmount + $row1['amount'];
                    }
                }
                $balanceCollection = $billAmount - $billCollectedAmount;
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".ucwords($data1['custermerName'])."</td>";
                    echo "<td>".strtoupper($row['billNo'])."</td>";
                    echo "<td>".number_format($billAmount)."</td>";
                    echo "<td>".number_format($billCollectedAmount)."</td>";
                    echo "<td>".number_format($balanceCollection)."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm27()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteACBillColtDetails' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <a href='admin.php?acbillnrepcol&vid=".$row['billNo']."' class='btn btn-primary btn-sm' title='View Other Details'>
                                                <i class='fas fa-eye'></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                echo "</tr>";
                $no++;
            }
        }
    }

    function showACBillToCollectInRepHandAtAfterInProgressFindView($conn,$txtUserId,$date,$billNo){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        if(($billNo == '' && $billNo == "" && $billNo == null && $billNo == NULL)){
            $sql = "SELECT * FROM `tblacbilltocollectinrephand` WHERE `status`<>'In Progress' AND `date`='".$date."'";
        }
        elseif(($date == '' && $date == "" && $date == null && $date == NULL)){
            $sql = "SELECT * FROM `tblacbilltocollectinrephand` WHERE `status`<>'In Progress' AND `billNo`='".$billNo."'";
        }
        else{
            $sql = "SELECT * FROM `tblacbilltocollectinrephand` WHERE `status`<>'In Progress' AND `date`='".$date."' AND `billNo`='".$billNo."'";
        }
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                $billAmount = 0;
                $sql1 = "SELECT * FROM `tblacbill` WHERE `billNo`='".$row['billNo']."'";
                $result1 = mysqli_query($conn,$sql1);
                $data1 = $result1->fetch_assoc();
                if(mysqli_num_rows($result1)==1){
                    $billAmount = $data1['amount'];
                }
                $billCollectedAmount = 0;
                $sql2 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
                $result2 = mysqli_query($conn,$sql2);
                if(mysqli_num_rows($result2)>=1){
                    while($row1 = mysqli_fetch_assoc($result2)){
                        $billCollectedAmount = $billCollectedAmount + $row1['amount'];
                    }
                }
                $balanceCollection = $billAmount - $billCollectedAmount;
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".ucwords($data1['custermerName'])."</td>";
                    echo "<td>".strtoupper($row['billNo'])."</td>";
                    echo "<td>".number_format($billAmount)."</td>";
                    echo "<td>".number_format($billCollectedAmount)."</td>";
                    echo "<td>".number_format($balanceCollection)."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm27()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteACBillColtDetails' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <a href='admin.php?acbillnrepcol&vid=".$row['billNo']."' class='btn btn-primary btn-sm' title='View Other Details'>
                                                <i class='fas fa-eye'></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                echo "</tr>";
                $no++;
            }
        }
    }

    function deleteACBillToCollectInRepHandAtInProgress($conn,$removeACBillColtDetails){
        $sql = "DELETE FROM `tblacbilltocollectinrephand` WHERE `id`='".$removeACBillColtDetails."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function readyToInsertACBillCollectionsData($conn,$billNo){
        $sql = "SELECT * FROM `tblacbill` WHERE `billNo`='".$billNo."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        $sql0 = "SELECT * FROM `tblacbill` WHERE `customerId`='".$data['customerId']."'";
        $result0 = mysqli_query($conn,$sql0);
        if(mysqli_num_rows($result0)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result0)){
                $billAmount = 0;
                $sql1 = "SELECT * FROM `tblacbill` WHERE `billNo`='".$row['billNo']."'";
                $result1 = mysqli_query($conn,$sql1);
                $data1 = $result1->fetch_assoc();
                if(mysqli_num_rows($result1)==1){
                    $billAmount = $data1['amount'];
                }
                $billCollectedAmount = 0;
                $sql2 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
                $result2 = mysqli_query($conn,$sql2);
                if(mysqli_num_rows($result2)>1){
                    while($row1 = mysqli_fetch_assoc($result2)){
                        $balanceCollection = $billAmount - $row1['amount'];
                        if($row['billNo'] == $billNo){
                            echo "<tr class='table-active'>";
                                echo "<td>".$no."</td>";
                                echo "<td>".ucwords($data1['custermerName'])."</td>";
                                echo "<td>".$row['acbillDate']."</td>";
                                echo "<td>".strtoupper($row['billNo'])."</td>";
                                echo "<td>".number_format($billAmount,2)."</td>";
                                echo "<td>".$row1['date']."</td>";
                                echo "<td>".$row1['receptNo']."</td>";
                                echo "<td>".number_format($row1['amount'],2)."</td>";
                                echo "<td>".number_format($balanceCollection,2)."</td>";
                            echo "</tr>";
                        }
                        else{
                            echo "<tr>";
                                echo "<td>".$no."</td>";
                                echo "<td>".ucwords($data1['custermerName'])."</td>";
                                echo "<td>".$row['acbillDate']."</td>";
                                echo "<td>".strtoupper($row['billNo'])."</td>";
                                echo "<td>".number_format($billAmount,2)." Rs</td>";
                                echo "<td>".$row1['date']."</td>";
                                echo "<td>".$row1['receptNo']."</td>";
                                echo "<td>".number_format($row1['amount'],2)." Rs</td>";
                                echo "<td>".number_format($balanceCollection,2)." Rs</td>";
                            echo "</tr>";
                        }
                    }
                }
                elseif(mysqli_num_rows($result2)==1){
                    $data2 = $result2->fetch_assoc();
                    $balanceCollection = $billAmount - $data2['amount'];
                    if($row['billNo'] == $billNo){
                        echo "<tr class='table-active'>";
                            echo "<td>".$no."</td>";
                            echo "<td>".ucwords($data1['custermerName'])."</td>";
                            echo "<td>".$row['acbillDate']."</td>";
                            echo "<td>".strtoupper($row['billNo'])."</td>";
                            echo "<td>".number_format($billAmount,2)." Rs</td>";
                            echo "<td>".$data2['date']."</td>";
                            echo "<td>".$data2['receptNo']."</td>";
                            echo "<td>".number_format($data2['amount'],2)." Rs</td>";
                            echo "<td>".number_format($balanceCollection,2)." Rs</td>";
                        echo "</tr>";
                    }
                    else{
                        echo "<tr>";
                            echo "<td>".$no."</td>";
                            echo "<td>".ucwords($data1['custermerName'])."</td>";
                            echo "<td>".$row['acbillDate']."</td>";
                            echo "<td>".strtoupper($row['billNo'])."</td>";
                            echo "<td>".number_format($billAmount,2)." Rs</td>";
                            echo "<td>".$data2['date']."</td>";
                            echo "<td>".$data2['receptNo']."</td>";
                            echo "<td>".number_format($data2['amount'],2)." Rs</td>";
                            echo "<td>".number_format($balanceCollection,2)." Rs</td>";
                        echo "</tr>";
                    }
                }
                else{
                    $balanceCollection = $billAmount - $billCollectedAmount;
                    if($row['billNo'] == $billNo){
                        echo "<tr class='table-active'>";
                            echo "<td>".$no."</td>";
                            echo "<td>".ucwords($data1['custermerName'])."</td>";
                            echo "<td>".$row['acbillDate']."</td>";
                            echo "<td>".strtoupper($row['billNo'])."</td>";
                            echo "<td>".number_format($billAmount,2)." Rs</td>";
                            echo "<td> - NULL - </td>";
                            echo "<td> - NULL - </td>";
                            echo "<td> - NULL - </td>";
                            echo "<td>".number_format($balanceCollection,2)." Rs</td>";
                        echo "</tr>"; 
                    }
                    else{
                        echo "<tr>";
                            echo "<td>".$no."</td>";
                            echo "<td>".ucwords($data1['custermerName'])."</td>";
                            echo "<td>".$row['acbillDate']."</td>";
                            echo "<td>".strtoupper($row['billNo'])."</td>";
                            echo "<td>".number_format($billAmount,2)." Rs</td>";
                            echo "<td> - NULL - </td>";
                            echo "<td> - NULL - </td>";
                            echo "<td> - NULL - </td>";
                            echo "<td>".number_format($balanceCollection,2)." Rs</td>";
                        echo "</tr>"; 
                    }                   
                }
                $no++;
            }
        }
    }

    function viewCollectingAmount($conn,$billNo){
        $sql = "SELECT * FROM `tblacbill` WHERE `billNo`='".$billNo."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        $sql0 = "SELECT * FROM `tblacbill` WHERE `customerId`='".$data['customerId']."'";
        $result0 = mysqli_query($conn,$sql0);
        $billAmount = 0;
        $billCollectedAmount = 0;
        $balanceCollection = 0;
        if(mysqli_num_rows($result0)>=1){
            while($row = mysqli_fetch_assoc($result0)){
                $billAmount = $billAmount + $row['amount'];

                $sql2 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
                $result2 = mysqli_query($conn,$sql2);
                if(mysqli_num_rows($result2)>1){
                    while($row1 = mysqli_fetch_assoc($result2)){
                        $billCollectedAmount = $billCollectedAmount + $row1['amount'];
                    }
                }
                elseif(mysqli_num_rows($result2)==1){
                    $data2 = $result2->fetch_assoc();
                    $billCollectedAmount = $billCollectedAmount + $data2['amount'];
                }
                else{
                    $billCollectedAmount = $billCollectedAmount + 0;       
                }
            }
        }
        $balanceCollection = $billAmount - $billCollectedAmount;
        return $balanceCollection;
    }

    function sltOptForACBillColt($conn,$billNo){
        $sql = "SELECT * FROM `tblacbill` WHERE `billNo`='".$billNo."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        $sql0 = "SELECT * FROM `tblacbill` WHERE `customerId`='".$data['customerId']."'";
        $result0 = mysqli_query($conn,$sql0);
        $billCollectedAmount = 0;
        $txtSelectedOrNot = "";
        while($row = mysqli_fetch_assoc($result0)){
            $sql2 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
            $result2 = mysqli_query($conn,$sql2);
            if(mysqli_num_rows($result2)>1){
                while($row1 = mysqli_fetch_assoc($result2)){
                    $billCollectedAmount += $row1['amount'];
                }
            }
            elseif(mysqli_num_rows($result2)==1){
                $data2 = $result2->fetch_assoc();
                $billCollectedAmount += $data2['amount'];
            }
            else{
                $billCollectedAmount = $billCollectedAmount;       
            }

            if($row['billNo'] == $billNo){
                $txtSelectedOrNot = "selected";
            }

            if($billCollectedAmount == $row['amount']){
                echo "<option value='".$row['billNo']."' ".$txtSelectedOrNot." disabled>".$row['billNo']." (Fully Collected)</option>";
            }
            if($billCollectedAmount < $row['amount']){
                echo "<option value='".$row['billNo']."' ".$txtSelectedOrNot.">".$row['billNo']."</option>";
            }

        }
    }

    function addACBillCollectionsDataByCash($conn,$txtUserId,$date,$billNo,$receptNo,$paymentMethod,$chequeNo,$bank,$amount){
        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }
        $sql = "INSERT INTO `tblacbillcollection`(`date`, `billNo`, `receptNo`, `paymentMethod`, `chequeNo`, `bank`, `amount`,`addedBy`, `status`) VALUES ('".$date."','".$billNo."','".$receptNo."','".$paymentMethod."','".$chequeNo."','".$bank."','".$amount."','".$data['staffsId']."','".$txtStatus."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function viewACBillCollectionSetails($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblacbillcollection`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                $sql1 = "SELECT * FROM `tblacbill` WHERE `billNo`='".$row['billNo']."'";
                $result1 = mysqli_query($conn,$sql1);
                $data1 = $result1->fetch_assoc();
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".ucwords($data1['custermerName'])."</td>";
                    echo "<td>".$data1['acbillDate']."</td>";
                    echo "<td>".strtoupper($row['billNo'])."</td>";
                    echo "<td>".strtoupper($row['receptNo'])."</td>";
                    echo "<td>Payment Type is : ".ucwords($row['paymentMethod'])."<br>";
                    if($row['paymentMethod']=="Cheque"){
                        echo "Cheque No is : ".strtoupper($row['chequeNo'])."<br>Bank is : ".ucwords($row['bank'])."<br>";
                    }
                    echo "</td>";
                    echo "<td>".number_format($row['amount'])."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm27()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteACBillColtedDetails' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <a href='admin.php?acbcr&abcide=".$row['id']."' class='btn btn-secondary btn-sm' title='Edit Details'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <a href='admin.php?acbcr&abcbidv=".$row['billNo']."' class='btn btn-primary btn-sm' title='View Other Details'>
                                                <i class='fas fa-eye'></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                echo "</tr>";
                $no++;
            }
        }
    }

    function deleteACBillToCollectedDetails($conn,$deleteACBillColtedDetails){
        $sql = "DELETE FROM `tblacbillcollection` WHERE `id`='".$deleteACBillColtedDetails."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function viewOpeningBalanceInCash($conn,$datStart){
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE `cashBillDate` BETWEEN '2021-01-01' AND '".$datStart."'";
        $result = mysqli_query($conn,$sql);
        $totalCashIncome = 0;
        while($row = mysqli_fetch_assoc($result)){
            $totalCashIncome = $totalCashIncome + $row['cashBillAmount'];
        }

        $sql0 = "SELECT * FROM `tblacbillcollection` WHERE `date` BETWEEN '2021-01-01' AND '".$datStart."'";
        $result0 = mysqli_query($conn,$sql0);
        $totalCashIncomeByCollection = 0;
        while($row0 = mysqli_fetch_assoc($result0)){
            if($row0['paymentMethod'] == "Cash"){
                $totalCashIncomeByCollection = $totalCashIncomeByCollection + $row0['amount'];
            }
        }

        $sql1 = "SELECT * FROM `tblcashdeposite` WHERE `date` BETWEEN '2021-01-01' AND '".$datStart."'";
        $result1 = mysqli_query($conn,$sql1);
        $totalCashDeposite = 0;
        while($row1 = mysqli_fetch_assoc($result1)){
            $totalCashDeposite = $totalCashDeposite + $row1['amount'];
        }

        $sql2 = "SELECT * FROM `tblvoucher` WHERE `date` BETWEEN '2021-01-01' AND '".$datStart."'";
        $result2 = mysqli_query($conn,$sql2);
        $totalVoucher = 0;
        while($row2 = mysqli_fetch_assoc($result2)){
            $totalVoucher = $totalVoucher + $row2['amount'];
        }

        $totalOpeningBalanceInCash = ($totalCashIncome + $totalCashIncomeByCollection) - ($totalCashDeposite + $totalVoucher);

        return number_format($totalOpeningBalanceInCash,2);
    }

    function viewOpeningBalanceInCheque($conn,$datStart){
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE `chequeBillDate` BETWEEN '2021-01-01' AND '".$datStart."'";
        $result = mysqli_query($conn,$sql);
        $totalChequeIncome = 0;
        while($row = mysqli_fetch_assoc($result)){
            $totalChequeIncome = $totalChequeIncome + $row['chequeBillAmount'];
        }

        $sql0 = "SELECT * FROM `tblacbillcollection` WHERE `date` BETWEEN '2021-01-01' AND '".$datStart."'";
        $result0 = mysqli_query($conn,$sql0);
        $totalChequeIncomeByCollection = 0;
        while($row0 = mysqli_fetch_assoc($result0)){
            if($row0['paymentMethod'] == "Cheque"){
                $totalChequeIncomeByCollection = $totalChequeIncomeByCollection + $row0['amount'];
            }
        }

        $sql1 = "SELECT * FROM `tblchequedeposite` WHERE `date` BETWEEN '2021-01-01' AND '".$datStart."'";
        $result1 = mysqli_query($conn,$sql1);
        $totalChequeDeposite = 0;
        while($row1 = mysqli_fetch_assoc($result1)){
            $totalChequeDeposite = $totalChequeDeposite + $row1['amount'];
        }

        $totalOpeningBalanceInCheque = ($totalChequeIncome + $totalChequeIncomeByCollection) - ($totalChequeDeposite);

        return number_format($totalOpeningBalanceInCheque,2);
    }

    function viewLedgerBetweenTwoDays($conn,$datStart,$datEnd){
        $no = 1;
        
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE `cashBillDate` BETWEEN '".$datStart."' AND '".$datEnd."'";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$row['cashBillDate']."</td>";
                echo "<td>Bill No ".$row['cashBillNo']." is Cash Bill which is billed at ".$row['cashBillDate']." for ".$row['cashBillCustomerName']." by ".$row['cashBillRep']."</td>";
                echo "<td><font color='green'>+".number_format($row['cashBillAmount'],2)."</font></td>";
                echo "<td><center>--</center></td>";
            echo "</tr>";
            $no++;
        }

        $sql0 = "SELECT * FROM `tblacbillcollection` WHERE `date` BETWEEN '".$datStart."' AND '".$datEnd."'";
        $result0 = mysqli_query($conn,$sql0);
        while($row0 = mysqli_fetch_assoc($result0)){
            if($row0['paymentMethod'] == "Cash"){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row0['date']."</td>";
                    echo "<td>A/C Bill No ".$row0['billNo']." is collected at ".$row0['date']." by cash</td>";
                    echo "<td><font color='green'>+".number_format($row0['amount'],2)."</font></td>";
                    echo "<td><center>--</center></td>";
                echo "</tr>";
            }
            if($row0['paymentMethod'] == "Cheque"){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row0['date']."</td>";
                    echo "<td>A/C Bill No ".$row0['billNo']." is collected at ".$row0['date']." by cheque numbered ".$row0['chequeNo']." and belong to ".$row0['bank']." bank</td>";
                    echo "<td><center>--</center></td>";
                    echo "<td><font color='green'>+".number_format($row0['amount'],2)."</font></td>";
                echo "</tr>";
            }
            $no++;
        }

        $sql00 = "SELECT * FROM `tblchequebilldetails` WHERE `chequeBillDate` BETWEEN '".$datStart."' AND '".$datEnd."'";
        $result00 = mysqli_query($conn,$sql00);
        while($row00 = mysqli_fetch_assoc($result00)){
            echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$row00['chequeBillDate']."</td>";
                echo "<td>Bill No ".$row00['chequeNo']." is billed as cheque bill which is billed at ".$row00['chequeBillDate']." by cheque numbered ".$row00['chequeNo']." and belong to ".$row00['chequeBillBank']." bank</td>";
                echo "<td><center>--</center></td>";
                echo "<td><font color='green'>+".number_format($row00['chequeBillAmount'],2)."</font></td>";
            echo "</tr>";
            $no++;
        }

        $sql1 = "SELECT * FROM `tblcashdeposite` WHERE `date` BETWEEN '".$datStart."' AND '".$datEnd."'";
        $result1 = mysqli_query($conn,$sql1);
        while($row1 = mysqli_fetch_assoc($result1)){
            echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$row1['date']."</td>";
                echo "<td>Cash Deposite for account no - ".$row1['accountNo']." which is hold by ".$row1['accountHolderName']." and account bank is ".$row1['bank']."</td>";
                echo "<td><font color='red'>-".number_format($row1['amount'],2)."</font></td>";
                echo "<td><center>--</center></td>";
            echo "</tr>";
            $no++;
        }

        $sql2 = "SELECT * FROM `tblvoucher` WHERE `date` BETWEEN '".$datStart."' AND '".$datEnd."'";
        $result2 = mysqli_query($conn,$sql2);
        while($row2 = mysqli_fetch_assoc($result2)){
            echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$row2['date']."</td>";
                echo "<td>Voucher for ".$row2['description']."</td>";
                echo "<td><font color='red'>-".number_format($row2['amount'],2)."</font></td>";
                echo "<td><center>--</center></td>";
            echo "</tr>";
            $no++;
        }

        $sql3 = "SELECT * FROM `tblchequedeposite` WHERE `date` BETWEEN '".$datStart."' AND '".$datEnd."'";
        $result3 = mysqli_query($conn,$sql3);
        $totalChequeDeposite = 0;
        while($row3 = mysqli_fetch_assoc($result3)){
            echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$row3['date']."</td>";
                echo "<td>Cheque deposite for account no - ".$row3['accountNo']." which is hold by ".$row3['accountHolderName'].". Deposited cheque number is ".$row3['chequeNo']." and bank is ".$row3['bank']."</td>";
                echo "<td><center>--</center></td>";
                echo "<td><font color='red'>-".number_format($row3['amount'],2)."</font></td>";
            echo "</tr>";
            $no++;
        }
    }

    function viewClosingBalanceInCash($conn,$datEnd){
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE `cashBillDate` BETWEEN '2021-01-01' AND '".$datEnd."'";
        $result = mysqli_query($conn,$sql);
        $totalCashIncome = 0;
        while($row = mysqli_fetch_assoc($result)){
            $totalCashIncome = $totalCashIncome + $row['cashBillAmount'];
        }

        $sql0 = "SELECT * FROM `tblacbillcollection` WHERE `date` BETWEEN '2021-01-01' AND '".$datEnd."'";
        $result0 = mysqli_query($conn,$sql0);
        $totalCashIncomeByCollection = 0;
        while($row0 = mysqli_fetch_assoc($result0)){
            if($row0['paymentMethod'] == "Cash"){
                $totalCashIncomeByCollection = $totalCashIncomeByCollection + $row0['amount'];
            }
        }

        $sql1 = "SELECT * FROM `tblcashdeposite` WHERE `date` BETWEEN '2021-01-01' AND '".$datEnd."'";
        $result1 = mysqli_query($conn,$sql1);
        $totalCashDeposite = 0;
        while($row1 = mysqli_fetch_assoc($result1)){
            $totalCashDeposite = $totalCashDeposite + $row1['amount'];
        }

        $sql2 = "SELECT * FROM `tblvoucher` WHERE `date` BETWEEN '2021-01-01' AND '".$datEnd."'";
        $result2 = mysqli_query($conn,$sql2);
        $totalVoucher = 0;
        while($row2 = mysqli_fetch_assoc($result2)){
            $totalVoucher = $totalVoucher + $row2['amount'];
        }

        $totalOpeningBalanceInCash = ($totalCashIncome + $totalCashIncomeByCollection) - ($totalCashDeposite + $totalVoucher);

        return number_format($totalOpeningBalanceInCash,2);
    }

    function viewClosingBalanceInCheque($conn,$datEnd){
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE `chequeBillDate` BETWEEN '2021-01-01' AND '".$datEnd."'";
        $result = mysqli_query($conn,$sql);
        $totalChequeIncome = 0;
        while($row = mysqli_fetch_assoc($result)){
            $totalChequeIncome = $totalChequeIncome + $row['chequeBillAmount'];
        }

        $sql0 = "SELECT * FROM `tblacbillcollection` WHERE `date` BETWEEN '2021-01-01' AND '".$datEnd."'";
        $result0 = mysqli_query($conn,$sql0);
        $totalChequeIncomeByCollection = 0;
        while($row0 = mysqli_fetch_assoc($result0)){
            if($row0['paymentMethod'] == "Cheque"){
                $totalChequeIncomeByCollection = $totalChequeIncomeByCollection + $row0['amount'];
            }
        }

        $sql1 = "SELECT * FROM `tblchequedeposite` WHERE `date` BETWEEN '2021-01-01' AND '".$datEnd."'";
        $result1 = mysqli_query($conn,$sql1);
        $totalChequeDeposite = 0;
        while($row1 = mysqli_fetch_assoc($result1)){
            $totalChequeDeposite = $totalChequeDeposite + $row1['amount'];
        }

        $totalOpeningBalanceInCheque = ($totalChequeIncome + $totalChequeIncomeByCollection) - ($totalChequeDeposite);

        return number_format($totalOpeningBalanceInCheque,2);
    }

    function viewBasicSaleReport($conn,$datStart,$datEnd,$txtRep){
        $date1=date_create($datStart);
        $date2=date_create($datEnd);
        $diff=date_diff($date1,$date2);
        $diff2=$diff->format("%R%a");
        $no = 1;
        while($diff2 >= 0){
            $totalChequeAmount = 0;
            $totalCashAmount = 0;
            $totalACAmount = 0;
            $totalAllAmount = 0;

            $sd = date_format($date1,"Y-m-d");
            $ed = date_format($date2,"Y-m-d");
            if($txtRep == 'All'){
                $sql1 = "SELECT * FROM `tblchequebilldetails` WHERE `chequeBillDate`='".$sd."'";
                $sql2 = "SELECT * FROM `tblcashbilldetails` WHERE `cashBillDate`='".$sd."'";
                $sql3 = "SELECT * FROM `tblacbill` WHERE `acbillDate`='".$sd."'";
            }
            else{
                $sql1 = "SELECT * FROM `tblchequebilldetails` WHERE (`chequeBillDate`='".$sd."') AND `chequeBillRep`='".$txtRep."'";
                $sql2 = "SELECT * FROM `tblcashbilldetails` WHERE (`cashBillDate`='".$sd."') AND `cashBillRep`='".$txtRep."'";
                $sql3 = "SELECT * FROM `tblacbill` WHERE (`acbillDate`='".$sd."') AND `rep`='".$txtRep."'";
            }
                $result1 = mysqli_query($conn,$sql1);
                $result2 = mysqli_query($conn,$sql2);
                $result3 = mysqli_query($conn,$sql3);
                if(mysqli_num_rows($result1)>=1){
                    while($row1 = mysqli_fetch_assoc($result1)){
                        $totalChequeAmount = $totalChequeAmount + $row1['chequeBillAmount'];
                    }
                }
                else{
                    $totalChequeAmount = 0;
                }
                if(mysqli_num_rows($result2)>=1){
                    while($row2 = mysqli_fetch_assoc($result2)){
                        $totalCashAmount = $totalCashAmount + $row2['cashBillAmount'];
                    }
                }
                else{
                    $totalCashAmount = 0;
                }
                if(mysqli_num_rows($result3)>=1){
                    while($row3 = mysqli_fetch_assoc($result3)){
                        $totalACAmount = $totalACAmount + $row3['amount'];
                    }
                } 
                else{
                    $totalACAmount = 0;
                }
                    
                $totalAllAmount = $totalChequeAmount + $totalCashAmount + $totalACAmount;
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$sd."</td>";
                    echo "<td>".$totalACAmount."</td>";
                    echo "<td>".$totalCashAmount."</td>";
                    echo "<td>".$totalChequeAmount."</td>";
                    echo "<td>".$totalAllAmount."</td>";
                echo "</tr>";

                $no++;

                $date1 = date_add($date1,date_interval_create_from_date_string("1 days"));
                $diff=date_diff($date1,$date2);
                $diff2=$diff->format("%R%a");
        }
    }

    function viewBasicSaleReportForCustomerBased($conn,$datStart,$datEnd){
        $date1=date_create($datStart);
        $date2=date_create($datEnd);
        $diff=date_diff($date1,$date2);
        $diff2=$diff->format("%R%a");
        $no = 1;
        while($diff2 >= 0){
            $totalChequeAmount = 0;
            $totalCashAmount = 0;
            $totalACAmount = 0;
            $totalAllAmount = 0;

            $sd = date_format($date1,"Y-m-d");
            $ed = date_format($date2,"Y-m-d");

            $sql = "SELECT * FROM `tblcustomers`";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>=1){
                while($row = mysqli_fetch_assoc($result)){
                    $billNoText = "";

                    $sql1 = "SELECT * FROM `tblchequebilldetails` WHERE `chequeBillDate`='".$sd."' AND `chequeBillCustomerCode`='".$row['customerId']."'";
                    $sql2 = "SELECT * FROM `tblcashbilldetails` WHERE `cashBillDate`='".$sd."' AND `cashBillCustomerCode`='".$row['customerId']."'";
                    $sql3 = "SELECT * FROM `tblacbill` WHERE `acbillDate`='".$sd."' AND `customerId`='".$row['customerId']."'";

                    $result1 = mysqli_query($conn,$sql1);
                    $result2 = mysqli_query($conn,$sql2);
                    $result3 = mysqli_query($conn,$sql3);

                    if(mysqli_num_rows($result1)>=1){
                        while($row1 = mysqli_fetch_assoc($result1)){
                            $totalChequeAmount = $totalChequeAmount + $row1['chequeBillAmount'];
                        }
                    }
                    else{
                        $totalChequeAmount = 0;
                    }
                    if(mysqli_num_rows($result2)>=1){
                        while($row2 = mysqli_fetch_assoc($result2)){
                            $totalCashAmount = $totalCashAmount + $row2['cashBillAmount'];
                        }
                    }
                    else{
                        $totalCashAmount = 0;
                    }
                    if(mysqli_num_rows($result3)>=1){
                        while($row3 = mysqli_fetch_assoc($result3)){
                            $totalACAmount = $totalACAmount + $row3['amount'];
                        }
                    } 
                    else{
                        $totalACAmount = 0;
                    }
                    $totalAllAmount = $totalChequeAmount + $totalCashAmount + $totalACAmount;
                    if((mysqli_num_rows($result1)>=1) || (mysqli_num_rows($result2)>=1) || (mysqli_num_rows($result3)>=1)){
                        echo "<tr>";
                            echo "<td>".$no."</td>";
                            echo "<td>".$sd."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$totalACAmount."</td>";
                            echo "<td>".$totalCashAmount."</td>";
                            echo "<td>".$totalChequeAmount."</td>";
                            echo "<td>".$totalAllAmount."</td>";
                        echo "</tr>";
                        $no++;
                    }
                }
            }
            $date1 = date_add($date1,date_interval_create_from_date_string("1 days"));
            $diff=date_diff($date1,$date2);
            $diff2=$diff->format("%R%a");
        }
    }

    function viewProfit($conn,$txtYear,$txtMonth){
        $getAllSalesAmounts = getAllSalesAmounts($conn,$txtMonth,$txtYear);
        echo "<div class='row'>
                <div class='d-flex justify-content-center'>
                    <center>
                        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#addProfitOrLossModal' title='Add Profit/Expensive Details'>
                            +
                        </button>
                    </center>
                </div>
            </div>
            <p></p><p></p>";
        echo "<div class='row'>
                <div class='table-responsive'>
                    <table class='table table-bordered' width='100%' cellspacing='0'>
                        <tbody>";
                    echo "<tr class='table-primary'>";
                        echo "<td colspan='3'><center><h3 align='center' style='font-weight: bold; color: black;'>Profit / Loss Report for ".$txtMonth." Month of ".$txtYear." th Year</h3></center></td>";
                    echo "</tr>";
                    echo "<tr class='table-warning'>";
                        echo "<td><center><h6 align='center' style='font-weight: bold; color: black;'> Descriptions </h6></center></td>";
                        echo "<td colspan='2'><center><h6 align='center' style='font-weight: bold; color: black;'> Amounts </h6></center></td>";
                    echo "</tr>";
                    echo "<tr style='color: blue;'>";
                        echo "<td>Sales Turnovers</td>";
                        echo "<td style='font-weight: bold;'><center> - </center></td>";
                        echo "<td style='font-weight: bold; text-align: right;'><span id='st'>".number_format($getAllSalesAmounts,2)."</span></td>";
                    echo "</tr>";
                    $salesCommission = (($getAllSalesAmounts / 114) * 100) * 0.14;
                    $totalIncom = $salesCommission;
                    echo "<tr style='color: green;'>";
                        echo "<td>Commissions</td>";
                        echo "<td style='font-weight: bold;'><center> - </center></td>";
                        echo "<td style='font-weight: bold; text-align: right;'>+<span id='com'>".number_format($salesCommission,2)."</span></td>";
                    echo "</tr>";

                    $sql2 = "SELECT * FROM `tblprofitlostreport` WHERE `type`='Profite' AND (`month`='".$txtMonth."') AND (`year`='".$txtYear."')";
                    $result2 = mysqli_query($conn,$sql2);
                    while($row2 = mysqli_fetch_assoc($result2)){
                        echo "<tr style='color: green;'>";
                            echo "<td>".$row2['description']."</td>";
                            echo "<td style='font-weight: bold;'><center> - </center></td>";
                            echo "<td style='font-weight: bold; text-align: right;'>+".number_format($row2['amount'],2)."</td>";
                            echo "<td style='font-weight: bold;'>
                                    <center> 
                                        <div class='row'>
                                            <form action='' method='POST'>
                                                <button name='btnDeletePLReport' class='btn btn-danger btn-sm' title='Delete This Income' onclick='validateForm29()'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                                <input type='hidden' name='deletePLReportID' value='".$row2['id']."'>
                                                <input type='hidden' id='txtViewMonth' name='txtViewMonth' value='".$txtMonth."'>
                    
                                                <input type='hidden' id='txtViewYear' name='txtViewYear' value='".$txtYear."'>
                                            </form>
                                            
                                            <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editProfitModalID".$row2['id']."' title='Edit Profit Details'>
                                                <i class='fas fa-edit'></i>
                                            </button>
                                        </div>
                                    </center>
                                </td>";
                        echo "</tr>";
                        $totalIncom += $row2['amount'];
                        echo "<!-- Modal For editProfitModalID".$row2['id']." -->
                                <div class='modal fade' id='editProfitModalID".$row2['id']."' tabindex='-1' role='dialog' aria-labelledby='editProfitModalID".$row2['id']."Title' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='editProfitModalID".$row2['id']."Title'>Edit Income Details</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                <form action='' method='POST'>
                                                    <div class='row'>

                                                        <div class='input-group mb-2 col-12'>
                                                            <div class='input-group-prepend'>
                                                            <div class='input-group-text'><i class='fas fa-tape'></i></div>
                                                            </div>
                                                            <select class='form-control' id='txtType' name='txtType'>
                                                                <option disabled>Select Type</option>
                                                                <option value='Profite' selected>Profite</option>
                                                                <option value='Expensive'>Expensive</option>
                                                            </select>
                                                        </div>
                                    
                                                        <div class='input-group mb-2 col-12'>
                                                            <div class='input-group-prepend'>
                                                            <div class='input-group-text'><i class='fas fa-quote-left'></i></div>
                                                            </div>
                                                            <input class='form-control' type='text' name='txtDescription' id='txtDescription' placeholder='Description' value='".$row2['description']."'/>
                                                        </div>
                                    
                                                        <div class='input-group mb-2 col-12'>
                                                            <div class='input-group-prepend'>
                                                            <div class='input-group-text'><i class='fas fa-wallet'></i></div>
                                                            </div>
                                                            <input class='form-control' type='number' name='txtAmount' id='txtAmount' placeholder='Amount' value='".$row2['amount']."'/>
                                                        </div>

                                                        <input type='hidden' id='txtID' name='txtID' value='".$row2['id']."'>

                                                        <input type='hidden' id='txtViewMonth' name='txtViewMonth' value='".$txtMonth."'>
                    
                                                        <input type='hidden' id='txtViewYear' name='txtViewYear' value='".$txtYear."'>
                                    
                                                        <button type='submit' name='btnEdit' class='btn btn-primary'>Edit</button>
                                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                    
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                    }

                    echo "<tr class='table-success' style='color: green;'>";
                        echo "<td style='font-weight: bold;'>Gross Profit</td>";
                        echo "<td style='font-weight: bold;'></td>";
                        echo "<td style='font-weight: bold; text-align: right;'>+".number_format($totalIncom,2)."</td>";
                    echo "</tr>";

                    $sql = "SELECT * FROM `tblexpensives` WHERE status<>'In Progress' AND (`date` BETWEEN '".$txtYear."-".$txtMonth."-01' AND '".$txtYear."-".$txtMonth."-31')";
                    $result = mysqli_query($conn,$sql);
                    $totalExpensive = 0;
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr style='color: red;'>";
                            echo "<td>".$row['type']."</td>";
                            echo "<td style='font-weight: bold; text-align: right;'>-".number_format($row['amount'],2)."</td>";
                            echo "<td style='font-weight: bold;'><center> - </center></td>";
                        echo "</tr>";
                        $totalExpensive += $row['amount'];
                    }

                    $sql3 = "SELECT * FROM `tblsalary` WHERE status<>'In Progress' AND (`salaryMonth`='".$txtMonth."') AND (`salaryYear`='".$txtYear."')";
                    $result3 = mysqli_query($conn,$sql3);
                    while($row3 = mysqli_fetch_assoc($result3)){
                        echo "<tr style='color: red;'>";
                            echo "<td> Gross Salary of ".$row3['staffsName']."</td>";
                            echo "<td style='font-weight: bold; text-align: right;'>-".number_format($row3['grossSalaray'],2)."</td>";
                            echo "<td style='font-weight: bold;'><center> - </center></td>";
                        echo "</tr>";
                        $totalExpensive += $row3['grossSalaray'];
                    }

                    $sql1 = "SELECT * FROM `tblprofitlostreport` WHERE `type`='Expensive' AND (`month`='".$txtMonth."') AND (`year`='".$txtYear."')";
                    $result1 = mysqli_query($conn,$sql1);
                    while($row1 = mysqli_fetch_assoc($result1)){
                        echo "<tr style='color: red;'>";
                            echo "<td>".$row1['description']."</td>";
                            echo "<td style='font-weight: bold; text-align: right;'>-".number_format($row1['amount'],2)."</td>";
                            echo "<td style='font-weight: bold;'><center> - </center></td>";
                            echo "<td style='font-weight: bold;'>
                                    <center> 
                                        <div class='row'>
                                            <form action='' method='POST'>
                                                <button name='btnDeletePLReport' class='btn btn-danger btn-sm' title='Delete This Income' onclick='validateForm29()'>
                                                    <i class='fas fa-trash-alt'></i>
                                                </button>
                                                <input type='hidden' name='deletePLReportID' value='".$row1['id']."'>
                                                <input type='hidden' id='txtViewMonth' name='txtViewMonth' value='".$txtMonth."'>
                    
                                                <input type='hidden' id='txtViewYear' name='txtViewYear' value='".$txtYear."'>
                                            </form>
                                            
                                            <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editLossModalID".$row1['id']."' title='Edit Profit Details'>
                                                <i class='fas fa-edit'></i>
                                            </button>
                                        </div>
                                    </center>
                                </td>";
                        echo "</tr>";
                        $totalExpensive += $row1['amount'];
                        echo "<!-- Modal For editLossModalID".$row1['id']." -->
                                <div class='modal fade' id='editLossModalID".$row1['id']."' tabindex='-1' role='dialog' aria-labelledby='editLossModalID".$row1['id']."Title' aria-hidden='true'>
                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='editLossModalID".$row1['id']."Title'>Edit Expensive Details</h5>
                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>
                                            <div class='modal-body'>
                                                <form action='' method='POST'>
                                                    <div class='row'>

                                                        <div class='input-group mb-2 col-12'>
                                                            <div class='input-group-prepend'>
                                                            <div class='input-group-text'><i class='fas fa-tape'></i></div>
                                                            </div>
                                                            <select class='form-control' id='txtType' name='txtType'>
                                                                <option disabled>Select Type</option>
                                                                <option value='Profite'>Profite</option>
                                                                <option value='Expensive' selected>Expensive</option>
                                                            </select>
                                                        </div>
                                    
                                                        <div class='input-group mb-2 col-12'>
                                                            <div class='input-group-prepend'>
                                                            <div class='input-group-text'><i class='fas fa-quote-left'></i></div>
                                                            </div>
                                                            <input class='form-control' type='text' name='txtDescription' id='txtDescription' placeholder='Description' value='".$row1['description']."'/>
                                                        </div>
                                    
                                                        <div class='input-group mb-2 col-12'>
                                                            <div class='input-group-prepend'>
                                                            <div class='input-group-text'><i class='fas fa-wallet'></i></div>
                                                            </div>
                                                            <input class='form-control' type='number' name='txtAmount' id='txtAmount' placeholder='Amount' value='".$row1['amount']."'/>
                                                        </div>

                                                        <input type='hidden' id='txtID' name='txtID' value='".$row1['id']."'>

                                                        <input type='hidden' id='txtViewMonth' name='txtViewMonth' value='".$txtMonth."'>
                    
                                                        <input type='hidden' id='txtViewYear' name='txtViewYear' value='".$txtYear."'>
                                    
                                                        <button type='submit' name='btnEdit' class='btn btn-primary'>Edit</button>
                                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                    
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                    }

                    echo "<tr class='table-danger' style='color: red;'>";
                        echo "<td style='font-weight: bold;'>Total Expensive</td>";
                        echo "<td style='font-weight: bold; text-align: right;'>-<span id='te'>".number_format($totalExpensive,2)."</span></td>";
                        echo "<td style='font-weight: bold;'></td>";
                    echo "</tr>";
                    $netProfit = $totalIncom - $totalExpensive;
                    echo "<tr class='table-secondary'>";
                        echo "<td style='font-weight: bold; color: blue;'>Net Profit</td>";
                        if($netProfit>0){
                            echo "<td colspan='2' style='font-weight: bold; text-align: right; color: green;'>+".number_format($netProfit,2)."</td>";
                        }
                        elseif($netProfit==0){
                            echo "<td colspan='2' style='font-weight: bold; text-align: right; color: blue;'>".number_format($netProfit,2)."</td>";
                        }
                        else{
                            echo "<td colspan='2' style='font-weight: bold; text-align: right; color: red;'>".number_format($netProfit,2)."</td>";
                        }
                    echo "</tr>";
        echo "         </tbody>
                    </table>
                </div>
             </div>";
        
        echo "<!-- Modal For addProfitOrLossModal -->
                <div class='modal fade' id='addProfitOrLossModal' tabindex='-1' role='dialog' aria-labelledby='addProfitOrLossModalTitle' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='addProfitOrLossModalTitle'>Add Profit / Expensive</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>
                            <div class='modal-body'>
                                <form action='' method='POST'>
                                    <div class='row'>

                                        <div class='input-group mb-2 col-12'>
                                            <div class='input-group-prepend'>
                                            <div class='input-group-text'><i class='fas fa-tape'></i></div>
                                            </div>
                                            <select class='form-control' id='txtType' name='txtType'>
                                                <option selected disabled>Select Type</option>
                                                <option value='Profite'>Profite</option>
                                                <option value='Expensive'>Expensive</option>
                                            </select>
                                        </div>
                    
                                        <div class='input-group mb-2 col-12'>
                                            <div class='input-group-prepend'>
                                            <div class='input-group-text'><i class='fas fa-quote-left'></i></div>
                                            </div>
                                            <input class='form-control' type='text' name='txtDescription' id='txtDescription' placeholder='Description'/>
                                        </div>
                    
                                        <div class='input-group mb-2 col-12'>
                                            <div class='input-group-prepend'>
                                            <div class='input-group-text'><i class='fas fa-wallet'></i></div>
                                            </div>
                                            <input class='form-control' type='number' name='txtAmount' id='txtAmount' placeholder='Amount'/>
                                        </div>

                                        <input type='hidden' id='txtAddMonth' name='txtAddMonth' value='".$txtMonth."'>
                    
                                        <input type='hidden' id='txtAddYear' name='txtAddYear' value='".$txtYear."'>

                                        <input type='hidden' id='txtViewMonth' name='txtViewMonth' value='".$txtMonth."'>
                    
                                        <input type='hidden' id='txtViewYear' name='txtViewYear' value='".$txtYear."'>
                    
                                        <button type='submit' name='btnAdd' class='btn btn-primary'>Add</button>
                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";

    }

    function viewStaffsForSalary($conn){
        $sql = "SELECT * FROM `tblstaffs`";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td><center><img src='".$row['staffsPicture']."' width='50px' height='50px'></center></td>";
                    echo "<td>".strtoupper($row['staffsId'])."</td>";
                    echo "<td>".ucwords($row['staffsNIC'], " ")."</td>";
                    echo "<td>".ucwords($row['staffsName'], " ")."</td>";
                    echo "<td>".ucwords($row['staffsAddress'], " ")."</td>";
                    echo "<td>".$row['staffsContactNo']."</td>";
                    echo "<td>".$row['staffsType']."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }                        
                    echo "<td>";
                            echo "<div class='col-3'>
                                    <a href='admin.php?salary&vsid=".$row['staffsId']."' class='btn btn-primary btn-sm' title='View Staff Salary Detalis'>
                                        <i class='fas fa-binoculars'></i>
                                    </a>
                                </div>
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
            }
        }
    }

    function getCommissionForInitial($conn,$txtStaffId){

        $dataUser = fetchStaffDetails($conn,$txtStaffId);

        $datStart = date('Y') . "-" . date('m') . "-" . "01";
        $datEnd = date('Y') . "-" . date('m') . "-" . "31";

        $sql1 = "SELECT * FROM `tblchequebilldetails` WHERE (`chequeBillDate` BETWEEN '".$datStart."' AND '".$datEnd."') AND (`chequeBillRep`='".$dataUser['staffsName']."')";
        $sql2 = "SELECT * FROM `tblcashbilldetails` WHERE (`cashBillDate` BETWEEN '".$datStart."' AND '".$datEnd."') AND (`cashBillRep`='".$dataUser['staffsName']."')";
        $sql3 = "SELECT * FROM `tblacbill` WHERE (`acbillDate` BETWEEN '".$datStart."' AND '".$datEnd."') AND (`rep`='".$dataUser['staffsName']."')";

        $result1 = mysqli_query($conn,$sql1);
        $result2 = mysqli_query($conn,$sql2);
        $result3 = mysqli_query($conn,$sql3);

        $totalChequeAmount = 0;
        $totalCashAmount = 0;
        $totalACAmount = 0;

        if(mysqli_num_rows($result1)>=1){
            while($row1 = mysqli_fetch_assoc($result1)){
                $totalChequeAmount = $totalChequeAmount + $row1['chequeBillAmount'];
            }
        }
        else{
            $totalChequeAmount = 0;
        }
        if(mysqli_num_rows($result2)>=1){
            while($row2 = mysqli_fetch_assoc($result2)){
                $totalCashAmount = $totalCashAmount + $row2['cashBillAmount'];
            }
        }
        else{
            $totalCashAmount = 0;
        }
        if(mysqli_num_rows($result3)>=1){
            while($row3 = mysqli_fetch_assoc($result3)){
                $totalACAmount = $totalACAmount + $row3['amount'];
            }
        } 
        else{
            $totalACAmount = 0;
        }
        $totalAllAmount = $totalChequeAmount + $totalCashAmount + $totalACAmount;
        return $totalAllAmount;
    }

    ################################### Dashboard ##################################################

    function showNoOfCustomers($conn){
        $sql = "SELECT * FROM `tblcustomers` WHERE `status`<>'Pending'";
        $result = mysqli_query($conn,$sql);
        $totalCustomers = mysqli_num_rows($result);
        return $totalCustomers;
    }

    function showPrimaryTargetsDetails($conn){
        $sql = "SELECT * FROM `tbltarget` WHERE `targetYear`<>'Pending'";
        $result = mysqli_query($conn,$sql);
        $totalCustomers = mysqli_num_rows($result);
        return $totalCustomers;
    }

    function showTargetsBarsPT($conn){
        $txtViewMonth = date('m');
        $txtViewMonthOld = $txtViewMonth;
        if($txtViewMonth=='01'){
            $txtViewMonth='January';
        }
        if($txtViewMonth=='02'){
            $txtViewMonth='February';
        }
        if($txtViewMonth=='03'){
            $txtViewMonth='March';
        }
        if($txtViewMonth=='04'){
            $txtViewMonth='April';
        }
        if($txtViewMonth=='05'){
            $txtViewMonth='May';
        }
        if($txtViewMonth=='06'){
            $txtViewMonth='June';
        }
        if($txtViewMonth=='07'){
            $txtViewMonth='July';
        }
        if($txtViewMonth=='08'){
            $txtViewMonth='August';
        }
        if($txtViewMonth=='09'){
            $txtViewMonth='September';
        }
        if($txtViewMonth=='10'){
            $txtViewMonth='October';
        }
        if($txtViewMonth=='11'){
            $txtViewMonth='November';
        }
        if($txtViewMonth=='12'){
            $txtViewMonth='December';
        }
        $targetYear = date('Y');
        $sql1 = "SELECT * FROM `tbltarget` WHERE `targetMonth`='".$txtViewMonth."' AND `targetYear`='".$targetYear."'";
        $result1 = mysqli_query($conn,$sql1);
        $data1 = $result1->fetch_assoc();

        $startDate = $targetYear . "-" . $txtViewMonthOld . "-" . '01';
        $endDate = $targetYear . "-" . $txtViewMonthOld . "-" . '31';
        $sql2 = "SELECT SUM(`invoinvocingAmount`) AS `totalInvoinvocingAmount` FROM `tblgoods` WHERE `invoinvocingDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result2 = mysqli_query($conn,$sql2);
        $data2 = $result2->fetch_assoc();

        if($data1['primaryTarget'] != 0){
            $achievedPercentage = ($data2['totalInvoinvocingAmount'] / $data1['primaryTarget']) * 100;
        }
        else{
            $achievedPercentage = (0) * 100;
        }

        return $achievedPercentage;
    }

    function showTargetsBarsRD($conn){
        $txtViewMonth = date('m');
        $txtViewMonthOld = $txtViewMonth;
        if($txtViewMonth=='01'){
            $txtViewMonth='January';
        }
        if($txtViewMonth=='02'){
            $txtViewMonth='February';
        }
        if($txtViewMonth=='03'){
            $txtViewMonth='March';
        }
        if($txtViewMonth=='04'){
            $txtViewMonth='April';
        }
        if($txtViewMonth=='05'){
            $txtViewMonth='May';
        }
        if($txtViewMonth=='06'){
            $txtViewMonth='June';
        }
        if($txtViewMonth=='07'){
            $txtViewMonth='July';
        }
        if($txtViewMonth=='08'){
            $txtViewMonth='August';
        }
        if($txtViewMonth=='09'){
            $txtViewMonth='September';
        }
        if($txtViewMonth=='10'){
            $txtViewMonth='October';
        }
        if($txtViewMonth=='11'){
            $txtViewMonth='November';
        }
        if($txtViewMonth=='12'){
            $txtViewMonth='December';
        }
        $targetYear = date('Y');
        $sql1 = "SELECT * FROM `tbltarget` WHERE `targetMonth`='".$txtViewMonth."' AND `targetYear`='".$targetYear."'";
        $result1 = mysqli_query($conn,$sql1);
        $data1 = $result1->fetch_assoc();

        $startDate = $targetYear . "-" . $txtViewMonthOld . "-" . '01';
        $endDate = $targetYear . "-" . $txtViewMonthOld . "-" . '31';
        
        $sql3 = "SELECT SUM(`amount`) AS `totalACAmount` FROM `tblacbill` WHERE `acbillDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result3 = mysqli_query($conn,$sql3);
        $data3 = $result3->fetch_assoc();

        $sql4 = "SELECT SUM(`cashBillAmount`) AS `totalCashAmount` FROM `tblcashbilldetails` WHERE `cashBillDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result4 = mysqli_query($conn,$sql4);
        $data4 = $result4->fetch_assoc();

        $sql5 = "SELECT SUM(`chequeBillAmount`) AS `totalChequeAmount` FROM `tblchequebilldetails` WHERE `chequeBillDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result5 = mysqli_query($conn,$sql5);
        $data5 = $result5->fetch_assoc();

        $achievement = $data3['totalACAmount'] + $data4['totalCashAmount'] + $data5['totalChequeAmount'];

        if($data1['RDTarget'] != 0){
            $achievedPercentage2 = ($achievement / $data1['RDTarget']) * 100;
        }
        else{
            $achievedPercentage2 = (0) * 100;
        }

        return $achievedPercentage2;
    }

    function getAllSalesAmounts($conn,$txtViewMonth,$txtYear){
        $txtViewMonth = $txtViewMonth;
        $txtViewMonthOld = $txtViewMonth;
        if($txtViewMonth=='01'){
            $txtViewMonth='January';
        }
        if($txtViewMonth=='02'){
            $txtViewMonth='February';
        }
        if($txtViewMonth=='03'){
            $txtViewMonth='March';
        }
        if($txtViewMonth=='04'){
            $txtViewMonth='April';
        }
        if($txtViewMonth=='05'){
            $txtViewMonth='May';
        }
        if($txtViewMonth=='06'){
            $txtViewMonth='June';
        }
        if($txtViewMonth=='07'){
            $txtViewMonth='July';
        }
        if($txtViewMonth=='08'){
            $txtViewMonth='August';
        }
        if($txtViewMonth=='09'){
            $txtViewMonth='September';
        }
        if($txtViewMonth=='10'){
            $txtViewMonth='October';
        }
        if($txtViewMonth=='11'){
            $txtViewMonth='November';
        }
        if($txtViewMonth=='12'){
            $txtViewMonth='December';
        }
        $targetYear = $txtYear;
        $sql1 = "SELECT * FROM `tbltarget` WHERE `targetMonth`='".$txtViewMonth."' AND `targetYear`='".$targetYear."'";
        $result1 = mysqli_query($conn,$sql1);
        $data1 = $result1->fetch_assoc();

        $startDate = $targetYear . "-" . $txtViewMonthOld . "-" . '01';
        $endDate = $targetYear . "-" . $txtViewMonthOld . "-" . '31';
        
        $sql3 = "SELECT SUM(`amount`) AS `totalACAmount` FROM `tblacbill` WHERE `acbillDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result3 = mysqli_query($conn,$sql3);
        $data3 = $result3->fetch_assoc();

        $sql4 = "SELECT SUM(`cashBillAmount`) AS `totalCashAmount` FROM `tblcashbilldetails` WHERE `cashBillDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result4 = mysqli_query($conn,$sql4);
        $data4 = $result4->fetch_assoc();

        $sql5 = "SELECT SUM(`chequeBillAmount`) AS `totalChequeAmount` FROM `tblchequebilldetails` WHERE `chequeBillDate` BETWEEN '".$startDate."' AND '".$endDate."'";
        $result5 = mysqli_query($conn,$sql5);
        $data5 = $result5->fetch_assoc();

        $achievement = $data3['totalACAmount'] + $data4['totalCashAmount'] + $data5['totalChequeAmount'];

        return $achievement;
    }

    function viewProfitForDashboard($conn,$txtYear,$txtMonth){
        $getAllSalesAmounts = getAllSalesAmounts($conn,$txtMonth,$txtYear);
        $salesCommission = (($getAllSalesAmounts / 114) * 100) * 0.14;
        $totalIncom = $salesCommission;

        $sql2 = "SELECT * FROM `tblprofitlostreport` WHERE `type`='Profite' AND (`month`='".$txtMonth."') AND (`year`='".$txtYear."')";
        $result2 = mysqli_query($conn,$sql2);
        while($row2 = mysqli_fetch_assoc($result2)){
            $totalIncom += $row2['amount'];
        }

        $sql = "SELECT * FROM `tblexpensives` WHERE status<>'In Progress' AND (`date` BETWEEN '".$txtYear."-".$txtMonth."-01' AND '".$txtYear."-".$txtMonth."-31')";
        $result = mysqli_query($conn,$sql);
        $totalExpensive = 0;
        while($row = mysqli_fetch_assoc($result)){
            $totalExpensive += $row['amount'];
        }

        $sql3 = "SELECT * FROM `tblsalary` WHERE status<>'In Progress' AND (`salaryMonth`='".$txtMonth."') AND (`salaryYear`='".$txtYear."')";
        $result3 = mysqli_query($conn,$sql3);
        while($row3 = mysqli_fetch_assoc($result3)){
            $totalExpensive += $row3['grossSalaray'];
        }

        $sql1 = "SELECT * FROM `tblprofitlostreport` WHERE `type`='Expensive' AND (`month`='".$txtMonth."') AND (`year`='".$txtYear."')";
        $result1 = mysqli_query($conn,$sql1);
        while($row1 = mysqli_fetch_assoc($result1)){
            $totalExpensive += $row1['amount'];
        }

        $netProfit = $totalIncom - $totalExpensive;
        return number_format($netProfit,2);
    }

    function showACBillNo($conn){
        $sql = "SELECT * FROM `tblacbill` WHERE (status<>'In Progress') AND (`acbillDate` BETWEEN '".date('Y')."-".date('m')."-01' AND '".date('Y')."-".date('m')."-31')";
        $result = mysqli_query($conn,$sql);
        $totalAmount = 0;
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $totalAmount += $row['amount'];
            }
        }
        return number_format($totalAmount,2);
    }

    function showCashBillNo($conn){
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE (status<>'In Progress') AND (`cashBillDate` BETWEEN '".date('Y')."-".date('m')."-01' AND '".date('Y')."-".date('m')."-31')";
        $result = mysqli_query($conn,$sql);
        $totalAmount = 0;
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $totalAmount += $row['cashBillAmount'];
            }
        }
        return number_format($totalAmount,2);
    }

    function showChequeBillNo($conn){
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE (status<>'In Progress') AND (`chequeBillDate` BETWEEN '".date('Y')."-".date('m')."-01' AND '".date('Y')."-".date('m')."-31')";
        $result = mysqli_query($conn,$sql);
        $totalAmount = 0;
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $totalAmount += $row['chequeBillAmount'];
            }
        }
        return number_format($totalAmount,2);
    }

    function showACBillsCollectedDetails($conn){
        $sql = "SELECT * FROM `tblacbill` WHERE (status<>'In Progress') AND (`acbillDate` BETWEEN '".date('Y')."-".date('m')."-01' AND '".date('Y')."-".date('m')."-31')";
        $result = mysqli_query($conn,$sql);

        $noOfBills = 0;
        $noOfBillsCollected = 0;

        if(mysqli_num_rows($result)>=1){
            
            while($row = mysqli_fetch_assoc($result)){

                $collectedAmounts = 0;
                $sql0 = "SELECT * FROM `tblacbillcollection` WHERE `billNo`='".$row['billNo']."'";
                $result0 = mysqli_query($conn,$sql0);
                if(mysqli_num_rows($result0)>=1){
                    while($row0 = mysqli_fetch_assoc($result0)){
                        $collectedAmounts += $row0['amount'];
                    }
                }

                if($collectedAmounts >= $row['amount']){
                    $noOfBillsCollected++;
                }
                $noOfBills++;
            }
        }

        return $noOfBillsCollected . " of " . $noOfBills;
    }

    function showChequeBillsDepositedDetails($conn){
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE (status<>'In Progress') AND (`chequeBillDate` BETWEEN '".date('Y')."-".date('m')."-01' AND '".date('Y')."-".date('m')."-31')";
        $result = mysqli_query($conn,$sql);

        $noOfBills = 0;
        $noOfBillsCollected = 0;

        if(mysqli_num_rows($result)>=1){
            
            while($row = mysqli_fetch_assoc($result)){

                $collectedAmounts = 0;
                $sql0 = "SELECT * FROM `tblchequedeposite` WHERE `chequeNo`='".$row['chequeNo']."'";
                $result0 = mysqli_query($conn,$sql0);
                if(mysqli_num_rows($result0)==1){
                    $noOfBillsCollected++;
                }
                $noOfBills++;
            }
        }

        return $noOfBillsCollected . " of " . $noOfBills;
    }

    



    ######################################### Bill Board ############################################

    function showCustomersDetailsForBillBoard($conn){
        $sql = "SELECT * FROM `tblcustomers` WHERE `status`='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".strtoupper($row['customerId'])."</td>";
                    echo "<td>".ucwords($row['name'], " ")."</td>";
                    echo "<td>".ucwords($row['address'], " ")."</td>";
                    echo "<td>".$row['contactNo']."</td>";
                    echo "<td>".$row['shopType']."</td>";
                    echo "<td>".$row['frezerType']."</td>";
                    echo "<td>".ucwords($row['route'], " ")."</td>";
                    echo "<td>".ucwords($row['rep'], " ")."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }                        
                    echo "<td>
                            <div class='row'>";
                            if($row['status']=='pending'){
                                echo "<div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnActiveCustomerFromPending' class='btn btn-success btn-sm' title='Active Customer' onclick='validateForm3()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeCustomerIdFromPending' value='".$row['customerId']."'>
                                        </form>
                                    </div>";
                            }
                            echo "
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
            }
            echo "<tr>";
                echo "<td colspan='11'>";
                echo "<div class='col-3'>
                        <form action='' method='POST'>
                            <button name='btnActiveCustomerFromPending' class='btn btn-success btn-sm' title='Active Customer' onclick='validateForm3_1()'>
                                <i class='fas fa-play'></i>
                            </button>
                            <input type='hidden' name='activeCustomerIdFromPending' value='all'>
                        </form>
                    </div>";
                echo "</td>";
            echo "</tr>";

        }
    }

    function showStaffsDetailsForBillBoard($conn){
        $sql = "SELECT * FROM `tblstaffs` WHERE `status`='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td><center><img src='".$row['staffsPicture']."' width='50px' height='50px'></center></td>";
                    echo "<td>".strtoupper($row['staffsId'])."</td>";
                    echo "<td>".ucwords($row['staffsNIC'], " ")."</td>";
                    echo "<td>".ucwords($row['staffsName'], " ")."</td>";
                    echo "<td>".ucwords($row['staffsAddress'], " ")."</td>";
                    echo "<td>".$row['staffsContactNo']."</td>";
                    echo "<td>".$row['staffsType']."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }                        
                    echo "<td>
                            <div class='row'>";
                            if($row['status']=='pending'){
                                echo "<div class='col-3'>
                                        <form action='#' method='POST'>
                                            <button name='btnActiveStaffFromPending' class='btn btn-success btn-sm' title='Active Staff' onclick='validateForm6()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeStaffIdFromPending' value='".$row['staffsId']."'>
                                        </form>
                                    </div>";
                            }
                            echo "
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
            }
            echo "<tr>";
                echo "<td colspan='10'>";
                echo "<div class='col-3'>
                        <form action='' method='POST'>
                            <button name='btnActiveStaffFromPending' class='btn btn-success btn-sm' title='Active All Staffs' onclick='validateForm6_1()'>
                                <i class='fas fa-play'></i>
                            </button>
                            <input type='hidden' name='activeStaffIdFromPending' value='all'>
                        </form>
                    </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function showRoutesDetailsForBillBoard($conn){
        $sql = "SELECT * FROM `tblroutes` WHERE `status`='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".strtoupper($row['routeId'])."</td>";
                    echo "<td>".ucwords($row['routeName'], " ")."</td>";
                    echo "<td>".$row['routeItenary']."</td>";
                    echo "<td>".ucwords($row['routeTown'], " ")."</td>";
                    echo "<td>".$row['routeNoOfShops']."</td>";
                    echo "<td>".ucwords($row['routeRep'], " ")."</td>";
                    echo "<td>".$row['routeNoOfFC']."</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'blocked'){
                        echo "<td><span  style='color: white;background: red'>".ucwords($row['status'], " ")."</span></td>";
                    }                        
                    echo "<td>
                            <div class='row'>";
                            if($row['status']=='pending'){
                                echo "<div class='col-3'>
                                        <form action='#' method='POST'>
                                            <button name='btnActiveRouteFromPending' class='btn btn-success btn-sm' title='Active Route' onclick='validateForm9()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeRouteIdFromPending' value='".$row['routeId']."'>
                                        </form>
                                    </div>";
                            }
                        echo "</div>
                        </td>";
                echo "</tr>";
                $no++;
            }
            echo "<tr>";
                echo "<td colspan='10'>";
                echo "<div class='col-3'>
                        <form action='' method='POST'>
                            <button name='btnActiveRouteFromPending' class='btn btn-success btn-sm' title='Active All Routes' onclick='validateForm9_1()'>
                                <i class='fas fa-play'></i>
                            </button>
                            <input type='hidden' name='activeRouteIdFromPending' value='all'>
                        </form>
                    </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function showACBillAfterInProgressesInformationsForBillBoard($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $total = 0;
        $sql = "SELECT * FROM `tblacbill` WHERE status='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                $dataCst = fetchCustomerDetails($conn,$row['customerId']);

                $date1=date_create($row['acbillDate']);
                $date2=date_create(date('Y-m-d'));
                $diff=date_diff($date1,$date2);
                $diff2=$diff->format("%R%a");

                echo "<tr class='table-danger'>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['acbillDate']."</td>";
                    echo "<td>".strtoupper($row['customerId'])."</td>";
                    echo "<td>".ucwords($row['custermerName'])."</td>";
                    echo "<td>".strtoupper($row['billNo'])."</td>";
                    echo "<td>".$dataCst['route']."</td>";
                    echo "<td>".ucwords($row['rep'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    $diff2=$diff->format("%a");
                    echo "<td style='color: green'>".$diff2." Days Left</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='admin.php?bb' method='POST'>
                                        <button name='btnActiveACBillFromPending' class='btn btn-success btn-sm' title='Active AC Bill' onclick='validateForm9()'>
                                            <i class='fas fa-play'></i>
                                        </button>
                                        <input type='hidden' name='activeACBillFromPending' value='".$row['billNo']."'>
                                    </form>
                                </div>
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
                $total = $total + $row['amount'];
            }
            echo "<tr class='table-danger'>";
                echo "<td colspan='7'><strong>Total</strong></td>";
                echo "<td>".number_format($total,2)." Rs</td>";
                echo "<td colspan='3'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveRouteFromPending' class='btn btn-success btn-sm' title='Active All AC Bills' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeACBillFromPending' value='all'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function showFindACBillAfterInProgressesInformationsForBillBoard($conn,$datFrom,$datTo,$txtRep,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $total = 0;
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($txtRep == 'all')){
            $sql = "SELECT * FROM `tblacbill` WHERE status='Pending' AND acbillDate=".$datFrom."";
        }
        elseif(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL)){
            $sql = "SELECT * FROM `tblacbill` WHERE status='Pending' AND (acbillDate='".$datFrom."') AND rep='".$txtRep."'";
        }
        elseif(($txtRep == 'all')){
            $sql = "SELECT * FROM `tblacbill` WHERE status='Pending' AND (acbillDate BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        else{
            $sql = "SELECT * FROM `tblacbill` WHERE status='Pending' AND (acbillDate BETWEEN '".$datFrom."' AND '".$datTo."') AND (rep='".$txtRep."')";
        }
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                $dataCst = fetchCustomerDetails($conn,$row['customerId']);

                $date1=date_create($row['acbillDate']);
                $date2=date_create(date('Y-m-d'));
                $diff=date_diff($date1,$date2);
                $diff2=$diff->format("%R%a");

                echo "<tr class='table-danger'>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['acbillDate']."</td>";
                    echo "<td>".strtoupper($row['customerId'])."</td>";
                    echo "<td>".ucwords($row['custermerName'])."</td>";
                    echo "<td>".strtoupper($row['billNo'])."</td>";
                    echo "<td>".$dataCst['route']."</td>";
                    echo "<td>".ucwords($row['rep'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    $diff2=$diff->format("%a");
                    echo "<td style='color: green'>".$diff2." Days Left</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    echo "<td>
                            <div class='row'>
                                <div class='col-3'>
                                    <form action='admin.php?bb' method='POST'>
                                        <button name='btnActiveACBillFromPending' class='btn btn-success btn-sm' title='Active AC Bill' onclick='validateForm9()'>
                                            <i class='fas fa-play'></i>
                                        </button>
                                        <input type='hidden' name='activeACBillFromPending' value='".$row['billNo']."'>
                                    </form>
                                </div>
                            </div>
                        </td>";
                echo "</tr>";
                $no++;
                $total = $total + $row['amount'];
            }
            echo "<tr class='table-danger'>";
                echo "<td colspan='7'><strong>Total</strong></td>";
                echo "<td>".number_format($total,2)." Rs</td>";
                echo "<td colspan='3'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveRouteFromPending' class='btn btn-success btn-sm' title='Active All AC Bills' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeACBillFromPending' value='all'>
                                <input type='hidden' name='activeACBillFromPendingDateFrom' value='".$datFrom."'>
                                <input type='hidden' name='activeACBillFromPendingDateTo' value='".$datTo."'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function activeACBillDetailsFromPending($conn,$activeACBillFromPending){
        if($activeACBillFromPending == "all"){
            $sql = "UPDATE `tblacbill` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblacbill` SET `status`='active' WHERE billNo='".$activeACBillFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
            
    }

    function activeACBillDetailsFromPending2($conn,$activeACBillFromPending,$activeACBillFromPendingDateFrom,$activeACBillFromPendingDateTo){
        $sql = "UPDATE `tblacbill` SET `status`='active' WHERE `status`='Pending' AND (`acbillDate` BETWEEN '".$activeACBillFromPendingDateFrom."' AND '".$activeACBillFromPendingDateTo."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showChqBillAfterInProgressesInformationsForBillBoard($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $total = 0;
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE status='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){

                echo "<tr class='table-success'>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['chequeBillDate']."</td>";
                    echo "<td>".strtoupper($row['chequeBillCustomerCode'])."</td>";
                    echo "<td>".ucwords($row['chequeBillCustomerName'])."</td>";
                    echo "<td>".strtoupper($row['chequeBillNo'])."</td>";

                    $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['chequeBillRep']."'";
                    $result2 = mysqli_query($conn,$sql2);
                    $data2 = $result2->fetch_assoc();

                    echo "<td>".ucwords($data2['routeName'])."</td>";

                    echo "<td>".ucwords($row['chequeBillRep'])."</td>";
                    echo "<td>".strtoupper($row['chequeNo'])."</td>";
                    echo "<td>".ucwords($row['chequeBillBank'])."</td>";

                    $date1=date_create($row['chequeDate']);
                    $date2=date_create(date("Y-m-d"));
                    $diff=date_diff($date2,$date1);
                    if($diff->format("%R%a days")>=0){
                        echo "<td style='color: green;'><strong>".$diff->format("%R%a days")."</strong></td>";
                    }
                    else{
                        echo "<td style='color: red;'><strong>".$diff->format("%R%a days")."</strong></td>";
                    }

                    echo "<td>".number_format($row['chequeBillAmount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    echo "<td>
                        <div class='row'>
                            <div class='col-3'>
                                <form action='admin.php?bb' method='POST'>
                                    <button name='btnActiveChequeBillFromPending' class='btn btn-success btn-sm' title='Active Cheque Bill' onclick='validateForm9()'>
                                        <i class='fas fa-play'></i>
                                    </button>
                                    <input type='hidden' name='activeChequeBillFromPending' value='".$row['chequeNo']."'>
                                </form>
                            </div>
                        </div>
                    </td>";
                echo "</tr>";

                $no++;

                $total = $total + $row['chequeBillAmount'];
            }
            echo "<tr class='table-success'>";
                echo "<td colspan='10'><strong>Total</strong></td>";
                echo "<td>".number_format($total,2)." Rs</td>";
                echo "<td colspan='2'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveRouteFromPending' class='btn btn-success btn-sm' title='Active All Cheque Bills' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeChequeBillFromPending' value='all'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function showFindChqBillAfterInProgressesInformationsForBillBoard($conn,$datFrom,$datTo,$txtRep,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $total = 0;
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($txtRep == 'all')){
            $sql = "SELECT * FROM `tblchequebilldetails` WHERE status='Pending' AND chequeBillDate=".$datFrom."";
        }
        elseif(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL)){
            $sql = "SELECT * FROM `tblchequebilldetails` WHERE status='Pending' AND (chequeBillDate='".$datFrom."') AND chequeBillRep='".$txtRep."'";
        }
        elseif(($txtRep == 'all')){
            $sql = "SELECT * FROM `tblchequebilldetails` WHERE status='Pending' AND (chequeBillDate BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        else{
            $sql = "SELECT * FROM `tblchequebilldetails` WHERE status='Pending' AND (chequeBillDate BETWEEN '".$datFrom."' AND '".$datTo."') AND (chequeBillRep='".$txtRep."')";
        }
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){

                echo "<tr class='table-success'>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['chequeBillDate']."</td>";
                    echo "<td>".strtoupper($row['chequeBillCustomerCode'])."</td>";
                    echo "<td>".ucwords($row['chequeBillCustomerName'])."</td>";
                    echo "<td>".strtoupper($row['chequeBillNo'])."</td>";

                    $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['chequeBillRep']."'";
                    $result2 = mysqli_query($conn,$sql2);
                    $data2 = $result2->fetch_assoc();

                    echo "<td>".ucwords($data2['routeName'])."</td>";

                    echo "<td>".ucwords($row['chequeBillRep'])."</td>";
                    echo "<td>".strtoupper($row['chequeNo'])."</td>";
                    echo "<td>".ucwords($row['chequeBillBank'])."</td>";

                    $date1=date_create($row['chequeDate']);
                    $date2=date_create(date("Y-m-d"));
                    $diff=date_diff($date2,$date1);
                    if($diff->format("%R%a days")>=0){
                        echo "<td style='color: green;'><strong>".$diff->format("%R%a days")."</strong></td>";
                    }
                    else{
                        echo "<td style='color: red;'><strong>".$diff->format("%R%a days")."</strong></td>";
                    }

                    echo "<td>".number_format($row['chequeBillAmount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    echo "<td>
                        <div class='row'>
                            <div class='col-3'>
                                <form action='admin.php?bb' method='POST'>
                                    <button name='btnActiveChequeBillFromPending' class='btn btn-success btn-sm' title='Active Cheque Bill' onclick='validateForm9()'>
                                        <i class='fas fa-play'></i>
                                    </button>
                                    <input type='hidden' name='activeChequeBillFromPending' value='".$row['chequeNo']."'>
                                </form>
                            </div>
                        </div>
                    </td>";
                echo "</tr>";

                $no++;

                $total = $total + $row['chequeBillAmount'];
            }
            echo "<tr class='table-success'>";
                echo "<td colspan='10'><strong>Total</strong></td>";
                echo "<td>".number_format($total,2)." Rs</td>";
                echo "<td colspan='2'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveRouteFromPending' class='btn btn-success btn-sm' title='Active All Cheque Bills' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeChequeBillFromPending' value='all'>
                                <input type='hidden' name='activeChequeBillFromPendingDateFrom' value='".$datFrom."'>
                                <input type='hidden' name='activeChequeBillFromPendingDateTo' value='".$datTo."'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function activeChequeBillDetailsFromPending($conn,$activeChequeBillFromPending){
        if($activeChequeBillFromPending == "all"){
            $sql = "UPDATE `tblchequebilldetails` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblchequebilldetails` SET `status`='active' WHERE chequeNo='".$activeChequeBillFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function activeChequeBillDetailsFromPending2($conn,$activeChequeBillFromPending,$activeChequeBillFromPendingDateFrom,$activeChequeBillFromPendingDateTo){
        $sql = "UPDATE `tblchequebilldetails` SET `status`='active' WHERE `status`='Pending' AND (`chequeBillDate` BETWEEN '".$activeChequeBillFromPendingDateFrom."' AND '".$activeChequeBillFromPendingDateTo."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showCashBillAfterInProgressesInformationsForBillBoard($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $total = 0;
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE status='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['cashBillDate']."</td>";
                    echo "<td>".strtoupper($row['cashBillCustomerCode'])."</td>";
                    echo "<td>".ucwords($row['cashBillCustomerName'])."</td>";
                    echo "<td>".strtoupper($row['cashBillNo'])."</td>";

                    $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['cashBillRep']."'";
                    $result2 = mysqli_query($conn,$sql2);
                    $data2 = $result2->fetch_assoc();

                    echo "<td>".ucwords($data2['routeName'])."</td>";

                    echo "<td>".ucwords($row['cashBillRep'])."</td>";
                    echo "<td>".number_format($row['cashBillAmount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='admin.php?bb' method='POST'>
                                            <button name='btnActiveCashBillFromPending' class='btn btn-success btn-sm' title='Active Cash Bill' onclick='validateForm9()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeCashBillFromPending' value='".$row['cashBillNo']."'>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
                $total = $total + $row['cashBillAmount'];
            }
            echo "<tr>";
                echo "<td colspan='7'><strong>Total</strong></td>";
                echo "<td>".number_format($total,2)." Rs</td>";
                echo "<td colspan='2'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveRouteFromPending' class='btn btn-success btn-sm' title='Active All Cash Bills' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeCashBillFromPending' value='all'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function showFindCashBillAfterInProgressesInformationsForBillBoard($conn,$datFrom,$datTo,$txtRep,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $total = 0;
        if(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL) && ($txtRep == 'all')){
            $sql = "SELECT * FROM `tblcashbilldetails` WHERE status='Pending' AND cashBillDate=".$datFrom."";
        }
        elseif(($datTo == '' && $datTo == "" && $datTo = null && $datTo == NULL)){
            $sql = "SELECT * FROM `tblcashbilldetails` WHERE status='Pending' AND (cashBillDate='".$datFrom."') AND cashBillRep='".$txtRep."'";
        }
        elseif(($txtRep == 'all')){
            $sql = "SELECT * FROM `tblcashbilldetails` WHERE status='Pending' AND (cashBillDate BETWEEN '".$datFrom."' AND '".$datTo."')";
        }
        else{
            $sql = "SELECT * FROM `tblcashbilldetails` WHERE status='Pending' AND (cashBillDate BETWEEN '".$datFrom."' AND '".$datTo."') AND (cashBillRep='".$txtRep."')";
        }
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['cashBillDate']."</td>";
                    echo "<td>".strtoupper($row['cashBillCustomerCode'])."</td>";
                    echo "<td>".ucwords($row['cashBillCustomerName'])."</td>";
                    echo "<td>".strtoupper($row['cashBillNo'])."</td>";

                    $sql2 = "SELECT * FROM `tblroutes` WHERE `routeRep`='".$row['cashBillRep']."'";
                    $result2 = mysqli_query($conn,$sql2);
                    $data2 = $result2->fetch_assoc();

                    echo "<td>".ucwords($data2['routeName'])."</td>";

                    echo "<td>".ucwords($row['cashBillRep'])."</td>";
                    echo "<td>".number_format($row['cashBillAmount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='admin.php?bb' method='POST'>
                                            <button name='btnActiveCashBillFromPending' class='btn btn-success btn-sm' title='Active Cash Bill' onclick='validateForm9()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeCashBillFromPending' value='".$row['cashBillNo']."'>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
                $total = $total + $row['cashBillAmount'];
            }
            echo "<tr>";
                echo "<td colspan='7'><strong>Total</strong></td>";
                echo "<td>".number_format($total,2)." Rs</td>";
                echo "<td colspan='2'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveRouteFromPending' class='btn btn-success btn-sm' title='Active All Cash Bills' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeCashBillFromPending' value='all'>
                                <input type='hidden' name='activeCashBillFromPendingDatFrom' value='".$datFrom."'>
                                <input type='hidden' name='activeCashBillFromPendingDatTo' value='".$datTo."'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function activeCashBillDetailsFromPending($conn,$activeCashBillFromPending){
        if($activeCashBillFromPending == "all"){
            $sql = "UPDATE `tblcashbilldetails` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblcashbilldetails` SET `status`='active' WHERE cashBillNo='".$activeCashBillFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function activeCashBillDetailsFromPending2($conn,$activeCashBillFromPending,$activeCashBillFromPendingDatFrom,$activeCashBillFromPendingDatTo){
        $sql = "UPDATE `tblcashbilldetails` SET `status`='active' WHERE `status`='Pending' AND (`cashBillDate` BETWEEN '".$activeCashBillFromPendingDatFrom."' AND '".$activeCashBillFromPendingDatTo."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function showCashDepositeAfterInProgressesInformationsForBillBoard($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblcashdeposite` WHERE status='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['accountHolderName'])."</td>";
                    echo "<td>".$row['accountNo']."</td>";
                    echo "<td>".ucwords($row['bank'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='#' method='POST'>
                                            <button name='btnActiveCashDepositeFromPending' class='btn btn-success btn-sm' title='Active Cash Deposite' onclick='validateForm9()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeCashDepositeFromPending' value='".$row['id']."'>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
            echo "<tr>";
                echo "<td colspan='8'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveCashDepositeFromPending' class='btn btn-success btn-sm' title='Active All Cash Deposite' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeCashDepositeFromPending' value='all'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function activeCashDepositeBillDetailsFromPending($conn,$activeCashDepositeFromPending){
        if($activeCashDepositeFromPending == "all"){
            $sql = "UPDATE `tblcashdeposite` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblcashdeposite` SET `status`='active' WHERE id='".$activeCashDepositeFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function showChqeueDepositeAfterInProgressesInformationsForBillBoard($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblchequedeposite` WHERE status='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['accountHolderName'])."</td>";
                    echo "<td>".$row['accountNo']."</td>";
                    echo "<td>".$row['chequeNo']."</td>";
                    echo "<td>".ucwords($row['bank'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='#' method='POST'>
                                            <button name='btnActiveChequeDepositeFromPending' class='btn btn-success btn-sm' title='Active Cheque Deposite' onclick='validateForm9()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeChequeDepositeFromPending' value='".$row['id']."'>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
            echo "<tr>";
                echo "<td colspan='9'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveChequeDepositeFromPending' class='btn btn-success btn-sm' title='Active All Cheque Deposite' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeChequeDepositeFromPending' value='all'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function activeChqeueDepositeBillDetailsFromPending($conn,$activeChequeDepositeFromPending){
        if($activeChequeDepositeFromPending == "all"){
            $sql = "UPDATE `tblchequedeposite` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblchequedeposite` SET `status`='active' WHERE id='".$activeChequeDepositeFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function showVoucherAfterInProgressesInformationsForBillBoard($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblvoucher` WHERE status='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['voucherNo'])."</td>";
                    echo "<td>".ucwords($row['description'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='#' method='POST'>
                                            <button name='btnActiveVoucherFromPending' class='btn btn-success btn-sm' title='Active Voucher' onclick='validateForm9()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeVoucherFromPending' value='".$row['id']."'>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
            echo "<tr>";
                echo "<td colspan='7'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveVoucherFromPending' class='btn btn-success btn-sm' title='Active All Voucher' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeVoucherFromPending' value='all'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function activeVoucherBillDetailsFromPending($conn,$activeVoucherFromPending){
        if($activeVoucherFromPending == "all"){
            $sql = "UPDATE `tblvoucher` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblvoucher` SET `status`='active' WHERE id='".$activeVoucherFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function showExpensivesAfterInProgressesInformationsForBillBoard($conn,$txtUserId){
        $dataUser = fetchUsersLoginDetails($conn,$txtUserId);
        $sql = "SELECT * FROM `tblexpensives` WHERE status='Pending'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".ucwords($row['type'])."</td>";
                    echo "<td>".number_format($row['amount'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($dataUser['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='#' method='POST'>
                                            <button name='btnActiveExpensiveFromPending' class='btn btn-success btn-sm' title='Active Expensive' onclick='validateForm9()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeExpensiveFromPending' value='".$row['id']."'>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                        
                echo "</tr>";
                $no++;
            }
            echo "<tr>";
                echo "<td colspan='6'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveExpensiveFromPending' class='btn btn-success btn-sm' title='Active All Expensive' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeExpensiveFromPending' value='all'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function activeExpensivesBillDetailsFromPending($conn,$activeExpensiveFromPending){
        if($activeExpensiveFromPending == "all"){
            $sql = "UPDATE `tblexpensives` SET `status`='active' WHERE `status`='Pending'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tblexpensives` SET `status`='active' WHERE id='".$activeExpensiveFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function showSystemUserRequest($conn){
        $sql = "SELECT * FROM `tbllogin` WHERE status='Waiting'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no =1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td><center><img src='".$row['profilePicture']."' width='50px' height='50px'></center></td>";
                    echo "<td>".strtoupper($row['staffsId'])."</td>";
                    $dataUser = fetchStaffDetails($conn,$row['staffsId']);
                    echo "<td>".ucwords($dataUser['staffsName'])."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".ucwords($row['type'])."</td>";
                    echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='#' method='POST'>
                                            <button name='btnActiveSystemUserFromPending' class='btn btn-success btn-sm' title='Active System User' onclick='validateForm28()'>
                                                <i class='fas fa-play'></i>
                                            </button>
                                            <input type='hidden' name='activeSystemUserFromPending' value='".$row['staffsId']."'>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                        
                echo "</tr>";
                $no++;
            }
            echo "<tr>";
                echo "<td colspan='6'>";
                    echo "<div class='col-3'>
                            <form action='' method='POST'>
                                <button name='btnActiveSystemUserFromPending' class='btn btn-success btn-sm' title='Active All Users' onclick='validateForm9_1()'>
                                    <i class='fas fa-play'></i>
                                </button>
                                <input type='hidden' name='activeSystemUserFromPending' value='all'>
                            </form>
                        </div>";
                echo "</td>";
            echo "</tr>";
        }
    }

    function activeSystemUserFromPending($conn,$activeSystemUserFromPending){
        if($activeSystemUserFromPending == "all"){
            $sql = "UPDATE `tbllogin` SET `status`='active' WHERE `status`='Waiting'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
        else{
            $sql = "UPDATE `tbllogin` SET `status`='active' WHERE staffsId='".$activeSystemUserFromPending."'";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Details Active Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function noOfRequestsForBillBoard($conn){
        $sql1 = "SELECT * FROM `tblcustomers` WHERE `status`='Pending'";
        $result1 = mysqli_query($conn,$sql1);
        $noOfCustomers = mysqli_num_rows($result1);

        $sql2 = "SELECT * FROM `tblstaffs` WHERE `status`='Pending'";
        $result2 = mysqli_query($conn,$sql2);
        $noOfStaffs = mysqli_num_rows($result2);

        $sql3 = "SELECT * FROM `tblroutes` WHERE `status`='Pending'";
        $result3 = mysqli_query($conn,$sql3);
        $noOfRoutes = mysqli_num_rows($result3);
        
        $sql4 = "SELECT * FROM `tblacbill` WHERE status='Pending'";
        $result4 = mysqli_query($conn,$sql4);
        $noOfACBill = mysqli_num_rows($result4);
        
        $sql5 = "SELECT * FROM `tblchequebilldetails` WHERE status='Pending'";
        $result5 = mysqli_query($conn,$sql5);
        $noOfChqBill = mysqli_num_rows($result5);
        
        $sql6 = "SELECT * FROM `tblcashbilldetails` WHERE status='Pending'";
        $result6 = mysqli_query($conn,$sql6);
        $noOfCshBill = mysqli_num_rows($result6);
        
        $sql7 = "SELECT * FROM `tblcashdeposite` WHERE status='Pending'";
        $result7 = mysqli_query($conn,$sql7);
        $noOfCshDeposit = mysqli_num_rows($result7);
        
        $sql8 = "SELECT * FROM `tblchequedeposite` WHERE status='Pending'";
        $result8 = mysqli_query($conn,$sql8);
        $noOfChqDeposit = mysqli_num_rows($result8);
        
        $sql9 = "SELECT * FROM `tblvoucher` WHERE status='Pending'";
        $result9 = mysqli_query($conn,$sql9);
        $noOfVoucher = mysqli_num_rows($result9);
        
        $sql10 = "SELECT * FROM `tblexpensives` WHERE status='Pending'";
        $result10 = mysqli_query($conn,$sql10);
        $noOfExpensive = mysqli_num_rows($result10);

        $sql11 = "SELECT * FROM `tbllogin` WHERE status='Waiting'";
        $result11 = mysqli_query($conn,$sql11);
        $noOfSystemUser = mysqli_num_rows($result11);

        $noOfEveryUserAdded = array("noOfCustomers"=>$noOfCustomers,"noOfStaffs"=>$noOfStaffs,"noOfRoutes"=>$noOfRoutes,"noOfACBill"=>$noOfACBill,"noOfChqBill"=>$noOfChqBill,"noOfCshBill"=>$noOfCshBill,"noOfCshDeposit"=>$noOfCshDeposit,"noOfChqDeposit"=>$noOfChqDeposit,"noOfVoucher"=>$noOfVoucher,"noOfExpensive"=>$noOfExpensive,"noOfSystemUser"=>$noOfSystemUser);

        return $noOfEveryUserAdded;
    }

    function chkLoginUserInStaffTbl($conn,$userId){
        $sql = "SELECT * FROM `tblstaffs` WHERE staffsId='".$userId."'";
        $result = mysqli_query($conn,$sql);
        $noOfStaff = mysqli_num_rows($result);
        return $noOfStaff;
    }

    ##################################################### Customers Individuals ######################

    function viewBasicSaleReportForCustomerBasedForCID($conn,$customerId){
        $no = 1;

        $totalChequeAmount = 0;
        $totalCashAmount = 0;
        $totalACAmount = 0;
        $totalAllAmount = 0;

        $billNoText = "";

        $chqBillDetails = array();
        $cshBillDetails = array();
        $acBillDetails = array();

        $sql1 = "SELECT * FROM `tblchequebilldetails` WHERE `chequeBillCustomerCode`='".$customerId."'";
        $sql2 = "SELECT * FROM `tblcashbilldetails` WHERE `cashBillCustomerCode`='".$customerId."'";
        $sql3 = "SELECT * FROM `tblacbill` WHERE `customerId`='".$customerId."'";

        $result1 = mysqli_query($conn,$sql1);
        $result2 = mysqli_query($conn,$sql2);
        $result3 = mysqli_query($conn,$sql3);

        if(mysqli_num_rows($result1)>=1){
            while($row1 = mysqli_fetch_assoc($result1)){
                $chqBillDetails = $row1;
            }
        }
        if(mysqli_num_rows($result2)>=1){
            while($row2 = mysqli_fetch_assoc($result2)){
                $cshBillDetails = $row2;
            }
        }
        if(mysqli_num_rows($result3)>=1){
            while($row3 = mysqli_fetch_assoc($result3)){
                $acBillDetails = $row3;
            }
        }
        $totalAllAmount = $totalChequeAmount + $totalCashAmount + $totalACAmount;
        if((mysqli_num_rows($result1)>=1) || (mysqli_num_rows($result2)>=1) || (mysqli_num_rows($result3)>=1)){
            echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td></td>";
                echo "<td></td>";
                echo "<td>".number_format($totalACAmount,2)."</td>";
                echo "<td>".number_format($totalCashAmount,2)."</td>";
                echo "<td>".number_format($totalChequeAmount,2)."</td>";
                echo "<td>".number_format($totalAllAmount,2)."</td>";
            echo "</tr>";
            $no++;
        }
    }

    function viewBasicSaleReportForSID($conn,$txtRep){
        $dataUser = fetchStaffDetails($conn,$txtRep);

        $date1=date_create('2021-01-01');
        $date2=date_create(date('Y-m-d'));
        $diff=date_diff($date1,$date2);
        $diff2=$diff->format("%R%a");
        $no = 1;
        while($diff2 >= 0){
            $totalChequeAmount = 0;
            $totalCashAmount = 0;
            $totalACAmount = 0;
            $totalAllAmount = 0;

            $sd = date_format($date1,"Y-m-d");
            $ed = date_format($date2,"Y-m-d");
            
            $sql1 = "SELECT * FROM `tblchequebilldetails` WHERE (`chequeBillDate`='".$sd."') AND `chequeBillRep`='".$dataUser['staffsName']."'";
            $sql2 = "SELECT * FROM `tblcashbilldetails` WHERE (`cashBillDate`='".$sd."') AND `cashBillRep`='".$dataUser['staffsName']."'";
            $sql3 = "SELECT * FROM `tblacbill` WHERE (`acbillDate`='".$sd."') AND `rep`='".$dataUser['staffsName']."'";

            $result1 = mysqli_query($conn,$sql1);
            $result2 = mysqli_query($conn,$sql2);
            $result3 = mysqli_query($conn,$sql3);
            if(mysqli_num_rows($result1)>=1){
                while($row1 = mysqli_fetch_assoc($result1)){
                    $totalChequeAmount = $totalChequeAmount + $row1['chequeBillAmount'];
                }
            }
            else{
                $totalChequeAmount = 0;
            }
            if(mysqli_num_rows($result2)>=1){
                while($row2 = mysqli_fetch_assoc($result2)){
                    $totalCashAmount = $totalCashAmount + $row2['cashBillAmount'];
                }
            }
            else{
                $totalCashAmount = 0;
            }
            if(mysqli_num_rows($result3)>=1){
                while($row3 = mysqli_fetch_assoc($result3)){
                    $totalACAmount = $totalACAmount + $row3['amount'];
                }
            } 
            else{
                $totalACAmount = 0;
            }
                    
            $totalAllAmount = $totalChequeAmount + $totalCashAmount + $totalACAmount;
            echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$sd."</td>";
                echo "<td>".number_format($totalCashAmount,2)."</td>";
                echo "<td>".number_format($totalChequeAmount,2)."</td>";
                echo "<td>".number_format($totalACAmount,2)."</td>";
                echo "<td>".number_format($totalAllAmount,2)."</td>";
            echo "</tr>";

            $no++;

            $date1 = date_add($date1,date_interval_create_from_date_string("1 days"));
            $diff=date_diff($date1,$date2);
            $diff2=$diff->format("%R%a");
        }
    }

    function viewBasicSaleReportForSIDForAllTime($conn,$txtRep){
        $dataUser = fetchStaffDetails($conn,$txtRep);
            $totalChequeAmount = 0;
            $totalCashAmount = 0;
            $totalACAmount = 0;
            $totalAllAmount = 0;
            
            $sql1 = "SELECT * FROM `tblchequebilldetails` WHERE `chequeBillRep`='".$dataUser['staffsName']."'";
            $sql2 = "SELECT * FROM `tblcashbilldetails` WHERE `cashBillRep`='".$dataUser['staffsName']."'";
            $sql3 = "SELECT * FROM `tblacbill` WHERE `rep`='".$dataUser['staffsName']."'";

            $result1 = mysqli_query($conn,$sql1);
            $result2 = mysqli_query($conn,$sql2);
            $result3 = mysqli_query($conn,$sql3);
            if(mysqli_num_rows($result1)>=1){
                while($row1 = mysqli_fetch_assoc($result1)){
                    $totalChequeAmount = $totalChequeAmount + $row1['chequeBillAmount'];
                }
            }
            else{
                $totalChequeAmount = 0;
            }
            if(mysqli_num_rows($result2)>=1){
                while($row2 = mysqli_fetch_assoc($result2)){
                    $totalCashAmount = $totalCashAmount + $row2['cashBillAmount'];
                }
            }
            else{
                $totalCashAmount = 0;
            }
            if(mysqli_num_rows($result3)>=1){
                while($row3 = mysqli_fetch_assoc($result3)){
                    $totalACAmount = $totalACAmount + $row3['amount'];
                }
            } 
            else{
                $totalACAmount = 0;
            }
                    
            $totalAllAmount = $totalChequeAmount + $totalCashAmount + $totalACAmount;

        $allData = array("totalCashAmount"=>$totalCashAmount,"totalChequeAmount"=>$totalChequeAmount,"totalACAmount"=>$totalACAmount,"totalAllAmount"=>$totalAllAmount,);

        return $allData;
    }

    function viewBasicSaleReportForSIDForThisMonth($conn,$txtRep){
        $dataUser = fetchStaffDetails($conn,$txtRep);

        $strDate = date('Y') . "-" . date('m') . "-01";
        $endDate = date('Y') . "-" . date('m') . "-31";

            $totalChequeAmount = 0;
            $totalCashAmount = 0;
            $totalACAmount = 0;
            $totalAllAmount = 0;
            
            $sql1 = "SELECT * FROM `tblchequebilldetails` WHERE (`chequeBillDate` BETWEEN '".$strDate."' AND '".$endDate."') AND (`chequeBillRep`='".$dataUser['staffsName']."')";
            $sql2 = "SELECT * FROM `tblcashbilldetails` WHERE (`cashBillDate` BETWEEN '".$strDate."' AND '".$endDate."') AND (`cashBillRep`='".$dataUser['staffsName']."')";
            $sql3 = "SELECT * FROM `tblacbill` WHERE (`acbillDate` BETWEEN '".$strDate."' AND '".$endDate."') AND (`rep`='".$dataUser['staffsName']."')";

            $result1 = mysqli_query($conn,$sql1);
            $result2 = mysqli_query($conn,$sql2);
            $result3 = mysqli_query($conn,$sql3);
            if(mysqli_num_rows($result1)>=1){
                while($row1 = mysqli_fetch_assoc($result1)){
                    $totalChequeAmount = $totalChequeAmount + $row1['chequeBillAmount'];
                }
            }
            else{
                $totalChequeAmount = 0;
            }
            if(mysqli_num_rows($result2)>=1){
                while($row2 = mysqli_fetch_assoc($result2)){
                    $totalCashAmount = $totalCashAmount + $row2['cashBillAmount'];
                }
            }
            else{
                $totalCashAmount = 0;
            }
            if(mysqli_num_rows($result3)>=1){
                while($row3 = mysqli_fetch_assoc($result3)){
                    $totalACAmount = $totalACAmount + $row3['amount'];
                }
            } 
            else{
                $totalACAmount = 0;
            }
                    
            $totalAllAmount = $totalChequeAmount + $totalCashAmount + $totalACAmount;

        $thisMonthData = array("totalCashAmount"=>$totalCashAmount,"totalChequeAmount"=>$totalChequeAmount,"totalACAmount"=>$totalACAmount,"totalAllAmount"=>$totalAllAmount,);

        return $thisMonthData;
    }

    ######################################## Salary #############################################

    function salaryAdding($conn,$txtUserId,$staffsId,$staffsName,$basicPerDay,$attendance,$basicTotal,$comissionAmount,$commissionPercentage,$totalComission,$incentive,$grossSalaray,$sortStore,$advance,$totalDischarges,$netSalary,$salaryMonth,$salaryYear){

        $data = fetchUsersLoginDetails($conn,$txtUserId);
        $txtStatus = '';
        if($data['type']=='admin'){
            $txtStatus = 'active';
        }
        if($data['type']=='user'){
            $txtStatus = 'pending';
        }

        $sql = "SELECT * FROM `tblsalary` WHERE (salaryMonth='".$salaryMonth."') AND (salaryYear='".$salaryYear."')";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            echo " <script>
                        setTimeout(function(){ swal('Failed!', 'Salary is already Added!', 'error');},25);
                    </script> ";
        }
        else{
            $sql1 = "INSERT INTO `tblsalary`(`staffsId`, `staffsName`, `basicPerDay`, `attendance`, `basicTotal`, `comissionAmount`, `commissionPercentage`, `totalComission`, `incentive`, `grossSalaray`, `sortStore`, `advance`, `totalDischarges`, `netSalary`, `salaryMonth`, `salaryYear`, `addedBy`,  `status`) VALUES ('".$staffsId."', '".$staffsName."', '".$basicPerDay."', '".$attendance."', '".$basicTotal."', '".$comissionAmount."', '".$commissionPercentage."', '".$totalComission."', '".$incentive."', '".$grossSalaray."', '".$sortStore."', '".$advance."', '".$totalDischarges."', '".$netSalary."', '".$salaryMonth."', '".$salaryYear."', '".$data['staffsId']."', '".$txtStatus."')";
            $result1 = mysqli_query($conn,$sql1);
            if($result1){
                echo " <script>
                            setTimeout(function(){ swal({title: 'Success!',text: 'Customer Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                        </script> ";
            }
            else{
                echo " <script>
                            setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                        </script> ";
            }
        }
    }

    function salaryViewing($conn,$txtUserId,$txtStaffId){

        $data = fetchUsersLoginDetails($conn,$txtUserId);
        
        $sql = "SELECT * FROM `tblsalary` WHERE staffsId='".$txtStaffId."'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>=1){
            $no = 1;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                    echo "<td>".$no."</td>";
                    echo "<td>".$row['salaryYear']."</td>";
                    echo "<td>".$row['salaryMonth']."</td>";
                    echo "<td>".number_format($row['basicPerDay'],2)." Rs</td>";
                    echo "<td>".$row['attendance']."</td>";
                    echo "<td>".number_format($row['basicTotal'],2)." Rs</td>";
                    echo "<td>".number_format($row['comissionAmount'],2)." Rs</td>";
                    echo "<td>".$row['commissionPercentage']."%</td>";
                    echo "<td>".number_format($row['totalComission'],2)." Rs</td>";
                    echo "<td>".number_format($row['incentive'],2)." Rs</td>";
                    echo "<td>".number_format($row['grossSalaray'],2)." Rs</td>";
                    echo "<td>".number_format($row['sortStore'],2)." Rs</td>";
                    echo "<td>".number_format($row['advance'],2)." Rs</td>";
                    echo "<td>".number_format($row['totalDischarges'],2)." Rs</td>";
                    echo "<td>".number_format($row['netSalary'],2)." Rs</td>";
                    if($row['status'] == 'active'){
                        echo "<td><span  style='color: yellow;background: green'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($row['status'] == 'pending'){
                        echo "<td><span  style='color: green;background: yellow'>".ucwords($row['status'], " ")."</span></td>";
                    }
                    if($data['type']=='admin'){
                        echo "<td>
                                <div class='row'>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <button name='btnDeleteInvoinvocing' class='btn btn-danger btn-sm' title='Delete Bill' onclick='validateForm27()'>
                                                <i class='fas fa-trash-alt'></i>
                                            </button>
                                            <input type='hidden' name='deleteSalaryInformation' value='".$row['id']."'>
                                        </form>
                                    </div>
                                    <div class='col-3'>
                                        <form action='' method='POST'>
                                            <a href='admin.php?salary&vsid=".$_GET['vsid']."&esde=".$row['id']."' class='btn btn-secondary btn-sm' title='Edit Details'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </td>";
                    }
                echo "</tr>";
                $no++;
            }
        }
    }

    function deleteSalaryInformation($conn,$deleteSalaryInformation){
        $sql = "DELETE FROM `tblsalary` WHERE id='".$deleteSalaryInformation."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function fetchEmployeeSalaryDetails($conn,$esde){
        $sql = "SELECT * FROM `tblsalary` WHERE id='".$esde."'";
        $result = mysqli_query($conn,$sql);
        $data = $result->fetch_assoc();
        return $data;
    }

    function editSalaryDetails($conn,$id,$basicPerDay,$attendance,$basicTotal,$comissionAmount,$commissionPercentage,$totalComission,$incentive,$grossSalaray,$sortStore,$advance,$totalDischarges,$netSalary,$salaryMonth,$salaryYear){
        $sql = "UPDATE `tblsalary` SET `basicPerDay`='".$basicPerDay."',`attendance`='".$attendance."',`basicTotal`='".$basicTotal."',`comissionAmount`='".$comissionAmount."',`commissionPercentage`='".$commissionPercentage."',`totalComission`='".$totalComission."',`incentive`='".$incentive."',`grossSalaray`='".$grossSalaray."',`sortStore`='".$sortStore."',`advance`='".$advance."',`totalDischarges`='".$totalDischarges."',`netSalary`='".$netSalary."',`salaryMonth`='".$salaryMonth."',`salaryYear`='".$salaryYear."' WHERE `id`='".$id."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    ############################################# Default Date Setting ###############################

    function defaultDateSettingForCrdSale($conn){
        $sql = "SELECT * FROM `tblacbill` WHERE `status`='In Progress' ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['acbillDate'];
                break;
            }
        }
        else{
            $datOutput = date('Y-m-d');
        }
        return $datOutput;
    }

    function defaultRepSelectedACBill($conn){
        $sql = "SELECT * FROM `tblacbill` WHERE `status`='In Progress' ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['rep'];
                break;
            }
        }

        $selectedOption = '';
        $sql1 = "SELECT * FROM `tblstaffs` WHERE staffsType='Rep'";
        $result1 = mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result1)>=1){
            while($row1 = mysqli_fetch_assoc($result1)){
                if($datOutput == $row1['staffsName']){
                    $selectedOption = ' selected';
                }
                echo "<option value=\"".$row1['staffsName']."\"".$selectedOption.">".ucwords($row1['staffsName'], " ")."</option>";
                $selectedOption = '';
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function defaultDateSettingForChqSale($conn){
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE status='In Progress' ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['chequeBillDate'];
                break;
            }
        }
        else{
            $datOutput = date('Y-m-d');
        }
        return $datOutput;
    }

    function defaultRepSelectedChqBill($conn){
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE `status`='In Progress' ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['chequeBillRep'];
                break;
            }
        }

        $selectedOption = '';
        $sql1 = "SELECT * FROM `tblstaffs` WHERE staffsType='Rep'";
        $result1 = mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result1)>=1){
            while($row1 = mysqli_fetch_assoc($result1)){
                if($datOutput == $row1['staffsName']){
                    $selectedOption = ' selected';
                }
                echo "<option value=\"".$row1['staffsName']."\"".$selectedOption.">".ucwords($row1['staffsName'], " ")."</option>";
                $selectedOption = '';
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function defaultChqDateSettingForChqSale($conn){
        $sql = "SELECT * FROM `tblchequebilldetails` WHERE status='In Progress' ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['chequeDate'];
                break;
            }
        }
        else{
            $datOutput = date('Y-m-d');
        }
        return $datOutput;
    }

    function defaultDateSettingForCshSale($conn){
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE status='In Progress' ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['cashBillDate'];
                break;
            }
        }
        else{
            $datOutput = date('Y-m-d');
        }
        return $datOutput;
    }

    function defaultRepSelectedCashBill($conn){
        $sql = "SELECT * FROM `tblcashbilldetails` WHERE status='In Progress' ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['cashBillRep'];
                break;
            }
        }

        $selectedOption = '';
        $sql1 = "SELECT * FROM `tblstaffs` WHERE staffsType='Rep'";
        $result1 = mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result1)>=1){
            while($row1 = mysqli_fetch_assoc($result1)){
                if($datOutput == $row1['staffsName']){
                    $selectedOption = ' selected';
                }
                echo "<option value=\"".$row1['staffsName']."\"".$selectedOption.">".ucwords($row1['staffsName'], " ")."</option>";
                $selectedOption = '';
            }
        }
        else{
            echo "<option value=\"\" disabled>Please Add Reps</option>";
        }
    }

    function defaultDateSettingForACBillInRHToColt($conn){
        $sql = "SELECT * FROM `tblacbilltocollectinrephand` WHERE `status`='In Progress' ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['date'];
                break;
            }
        }
        else{
            $datOutput = date('Y-m-d');
        }
        return $datOutput;
    }

    function defaultDateSettingForCshDept($conn){
        $sql = "SELECT * FROM `tblcashdeposite` ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['date'];
                break;
            }
        }
        else{
            $datOutput = date('Y-m-d');
        }
        return $datOutput;
    }

    function defaultDateSettingForChqDept($conn){
        $sql = "SELECT * FROM `tblchequedeposite` ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['date'];
                break;
            }
        }
        else{
            $datOutput = date('Y-m-d');
        }
        return $datOutput;
    }

    function defaultDateSettingForVoucher($conn){
        $sql = "SELECT * FROM `tblvoucher` ORDER BY `addedDate` DESC";
        $result = mysqli_query($conn,$sql);
        $datOutput = '';
        if(mysqli_num_rows($result)>=1){
            while($row = mysqli_fetch_assoc($result)){
                $datOutput = $row['date'];
                break;
            }
        }
        else{
            $datOutput = date('Y-m-d');
        }
        return $datOutput;
    }

    function showNotification1($conn){
        $noOfEveryUserAdded = noOfRequestsForBillBoard($conn);
        $showNotificationOnMasterData = '';
        $showNotificationOnSales = '';
        $showNotificationOnLedger = '';
        $showNotificationOnExpenses = '';
        if($noOfEveryUserAdded['noOfCustomers']>=1 || $noOfEveryUserAdded['noOfStaffs']>=1 || $noOfEveryUserAdded['noOfRoutes']>=1){
            $showNotificationOnMasterData = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfACBill']>=1 || $noOfEveryUserAdded['noOfChqBill']>=1 || $noOfEveryUserAdded['noOfCshBill']>=1){
            $showNotificationOnSales = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfCshDeposit']>=1 || $noOfEveryUserAdded['noOfChqDeposit']>=1 || $noOfEveryUserAdded['noOfVoucher']>=1){
            $showNotificationOnLedger = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfExpensive']>=1){
            $showNotificationOnExpenses = '<span class="badge badge-danger badge-counter">*</span>';
        }

        $outputDataToShowNotification = array("showNotificationOnMasterData"=>$showNotificationOnMasterData,"showNotificationOnSales"=>$showNotificationOnSales,"showNotificationOnLedger"=>$showNotificationOnLedger,"showNotificationOnExpenses"=>$showNotificationOnExpenses);

        return $outputDataToShowNotification;
    }

    function showNotification2($conn){
        $noOfEveryUserAdded = noOfRequestsForBillBoard($conn);
        $showNotificationOnMasterData1 = '';
        $showNotificationOnMasterData2 = '';
        $showNotificationOnMasterData3 = '';
        $showNotificationOnSales1 = '';
        $showNotificationOnSales2 = '';
        $showNotificationOnSales3 = '';
        $showNotificationOnLedger1 = '';
        $showNotificationOnLedger2 = '';
        $showNotificationOnLedger3 = '';
        if($noOfEveryUserAdded['noOfCustomers']>=1){
            $showNotificationOnMasterData1 = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfStaffs']>=1){
            $showNotificationOnMasterData2 = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfRoutes']>=1){
            $showNotificationOnMasterData3 = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfACBill']>=1){
            $showNotificationOnSales1 = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfChqBill']>=1){
            $showNotificationOnSales2 = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfCshBill']>=1){
            $showNotificationOnSales3 = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfCshDeposit']>=1){
            $showNotificationOnLedger1 = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfChqDeposit']>=1){
            $showNotificationOnLedger2 = '<span class="badge badge-danger badge-counter">*</span>';
        }
        if($noOfEveryUserAdded['noOfVoucher']>=1){
            $showNotificationOnLedger3 = '<span class="badge badge-danger badge-counter">*</span>';
        }

        $outputDataToShowNotification2 = array("showNotificationOnMasterData1"=>$showNotificationOnMasterData1,"showNotificationOnMasterData2"=>$showNotificationOnMasterData2,"showNotificationOnMasterData3"=>$showNotificationOnMasterData3,"showNotificationOnSales1"=>$showNotificationOnSales1,"showNotificationOnSales2"=>$showNotificationOnSales2,"showNotificationOnSales3"=>$showNotificationOnSales3,"showNotificationOnLedger1"=>$showNotificationOnLedger1,"showNotificationOnLedger2"=>$showNotificationOnLedger2,"showNotificationOnLedger3"=>$showNotificationOnLedger3);

        return $outputDataToShowNotification2;
    }

    function showMainNotification1($conn){
        $noOfTotalNotification = 0;
        $sql1 = "SELECT * FROM `tblcustomers` WHERE `status`='Pending' ORDER BY `addedDate` DESC";
        $result1 = mysqli_query($conn,$sql1);
        $noOfCustomers = mysqli_num_rows($result1);
        $datOutput1 = '';
        $notiOutput1 = '';
        if(mysqli_num_rows($result1)>=1){
            while($row1 = mysqli_fetch_assoc($result1)){
                $datOutput1 = $row1['addedDate'];
                break;
            }
            $notiOutput1 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-folder text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput1.'</div>
                                    <span class="font-weight-bold">New '.$noOfCustomers.' Custmers data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }

        $sql2 = "SELECT * FROM `tblstaffs` WHERE `status`='Pending' ORDER BY `addedDate` DESC";
        $result2 = mysqli_query($conn,$sql2);
        $noOfStaffs = mysqli_num_rows($result2);
        $datOutput2 = '';
        $notiOutput2 = '';
        if(mysqli_num_rows($result2)>=1){
            while($row2 = mysqli_fetch_assoc($result2)){
                $datOutput2 = $row2['addedDate'];
                break;
            }
            $notiOutput2 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-secondary">
                                        <i class="fas fa-folder text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput2.'</div>
                                    <span class="font-weight-bold">New '.$noOfStaffs.' Staffs data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }

        $sql3 = "SELECT * FROM `tblroutes` WHERE `status`='Pending' ORDER BY `addedDate` DESC";
        $result3 = mysqli_query($conn,$sql3);
        $noOfRoutes = mysqli_num_rows($result3);
        $datOutput3 = '';
        $notiOutput3 = '';
        if(mysqli_num_rows($result3)>=1){
            while($row3 = mysqli_fetch_assoc($result3)){
                $datOutput3 = $row3['addedDate'];
                break;
            }
            $notiOutput3 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-folder text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput3.'</div>
                                    <span class="font-weight-bold">New '.$noOfRoutes.' Routes data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }
        
        $sql4 = "SELECT * FROM `tblacbill` WHERE status='Pending' ORDER BY `addedDate` DESC";
        $result4 = mysqli_query($conn,$sql4);
        $noOfACBill = mysqli_num_rows($result4);
        $datOutput4 = '';
        $notiOutput4 = '';
        if(mysqli_num_rows($result4)>=1){
            while($row4 = mysqli_fetch_assoc($result4)){
                $datOutput4 = $row4['addedDate'];
                break;
            }
            $notiOutput4 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-folder text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput4.'</div>
                                    <span class="font-weight-bold">New '.$noOfACBill.' AC Bill data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }
        
        $sql5 = "SELECT * FROM `tblchequebilldetails` WHERE status='Pending' ORDER BY `addedDate` DESC";
        $result5 = mysqli_query($conn,$sql5);
        $noOfChqBill = mysqli_num_rows($result5);
        $datOutput5 = '';
        $notiOutput5 = '';
        if(mysqli_num_rows($result5)>=1){
            while($row5 = mysqli_fetch_assoc($result5)){
                $datOutput5 = $row5['addedDate'];
                break;
            }
            $notiOutput5 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-dollar-sign text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput5.'</div>
                                    <span class="font-weight-bold">New '.$noOfChqBill.' Cheque Bill data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }
        
        $sql6 = "SELECT * FROM `tblcashbilldetails` WHERE status='Pending' ORDER BY `addedDate` DESC";
        $result6 = mysqli_query($conn,$sql6);
        $noOfCshBill = mysqli_num_rows($result6);
        $datOutput6 = '';
        $notiOutput6 = '';
        if(mysqli_num_rows($result6)>=1){
            while($row6 = mysqli_fetch_assoc($result6)){
                $datOutput6 = $row6['addedDate'];
                break;
            }
            $notiOutput6 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-dollar-sign text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput6.'</div>
                                    <span class="font-weight-bold">New '.$noOfCshBill.' Cash Bill data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }
        
        $sql7 = "SELECT * FROM `tblcashdeposite` WHERE status='Pending' ORDER BY `addedDate` DESC";
        $result7 = mysqli_query($conn,$sql7);
        $noOfCshDeposit = mysqli_num_rows($result7);
        $datOutput7 = '';
        $notiOutput7 = '';
        if(mysqli_num_rows($result7)>=1){
            while($row7 = mysqli_fetch_assoc($result7)){
                $datOutput7 = $row7['addedDate'];
                break;
            }
            $notiOutput7 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-balance-scale text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput7.'</div>
                                    <span class="font-weight-bold">New '.$noOfCshDeposit.' Cash Deposites data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }
        
        $sql8 = "SELECT * FROM `tblchequedeposite` WHERE status='Pending' ORDER BY `addedDate` DESC";
        $result8 = mysqli_query($conn,$sql8);
        $noOfChqDeposit = mysqli_num_rows($result8);
        $datOutput8 = '';
        $notiOutput8 = '';
        if(mysqli_num_rows($result8)>=1){
            while($row8 = mysqli_fetch_assoc($result8)){
                $datOutput8 = $row8['addedDate'];
                break;
            }
            $notiOutput8 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-dark">
                                        <i class="fas fa-balance-scale text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput8.'</div>
                                    <span class="font-weight-bold">New '.$noOfChqDeposit.' Cheque Deposites data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }
        
        $sql9 = "SELECT * FROM `tblvoucher` WHERE status='Pending' ORDER BY `addedDate` DESC";
        $result9 = mysqli_query($conn,$sql9);
        $noOfVoucher = mysqli_num_rows($result9);
        $datOutput9 = '';
        $notiOutput9 = '';
        if(mysqli_num_rows($result9)>=1){
            while($row9 = mysqli_fetch_assoc($result9)){
                $datOutput9 = $row9['addedDate'];
                break;
            }
            $notiOutput9 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-balance-scale text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput9.'</div>
                                    <span class="font-weight-bold">New '.$noOfVoucher.' Vouchers data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }
        
        $sql10 = "SELECT * FROM `tblexpensives` WHERE status='Pending' ORDER BY `addedDate` DESC";
        $result10 = mysqli_query($conn,$sql10);
        $noOfExpensive = mysqli_num_rows($result10);
        $datOutput10 = '';
        $notiOutput10 = '';
        if(mysqli_num_rows($result10)>=1){
            while($row10 = mysqli_fetch_assoc($result10)){
                $datOutput10 = $row10['addedDate'];
                break;
            }
            $notiOutput10 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-folder text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">'.$datOutput10.'</div>
                                    <span class="font-weight-bold">New '.$noOfExpensive.' Expensences data have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }

        $sql11 = "SELECT * FROM `tbllogin` WHERE status='Waiting'";
        $result11 = mysqli_query($conn,$sql11);
        $noOfSystemUser = mysqli_num_rows($result11);
        $notiOutput11 = '';
        if(mysqli_num_rows($result11)>=1){
            $notiOutput11 = '<a class="dropdown-item d-flex align-items-center" href="admin.php?bb">
                                <div class="mr-3">
                                    <div class="icon-circle bg-dark">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <span class="font-weight-bold">New '.$noOfSystemUser.' System Users have been added by User</span>
                                </div>
                            </a>';
            $noOfTotalNotification = $noOfTotalNotification + 1;
        }

        $outputMainNotification = array("notiOutput1"=>$notiOutput1,"notiOutput2"=>$notiOutput2,"notiOutput3"=>$notiOutput3,"notiOutput4"=>$notiOutput4,"notiOutput4"=>$notiOutput4,"notiOutput5"=>$notiOutput5,"notiOutput6"=>$notiOutput6,"notiOutput7"=>$notiOutput7,"notiOutput8"=>$notiOutput8,"notiOutput9"=>$notiOutput9,"notiOutput10"=>$notiOutput10,"notiOutput11"=>$notiOutput11,"noOfTotalNotification"=>$noOfTotalNotification);

        return $outputMainNotification;
    }

    ############################### Profit Section New    ########################################

    function addProfitOrLoss($conn,$txtMonth,$txtYear,$txtType,$txtDiscription,$txtAmount){
        $sql = "INSERT INTO `tblprofitlostreport`(`month`, `year`, `type`, `description`, `amount`) VALUES ('".$txtMonth."','".$txtYear."','".$txtType."','".$txtDiscription."','".$txtAmount."')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Added Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function deleteProfitOrLoss($conn,$id){
        $sql = "DELETE FROM `tblprofitlostreport` WHERE id='".$id."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Deleted Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }

    function editProfitOrLoss($conn,$id,$txtType,$txtDiscription,$txtAmount){
        $sql = "UPDATE `tblprofitlostreport` SET `type`='".$txtType."',`description`='".$txtDiscription."',`amount`='".$txtAmount."' WHERE `id`='".$id."'";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo " <script>
                        setTimeout(function(){ swal({title: 'Success!',text: 'Details Edited Successfully!',icon: 'success',button: false, timer: 1000});},25);
                    </script> ";
        }
        else{
            echo " <script>
                        setTimeout(function(){ swal({title: 'Failed!',text: 'Try Again!',icon: 'error',button: false, timer: 1000});},25);
                    </script> ";
        }
    }




?>