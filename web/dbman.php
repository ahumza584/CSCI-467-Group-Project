<?php
include_once 'dbfunctions.php';
include_once 'miscfuncs.php';
print_html_header();
?>
<h1> Database debugger </h1>
<?php

if(array_key_exists("resetdb", $_POST)){
    DB_reset();
}

if(array_key_exists("loadsample", $_POST)){
    DB_load_sample_data();
}



?>

<form action="dbman.php" method="post">
<input type="checkbox" name="resetdb"    value="true" checked="true"><label>Reset database</label><br>
<input type="checkbox" name="loadsample" value="true" checked="true"><label>Load sample data</label><br>
<input type="submit">
</form>

<?php

display_associates();
display_quotes();




?>


<?php print_html_footer(); ?>
