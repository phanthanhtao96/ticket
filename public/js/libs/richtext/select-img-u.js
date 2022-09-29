function makeSelection(frm, name) {
    if (!frm || !name) return;
    var elem = frm.elements[name];
    if (!elem) return;
    var val = elem.value;
    if (opener.targetImg !== null) {
        opener.targetImg.src = "/uploads/posts/200/" + val;
    }
    opener.targetElement.value = val;
    console.log(opener.targetElement.value);
    this.close();
}

function ChangeText(oFileInput, sTargetID) {
    document.getElementById(sTargetID).value = oFileInput.value;
}