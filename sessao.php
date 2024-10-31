<?php
	session_start();

	$usuario = $_SESSION['usuario'];

	if($usuario == null){
		die("Usuário não autenticado!
		<a href='login.html'>Logar</a>");
	}