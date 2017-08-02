function histbtnkai(){
    document.getElementById("hisbtn").href="javascritp:return false;";

    // console.log(document.getElementById("list").style.display);
    if (document.getElementById("list").style.display=="none"){
        document.getElementById("list").style.display="block";
    }else{
        document.getElementById("list").style.display="none";
    }
}
