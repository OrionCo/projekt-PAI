var totalCount = 9;

function ChangeIt(){
    var num = Math.ceil(Math.random() * totalCount);
    document.querySelector("#navbar").style.backgroundImage = 'url("bgimages/' + num + '.svg")';
    document.querySelector("#navbar").style.backgroundRepeat = 'repeat';
    document.querySelector("#navbar").style.backgroundPosition = '100%';
    document.querySelector("#mobilenav").style.backgroundImage = 'url("bgimages/' + num + '.svg")';
    document.querySelector("#mobilenav").style.backgroundRepeat = 'repeat';
    document.querySelector("#mobilenav").style.backgroundPosition = '100%';
}