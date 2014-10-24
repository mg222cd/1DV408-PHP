<h1>Projekt i kursen 1DV408 - Webbutveckling med PHP</h1>

<h2>Beskrivning</h2>
dinspring.se är en träningsdagbok för distanssporter (som löpning, cykel, simning, skidor, vandring) där
man loggar sina träningspass för att hålla ordning på distanser, tider och snittider.

<h2>Installationsanvisningar</h2>
<p>1. I filen /Kod/Model/DatabaseConnection.php - ändra databasinställningarna till aktuella för webbhoteller:</p>
<p>protected $dbUsername = 'skriv ditt användarnamn här';</p>
<p>protected $dbPassword = 'skriv ditt lösenord här';</p>
<p>byt även ut dbname=login på raden nedan mot namnet på din databas, tex dbname=minDatabas
protected $dbConnstring = 'mysql:host=mysql01.citynetwork.se;dbname=login;charset=utf8';</p>
<p>2. Lägg till databasen genom att logga in på din egen databas och importera däri databasen med SQL,
  beskrivning ges i dokumentet: /Dokumentation/InstalleraDatabas.odt</p>
<p>3. I rooten på ditt webhotell, lägg in all kod som finns i mappen /Kod</p>

<h2>klassdiagram</h2>
<p>Finns under /Dokumentation/klassdiagram.png</p>
<img src="https://github.com/mg222cd/1DV408-PHP/blob/master/Projektet/Dokumentation/klassdiagram.png" />


