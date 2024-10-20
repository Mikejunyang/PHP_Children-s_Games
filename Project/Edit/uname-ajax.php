<?php
if(isset($_POST['username'])){
    $username= $_POST['username'];

    // Perform validation (e.g., check if username already exists in the database)
    // For demonstration purposes, let's assume a simple validation
    if(!preg_match("/[a-zA-Z]/", $username)){
        echo "Must start with a letter a-z or A-Z";
    } 
    elseif(!preg_match("/[a-zA-Z0-9]{8}/", $username)){
        echo "Must contain at least 8 characters";
    }
    else {
        // Username is valid
        echo ""; // Empty string means no error
    }
}
?>