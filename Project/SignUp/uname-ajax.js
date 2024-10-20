function validateUName(){
    var userNameInput = document.getElementById("username");
    var userName = userNameInput.value;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", "uname-ajax.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            // Update the error message span with the response
            document.getElementById("username-error").innerText = xmlhttp.responseText;
        }
    };

    // Send the AJAX request with the username data
    xmlhttp.send("username=" + userName);
}