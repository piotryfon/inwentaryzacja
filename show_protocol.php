<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_id_protokolu']))
{
	require_once __DIR__ ."/test/database.php";

	$id_protololu_post = $_POST["submit_id_protokolu"];

	//	$userQuery = $db->prepare('SELECT id, password FROM admins WHERE login = :login');
	    $userQuery = $db->prepare('SELECT pdf_doc FROM protocol_transmission WHERE id = :id');		
		$userQuery->bindValue(':id', $id_protololu_post, PDO::PARAM_STR);		
	//	$userQuery->bindColumn(1, $project_name);
		$userQuery->bindColumn(1, $pdf_doc, PDO::PARAM_LOB);	
		//Sprawdzić co robi 
		$project_name = "testNazwa";
		
		 if ($userQuery->execute() === FALSE) 
		 {
			echo 'Could not display pdf';
		 } else 
			{
				$userQuery->fetch(PDO::FETCH_BOUND);
				
				header("Content-type: application/pdf");  
				header('Content-disposition: inline; filename="'.$project_name.'.pdf"');
				header('Content-Transfer-Encoding: binary');
				header('Accept-Ranges: bytes');
				echo $pdf_doc;		
				
			}
} else	{
			header('location: pracownicy_tabela.php');
		}
      ?>
