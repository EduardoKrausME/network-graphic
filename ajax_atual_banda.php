<?php
/**
 * User: Eduardo Kraus
 * Date: 09/11/16
 * Time: 14:16
 */

date_default_timezone_set ( 'America/Sao_Paulo' );

$netDev = shell_exec ( "cat /proc/net/dev" );

require 'Banda.php';
list( $somaRedeStartIn, $somaRedeStartOut ) = Banda::processBanda ( $netDev );

die( $somaRedeStartIn . ':' . $somaRedeStartOut . ':' . date ( 'Y-m-d-H-i-s' ) );