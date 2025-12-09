<?php
/**
 * Database Connection File
 * Krusty Krab Contact Form System
 * 
 * This file establishes connection to the MySQL database
 * using XAMPP's default settings for localhost
 */

// Database configuration
$host = "localhost";        // Database host (localhost for XAMPP)
$username = "root";         // Default XAMPP MySQL username
$password = "";             // Default XAMPP MySQL password (empty)
$database = "krusty_krab_db"; // Database name

// Create connection using mysqli
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set character set to UTF-8 for proper encoding
mysqli_set_charset($conn, "utf8mb4");
?>
