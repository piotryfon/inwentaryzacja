<?PHP
	function addProtocolToDatabase($protocol_path, $id_pracownika_post, $login, $tmp_file_path)
	{	
		$date = date("Y.m.d"); 
		$godzina = date("H.i.s");
			
		$protocol_name = $login . ' ' . $date . ' ' . $godzina  . '.pdf';
		
		$directory_name = 'protokoly' . '/' . $login;
		
		$sciazka_do_pliku = 'protokoly' . '/' . $login . '/' . $protocol_name;
		
		if( is_dir($directory_name) === false )
		{
			mkdir($directory_name);
			copy($tmp_file_path, $sciazka_do_pliku);
		} 
		else	
		{
			copy($tmp_file_path, $sciazka_do_pliku);		
		}
			try 
			{			
				require_once "database.php";
				
				$userQuery = $db->prepare("INSERT INTO protocol_transmission (protocol_name, protocol_path , protocol_date, protocol_time, id_pracownika) VALUES(:protocol_name, :protocol_path , :protocol_date, :protocol_time, :id_pracownika)");
				$userQuery ->bindParam(':protocol_name', $protocol_name);
				$userQuery ->bindParam(':protocol_path', $directory_name);
				$userQuery ->bindParam(':protocol_date', $date);
				$userQuery ->bindParam(':protocol_time', $godzina);
				$userQuery ->bindParam(':id_pracownika', $id_pracownika_post);
						
				if ($userQuery->execute() === FALSE) 
				{
					echo 'Nie można było dodać protokołu do bazy';
				} 
				else 
				{
					echo 'Protokół został doadny do bazy';
				}
			}
			catch (Exception $e) 
			{
				echo "Nie można dodać pliku do bazy.<br>".$e->getMessage();
			}		
	}

?>