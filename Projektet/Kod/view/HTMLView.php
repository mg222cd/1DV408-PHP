<?php
namespace View;

class HTMLView{

    public function echoHTML($body){
      $time = $this->getDateAndTime();
      echo "<!DOCTYPE html>
              <html>
              <head>
                <title>DinSpring - träningsdagbok för distansträning</title>
                <meta charset = 'UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <link rel='stylesheet' type='text/css' href='./BasicStyles/Style.css'>
                <!-- Bootstrap -->
                <link href='./BasicStyles/Bootstrap/css/bootstrap.min.css' rel='stylesheet'>
              </head>
              <body>
              <div class='container'>
                <header>
                  <h1>DinSpring</h1>
                  <p class='tight'>statistik för distansträning<p>
                </header>
                <div id='content'>
                  $body
                </div>
                <footer>
                  <p class='tight'>Marike Grinde 2014</p>
                  <p class='tight'>1DV408 - Webbutveckling med PHP</p>
                  <p class='tight'>Linnéuniversitetet</p>
                </footer>
              </div>  
              </body>
              </html>";
    }

    private function getDateAndTime(){
      setlocale (LC_ALL, "sv_SE");
      $date = date('d F');
      $year = date('Y');
      $day = ucfirst(strftime("%A"));
      $time = date('H:i:s');
      return utf8_encode($day) . ', den ' . $date . ' år ' . $year . '. Klockan är [' . $time . ']';
    }
}