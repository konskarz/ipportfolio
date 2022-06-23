<?php defined( '_JEXEC' ) or die;

if ($this->error->getCode() == '404') {
	header("HTTP/1.0 404 Not Found");
}
header('Location: ' . $this->baseurl . '/index.php');
exit();

?>