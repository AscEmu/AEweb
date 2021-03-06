    <div id="overlay-register" onclick="overlayOff('register')">
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
                   <input type="text" name="name" class="form-control" placeholder="Account Name (used for login game)" maxlength="50" />
                </div>
             </div>
                
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-user" aria-hidden="true"></span></span>
                   <input type="text" name="displayName" class="form-control" placeholder="Display Name (shown on website)" maxlength="50" />
                </div>
             </div>
                
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-envelope" aria-hidden="true"></span></span>
                   <input type="email" name="email" class="form-control" placeholder="Your Email" maxlength="40" />
                </div>
                
             </div>
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-key" aria-hidden="true"></span></span>
                   <input type="password" name="pass" class="form-control" placeholder="Password" maxlength="15" />
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
            If you already have an account, please <button type="button" class="btn btn-success btn-sm" onclick="overlayOff('register');overlayOn('login')">Login</button>
        </div>
    </div>