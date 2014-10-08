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
              </head>
              <body>
                $body
                <p>$time</p>
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