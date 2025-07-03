<?php

session_start();

require_once "../DAL/export_importData_dal.php";

$handler = new exportData_DAL();

// Handle export (via GET link)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $handler->exportData();
    exit(); // Important to stop execution after download
}

// Handle import (via POST form)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import']) && isset($_FILES['csv_file'])) {
    $handler->importCSV($_FILES['csv_file']['tmp_name']);
}
