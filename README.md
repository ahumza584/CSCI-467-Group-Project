Program: Quote tracker.

Installation:
  To install, duplicate the sendall.sh.template file (without the .template extension), filling in the variables so that the system can copy the files into the remote location;
    IDENT_FILE    -> An ssh identity file for logging into the remote server
    REMOTE_BASE   -> The base directory in the remote server to install the package to
    REMOTE_USER   -> The username to log into the server
    REMOTE_DOMAIN -> The address of the server

  You will also need to make an effective copy of the dblogin.php.template file (without the .template extension).
  You will need to set the variables within as follows:
    $uname => The username for logging into the database
    $pass =>  The password for logging into the database
    $dbname =>  The name of the database.


  Login details for the external legacy database are already filled in.

  Usage:
    Login from the login.php page. You will be redirected to the quote viewing area, and if you have administrative Privilege you will also see the associate editing page.

    Clicking on the edit button for a page will take you to the quote details dialog. If IGNORE_OWNERSHIP (constant in dbfunctions.php) is disabled, then the page will disable the input fields if you do not own the quote.

    Accessing this page without specifying a quote will allow you to create a new quote.
