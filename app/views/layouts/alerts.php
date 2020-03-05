<?php

if(null !== $successMessage)
{
    ?>
    <div class="alert alert-success" role="alert">
        <?=$successMessage?>
    </div>
    <?php
}

if(null !== $errorMessage)
{
    ?>
    <div class="alert alert-danger" role="alert">
        <?=$errorMessage?>
    </div>
    <?php
}
?>


