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

var expandListItem = document.querySelectorAll(".itemOpen");

for(var i = 0; i < expandListItem.length; i++){
    expandListItem[i].addEventListener("click", function(){
        this.parentElement.nextElementSibling.classList.toggle("active");
    });
}

var editListItem = document.querySelectorAll('.editInfo');

for(var i = 0; i < editListItem.length; i++){
    editListItem[i].addEventListener("click", function(e){
        e.target.parentElement.nextElementSibling.style.display = "none";
        e.target.style.display = "none";
        e.target.parentElement.nextElementSibling.nextElementSibling.style.display = "block";
    });
}