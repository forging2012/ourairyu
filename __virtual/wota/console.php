<?php

if ( in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1')) ) { ?>
<?php
}
else {
	die('你来到了一个不毛之地！');
}

?>
