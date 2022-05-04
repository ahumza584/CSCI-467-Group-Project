<head>

</head>

<?php

/*
    Quote viewing and editing page
*/

session_start();

echo $_POST['TargetQuote'];

//Get quote that is being worked on in standard format
if (array_key_exists('WORKQUOTE', $_SESSION)) {
  $Quote = $_SESSION['WORKQUOTE'];
}
else if (array_key_exists('TargetQuote', $_POST)) {

}
else {
  echo "Invalid state.";
  exit();
}



?>
