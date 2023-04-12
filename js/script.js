function openNav() {
    if (window.matchMedia("(max-width:500px").matches) {
        document.getElementById("sideNav").style.width = "150px";
        document.querySelector("body").style.marginLeft = "150px";
        document.getElementById("close").style.display = "flex";
        document.getElementById("close").style.justifyContent = "center"
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
        document.getElementById("menu").style.display = "flex";
        document.getElementById("menu").style.justifyContent = "center"
    }
    else {
        document.getElementById("menu").style.display = "inline-block";
    }
}

function displayReview(movie_id) {
    let modal = document.getElementById("review-modal");
    modal.style.display = 'block';
    document.getElementById("review-movie").value = movie_id;
}

function closeModal() {
    let modal = document.getElementById("review-modal");
    modal.style.display = 'none';
    document.getElementById("review-movie").value = '';
}