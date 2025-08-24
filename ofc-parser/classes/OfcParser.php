<?php

class OFCParser
{
    private $file;

    public function __construct($file) {
        $this->file = $file;
    }
    
    private function convert($url)
    {
        $string = '';

        foreach (file($url) as  $linha) {
            $string .= $linha;
        }

        return $string;
    }

    private function formatArray()
    {
        $ofc = $this->convert($this->file);

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

    public function build()
    {
        $extrato = [];
        
        $ofc = $this->formatArray();

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
