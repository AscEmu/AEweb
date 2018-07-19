    <div id="overlay-login" onclick="loginOff()">
        <div id="login">
            <div id="login-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
             <div class="form-group">
                <h2 class="">Login</h2>
             </div>
             <div class="form-group">
                <hr />
             </div>
             
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-user" aria-hidden="true"></span></span>
                   <input type="text" name="userName" class="form-control" placeholder="Enter Name" maxlength="50" />
                </div>
                
             </div>
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-key" aria-hidden="true"></span></span>
                   <input type="password" name="userPass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                
             </div>
             <div class="form-group">
                <hr />
             </div>
             <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary" name="btn-signin">Sign In</button>
             </div>
             <div class="form-group">
                <hr />
             </div>
          </form>
        </div>
            If you need an account, please <button type="button" class="btn btn-success btn-xs" onclick="loginOff;registerOn()()">Register</button>
        </div>
    </div>