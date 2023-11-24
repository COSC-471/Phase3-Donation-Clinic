<?php

// Connect to database
$con = mysqli_connect('localhost', 'root', '', 'blood clinic');

$query = "UPDATE DONOR SET ";

if (isset($_POST['fname']) && !empty($_POST['fname']))
    $query = $query . "First_Name='{$_POST['fname']}', ";

if (isset($_POST['lname']) && !empty($_POST['lname']))
    $query = $query . "Last_Name='{$_POST['lname']}', ";

if (isset($_POST['lname']) && !empty($_POST['blood']))
    $query = $query . "Blood_type='{$_POST['blood']}' ";

// We need to check if the donor with that id exists.
if (substr($query, -2)  == ", ") 
    $query = rtrim($query, ", ");

$query = $query . "WHERE ID='{$_POST['Donor_ID']}'";
$query_run = mysqli_query($con, $query);

header('Location: home.php');

$con->close();
?>