<?php
include('includes/conn.inc.php');

if (isset($_POST['btnForgotPassword']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    echo $_POST['fpEmail'];
}
