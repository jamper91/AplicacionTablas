<?php
session_start();
if($_SESSION['rol']!="inspector")
	header('Location: ../index.html');
?>