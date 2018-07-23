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
            <div class="col-5">
                <h2>Write some news</h2>
                <p>Let people know what is going on right now. Your Text will appear on the frontpage!</p>
                <p>You should avoid any coloring and sizing since it gets overwritten with the default style of the page.</p>
                <p>Feel free to add a picture to your message. It will appear in the default news image area on the home page.</p>
            </div>
            <div class="col-7">
                <h2> News</h2>
                <form style="max-width:100%">
                    <div style="width:100%; display:table; padding: 10px 3px;">
                        <label for="titel" style="display:table-cell;">Titel</label>
                        <input name="titel" id="titel" type="text" style="display:table-cell; width:100%">
                    </div>
                    <textarea id="text" name="message" rows="15" cols="100%"></textarea>
                    <hr>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'content/footer.cont.php'; ?>
