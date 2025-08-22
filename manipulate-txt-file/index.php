<?php 
	function registra_log($log,$processo){
		if(!file_exists('logs')){
			mkdir('logs',0700,true);
		}
		$arquivo = './logs/log.txt';
		$conexão_arquivo = fopen($arquivo, "a+");
		fwrite($conexão_arquivo, 'Realizado em: '.date('Y-m-d H:i:s').' - '.$log.' - ('.$processo.');'."<br>");
		fclose($conexão_arquivo);
	}
	function  ler_log(){
		$arquivo = './logs/log.txt';
		if(file_exists($arquivo)){
			$conexão_arquivo = fopen($arquivo, "r");
			while(!feof($conexão_arquivo)){
				$linha = fgets($conexão_arquivo,4096);
				echo $linha;
			}
			fclose($conexão_arquivo);
		}else{
			echo "Não registro no arquivo txt";
		}
	}
	registra_log('Marcos Lopes','teste');
	ler_log();
 ?>