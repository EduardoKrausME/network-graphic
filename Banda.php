<?php

/**
 * User: Eduardo Kraus
 * Date: 09/11/16
 * Time: 05:29
 */
class Banda
{

    private $bandaAnteriorIn  = -1;
    private $bandaAnteriorOut = -1;
    private $graficoDataIn    = array();
    private $graficoDataOut   = array();

    /**
     * @return array
     */
    public function getGraficoDataIn ()
    {
        return $this->graficoDataIn;
    }
    /**
     * @return array
     */
    public function getGraficoDataOut ()
    {
        return $this->graficoDataOut;
    }

    function __construct ()
    {


        // 1440 é um dia (24 horas vezes 60 minutos)
        for ( $i = 1440; $i > 1; $i-- ) {
            $nextMinute = time () - ( 60 * $i );
            $date       = date ( 'Y/m/d/H-i', $nextMinute );

            $file  = __DIR__ . '/networksaved/' . $date . '.txt';
            $banda = $this->getBandaByMinute ( $file );

            if ( $banda !== 0 ) {
                preg_match ( "/(\d+)\/(\d+)\/(\d+)\/(\d+)-(\d+)/", $date, $date_array );

                $year   = $date_array[ 1 ];
                $month  = $date_array[ 2 ] - 1; // Date.UTC mês começa com Zero
                $day    = $date_array[ 3 ];
                $hour   = $date_array[ 4 ];
                $minute = $date_array[ 5 ];

                $this->graficoDataIn[]  = "    [Date.UTC($year, $month, $day, $hour, $minute), {$banda['out']}]";
                $this->graficoDataOut[] = "    [Date.UTC($year, $month, $day, $hour, $minute), {$banda['in']}]";
            }
        }
    }

    private function getBandaByMinute ( $file )
    {
        if ( !file_exists ( $file ) )
            return 0;

        $fileData = file_get_contents ( $file );
        preg_match_all ( "/\s*([a-z0-9]+):\s*([0-9]+)\s*([0-9]+)\s*([0-9]+)\s*([0-9]+)\s*([0-9]+)\s*([0-9]+)\s*([0-9]+)\s*([0-9]+)\s*([0-9]+)/", $fileData, $outputNet );

        $somaRedeStartIn = $somaRedeStartOut = 0;
        foreach ( $outputNet[ 2 ] as $rede )
            $somaRedeStartIn += $rede;
        foreach ( $outputNet[ 10 ] as $rede )
            $somaRedeStartOut += $rede;

        if ( $this->bandaAnteriorIn == -1 ) {
            $this->bandaAnteriorIn  = $somaRedeStartIn;
            $this->bandaAnteriorOut = $somaRedeStartOut;

            return 0;
        }

        $retornoIn  = $somaRedeStartIn  - $this->bandaAnteriorIn;
        $retornoOut = $somaRedeStartOut - $this->bandaAnteriorOut;

        $this->bandaAnteriorIn  = $somaRedeStartIn;
        $this->bandaAnteriorOut = $somaRedeStartOut;

        // 60 minitos e banda é em segundos
        return array(
            'in'  => $retornoIn / 60,
            'out' => $retornoOut / 60
        );
    }

}