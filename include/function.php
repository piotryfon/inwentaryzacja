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
					echo'<br><div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Nie można dodać protokołu do bazy</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
				} 
				else 
				{
					echo'<br><div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Protokół został doadny do bazy</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
				}
			}
			catch (Exception $e) 
			{
				echo'<br><div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Nie można dodać protokołu do bazy</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
				echo "Nie można dodać pliku do bazy.<br>".$e->getMessage();
			}		
	}

?>