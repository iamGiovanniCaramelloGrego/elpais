<?php
session_start();
session_destroy(); // Destroi todas as sessões
header("Location: ../index.html"); // Redireciona para a página inicial
exit;
?>
