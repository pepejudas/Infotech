<?php

ini_set('display_errors', 1);

require_once 'Spreadsheet/Excel/Writer.php';

//Create a workbook
$workbook = new Spreadsheet_Excel_Writer(); //() must be empty or your downloaded file will be corrupt.
$workbook->setTempDir('tmp');

// Create a worksheet 
$worksheet = $workbook->addWorksheet('test');

// The actual data 
$worksheet->write(0, 0, 'Name'); 
$worksheet->write(0, 1, 'Age'); 
$worksheet->write(1, 0, 'John Smith'); 
$worksheet->write(1, 1, 30);
$worksheet->write(2, 0, 'Johann Schmidt');
$worksheet->write(2, 1, 31); $worksheet->write(3, 0, 'Juan Herrera');
$worksheet->write(3, 1, 32);

// send HTTP headers 
$workbook->send('prueba.xls');

// Let's send the file
$workbook->close();

?>
