<?php
$con = mysqli_connect("localhost", "root", "", "electricity_water");

if (isset($_GET['user_id']) && isset($_GET['month'])) {

    // Cast user_id to an integer to ensure it has a valid numeric value
    $user_id = (int)$_GET['user_id'];
    $month = $_GET['month'];
    
    // Wrap `month` in backticks to avoid conflicts with reserved words
    $query = "SELECT filename, image, filetype, size FROM image_upload WHERE user_id = $user_id AND `month` = '$month'";
    
    $result = mysqli_query($con, $query) or die('Error, query failed: ' . mysqli_error($con));

    list($name, $content, $type, $size) = mysqli_fetch_array($result);
    header("Content-Disposition: attachment; filename=$name");
    header("Content-length: $size");
    header("Content-type: $type");
    echo $content;

    exit;
}
?>
