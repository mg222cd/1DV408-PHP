<?php

class HTMLView{

    public function echoHTML($body){
        date_default_timezone_set("Europe/Stockholm");
        setlocale(LC_ALL, "sv_SE");
        $weekday = strftime("%A");
        utf8_encode($weekday);
        $time = $weekday . strftime(", den %d %B år %Y. Klockan är [%X]");
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
}