
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>


<div onclick="SlyUploader_startUpload('resulte')">buton</div>
<div id="resulte" style="border: 1px solid #000; height: 400px; ">Результат</div>


<script>
    var FilesUploads=new Array();
    function SlyUploader_startUpload(resultid){
        FilesUploads.push(FilesUploads.length);
        $('#' + resultid).append('<iframe id="iframeloader'+(FilesUploads.length)+'" style="width:1px; height: 1px; display:none"></iframe>');

        if(window.File && window.FileReader && window.FileList && window.Blob) {
            document.getElementById('iframeloader'+FilesUploads.length).contentDocument.writeln('<form method="post" enctype="multipart/form-data" action="uploadmodern.php" id="uploaderIframe" ><input type="hidden" name="iframeIdent" value="' + FilesUploads.length + '" /> <input type="file" name="filename[]" id="newfile" multiple onchange="window.parent.SlyUploader_ModernSubmit(this, '+FilesUploads.length+', \''+resultid+'\')" /></form>');
            form = document.getElementById('iframeloader'+FilesUploads.length).contentDocument.getElementById('uploaderIframe');
            form.onsubmit = function() {
                var file = this.elements.file1.files;
                if (file) {SlyUploader_ModernUpload(file, onSuccess, onError, onProgress); console.log('AllOK');} else {console.log('BAD :(');}
                return false;
            }
            document.getElementById('iframeloader'+FilesUploads.length).contentDocument.getElementById('newfile').click();
        } else {
        document.getElementById('iframeloader'+FilesUploads.length).contentDocument.writeln('<form method="post" enctype="multipart/form-data" action="upload.php" id="uploaderIframe" ><input type="hidden" name="iframeIdent" value="' + FilesUploads.length + '" /><input type="hidden" name="resultIdent" value="' + resultid + '" /><input type="file" name="filename[]" id="newfile" multiple onchange="window.parent.SlyUploader_Submit(' + FilesUploads.length + ')" /></form>');
        document.getElementById('iframeloader'+FilesUploads.length).contentDocument.getElementById('newfile').click();
        }

    }

    function SlyUploader_Submit(iframeId){
        document.getElementById('iframeloader'+iframeId).contentDocument.getElementById('uploaderIframe').submit();

    }

    function SlyUploader_ModernSubmit(obj, flow, resultid){
        for (var i=0;i<obj.files.length;i++){
           $('#'+resultid).append('<div id="imagesflow'+i+'-'+ flow +'">'+obj.files[i].name+' - загружается</div>');
            SlyUploader_ModernUpload( obj.files[i], i + '-' + flow, SlyUploader_onSuccess, SlyUploader_onError, SlyUploader_onProgress);
        }
        $('#iframeloader'+ flow).remove();
    }

    function SlyUploader_onSuccess(response) {

        var found;
        if (found=response.match(/flow:([0-9]+\-[0-9]+);\s(.*?);\s(.*)$/)) {} else {console.warn(response);} ;
        document.getElementById('imagesflow' + found[1]).innerHTML=found[3] + ' - loaded - ' + found[2];
    }

    function SlyUploader_onError() {
        console.log('error');
    }

    function SlyUploader_onProgress(loaded, total, flow) {
        document.getElementById('imagesflow' + flow).innerHTML=loaded + ' / '+ total;
        console.log(loaded + ' / '+ total);
    }

    function SlyUploader_ModernUpload(file, flow, onSuccess, onError, onProgress) {
            var xhr = new XMLHttpRequest();
            xhr.onload = xhr.onerror = function() {
                if(this.status != 200 || this.responseText.substr(0,5) == 'ERROR') {
                    onError(this);
                    return;
                } else {
                    onSuccess(this.responseText);
                }

            };
            xhr.upload.onprogress = function(event) {
                onProgress(event.loaded, event.total, flow);
            }
            xhr.upload.onsuccess = function(event) {
                onSuccess(event.name);
            }
            xhr.open("POST", "uploadmodern.php", true);
            var formData = new FormData();
            formData.append("file[]", file);
            formData.append("flow", flow);

            xhr.send(formData);
    }

    function SlyUploader_fileLoaded(filename, iframeIdent, resultid){
        for (var i=0;i<filename.length;i++)
      document.getElementById(resultid).innerHTML+=' - ' + filename[i];
        $('#iframeloader'+ iframeIdent).remove();
    }
</script>




