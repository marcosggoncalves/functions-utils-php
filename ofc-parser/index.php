<?php
require_once './classes/OfcParser.php';

$class = new OFCParser('./teste.ofx');

/**
 *  Realizar a formatação do array, retornando os itens com seus atributos
    * [
        *'TRNTYPE' => '0',
        *'DTPOSTED' => '20200605',
        *'TRNAMT' => '1030.27',
        *'FITID' => '51855',
        *'CHKNUM' => '51855',
        *'MEMO' => 'DP DIN LOT'
    *]
*/
echo json_encode($class->build());


