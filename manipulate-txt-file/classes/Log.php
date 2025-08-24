<?php 
	class Log{
		private $arquivo;
		
		public function __construct($arquivo) {
			$this->arquivo = $arquivo;
		}
		
		private function verificarPasta(){
			if(!file_exists($this->arquivo )){
				mkdir($this->arquivo,0700,true);
			}
		}

		private function texto($log, $metodo){
		   return 'Realizado em: '.date('Y-m-d H:i:s').' - '.$log.' - ('.$metodo.');'."<br>";
		}

		public function gravar($log, $metodo){
			try {
				$this->verificarPasta();
				$abrirArquivo = fopen("./{$this->arquivo}/log.txt", "a+");
			    fwrite($abrirArquivo, $this->texto($log, $metodo));
				fclose($abrirArquivo);
			} catch (\Throwable $th) {
				die($th->getMessage());
			}
		}

		public function ler(){
			try {
				$caminho = "./{$this->arquivo}/log.txt";
				
				if(file_exists($caminho)){
					$abrirArquivo = fopen($caminho, "r");

					while(!feof($abrirArquivo)){
						echo fgets($abrirArquivo, 4096);
					}

					fclose($abrirArquivo);
				}
			} catch (\Throwable $th) {
				die($th->getMessage());
			}	
		}
	}