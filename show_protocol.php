<?php

	if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['submit_id_protokolu']))
	{
			require_once __DIR__ ."/include/database.php";
			$id_protololu_post = $_GET["submit_id_protokolu"];
			$userQuery = $db->prepare('SELECT protocol_name, protocol_path FROM protocol_transmission WHERE id = :id');		
			$userQuery->bindValue(':id', $id_protololu_post, PDO::PARAM_STR);		
			$userQuery->bindColumn(1, $protocol_name, PDO::PARAM_STR);	
			$userQuery->bindColumn(2, $protocol_path, PDO::PARAM_STR);
			
			if ($userQuery->execute() === FALSE) 
			{
				echo 'Could not display pdf';
			}
			else 
			{
				$userQuery->fetch(PDO::FETCH_BOUND);		
				$filename = $protocol_path .'/'. $protocol_name ;	
				header("Content-type: application/pdf");
				header("Content-Length: " . filesize($filename));
				header('Content-Transfer-Encoding: binary');	
				header('Accept-Ranges: bytes');	
				// Send the file to the browser.
				readfile($filename);
			}
	}
	else
	{
		header('location: pracownicy_tabela.php');	
	}
			
?>
