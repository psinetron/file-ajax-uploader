<script type="text/javascript">
    CallNames();
function CallNames(){
    var massfiles=new Array();
<?php
for ($i=0;$i<count($_FILES['filename']['name']);$i++){
print 'massfiles.push(\''.$_FILES['filename']['name'][$i].'\');' . PHP_EOL;
print 'console.info(\''.$_FILES['filename']['name'][$i].'\');' . PHP_EOL;
}
?>
window.parent.SlyUploader_fileLoaded(massfiles, <?php print $_POST['iframeIdent']. ', \''. $_POST['resultIdent'] .'\'' ?>);
}
</script>