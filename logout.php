<?php
session_start();
session_destroy();
header("Location: loging.php");
exit();
?>