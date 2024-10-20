<?php
session_start(); 
session_destroy(); 

header("Location: ../LogIn/LogIn.html");
exit();
?>
