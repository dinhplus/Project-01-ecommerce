
<div class="popup">
    <h1 >Message:</h1>
    <hr>
    <div class="popup-message">
        <br>
        <?php
        if(isset($popupMessage)) {
            echo($popupMessage);
        }
        ?>

    </div>
    <form action="<?=$urlRedirect?>" method="GET">
        <input type="submit" name="" id="popup-submit-btn" value="OK!!! 👌🏿👌🏿👌🏿">
    </form>
    <?php if(isset($popupImage)){ ?>
        <img src="<?=$popupImage?>" alt="">
    <?php } ?>
</div>
