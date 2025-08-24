<?php

require_once './conexoes.php';
require_once './classes/Conector.php';

function listarClientes(){
    global $conexoes; 

    try {
        $class = new Conector($conexoes);

        $resultado = $class->query(0, "SELECT * FROM CLIENTE");

        foreach($resultado as $cliente){
            echo "<tr>
                    <td>{$cliente['NOME']}</td>
                    <td>{$cliente['CPF_CNPJ']}</td>
                </tr>";
        }
    } catch (\Exception $th) {
      echo $th->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de clientes</title>
</head>
<body>
    <table>
       <tr>
         <th>NOME</th>
         <th>CPF/CNPJ</th>
       </tr>
       <?=listarClientes()?>
    </table>
</body>
</html>