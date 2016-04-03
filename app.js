/*

function getEmployee(str){
	
	if(str.length == 0){
		return;
	}
	else{
		var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("suggestion").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "getEmployee.php?q=" + str, true);
        xmlhttp.send();
	}
}*/

$(function() {
    $( "#employee" ).autocomplete({
        source: 'getEmployee.php'
    });
});