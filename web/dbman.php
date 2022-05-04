<?php
include_once 'dbfunctions.php';
include_once 'formatters.php';
include_once 'miscfuncs.php';
print_html_header();
?>
<h1> System debugger </h1>
<?php

if(array_key_exists("resetdb", $_POST)){
    DB_reset();
}

if(array_key_exists("loadsample", $_POST)){
    DB_load_sample_data();
}

if(array_key_exists("USwap", $_POST)){
    $_SESSION['UID'] = $_POST['USwap'];
}


?>

<form action="dbman.php" method="post">
<input type="checkbox" name="resetdb"    value="true" checked="true"><label>Reset database</label><br>
<input type="checkbox" name="loadsample" value="true" checked="true"><label>Load sample data</label><br>
<input type="submit">
</form>

<a href="createQuote.php">Create quote dialog</a> <br>
<a href="viewQuotes.php">Quote viewing dialog</a> <br>
<a href="login.php">log out</a> <br>

<?php

function display_associates_with_id_buton($assocIds = null) {
    if (is_null($assocIds)){
        $assocIds = get_all_associate_ids();
    }
    echo("
    <h2> Associates </h2>
    <table>
        <tr>
        <th> ID </th>
        <th> Name </th>
        <th> Address </th>
        <th> commission </th>
        <th> Username </th>
        <th> Password </th>
        <th> Privelege Level </th>
        </tr>
    ");
    foreach($assocIds as $AssociateId) {
        $ainfo = GetAssocInfo($AssociateId);
        echo("<tr>");
            echo ("<td>" . $AssociateId        . "</td>");
            echo ("<td>" . $ainfo['Name']      . "</td>");
            echo ("<td>" . $ainfo['Address']   . "</td>");
            echo ("<td>" . $ainfo['Commision'] . "</td>");
            echo ("<td>" . $ainfo['Username']  . "</td>");
            echo ("<td>" . "WITHHELD"          . "</td>");
            echo ("<td>" . $ainfo['AuthLevel'] . "</td>");
            echo ("<td>");
            echo ("<form action =\"dbman.php\" method=\"post\">");
            echo ("<input type=\"submit\" name=\"USwap\" value=\"" . $AssociateId . "\" text=\"Edit\" method=\"post\">");
            echo ("</form>");
            echo ("</td>");
        echo("</tr>");
    }

    echo ("</table>");
}

display_associates_with_id_buton();
display_quotes();




?>


<?php print_html_footer(); ?>
