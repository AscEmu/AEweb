    <div id="overlay-register" onclick="registerOff()">
        <div id="register">
            <div id="register-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
             <div class="form-group">
                <h2 class="">Account Registration</h2>
             </div>
             <div class="form-group">
                <hr />
             </div>
             
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-user" aria-hidden="true"></span></span>
                   <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" />
                </div>
                
             </div>
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-envelope" aria-hidden="true"></span></span>
                   <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" />
                </div>
                
             </div>
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-key" aria-hidden="true"></span></span>
                   <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                
             </div>
             <div class="form-group">
                <hr />
             </div>
             <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
             </div>
             <div class="form-group">
                <hr />
             </div>
          </form>
            </div>
            If you already have an account, please <button type="button" class="btn btn-success btn-xs" onclick="registerOff();loginOn()">Login</button>
        </div>
    </div>