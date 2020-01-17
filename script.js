var db;

function indexedDBOk() 
{
	return "indexedDB" in window;
}

function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

document.addEventListener("DOMContentLoaded", function() 
{

	if(!indexedDBOk) return;

	var openRequest = indexedDB.open("idarticle_answer",1);

	openRequest.onupgradeneeded = function(e) 
	{
		var thisDB = e.target.result;

		if(!thisDB.objectStoreNames.contains("answer")) 
			thisDB.createObjectStore("answer", {autoIncrement:true});
	}

	openRequest.onsuccess = function(e) 
	{
		db = e.target.result;

		document.querySelector("#add").addEventListener("click", addanswer, false);
		document.querySelector("#getAll").addEventListener("click", getanswers, false);
		document.querySelector("#deleteAll").addEventListener("click", deleteAll, false);
		document.querySelector("#up").addEventListener("click", synchronize, false);

	}	

	openRequest.onerror = function(e) 
	{
		alert('Nieoczekiwany blad');
	}


},false);


function addanswer(e) 
{
	var name = document.querySelector("#imie").value;
	var wiek = document.querySelector("#wiek").value;
	if(wiek < 18)
	{
		alert("You are not old enough to vote");
		return false;
	}
	if(isEmpty(name))
	{
		alert("Name cannot be empty");
		return false;
	}
	if(document.getElementById('odpA').checked)
		var odp = document.querySelector("#odpA").value;
	else if(document.getElementById('odpB').checked)
		var odp = document.querySelector("#odpB").value;
	else if(document.getElementById('odpC').checked)
		var odp = document.querySelector("#odpC").value;
	else if(document.getElementById('odpD').checked)
		var odp = document.querySelector("#odpD").value;


	var transaction = db.transaction(["answer"],"readwrite");
	var store = transaction.objectStore("answer");

	var answer = 
	{
		name:name,
		wiek:wiek,
		odp:odp,
	}

	var request = store.add(answer);

	request.onerror = function(e) 
	{
		
		console.log("Error",e.target.error.name);
	}

	request.onsuccess = function(e) 
	{
		alert("Vote added");
		console.log("Vote added");
	}
}

function getanswers(e) 
{

	var s = "";

	db.transaction(["answer"], "readonly").objectStore("answer").openCursor().onsuccess = function(e) 
	{
		var cursor = e.target.result;
		if(cursor) 
		{
			s += "ID "+cursor.key+" ";
			for(var field in cursor.value) 
			{
				s+= field+"="+cursor.value[field]+" ";
			}
			s+="<br>";
			cursor.continue();
		}
		document.getElementById('wyniki').innerHTML = s;
	}
}

function deleteAll()
{
	var req = indexedDB.deleteDatabase("idarticle_answer");
	location.reload();
}

function synchronize(e)
{
	var s = "";
	var transaction = db.transaction(["answer"],"readwrite").objectStore("answer").openCursor().onsuccess = function(e)
	{

		var cursor = e.target.result;
		if(cursor) 
		{
			for(var field in cursor.value) 
			{
				s+= cursor.value[field]+":";
			}
			s+="#";
			cursor.continue();
		}
	var req = indexedDB.deleteDatabase("idarticle_answer");
	document.getElementById('hid').value = s;
	document.getElementById('akt').submit();
	}
}