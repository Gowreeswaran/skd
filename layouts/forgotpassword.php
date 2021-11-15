<div class="row">
    <div class="col-lg-12">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                <p class="mb-4">We get it, stuff happens. Just enter your email address, username and nic no below and we'll send you a temporary password!</p>
            </div>
            <form method="POST" action="index.php" class="user">
                <div class="form-group">
                    <input type="email" class="form-control form-control-user" id="txtEmail" name="txtEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="txtUsername" name="txtUsername" aria-describedby="emailHelp" placeholder="Enter Username...">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="txtNicNo" name="txtNicNo" aria-describedby="emailHelp" placeholder="Enter NIC No...">
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Reset Password
                </button>
            </form>
            <hr>
            <div class="text-center">
                <a class="small" href="index.php">Already have an account? Login!</a>
            </div>
        </div>
    </div>
</div>