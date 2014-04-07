<?php
session_start();
if($_SESSION['rol']!="usuario")
	header('Location: ../index.html');
?>