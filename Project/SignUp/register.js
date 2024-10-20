function check() {
    var input = document.getElementById('confirmpassword');

    if (input.value != document.getElementById('password').value) {
        input.setCustomValidity('Password Must be Matching.');
    } 
    else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
    }
}

/*
function showHint(str) {
    if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("txtHint").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
    }
  }
*/

/*
function showHint(str) {
    //If there is no character written in the field when the keyboard key is realeased
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
            return;
    } else {  //If there is at least 1 character in the field when the keyboard key is realeased 
        //Create the AJAX request: an object of XMLHttpRequest() 
        var xmlhttp = new AjaxFunction();
        //var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            //if (this.readyState == 4 && this.status == 200) {
            //status of a request: 0=Uninitialized, 1=Loading, 2=Loaded, 3=Interactive, or 4=Completed
            if (this.readyState == 4){
                //HTTP status code returned by the server. 200 means call succeeded.
                if (this.status == 200){
                    //Data returned by the server in text format.
                    if (this.responseText != null){
                        //Remove the comma and create an array with the occurences received from the server  
                        responseArray=this.responseText.split(",");
                        var str='';
                        //store option in variables 
                        for (var i=0; i<responseArray.length; i++){
                            str += '<option value="'+responseArray[i]+'"/>'; 
                        }
                        var theDatalist=document.getElementById("existingNames");
                        theDatalist.innerHTML=str; 
                    }
                    else 
                        alert("Communication error: No data received")
                }
                else
                    alert("Communication error: " + this.statusText)
            }
        };
        //1-HTTP method (GET or POST) 2-Target URL 3-Request handled asynchronously (true or false)
        xmlhttp.open("GET", "get_regions.php?rqst=" + str, true);
        //Send data to the target server
        xmlhttp.send();
    }
}

function AjaxFunction()  //Class to create compatible Ajax Request with the most popular browsers 
{
    var ajaxRequest;

    try // Non Internet Explorer Browser? like Safari, Chrome, Opera
    {   // Successful request
        ajaxRequest = new XMLHttpRequest()
    }
    catch(e) //Failed request
    {
        try // Internet Explorer 6+?
        {   // Successful request
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP")
        }
        catch(e) //Failed request
        {
            try // Internet Explorer 5?
            {   // Successful request
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP")
            }
                catch(e) // There is no asynchronous support
            { 
                alert("Your browser broke!");
                ajaxRequest = false
            }
        }
    }
    return request
}
*/
