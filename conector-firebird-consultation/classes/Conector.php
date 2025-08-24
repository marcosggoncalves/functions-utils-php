<?php 

class Conector {
    private $conexoes;
    private $forbiddenCommands =  ['delete', 'insert', 'update'];

    public function __construct($conexoes) {
        $this->conexoes = $conexoes;
    }

    private function getConexao($posicao) {
        if (!isset($this->conexoes[$posicao])) {
            return ['error' => true, 'message' => 'Posição da conexão inválida!'];
        }
        return $this->conexoes[$posicao];
    }

    private function DNS($conexao) {
        return "firebird:dbname={$conexao['host']}:{$conexao['database']};charset=UTF-8";
    }

    public function query($posicao, $query) {        
        try {
            if (preg_match('/\b(' . implode('|', $this->forbiddenCommands) . ')\b/i', $query)) {
                return 'Query SQL não pode ser executada, comando proibido!';
            }

            $conexao = $this->getConexao($posicao);
            if (isset($conexao['error'])) {
                return $conexao;
            }

            $dns = $this->DNS($conexao);

            $pdo = new PDO($dns, $conexao['user'], $conexao['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC 
            ]);

            $stmt = $pdo->query($query);

            return $stmt->fetchAll();

        } catch (PDOException $e) {
            return "Erro na conexão ou execução da query! {$e->getMessage()}";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
