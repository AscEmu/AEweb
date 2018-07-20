</div>
    
<footer>
    <div class="container">
        <div class="col-md-4">
            <h3><?php echo Config\Info::siteName ?></h3>
            <p><?php echo Config\Info::siteSlogan ?></p>
            <p>&copy; <?php echo Config\Info::siteName ?> | <?php echo Config\Info::foundedInYear != date("Y") ? Config\Info::foundedInYear."-".date("Y") : Config\Info::foundedInYear ?></p>
        </div>
        <div class="col-md-4">
            Some Text to pretend here is some content.
        </div>
        <div class="col-md-4">
            Home | Rules | Status (it is fake! Do not press it!)
        </div>
    </div>
</footer>
    
<script>

function overlayOn(name) {
    document.getElementById("overlay-"+name).style.display = "block";
}

function overlayOff(name) {
    document.getElementById("overlay-"+name).style.display = "none";
}
        
// ignore onclick event in this div ids
$(document).ready(function() {

    $('#register-form').click(function(e) {
        e.stopPropagation();
    });
    
    $('#login-form').click(function(e) {
        e.stopPropagation();
    });

});
</script>
</body>
</html>
<?php ob_end_flush(); ?>