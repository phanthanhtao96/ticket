$(document).ready(function () {
    $('.cause').richText();
    $('.content').richText();
});
targetImg = targetElement = null;
function makeSelection(frm, name, img) {
    if (!frm || !name) {
        return
    }
    if (img !== null) {
        targetImg = document.getElementById(img);
    }
    targetElement = frm.elements[name];
    console.log(targetElement);
    console.log(targetImg);
    window.open('/imgs/select');
}