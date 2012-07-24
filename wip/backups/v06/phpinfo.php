<?php

$dbhandle = sqlite_open('db/test.db', 0666, $error);

$query = "SELECT Name, Sex FROM Friends";
 $result = sqlite_query($dbhandle, $query);
 
sqlite_close($dbhandle);
?>