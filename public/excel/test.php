<?php
/**
 * XLS parsing uses php-excel-reader from http://code.google.com/p/php-excel-reader/
 */

use Ramsey\Uuid\Type\Integer;

	header('Content-Type: text/plain');

	if (isset($argv[1]))
	{
		$Filepath = $argv[1];
	}
	elseif (isset($_GET['File']))
	{
		$Filepath = $_GET['File'];
	}
	else
	{
		if (php_sapi_name() == 'cli')
		{
			echo 'Please specify filename as the first argument'.PHP_EOL;
		}
		else
		{
			echo 'Please specify filename as a HTTP GET parameter "File", e.g., "/test.php?File=test.xlsx"';
		}
		exit;
	}

	// Excel reader from http://code.google.com/p/php-excel-reader/
	require('php-excel-reader/excel_reader2.php');
	require('SpreadsheetReader.php');

	try
	{
		$Spreadsheet = new SpreadsheetReader($Filepath);

		$Sheets = $Spreadsheet -> Sheets();		

			foreach ($Spreadsheet as  $Row)
			{
				// echo $Key.': ';
				if ($Row)
				{  echo $Row[0];
					echo "[0]";
					echo $Row[1];
					echo "[1]";
					echo $Row[2];
					echo "[2]";
					echo $Row[3];
					echo "[3]";
					echo $Row[4];
					echo "[4]";
					echo $Row[5];
					echo "[5]";
					echo $Row[6];
					echo "[6]";
					echo $Row[7];
					echo "[7]";
					echo $Row[8];
					echo "[8]";
					echo $Row[9];
					echo "[9]";
				
					// foreach ($Row as $data) {
						
						
					// 	echo ($data);
					// 	echo("-");
					// }
					}
				else
				{
					echo "kosong";
				}
		
			}		
	}
	catch (Exception $E)
	{
		// echo $E -> getMessage();
	}
?>
