<?php	
/*

	I am going to pull in a few different snippets of code from different files and comment. I would be happy to provide more. I do not know if this is too much or too little.

 */


	//This is from a controller. Pulling in class files I've writeten other than that PHPMailer -that's a library I found on GitHub, and it's awesome.
	require "../../classes/AppError.class.php";
	require "../../classes/LogoOrder.class.php";
	require "../../classes/WorkOrder.class.php";
	require "../../classes/PackingSlip.class.php";
	require "../../phpmailer/PHPMailerAutoload.php";

	//I typically do these things right off the bat.
	$appError = new AppError;
	//PHP defaults to New York and that annoys me lol. Now that I think about it,.. I wonder if that is a global setting in the php.ini file. hm... Will investigate.
	date_default_timezone_set('America/Chicago');

	//Nested variable santizer with regular expression that 1) converts the string to upper case, 2) truncates leading and trailing spaces, 3) replaces single and double quotes with nothing, 4) gets out special characters, 5) gets out HTML tags.
	$customerName = strToUpper(trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', '', urldecode(html_entity_decode(strip_tags($_POST['customerName'])))))));

	//I tend to do this when making dates because I store alot of datetime's to the database.
	$received = date_create()->format('Y-m-d H:i:s');
	//But then if I want to display it to a user, I make it pretty.
	$received = date('m/d/y h:i A', strtotime($record['received']));

	//Favorite form of the if statement because it fits on one line, ternary.
	$styleSKU = ($style == 'L') ? 'H' : 'V';

	//Creating a PDF for the customer's order. I wrote the class file for this.
	$pdfSalesOrder = new SalesOrder();
	//Got to pass in a couple of things.
    $pdfSalesOrder->CreatePDF($orderNumber,$designNumber);

    //Throwing an error.
	$error = [$userID,"i/put/my/link/here/","nameOfFile.php",4,"CSRs email for logo mat order #{$orderNumber}."];
    $appError->Email($error);

	//Get a user's role from WordPress.
	$user_info = get_userdata($userID);
	$role = implode(', ', $user_info->roles);

	//Simple switch statement, I've changed some file names.
	$i = 0;
	while ($i <= 7)
	{
		switch (strToUpper(${"file" . $i})) 
		{
		    case "AI": echo "<td><a href=\"http://link/here/?download_file={$fileID}P{$i}.${'file' . $i}\"><img src=\"http://link/here/aiIcon.jpg\" /></a></td>"; break;
		    //Removed the rest of the cases, you get the jest.
		  }
		$i++;
	}

	//Doing stuff based on status.
	if ($status == 'New' || $status == 'Revision' || $	status == "Redesign") 
	{ //Do stuff. 
	}

	//Freeing up memory.
	unset($record);
	$mysqli->close();

	//Some queries I've written. Database, table, and field names have been sanatized.
	$query = $mysqli->query("SELECT * FROM databaseName.tableName WHERE field = '{$fieldID}' ORDER BY fieldID DESC LIMIT 100;");
	//I cut out the 20 some odd fields for readibility.
	$queryInsert = $mysqli->query("INSERT INTO tableName (fieldID, field1, field2) VALUES (NULL, '{$field1}', '{$field2}')");
	//Simple update statement.
	$queryUpdate = $mysqli->query("UPDATE tableName SET status = 'E' WHERE fieldID = '{$fieldNumber}'");

	//Uploading some files. (This is wrapped in error handling!)
	if(move_uploaded_file($_FILES['matImage']['tmp_name'], $proofDir . $file1Name))
	{ //Do stuff.
	}

	//This uploads files, but checks their extentions first. If the extension is bad it throws a flag.
	$i = 1;
	$error = 0;
	while ($i <= 8)
	{
		$temp = explode(".",$_FILES["file{$i}"]["name"]);
		$fileName = $proofNumber . "P{$i}." .end($temp); 
		$file = strToLower(end($temp));

		if ($file != "")
		{
			if ($file == 'ai' || $file == 'psd' || $file == 'cdr' || $file == 'eps' || $file == 'pdf' || $file == 'jpg' || $file == 'jpeg' || $file == 'png' || $file == 'bmp' || $file == 'tif' || $file == 'tiff') 
			{
				if ($i == 8)
				{
					$fileName = $proofNumber . "PE." .end($temp); 
				}
				if(move_uploaded_file($_FILES['file'.$i]['tmp_name'], $proofSubmissions . $fileName)) 
				{
					$pathFile = $directory . $fileName;
					if (!file_exists($pathFile))
					{
						$error = 1;
					}
					else
					{
						//I'm slightly proud of this one because I need to dynamically create variables.
						${"file" . $i}  = $file;
					}
				}
				else
				{
					$error = 1;
				}
			}
			else
			{	
				$badFileExt = $file;
				$error = 1;
			}
		}
		else
		{
			${"file" . $i}  = NULL;
		}
		$i++;
	}

	//Little piece of creating an excel file.
	$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$objWriter->save(str_replace('productionReport.php', 'Production Report ' . $date . '.xlsx', 'D:\some\directory\\' . $filename));

?>