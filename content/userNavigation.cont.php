<div class="user-bar">
    <div class="row">
        <div class="col-md-12">
            <div class="container">
            <?php
                if (!Session::get('userid'))
                {
            ?>
                <p>Welcome, Guest. Please <button type="button" class="btn btn-success btn-sm" onclick="overlayOn('login')">Login</button> or <button type="button" class="btn btn-success btn-sm" onclick="overlayOn('register')">Register</button></p>
            <?php
                }
                else
                {
                    $userFields = $webDB->getAllUserDataForAccount(Session::get('userid'));
                    $accountFields = $accDB->getAllAccountDataForAccount(Session::get('userid'));
                    if (!empty($userFields))
                    {
            ?>
                <p style="text-align:left;">
                    <img src="<?php echo Config\Hosting::baseURL ?>uploads/avatars/<?php echo $userFields['avatar'] ?>" width="35px" height="35px" style="border:3px solid grey; vertical-align: middle;" > Welcome back, <?php echo $userFields['displayName'] ?>
                    <span style="float:right;">
                        <a href="/admin/home" class="btn btn-dark btn-sm" role="button" aria-pressed="true"><i class="fas fa-hand-spock"></i> Admin Panel</a>
                        <a href="/account/home" class="btn btn-info btn-sm" role="button" aria-pressed="true"><i class="fas fa-cogs"></i> Account Panel</a>
                        <a href="<?php echo Config\Hosting::baseURL ?>logout.php" class="btn btn-danger btn-sm" role="button" aria-pressed="true"><i class="fa fa-power-off"></i> Logout</a>
                    </span>
                </p>
            <?php
                    }
                }
            ?>
            </div>
        </div>
    </div>
</div>