<?php
session_start();

$con = mysqli_connect('localhost','root', '', 'blood clinic');
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (isset($_POST['id']) ) {
	$query = "SELECT * FROM donor WHERE ID='{$_POST['id']}'";
    $query_run = mysqli_query($con, $query);
    if(mysqli_num_rows($query_run) > 0) {
        $_SESSION['Donor-in'] = TRUE;
        $_SESSION['Donor-id'] = $_POST['id'];   

        $row = $query_run -> fetch_assoc();
        $_SESSION['Donor-first'] = $row['First_Name'];
        header('Location: Donor-home.php');        
    }
}
?>