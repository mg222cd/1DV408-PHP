<h1>Projekt i kursen 1DV408 - Webbutveckling med PHP</h1>

<h2>Beskrivning</h2>
<p>dinspring.se är en träningsdagbok för distanssporter (som löpning, cykel, simning, skidor, vandring) där
man loggar sina träningspass för att hålla ordning på distanser, tider och snittider.</p>

<h2>Användning av applikationen</h2>
<p>Applikationen finns på här <a href="http://dinspring.se" target="_blank">http://dinspring.se</a></p>
<p>Testa gärna genom att registrera egen användare och träningspass, för färdig användare med testdata, logga in med användarnamn:marikegrinde@hotmail.com lösenord:123456</p>

<h2>Installationsanvisningar</h2>
<p>1. I filen /Projektet/Kod/Model/DatabaseConnection.php - ändra databasinställningarna till aktuella för webbhotellet:</p>
<p>protected $dbUsername = 'skriv ditt användarnamn här';</p>
<p>protected $dbPassword = 'skriv ditt lösenord här';</p>
<p>byt även ut dbname=login på raden nedan mot namnet på din databas, tex dbname=minDatabas
protected $dbConnstring = 'mysql:host=mysql01.citynetwork.se;dbname=login;charset=utf8';</p>
<p>2. Lägg till databasen genom att logga in på din egen databas och importera däri databasen med SQL,
  beskrivning ges i dokumentet: /Dokumentation/InstalleraDatabas.odt</p>
<p>3. I rooten på ditt webhotell, lägg in all kod som finns i mappen /Projektet/Kod</p>

<h2>Klassdiagram</h2>
<p>Finns under /Projektet/Dokumentation/klassdiagram.png</p>
<img src="https://github.com/mg222cd/1DV408-PHP/blob/master/Projektet/Dokumentation/klassdiagram.png" />

<h2>Användarvänlighet och tillgänglighet</h2>
<p>Jag har lagt stor fokus på att underlätta för användaren så mycket som möjligt, genom att vara konsekvent i fråga om felmeddelanden (de visas alltid på samma ställen och i röd färg för fel och grön färg för rätt) och information i text vad användaren förväntas göra. I formuläret där användaren lägger till och ändrar träningspass används input-typer på fälten för att hjälpa anvnändaren att ange korrekt format på datum och tid.</p>

<p>Gällande tillgänglighet följer applikationen W3Cs krav på tillgänglighet och har responsiv design så att applikationen fungerar på alla skärmtyper.</p>

<h2>Säkerhet</h2>
<p>Då input-typerna är endast ett stöd för användaren och inget som garanterar att säkra uppgifter skickas in i databas, därför valideras varje fält som om det vore ett vanligt textfält. Om ett datum i framtiden anges är det dagens datum som skickas in i databasen. Utan input-typerna finns små brister i att t.ex ej existerande datum (ex 2014-02-31) kan anges och även saknas validering för att minuter och sekunder ska vara mindre än 59. Detta är jag medveten om. </p>
<p>Gällande inloggning och registrering har jag lagt mycket tid för en säkrad inloggning så att sådan ej kan ske med manipulerad session eller manipulerad cookie.</p>

<h2>Vidareutveckling</h2>
<p>Funktioner att bygga vidare på är utökad statistik (t.ex att man ska kunna se total tränad tid och distans för detta år / denna månad /denna vecka, och även sortera detta på olika träningstyper. Jag vill även lägga till så att användaren själv kan administrera sina användaruppgifter när denne är inloggad.</p>
