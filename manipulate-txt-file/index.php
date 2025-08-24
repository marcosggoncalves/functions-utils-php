<?php

require_once './classes/Log.php';

$class = new Log('logs');
$class->gravar('Marcos Lopes','teste escrita .txt');
$class->ler();