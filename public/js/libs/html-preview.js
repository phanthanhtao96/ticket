function html_preview(html) {
    let win = window.open("", "Preview", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=800,height=700,top=" + (screen.height - 400) + ",left=" + (screen.width - 840));
    win.document.body.innerHTML = html;
}
