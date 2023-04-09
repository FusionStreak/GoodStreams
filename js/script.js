function openNav() {
    document.getElementById("sideNav").style.width = "300px";
    document.querySelector("body").style.marginLeft = "300px";
    document.getElementById("close").style.display = "inline-block";
    document.getElementById("menu").style.display = "none";
}

function closeNav() {
    document.getElementById("sideNav").style.width = "0";
    document.querySelector("body").style.marginLeft = "0";
    document.getElementById("close").style.display = "none";
    document.getElementById("menu").style.display = "inline-block";
}

