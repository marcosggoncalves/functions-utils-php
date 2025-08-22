<?php

namespace App\Utility;

class OfcParser
{
    /**
     * Convertar o array com os dados em string;
     */
    private function convert($url)
    {
        $string = '';

        foreach (file($url) as  $linha) {
            $string .= $linha;
        }

        return $string;
    }

    private function formatArray($file)
    {
        $ofc = $this->convert($file);

        $OFCArray = explode("<", $ofc);
        $tags = array();

        foreach ($OFCArray as $linha) {
            $tag=explode(">", $linha);
            
            if (isset($tag[1])) {
                if ($tag[1]!=null) {
                    if (isset($tags[$tag[0]])) {
                        if (is_array($tags[$tag[0]])) {
                            $tags[$tag[0]][]= trim($tag[1]);
                        } else {
                            $temp=$tags[$tag[0]];
                            $tags[$tag[0]]= array();
                            $tags[$tag[0]][]= trim($temp);
                            $tags[$tag[0]][]= trim($tag[1]);
                        }
                    } else {
                        $tags[$tag[0]]= trim($tag[1]);
                    }
                }
            }
        }
        return $tags;
    }

    private function dateFormat($DTPOSTED)
    {
        $date = substr($DTPOSTED, 0, 4) .'-'. substr($DTPOSTED, 4, 2) .'-'.  substr($DTPOSTED, 6, 2);
        return date_create_from_format('Y-m-d', $date);
    }

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
    public function build($arquivo)
    {
        $extrato = [];
        
        $ofc = $this->formatArray($arquivo);

        foreach ($ofc['STMTTRN'] as $index => $value) {
            $extrato[] = [
                'TRNTYPE' =>  $ofc['TRNTYPE'][$index],
                'DTPOSTED' => $this->dateFormat($ofc['DTPOSTED'][$index]),
                'TRNAMT' => $ofc['TRNAMT'][$index],
                'FITID' => $ofc['FITID'][$index],
                'CHKNUM'=> $ofc['CHKNUM'][$index],
                'MEMO' => $ofc['MEMO'][$index]
            ];
        }

        return $extrato;
    }
}
