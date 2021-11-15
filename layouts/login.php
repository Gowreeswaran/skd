<?php
    if(isset($_POST['btnSubmitLoginForm'])){
        login($conn,$_POST['txtUserId'],$_POST['txtPassword']);
    }
?>
<div class="row">
    <div class="col-lg-12">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Login</h1>
                <i class="fa fa-user-circle login-icon" aria-hidden="true"></i>
            </div>
            <form name="loginForm" method="POST" action="index.php" class="user">
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="txtUserId" name="txtUserId" aria-describedby="emailHelp" placeholder="Enter Email Address or User ID">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="txtPassword" name="txtPassword" placeholder="Password">
                </div>
                <hr>
                <button name="btnSubmitLoginForm" type="submit" class="btn btn-primary btn-user btn-block">
                    Login
                </button>
                <hr>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="index.php?forgetpassword">Forgot Password?</a>
            </div>
        </div>
    </div>
</div>
