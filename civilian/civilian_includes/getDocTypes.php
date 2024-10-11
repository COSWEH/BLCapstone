<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../document.c.php');
    exit;
}

$brgyDoc = $_SESSION['user_brgy'];

$sql = "SELECT `docType` FROM `tbl_typedoc` WHERE `brgydoc` = '$brgyDoc'";
$result = mysqli_query($con, $sql);

if (!$result) {
    // Handle SQL error
    echo '<option value="" disabled>Error fetching documents</option>';
    exit;
}

if (mysqli_num_rows($result) > 0) {
    $options = '<option value="" disabled selected>Select Document</option>';

    while ($row = mysqli_fetch_assoc($result)) {
        $docType = htmlspecialchars($row['docType'], ENT_QUOTES, 'UTF-8');
        $docTypeWithoutBrgy = preg_replace('/\s*\(.*?\)\s*/', '', $docType); // Remove (user_brgy) part

        $options .= '<option value="' . $docType . '">' . $docTypeWithoutBrgy . '</option>';
    }
} else {
    $options = '<option value="" disabled>No Document found</option>';
}

echo $options;
