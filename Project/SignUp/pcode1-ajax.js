function validatePass(){
    var passwordInput = document.getElementById("password");
    var password = passwordInput.value;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "pcode1-ajax.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            // Update the error message span with the response
            document.getElementById("password-error").innerText = xmlhttp.responseText;
        }
    };

    // Send the AJAX request with the username data
    xmlhttp.send("password=" + password);
}