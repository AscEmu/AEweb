<?php

?>

<?php include 'content/header.cont.php'; ?>

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Admin Panel</h2>
                <hr>
                <p>Really important stuff here. Throw some graphs at the top (everyone loves graphs). Mr. Poo is now living here until the awesome graphs arrives.</p>
                <h1 align="center"><i class="fas fa-poo"></i></h1>
            </div>
        </div>
    </div>
</div>
<div class="basic-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>Write some news</h2>
                <p>Let people know what is going on right now. Your Text will appear on the frontpage!</p>
                <p>You should avoid any coloring and sizing since it gets overwritten with the default style of the page.</p>
                <p>Feel free to add a picture to your message. It will appear in the default news image area on the home page.</p>
            </div>
            <div class="col-md-7">
                <h2> News</h2>
                <form>
                    <input type="hidden" iname="actionType" value="1">
                    <input type="hidden" name="userId" value="<?php echo Session::get('userid') ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" id="titel" placeholder="Titel">
                    </div>
                    <div class="form-group">
                        <label for="upload">Upload lead image</label>
                        <input type="file" class="form-control-file" id="upload">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="text" rows="15" placeholder="Message"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Post News</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'content/footer.cont.php'; ?>
