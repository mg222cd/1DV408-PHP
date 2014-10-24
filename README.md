Projekt i kursen 1DV408 - Webbutveckling med PHP

Beskrivning:
dinspring.se är en träningsdagbok för distanssporter (som löpning, cykel, simning, skidor, vandring) där
man loggar sina träningspass för att hålla ordning på distanser, tider och snittider.

Installationsanvisningar:
1. I filen /Kod/Model/DatabaseConnection.php - ändra databasinställningarna till aktuella för webbhoteller:
  rad 10. protected $dbUsername = 'skriv ditt användarnamn här'; 
  rad 11. protected $dbPassword = 'skriv ditt lösenord här';
  byt även ut dbname=login på raden nedan mot namnet på din databas, tex dbname=minDatabas
  rad 12. protected $dbConnstring = 'mysql:host=mysql01.citynetwork.se;dbname=login;charset=utf8';
2. Lägg till databasen genom att logga in på din egen databas och importera däri databasen med SQL,
  beskrivning ges i dokumentet: /Dokumentation/InstalleraDatabas.odt
3. I rooten på ditt webhotell, lägg in all kod som finns i mappen /Kod


