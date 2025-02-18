<?php
$connection = mysqli_connect("localhost", "root", "", "sks");

// Usuwanie użytkownika
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $del_sql = "DELETE FROM `zawodnicy` WHERE `id` = $delete_id";
    mysqli_query($connection, $del_sql);
    
    // Przekierowanie po usunięciu
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Dodawanie nowego użytkownika
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['id'])) {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $klasa = $_POST['klasa'];
    $rok = $_POST['rok'];
    $wzrost = $_POST['wzrost'];

    // Sprawdzenie, czy taki użytkownik już istnieje
    $check_sql = "SELECT * FROM `zawodnicy` WHERE `imie` = '$imie' AND `nazwisko` = '$nazwisko' AND `klasa` = '$klasa' AND `rokurodzenia` = '$rok' AND `wzrost` = '$wzrost'";
    $check_query = mysqli_query($connection, $check_sql);

    if (mysqli_num_rows($check_query) == 0) {
        // Dodanie nowego użytkownika
        $sql = "INSERT INTO `zawodnicy`(`imie`, `nazwisko`, `klasa`, `rokurodzenia`, `wzrost`) VALUES ('$imie','$nazwisko','$klasa','$rok','$wzrost')";
        mysqli_query($connection, $sql);
    }
}

// Sprawdzanie, czy formularz został wysłany w celu edycji
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $klasa = $_POST['klasa'];
    $rok = $_POST['rok'];
    $wzrost = $_POST['wzrost'];

    // Aktualizacja danych w bazie
    $update_sql = "UPDATE `zawodnicy` SET 
                   `imie` = IF('$imie' != '', '$imie', `imie`),
                   `nazwisko` = IF('$nazwisko' != '', '$nazwisko', `nazwisko`),
                   `klasa` = IF('$klasa' != '', '$klasa', `klasa`),
                   `rokurodzenia` = IF('$rok' != '', '$rok', `rokurodzenia`),
                   `wzrost` = IF('$wzrost' != '', '$wzrost', `wzrost`)
                   WHERE `id` = $id";
    mysqli_query($connection, $update_sql);

    // Przekierowanie po zapisaniu zmian
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color:rgb(244, 244, 244);
        }
        h1, h3 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="text"] {
            padding: 8px;
            margin: 8px 0;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
        .action-buttons {
            display: inline-block;
        }
        .action-buttons a {
            padding: 8px 16px;
            margin: 5px;
            text-decoration: none;
            background-color: #ff6347;
            color: white;
            border-radius: 4px;
        }
        .action-buttons a:hover {
            background-color: #ff4c35;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
		#edytuj{
			background-color: rgba(50, 112, 206, 0.93);
		}
    </style>
</head>
<body>

<p><a href="index.php">Wróć do indeksu</a></p>

<h1>Łączenie PHP do SQL przy pomocy mysqli</h1>
<a href="https://www.w3schools.com/php/php_mysql_connect.asp">dokumentacja w3schools</a>
<p>Dokumentacja funkcji z biblioteki mysqli, która jest dołączona do kadego egzaminu INF.03</p>
<img width="500px" src="mysqli.png" alt="mysqli">

<h3>Dopisz zawodnika</h3>
<div class="form-container">
    <form action="insertsks_del.php" method="post">
        <label for="imie">Imię:</label><br>
        <input type="text" name="imie" id="imie"><br>
        
        <label for="nazwisko">Nazwisko:</label><br>
        <input type="text" name="nazwisko" id="nazwisko"><br>
        
        <label for="klasa">Klasa:</label><br>
        <input type="text" name="klasa" id="klasa"><br>
        
        <label for="rok">Rok urodzenia:</label><br>
        <input type="text" name="rok" id="rok"><br>
        
        <label for="wzrost">Wzrost:</label><br>
        <input type="text" name="wzrost" id="wzrost"><br>
        
        <input type="submit" value="Zapisz">
    </form>
</div>

<h3>Aktualnie zapisani zawodnicy</h3>

<?php
// Wyświetlanie zawodników
$sql2 = "SELECT * FROM `zawodnicy`";
$query2 = mysqli_query($connection, $sql2);
if (mysqli_num_rows($query2) > 0) {
    echo "<table>";
    echo "<tr><th>Imię</th><th>Nazwisko</th><th>Klasa</th><th>Rok Urodzenia</th><th>Wzrost</th><th>Funkcje</th></tr>";
    while ($row = mysqli_fetch_row($query2)) {
        echo "<tr>
                <td>$row[1]</td>
                <td>$row[2]</td>
                <td>$row[3]</td>
                <td>$row[4]</td>
                <td>$row[5] cm</td>
                <td class='action-buttons'>
                    <a href='?delete_id=$row[0]'>Usuń</a>
                    <a id='edytuj' href='#' onclick='openEditPopup($row[0], \"$row[1]\", \"$row[2]\", \"$row[3]\", \"$row[4]\", \"$row[5]\")'>Edytuj</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Brak zapisanych zawodników.</p>";
}
?>

<!-- Pop-up do edycji użytkownika -->
<div id="editPopup" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid #ccc;">
    <h3>Edytuj zawodnika</h3>
    <form id="editForm" method="POST">
        <label for="editImie">Imię:</label><br>
        <input type="text" name="imie" id="editImie"><br>
        
        <label for="editNazwisko">Nazwisko:</label><br>
        <input type="text" name="nazwisko" id="editNazwisko"><br>
        
        <label for="editKlasa">Klasa:</label><br>
        <input type="text" name="klasa" id="editKlasa"><br>
        
        <label for="editRok">Rok urodzenia:</label><br>
        <input type="text" name="rok" id="editRok"><br>
        
        <label for="editWzrost">Wzrost:</label><br>
        <input type="text" name="wzrost" id="editWzrost"><br>
        
        <input type="hidden" name="id" id="editId">
        <input type="submit" value="Zapisz">
        <button type="button" onclick="closeEditPopup()">Anuluj</button>
    </form>
</div>

</body>
<?php
mysqli_close($connection);
?>

<script>
function openEditPopup(id, imie, nazwisko, klasa, rok, wzrost) {
    document.getElementById('editImie').value = imie;
    document.getElementById('editNazwisko').value = nazwisko;
    document.getElementById('editKlasa').value = klasa;
    document.getElementById('editRok').value = rok;
    document.getElementById('editWzrost').value = wzrost;
    document.getElementById('editId').value = id;
    document.getElementById('editPopup').style.display = 'block';
}

function closeEditPopup() {
    document.getElementById('editPopup').style.display = 'none';
}
</script>

</html>
