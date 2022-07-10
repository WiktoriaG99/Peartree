<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_style.css">
    <title>Peartree</title>
</head>
<body>
<?php
//Jeżeli użytkownik zalogownay
if (isset($_SESSION['loged_user'])) 
{
	//Wylogowanie
	if (isset($_POST['logout'])) 
	{
		session_destroy();
		echo '<script type="text/javascript"> window.location="Login.php";</script>';

	}

	$server_name = $_SESSION['servername'];
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	$database_name = $_SESSION['database_name'];
	
	$current_table = $_SESSION['table'];


	if ($current_table == NULL) 
	{
		echo '<script type="text/javascript"> window.location="ChooseTable.php";</script>';

	}


	function showData($rows, $columnsNames, $connection, $current_table, $sql_querry) 
	{
		$sql_result = $connection->query($sql_querry);

		while (($row = $sql_result->fetch_assoc()) != null) 
		{
			$rows[] = $row;
		}

		echo "<tr>";

		for ($i = 0; $i < count($rows); $i++) 
		{
			echo "<tr>";

			//Pierwszy formularz zawiera wszystkie inputy,
			//które przesyłane przez POST, potrzebne są do zaktualizowana rekordu w bazie

			//Drugi formularz odpowiadający za usunięcie rekordu
			//przesyła za pomocą POST tylko ID rekordu

			echo "<form method='post'>";
			for ($j = 0; $j < count($columnsNames); $j++) 
			{
				//ID tylko wyświetlone
				//brak możliwości zmiany ID
				if ($j == 0) {
					if ($rows[$i][$columnsNames[$j]])
						echo "<td>" . $rows[$i][$columnsNames[$j]] . "</td>";
					else {
						echo "<td> </td>";
					}
				}
				//Wyświetlenie pozostałych danych z bazy w textboxach, umożliwiających zmianę treści
				else {
					//Nazwa inputu to nazwa kolumny + id
					echo "<td> <input type='text' name= '" . $columnsNames[$j] . $rows[$i][$columnsNames[0]] .  "' value='" . $rows[$i][$columnsNames[$j]] . "' /></td>";
				}
			}
			//Przycisk zapisania zedytowanego rekordu
			echo "<td>";
			echo "
					<input type='hidden' name='id_to_update' value='" . $rows[$i][$columnsNames[0]] . "'>
					<input type='submit' name='update_record' value='Zapisz'>
				</form>";
			echo "</td>";
			//Przycisk do usunięcia danego rekordu
			echo "<td>";
			echo "<form method='post'>
					<input type='hidden' name='id_to_delete' value='" . $rows[$i][$columnsNames[0]] . "'>
					<input type='submit' name='delete_record' value='Usuń'>
				</form>";
			echo "</td>";
			echo "</tr>";
		}
	}
	?>
	<div id='Top'>
		<div id='Logo'>
			<image src='LogoPeartree.png' width='200' heigth='200' alt='Logo Peartree'>
		</div>
		<div id='Top_Right'>	
			<div id='PeartreeName'>
				<p>Peartree</p>
			</div>
			<div id='Panel_user'>
					<ul class="navigation">
						<li class="navigation-item">
							<?php
							echo "<form method='post'>
								<input type='submit' name='logout' value='Wyloguj się'>
							</form>";
							?>
						</li>
						<li class="navigation-item">
							<?php
							echo "<form method='post' action='EditAccount.php'>
								<input type='submit' name='edit_account' value='Konto'>
							</form>";
							?>
						</li>
						<li class="navigation-item">
							<?php
							echo "<form method='post' action='DeleteTable.php'>
								<input type='submit' name='delete_table' value='Usuń tabelę'>
							</form>";
							?>
						</li>
						<li class="navigation-item">
							<?php
							echo "<form method='post' action='ChooseTable.php'>
								<input type='submit' name='change_table' value='Zmień tabelę'>
							</form>";
							?>
						</li>
						<li class="navigation-item">
							<?php
							echo "<form action='Download_XML.php'>
								<input type='submit' value='Pobierz całość jako .xml'>
							</form>";
							?>
						</li>
						<li class="navigation-item">
							<?php
							echo "<form method='post' action='AddColumn.php'>
								<input type='submit' name='add_column' value='Dodaj kolumnę'>
							</form>";
							?>
						</li>
						<li class="navigation-item">
							<?php
							echo "<form method='post'>
								<input type='submit' name='add_record' value='Dodaj wiersz'>
							</form>";
							?>
						</li>
					</ul>
			</div>
		</div>
	</div>
<?php
	echo "<div id='Panel_table_name' class='center'>";
		echo "<p>Nazwa aktualnie wybranej tabeli: </p>";
		echo "<form method='post'>
			<input type='text' name='new_table_name' value='" . $current_table . "'>
			<input type='submit' name='change_table_name' value='Zmień nazwę'>
		</form>";
	echo "</div>";
?>
<?php

	$connection = new mysqli($server_name, $username, $password, $database_name);

	if (mysqli_connect_errno() != 0) 
	{
		echo 'Blad polaczenia: ' . mysqli_connect_error();
		exit;
	}

	$sql_querry = "SELECT * FROM " . $current_table;

	$sql_result = $connection->query($sql_querry);

	if ($sql_result == false) 
	{
		echo 'bledne polecenie sql_querry : ' . $sql_querry;
		$connection->close();
		exit;
	}

	$rows = array();

	if (($row = $sql_result->fetch_assoc()) == null) 
	{
		echo "<div class='center'>
			<p>Tabela jest pusta. Dodaj pierwszy wiersz.</p>
		</div>";
		$sql_querry  = "SHOW COLUMNS FROM " . $current_table;
		$sql_result = $connection->query($sql_querry);
		while ($columns = $sql_result->fetch_object()) 
		{
			$columnsNames[] = $columns->Field;
		}
		mysqli_data_seek($sql_result, 0);
	} 
	else  
	{		
		//Nazwy kolumn z bazy danych w tabeli columnsNames
		$sql_querry  = "SHOW COLUMNS FROM " . $current_table;
		$sql_result = $connection->query($sql_querry);
		while ($columns = $sql_result->fetch_object())  
	 	{
			$columnsNames[] = $columns->Field;
		}

		//Resetowanie pointera
		mysqli_data_seek($sql_result, 0);

		echo "<div id='Search' class='center'>
			<form method='post'>
				<label>Wyszukaj z kolumny: </label>
				<select name='phrase_to_find_column'>";
				for($i=0; $i<count($columnsNames); $i++) 
				{
					echo"<option value='" . $columnsNames[$i] . "'>" . $columnsNames[$i] . "</option>";
				}
				echo"</select>
				<label>frazę zawierającą: </label>
				<input type='text' name='phrase_to_find' value='' placeholder='np. Gracz'>
				<input type='submit' name='phrase_to_find_submit' value='Wyszukaj'>
				<input type='submit' name='show_all_data' value='Wyświetl wszystko'>
			</form>
		</div>";

		
		echo "<div id = 'Dialogue_lines' class='center'>
			<h3>Tabela kwestii dialogowych: </h3>
		</div>";

		echo "<div class='center' id='dialogue_table'>";
			//Początek tabeli
			echo "<table border='1'>";

			//Wyświetlenie nazw kolumn
			foreach ($columnsNames as $columnName) 
			{
				//Przyciski edycji i sortowania danej kolumny
				//Brak edycji i usunięia kolumny id
				if ($columnName == "id") 
				{
					echo "<th>";
					echo $columnName;
					echo "
					<form method='post'>
					<input type='hidden' name='column_sort_name' value='" . $columnName . "'> 
					<input type='submit' name='column_sort_asc' value='Sortuj rosnąco'>
					</form>

					<form method='post'>
					<input type='hidden' name='column_sort_name' value='" . $columnName . "'> 
					<input type='submit' name='column_sort_desc' value='Sortuj malejąco'>
					</form>
					</td>";
				}
				else 
				{
					echo "<th>";
					echo "<form method='post'>
							<input type='text' name='new_column_name' value='" . $columnName . "'>
							<input type='hidden' name='old_column_name' value='" . $columnName . "'> 
							<input type='submit' name='edit_column' value='Zmień nazwę kolumny'>
						</form>
				
						<form method='post'>
						<input type='hidden' name='column_to_delete' value='" . $columnName . "'> 
						<input type='submit' name='delete_column' value='Usuń kolumnę'>
						</form>

						<form method='post'>
						<input type='hidden' name='column_sort_name' value='" . $columnName . "'> 
						<input type='submit' name='column_sort_asc' value='Sortuj rosnąco'>
						</form>

						<form method='post'>
						<input type='hidden' name='column_sort_name' value='" . $columnName . "'> 
						<input type='submit' name='column_sort_desc' value='Sortuj malejąco'>
						</form>
					</td>";
				}
			}
			echo "</tr>";
	
			if(isset($_POST['column_sort_asc']))
			{
				$_SESSION['query'] = "SELECT * FROM " . $current_table . " ORDER BY " . $_POST['column_sort_name'] . " ASC";
			}
			if(isset($_POST['column_sort_desc']))
			{
				$_SESSION['query'] = "SELECT * FROM " . $current_table . " ORDER BY " . $_POST['column_sort_name'] . " DESC";
			}
			if(isset($_POST['phrase_to_find_submit']))
			{
				$_SESSION['query'] = "SELECT * FROM " . $current_table . " WHERE " . $_POST['phrase_to_find_column'] . " LIKE '%" . $_POST['phrase_to_find'] . "%'";
			}
			if(isset($_POST['show_all_data']))
			{
				$_SESSION['query'] =  "SELECT * FROM " . $current_table;
			}
			showData($rows, $columnsNames, $connection, $current_table, $_SESSION['query']);

			//Koniec tabeli
			echo "</table>";
		echo "</div>";
	}
?>

<?php
	//Dodanie wiersza/rekordu
	if (isset($_POST['add_record'])) 
	{
		$sql_querry  =  "INSERT INTO " . $current_table . " (";

		//W przypadku gdy istnieje TYLKO kolumna id
		if (count($columnsNames) == 1) 
		{
			$sql_querry  = $sql_querry  . "id) VALUES (NULL)";
		} 
		else 
		{
			for ($i = 0; $i < count($columnsNames); $i++) 
			{
				//Ostatni bez przecinka
				if ($i == count($columnsNames) - 1) 
				{
					$sql_querry  = $sql_querry  . "$columnsNames[$i]";
				} else {
					$sql_querry  = $sql_querry  . "$columnsNames[$i], ";
				}
			}

			$sql_querry  = $sql_querry  . ") VALUES (";
			for ($i = 0; $i < count($columnsNames); $i++) 
			{
				//Ostatni bez przecinka i z zamknięciem nawiasu od VALUES
				if ($i == count($columnsNames) - 1) 
				{
					$sql_querry  = $sql_querry  . "NULL)";
				} else {
					$sql_querry  = $sql_querry  . "NULL, ";
				}
			}
		}
		
		$result_add_record = $connection->query($sql_querry);

		if ($result_add_record == false) 
		{
			echo 'bledne polecenie sql: ' . $sql_querry;
			$connection->close();
			exit;
		}

		unset($_POST['add_record']);

		echo "<script language='javascript'>";
		echo 'alert("Dodano wiersz");';
		echo 'window.location.replace("Peartree.php");';
		echo "</script>";
	}
	//Usunięcie rekordu
	if (isset($_POST['delete_record'])) 
	{
		$sql_querry  = "DELETE from " . $current_table . " WHERE id = " . $_POST['id_to_delete'];
		$result_delete_record = $connection->query($sql_querry);

		if ($result_delete_record == false) 
		{
			echo 'Błędne polecenie sql: ' . $sql_querry;
			$connection->close();
			exit;
		}

		echo "<script language='javascript'>";
		echo 'alert("Usunięto wiersz");';
		echo 'window.location.replace("Peartree.php");';
		echo "</script>";
	}
	//Aktualizacja rekordu
	if (isset($_POST['update_record'])) 
	{
		$sql_querry  =  "UPDATE " . $current_table . " SET ";
		for ($i = 1; $i < count($columnsNames); $i++) 
		{
			//Ostatni bez przecinka
			if ($i == count($columnsNames) - 1) 
			{
				$sql_querry  = $sql_querry  . $columnsNames[$i] . "='" . $_POST[$columnsNames[$i] . $_POST['id_to_update']] . "'";
			} 
			else 
			{
				$sql_querry  = $sql_querry  . $columnsNames[$i] . "='" . $_POST[$columnsNames[$i] . $_POST['id_to_update']] . "', ";
			}
		}

		$sql_querry  = $sql_querry  . " WHERE " . $columnsNames[0] . "=" .  $_POST['id_to_update'];

		$result_update_record = $connection->query($sql_querry);

		if ($result_update_record == false) 
		{
			echo 'Błędne polecenie sql: ' . $sql_querry;
			$connection->close();
			exit;
		}

		echo "<script language='javascript'>";
		echo 'alert("Zapisano zaktualizowany wiersz");';
		echo 'window.location.replace("Peartree.php");';
		echo "</script>";
	}

	//Edycja nazwy kolumny	
	if (isset($_POST['edit_column'])) 
	{
		//Zmienna do typu kolumny, potrzebnego do zapytania
		$column_type="";

		//Pobranie typu (Type) kolumny dla kolumny, gdzie Field to nazwa kolumny 
		$sql_querry = "SHOW COLUMNS FROM " . $current_table . " WHERE Field = '" . $_POST['old_column_name'] .  "'";
		$sql_result=$connection->query($sql_querry);
		while ($row = $sql_result->fetch_object()) 
		{
			$column_type = $row->Type;
		}

		$sql_querry = "ALTER TABLE " . $current_table . " CHANGE " . $_POST['old_column_name'] ." " . $_POST['new_column_name'] . " " . $column_type;
		$result_edit_column = $connection->query($sql_querry);
		if ($result_edit_column == false)
		{
			echo 'Błędne polecenie sql: ' . $sql_querry;
			$connection->close();
			exit;
		}

		echo "<script language='javascript'>";
		echo 'alert("Zmieniono nazwę kolumny");';
		echo 'window.location.replace("Peartree.php");';
		echo "</script>";
	}
	
	//Usunięcie kolumny
	if (isset($_POST['delete_column'])) 
	{
		$sql_querry  = "ALTER TABLE " . $current_table . " DROP COLUMN " . $_POST['column_to_delete'];

		$result_delete_column = $connection->query($sql_querry);

		if ($result_delete_column == false)
		{
			echo 'Błędne polecenie sql: ' . $sql_querry;
			$connection->close();
			exit;
		}

		echo "<script language='javascript'>";
		echo 'alert("Usunięto kolumnę");';
		echo 'window.location.replace("Peartree.php");';
		echo "</script>";
	}

	//Zmiana nazwy tabeli
	if (isset($_POST['change_table_name'])) 
	{
		$sql_querry  = "ALTER TABLE " . $current_table . " RENAME TO " . $_POST['new_table_name'];

		$result_change_table_name = $connection->query($sql_querry);

		if ($result_change_table_name == false)
		{
			echo 'Błędne polecenie sql: ' . $sql_querry;
			$connection->close();
			exit;
		}

		//Pobranie ID obecnie zalogowanego użytkownika
		$sql_querry = "SELECT id FROM users WHERE username = '" . $_SESSION['loged_user'] . "'";
		$result = $connection -> query($sql_querry);
		if($result==false)
		{
			echo 'bledne polecenie sql: ' . $sql_querry;
			$connection->close();
			exit;
		}
		//Przypisanie ID do zmiennej
		while ($row = mysqli_fetch_array($result)) 
		{
			$loged_user_id = $row[0];
		}

		$sql_querry = "UPDATE user_table_connection SET table_name = '" . $_POST['new_table_name'] . "' WHERE id_user = " . $loged_user_id . " AND table_name='" . $current_table . "'";
		$result = $connection -> query($sql_querry);
		if($result==false)
		{
			echo 'bledne polecenie sql: ' . $sql_querry;
			$connection->close();
			exit;
		}

		else
		{
			//Zaktualizowanie nazwy aktualnej tabeli w zmiennej SESSION
			$_SESSION['table'] = $_POST['new_table_name'];
			echo "<script language='javascript'>";
			echo 'alert("Zmieniono nazwę tabeli");';
			echo 'window.location.replace("Peartree.php");';
			echo "</script>";
		}
	}
} 
else 
{
	?>
	    <div id='Top'>
		<div id='Logo'>
			<image src='LogoPeartree.png' width='200' heigth='200' alt='Logo Peartree'>
		</div>
		<div id='Top_Right'>	
			<div id='PeartreeName'>
				<p>Peartree</p>
			</div>
			<div id='Panel_user'>
			</div>
		</div>
	</div>
	<div class='center'>
		<p>Zaloguj się, aby uzyskać dostęp do zasobów.</p>
		<form method='post' action='Login.php'>
			<input type='submit' value='Zaloguj się'>
		</form>
	</div>
<?php
}

?>
</body>
</html>