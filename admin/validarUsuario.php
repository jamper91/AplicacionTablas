<?php
session_start();
if($_SESSION['rol']!="admin")
	header('Location: ../index.html');
?>