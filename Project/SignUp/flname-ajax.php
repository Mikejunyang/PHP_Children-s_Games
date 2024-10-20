<?php
if(isset($_POST['firstname'])){
    $firstname= $_POST['firstname'];
    //$firstname = "abcd";
    // Perform validation (e.g., check if username already exists in the database)
    // For demonstration purposes, let's assume a simple validation
    if(!preg_match("/[a-zA-Z]/", $firstname)){
        echo "Must start with a letter a-z or A-Z";
    } else {
        // Username is valid
        echo ""; // Empty string means no error
    }
}


if(isset($_POST['lastname'])){
    $lastname= $_POST['lastname'];

    // Perform validation (e.g., check if username already exists in the database)
    // For demonstration purposes, let's assume a simple validation
    if(!preg_match("/[a-zA-Z]/", $lastname)){
        echo "Must start with a letter a-z or A-Z";
    } else {
        // Username is valid
        echo ""; // Empty string means no error
    }
}
?>