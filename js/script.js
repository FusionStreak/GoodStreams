function openNav() {
    if (window.matchMedia("(max-width:500px").matches) {
        document.getElementById("sideNav").style.width = "110px";
        document.querySelector("body").style.marginLeft = "110px";
        document.getElementById("close").style.display = "block";

    }
    else {
        document.getElementById("sideNav").style.width = "300px";
        document.querySelector("body").style.marginLeft = "300px";
        document.getElementById("close").style.display = "inline-block";
    }
    document.getElementById("menu").style.display = "none";
}

function closeNav() {
    document.getElementById("sideNav").style.width = "0";
    document.querySelector("body").style.marginLeft = "0";
    document.getElementById("close").style.display = "none";
    if (window.matchMedia("(max-width:500px").matches) {
        document.getElementById("menu").style.display = "block";

    }
    else {
        document.getElementById("menu").style.display = "inline-block";
    }
}

