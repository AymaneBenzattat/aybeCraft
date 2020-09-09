<?php
        if (SETUP && Database::connect()) {
            ?>
    <h4 align="center" style="color: green;"><i class="fas fa-database"></i> Connected</h4>
    <?php
        }elseif (SETUP && !Database::connect()) {
            ?>
    <h4 align="center" style="color: red;"><i class="fas fa-database"></i> Disonnected</h4>
    <?php
        }
    ?>