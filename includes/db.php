<?php
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    include 'db_local.php';
} else {
    include 'db_live.php';
}
