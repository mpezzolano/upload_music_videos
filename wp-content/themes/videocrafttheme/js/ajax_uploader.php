<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#uploadForm").submit(function() {
            jQuery("#upload_video").attr("disabled", "disabled");
            jQuery("#upload_image").attr("disabled", "disabled");
        });
    });
    function _(el) {
        return document.getElementById(el);
    }
    function uploadFile(ref, c) {
        //var clickedID = jQuery(ref).attr('id');
        //source field value
        var clickedID = _(ref);
        //destination field
        var field = _(c).id;
        //source field
        var data = clickedID.files[0];
        //action for admin ajax
        var action = _("action").value;
        //alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append('field', field);
        formdata.append("data", data);
        //formdata.append("data", fileInputElement.clickedID[0]);
        formdata.append("action", action);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("ontimeout", errorHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.addEventListener('readystatechange', onreadystatechangeHandler, false);
        ajax.open("POST", "<?php echo admin_url("admin-ajax.php"); ?>");
        ajax.send(formdata);
    }
    function progressHandler(event) {
        //_("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
        var percent = (event.loaded / event.total) * 100;
        //_("progressBar").value = Math.round(percent);
        _("progress").style.display = "block";
        _("bar").style.width = Math.round(percent) + "%";
        _("percent").innerHTML = Math.round(percent) + "%";
        _("message").innerHTML = Math.round(percent) + "% uploading... please wait";
    }
    function completeHandler(event) {
        var response = event.target.responseText;
        var t = response.substring(0, response.length - 1);
        eval('obj=' + t);
        _(obj.field).value = obj.url;
        //alert(cbj.field);
        _("message").innerHTML = obj.message;
        //_("progressBar").value = 100;
        if (!obj.error) {
            _("bar").style.width = '100%';
            _("percent").innerHTML = "100%";
            _("message").style.color = "black";
        }
    }
    function errorHandler(event) {
        _("message").innerHTML = "Upload Failed";
    }
    function abortHandler(event) {
        _("message").innerHTML = "Upload Aborted";
    }
    // Handle the response from the server
    function onreadystatechangeHandler(evt) {
        var status = null;

        try {
            status = evt.target.status;
        }
        catch (e) {
            return;
        }

        if (status == '200' && evt.target.responseText) {
            var result = _('message');
            result.innerHTML = 'Upload Error, Please check your upload size and type.';
            result.style.color = "red";
            _("bar").style.width = '0';
            _("percent").innerHTML = "0";
        }
    }
</script>