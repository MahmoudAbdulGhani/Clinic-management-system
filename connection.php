<?php
$conn = mysqli_connect("localhost", "root", "", "medicare_hub");
if ($conn->error) {
    die("Error " . $conn->error);
}