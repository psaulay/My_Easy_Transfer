// Functions progress bar

function _(el) {
    return document.getElementById(el);
}
        
function uploadFile() {
    var file = _("uploaded_file").files[0];
    // alert(file.name+" | "+file.size+" | "+file.type);
    var formdata = new FormData();
    formdata.append("uploaded_file", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "file_upload_parser.php");
    ajax.send(formdata);
}

function progressHandler(event) {
    _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
}

function completeHandler(event) {
    _("status").innerHTML = event.target.responseText;
    _("progressBar").value = 100; //wil clear progress bar after successful upload
}

function errorHandler(event) {
    _("status").innerHTML = "Upload Failed";
}
        
function abortHandler(event) {
    _("status").innerHTML = "Upload Aborted";
}    


/* disparition divs */

function changer() {
    if (document.getElementById('1').style.display != 'none'){
        document.getElementById('1').style.display = 'none';
        document.getElementById('loading').style.display = 'block';
    } else {
        document.getElementById('loading').style.display = 'none';
        document.getElementById('1').style.display = 'block';
    }




    
    }