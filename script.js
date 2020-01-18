var db;

function indexedDBOk() {
    return "indexedDB" in window;
}

function isEmpty(obj) {
    for (var key in obj) {
        if (obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

document.addEventListener("DOMContentLoaded", function () {

    if (!indexedDBOk) return;

    var openRequest = indexedDB.open("idarticle_answer", 1);

    openRequest.onupgradeneeded = function (e) {
        var thisDB = e.target.result;

        if (!thisDB.objectStoreNames.contains("answer"))
            thisDB.createObjectStore("answer", {
                autoIncrement: true
            });
    }

    openRequest.onsuccess = function (e) {
        db = e.target.result;

        document.querySelector("#add").addEventListener("click", addanswer, false);
        document.querySelector("#getAll").addEventListener("click", getanswers, false);
        document.querySelector("#deleteAll").addEventListener("click", deleteAll, false);
        document.querySelector("#up").addEventListener("click", synchronize, false);

    }

    openRequest.onerror = function (e) {
        alert('ERROR');
    }


}, false);


function addanswer(e) {
    var name = document.querySelector("#imie").value;
    var wiek = document.querySelector("#wiek").value;
    if (wiek < 18) {
        alert("You are not old enough to vote");
        return false;
    }
    if (isEmpty(name)) {
        alert("Name cannot be empty");
        return false;
    }
    if (document.getElementById('odpA').checked)
        var odp = document.querySelector("#odpA").value;
    else if (document.getElementById('odpB').checked)
        var odp = document.querySelector("#odpB").value;
    else if (document.getElementById('odpC').checked)
        var odp = document.querySelector("#odpC").value;
    else if (document.getElementById('odpD').checked)
        var odp = document.querySelector("#odpD").value;


    var transaction = db.transaction(["answer"], "readwrite");
    var store = transaction.objectStore("answer");

    var answer = {
        name: name,
        wiek: wiek,
        odp: odp,
    }

    var request = store.add(answer);

    request.onerror = function (e) {

        console.log("Error", e.target.error.name);
    }

    request.onsuccess = function (e) {
        alert("Vote added");
        console.log("Vote added");
    }
}

function getanswers(e) {

    var s = "";
    var firstAnswer = 0;
    var secondAnswer = 0;
    var thirdAnswer = 0;
    var fourthAnswer = 0;
    var countAnswer = 0;
    db.transaction(["answer"], "readonly").objectStore("answer").openCursor().onsuccess = function (e) {
        var cursor = e.target.result;

        if (cursor) {
            s += "ID " + cursor.key + " ";
            for (var field in cursor.value) {
                s += field + "=" + cursor.value[field] + " ";
            }
            switch (cursor.value["odp"])
            {
                case 'A':
                    ++firstAnswer;
                    ++countAnswer;
                    break;
                case 'B':
                    ++secondAnswer;
                    ++countAnswer;
                    break;
                case 'C':
                    ++thirdAnswer;
                    ++countAnswer;
                    break;
                case 'D':
                    ++fourthAnswer;
                    ++countAnswer;
                    break;
            }
           
            s += cursor.value["odp"] + " " + secondAnswer;
            s += "<br>";
            cursor.continue();
        }
        var trumpVotes = Math.round((100 * firstAnswer)/ countAnswer);
        var warrenVotes = Math.round((100 * secondAnswer)/ countAnswer);
        var sandersVotes = Math.round((100 * thirdAnswer)/ countAnswer);
        var bidenVotes = Math.round((100 * fourthAnswer)/ countAnswer);
        if(countAnswer == 0)
        {
            trumpVotes = 0;
            warrenVotes = 0;
            sandersVotes = 0;
            bidenVotes = 0;
        }

        var graphTrump = "Trump "+trumpVotes + "%  <canvas id='myCanvas' width='"+(firstAnswer*100)+"' height='100' style='border:1px solid #c3c3c3; background-color: #3D9970;'></canvas>";
        var graphWarren = "Warren "+warrenVotes + "%  <canvas id='myCanvas' width='"+(secondAnswer*100)+"' height='100' style='border:1px solid #c3c3c3; background-color: #85144b;'></canvas>";
        var graphSanders = "Sanders "+sandersVotes + "%  <canvas id='myCanvas' width='"+(thirdAnswer*100)+"' height='100' style='border:1px solid #c3c3c3; background-color: #FF851B;'></canvas>";
        var graphBiden = "Biden "+bidenVotes + "%  <canvas id='myCanvas' width='"+(fourthAnswer*100)+"' height='100' style='border:1px solid #c3c3c3; background-color: #001f3f;'></canvas>";
        
        document.getElementById('trump').innerHTML = graphTrump;
        document.getElementById('warren').innerHTML = graphSanders;
        document.getElementById('sanders').innerHTML = graphWarren;
        document.getElementById('biden').innerHTML = graphBiden;
        document.getElementById('fadingImg').style.visibility = 'hidden';
        
    }

}

function deleteAll() {
    firstAnswer = 0;
    secondAnswer = 0;
    thirdAnswer = 0;
    fourthAnswer = 0;
    countAnswer = 0;
    var req = indexedDB.deleteDatabase("idarticle_answer");
    location.reload();
}

function synchronize(e) {
    var s = "";
    var transaction = db.transaction(["answer"], "readwrite").objectStore("answer").openCursor().onsuccess = function (e) {

        var cursor = e.target.result;
        if (cursor) {
            for (var field in cursor.value) {
                s += cursor.value[field] + ":";
            }
            s += "#";
            cursor.continue();
        }
        var req = indexedDB.deleteDatabase("idarticle_answer");
        document.getElementById('hid').value = s;
        document.getElementById('akt').submit();
    }
}

function removeImg()
{
    document.getElementById('fadeImgSecond').style.visibility = 'hidden';
}