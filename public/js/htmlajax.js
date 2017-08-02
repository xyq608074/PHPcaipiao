window.onload=function(){

    cqajax();
    bjajax();
    ftajax();

    setInterval("cqajax()",10000);
    setInterval("bjajax()",10000);
    setInterval("ftajax()",10000);
}
function bjajax(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange=function () {
        if (xhr.readyState==4){
            document.getElementById('bjpk10info').innerHTML = xhr.responseText;
        }
    }
    xhr.open('get', 'index.php?p=front&c=iframe&a=iframebj');
    xhr.send(null);
}

function ftajax(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange=function () {
        if (xhr.readyState==4){
            document.getElementById('xyftinfo').innerHTML = xhr.responseText;
        }
    }
    xhr.open('get', 'index.php?p=front&c=iframe&a=iframeft');
    xhr.send(null);
}

function cqajax(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange=function () {
        if (xhr.readyState==4){
            document.getElementById('cqsscinfo').innerHTML =xhr.responseText;
        }
    }
    xhr.open('get', 'index.php?p=front&c=iframe&a=iframecq');
    xhr.send(null);
}