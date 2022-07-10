<?php
	session_start();
	
    //Jeżeli użytkownik zalogownay
    if (isset ($_SESSION['loged_user']))
    {
		$server_name = $_SESSION['servername'];
		$username = $_SESSION['username'];
		$password = $_SESSION['password'];
		$database_name = $_SESSION['database_name'];
		
		$current_table = $_SESSION['table'];

		$connection = new mysqli($server_name, $username, $password, $database_name);

		if(mysqli_connect_errno()!=0)
		{
			echo 'Blad polaczenia: ' . mysqli_connect_error();
			exit;
		}

		//Tworzenie pliku XML na podstawie danych
		function createXMLfile($dialogueTable, $columnsNames)
		{
			$fileName = 'dialogue.xml';
			$dom = new DOMDocument('1.0', 'utf-8'); 
			//Element główny
			$root = $dom->createElement('dialogues'); 

			for($i=0; $i<count($dialogueTable); $i++)
			{				
				$dialogue = $dom->createElement('dialogue');
				//columnsNames[0] = wartość ID
				$value = $dialogueTable[$i][$columnsNames[0]];
				//Ustawienie atrybutu dla kolumny[0] czyli ID
				$dialogue->setAttribute($columnsNames[0], $value);

				//Dla każdej kolejnej kolumny po kolumnie ID $j=1
				for($j=1; $j<count($columnsNames);$j++)
				{
					$value = $dialogueTable[$i][$columnsNames[$j]];	
					$columnName = $dom->createElement($columnsNames[$j], $value); 
					$dialogue->appendChild($columnName); 

					$root->appendChild($dialogue);
				}
			}
			$dom->appendChild($root); 

			//Pobranie pliku
			header('Content-type: text/xml');
			header('Content-Disposition: attachment; filename="' . $fileName . '"');
			
			echo $dom->saveXML();
			exit();
		}

		//Nazwy kolumn z bazy danych w tabeli ColumnsNames
		$columnsNames = array();
		
		$sql_querry = "SHOW COLUMNS FROM " . $current_table;
		$result = $connection -> query($sql_querry);
		while($columns = $result->fetch_object())
		{
			$columnsNames[] = $columns->Field;
		}

		//Resetowanie pointera
		mysqli_data_seek($result,0);

		$sql_query = "SELECT * FROM " . $current_table;

		$dialogueTable = array();

		if ($result = $connection->query($sql_query)) 
		{
			//Uzupełnienie tablicy danymi z tabeli
			while ($row = $result->fetch_assoc()) 
			{
				array_push($dialogueTable, $row);
			}

			//Jeżeli tablica dialogueTable nie jest pusta
			if(count($dialogueTable))
			{
				createXMLfile($dialogueTable, $columnsNames);
			}
			$result->free();
		}	
		$connection->close();
	}
	else
	{
		echo "Zaloguj się, aby uzyskać dostęp do zasobów.";
		echo"<form method='post' action='Login.php'>
			<input type='submit' value='Zaloguj się'>
		</form>";
	}
?>