<?php
namespace View;

class HTMLView{

    public function echoHTML($body){
      $time = $this->getDateAndTime();
      echo "<!DOCTYPE html>
              <html>
              <head>
                <title>Login</title>
                <meta charset = 'UTF-8'>
                <link rel='stylesheet' type='text/css' href='./BasicStyles/Style.css'>
              </head>
              <body>
                <header>
                  <h1>DinSpring</h1>
                  <p>statistik för distansträning<p>
                </header>
                <div id='content'>
                  $body
                </div>
                <footer>
                  <hr>
                  <p>Marike Grinde 2014</p>
                </footer>
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