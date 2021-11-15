<?php 
	include_once '..\config\config.php';

	if(isset($_POST['repTxt'])) {
		$sql = "SELECT * FROM `tblcustomers` WHERE rep='".$_POST['repTxt']."'";
        $result = mysqli_query($conn,$sql);
        $datas = array();  
        while($row = mysqli_fetch_assoc($result))  
        {  
            $datas[] = $row;  
        }  
		echo json_encode($datas);
    }
    
    if(isset($_POST['cstCode'])) {
        $datas = array();  
        $sql = "SELECT * FROM `tblcustomers`";
        $result = mysqli_query($conn,$sql);
        $datas1 = array();  
        while($row = mysqli_fetch_assoc($result))  
        {  
            $datas1[] = $row;  
        }
        $datas[0] = $datas1;
        
        $sql1 = "SELECT * FROM `tblstaffs` WHERE `staffsType`='Rep'";
        $result1 = mysqli_query($conn,$sql1);
        $datas2 = array();  
        while($row1 = mysqli_fetch_assoc($result1))  
        {  
            $datas2[] = $row1;  
        }  
        $datas[1] = $datas2;

        $sql2 = "SELECT * FROM `tblcustomers` WHERE `customerId`='".$_POST['cstCode']."'";
        $result2 = mysqli_query($conn,$sql2);
        $datass = $result2->fetch_assoc();
        $datas[2] = $datass['rep'];

		echo json_encode($datas);
    }
    
    if(isset($_POST['cstName'])) {
        $datas = array();  
        $sql = "SELECT * FROM `tblcustomers`";
        $result = mysqli_query($conn,$sql);
        $datas1 = array();  
        while($row = mysqli_fetch_assoc($result))  
        {  
            $datas1[] = $row;  
        }
        $datas[0] = $datas1;
        
        $sql1 = "SELECT * FROM `tblstaffs` WHERE `staffsType`='Rep'";
        $result1 = mysqli_query($conn,$sql1);
        $datas2 = array();  
        while($row1 = mysqli_fetch_assoc($result1))  
        {  
            $datas2[] = $row1;  
        }  
        $datas[1] = $datas2;

        $sql2 = "SELECT * FROM `tblcustomers` WHERE `name`='".$_POST['cstName']."'";
        $result2 = mysqli_query($conn,$sql2);
        $datass = $result2->fetch_assoc();
        $datas[2] = $datass['rep'];

		echo json_encode($datas);
	}

    if(isset($_POST['salaryMonth1'])) {
        $datas = array();  
        
        $sql = "SELECT * FROM `tblstaffs` WHERE staffsId='".$_POST['staffId1']."'";
        $result = mysqli_query($conn,$sql);
        $dataUser = $result->fetch_assoc();

        $strDate = $_POST['salaryYear1'] . "-" . $_POST['salaryMonth1'] . "-01";
        $endDate = $_POST['salaryYear1'] . "-" . $_POST['salaryMonth1'] . "-31";

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

            $datas[0] = $totalAllAmount;

		echo json_encode($datas);
	}

 ?>