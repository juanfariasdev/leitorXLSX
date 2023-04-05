<?php
require (__DIR__ . '../XLSXReader.php');

// entire workbook
$xlsx = new XLSXReader('archive.xlsx');
$sheetNames = $xlsx->getSheetNames();



// loop through worksheets
foreach ($sheetNames as $sheetName) {
    $sheet = $xlsx->getSheet($sheetName);
    // worksheet header
    echo('<h3>' . htmlentities($sheetName) . '</h3><table>' . PHP_EOL);
    $xlsx_data = $sheet->getData();
    array_shift($xlsx_data);
    $header_row_xlsx = array_shift($xlsx_data);
    

    // header row
    echo('<tr>' . PHP_EOL);
    echo("\t<th>row</th>" . PHP_EOL);
    for ($i = 0; $i < count($header_row_xlsx); $i++) {
        $xlsx_field_name = '' . $header_row_xlsx[$i];
        echo("\t<th>" . htmlentities("$xlsx_field_name") . '</th>' . PHP_EOL);
    }
    echo('</tr>' . PHP_EOL);

    // loop through data rows
    $row_number = 1;
    foreach ($xlsx_data as $row_xlsx) {
        // data row
        echo('<tr>' . PHP_EOL);
        
        if(!empty($row_xlsx[0])){   
        echo("\t<td>" . htmlentities("$row_number") . '</td>' . PHP_EOL);
        
        for ($i = 0; $i < count($row_xlsx); $i++) {
            $xlsx_field_name = '' . ($i < count($header_row_xlsx) ? $header_row_xlsx[$i] : '');
            if ("$xlsx_field_name" === "DoB") {

                // date value
                $xlsx_field_value = DateTimeImmutable::
                        createFromFormat('U', XLSXReader::toUnixTimeStamp($row_xlsx[$i]))
                        ->format('Y-m-d');
            } else {

                // non-date value
                $xlsx_field_value = $row_xlsx[$i];

            }
            echo("\t<td>" . htmlentities("$xlsx_field_value") . '</td>' . PHP_EOL);
        }
    }
        echo('</tr>' . PHP_EOL);

        $row_number++;
    }
    echo("</table><!-- end of $sheetName -->" . PHP_EOL);
}