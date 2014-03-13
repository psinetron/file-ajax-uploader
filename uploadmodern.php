<?php
/*
 * Если ошибка - возвращаем ERROR
 */
print_r($_FILES);
print 'flow:' . $_POST['flow'] . '; ' . $_FILES['file']['tmp_name'][0] . '; '. $_FILES['file']['name'][0];
print '-OK';
?>