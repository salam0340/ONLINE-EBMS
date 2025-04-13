<?php
$con = mysqli_connect("localhost", "root", "", "electricity_water");

if (isset($_GET['user_id']) && isset($_GET['month'])) {
    // Convert user_id to an integer to ensure it's valid
    $user_id = intval($_GET['user_id']);
    // Escape the month parameter
    $month = mysqli_real_escape_string($con, $_GET['month']);
    
    $query = "SELECT filename, image, filetype, size FROM image_upload WHERE user_id = $user_id AND `month` = '$month'";
    
    $result = mysqli_query($con, $query) or die('Error, query failed: ' . mysqli_error($con));
    
    // Check if any record is found
    if(mysqli_num_rows($result) > 0){
        list($name, $content, $type, $size) = mysqli_fetch_array($result);
        header("Content-Disposition: attachment; filename=$name");
        header("Content-length: $size");
        header("Content-type: $type");
        echo $content;
    } else {
        echo "No record found.";
    }
    
    exit;
} else {
    echo "Invalid parameters.";
}
?>
