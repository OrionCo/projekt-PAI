var mobilenav = document.getElementById("mobilenav");
if(window.innerWidth <= 1200){
    document.querySelector("#container").style.marginTop = mobilenav.offsetHeight + "px";
}
const menu = document.querySelector("#mobileMenu");
menu.style.display = "none";
function mobileNav(){
    if(menu.style.display === "none"){
        menu.style.display = "block";
        menu.style.top = mobilenav.offsetHeight + "px";
    } else {
        menu.style.display = "none";
    }
}