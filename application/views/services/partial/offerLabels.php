<?php
    foreach ($details as $detail) {
        echo "<span class='label radius warning' style='margin: 0 5px 5px 0;'>#".str_replace(' ', '', $detail['description']).'</span>&nbsp;';
    }
