<?php

session_start();

require_once "../DAL/exportData_dal.php";


$exporter = new exportData_DAL();
$exporter->exportData();
