<?php
function print_html_header($title = "Generic Page", $stylesheet = "back.css") {
 echo("<!DOCTYPE html>
        <html lang=\"en\">
        <head>
        <meta charset=\"utf-8\">");

     echo("<title>" . $title . "</title>");

     echo("<link rel=\"stylesheet\" href=\"". $stylesheet ."\">");

 echo("<body>");
}

function print_html_footer(){
  echo("</body></html>");
}
?>