<?php
	$connection = mysqli_connect("localhost", "root","","sks");
?>
<html>
<head>
</head>
<body>

<p><a href="index.php">Wróć do indeksu</a></p>

<h1>Łączenie PHP do SQL przy pomocy mysqli strukturalnie (Sposób polecany na egzaminie)</h1>

<a href="https://www.w3schools.com/php/php_mysql_connect.asp">dokumentacja w3schools</a>
<p>Dokumentacja funkcji z biblioteki mysqli, która jest dołączona do kadego egzaminu INF.03</p>
 <img width="500px" src="mysqli.png"></img>

<form action="insertsks_del.php" method="post" >

<h3>Dopisz zawodnika</h3>
    Imię: <input type="text" name="imie" id="imie"><br>
	Nazwisko: <input type="text" name="nazwisko" id="nazwisko"><br>
	Klasa: <input type="text" name="klasa" id="klasa"><br>
    <input type="submit" value="zapisz" >
</form>


<?php
/*obsługa bazy przy pomocy zapytań strukturalnych, 
dokumentacje do tego sposobu znajdziecie w dokumentacji 
do egzaminu - na końcu, np: https://arkusze.pl/zawodowy/inf03-2022-styczen-egzamin-zawodowy-praktyczny.pdf , 

ale też znajduje się na w3schools

INSERT https://www.w3schools.com/php/php_mysql_insert.asp
DELETE: https://www.w3schools.com/php/php_mysql_delete.asp
SELECT https://www.w3schools.com/php/php_mysql_select.asp

*/ 


$sql = "INSERT INTO `zawodnicy`(`imie`, `nazwisko`, `klasa`) VALUES ('jamal','kneegrow','4ta')";
$query = mysqli_query($connection, $sql);

// usuwanie zawodnika

// edytowanie zawodnika - na 6

?>

<h3>Aktualnie zapisani zawodnicy</h3>
<ol>
<?php
	//wypisanie aktualnie zapisanych użytkowników z opcją edytowania
?>
</ol>


</body>
</html>