        <?php
            if ($hasLoginError)
            {
        ?>
        <div class="form-group">
            <div class="alert alert-danger">
                <span class="fa fa-info" aria-hidden="true"></span>
                <?php 
                    echo $userNameError;
                    echo isset($userPassError) ? '<br>' : "";
                    echo $userPassError;
                ?>
            </div>
        </div>
        <?php
            }
        ?>
        <?php
            if ($hasRegisterError)
            {
        ?>
        <div class="form-group">
            <div class="alert alert-danger">
                <span class="fa fa-info" aria-hidden="true"></span>
                <?php 
                    echo $nameError;
                    echo isset($emailError) ? '<br>' : "";
                    echo $emailError;
                    echo isset($passError) ? '<br>' : "";
                    echo $passError;
                ?>
            </div>
        </div>
        <?php
            }
            else if (!empty($errMSG))
            {
        ?>
        <div class="form-group">
            <div class="alert alert-success">
                <span class="fa fa-info" aria-hidden="true"></span> <?php echo $errMSG; ?>
            </div>
        </div>
        <?php
            }
        ?>