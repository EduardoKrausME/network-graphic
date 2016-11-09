<?php
/**
 * User: Eduardo Kraus
 * Date: 09/11/16
 * Time: 05:11
 */


/*************************

  A CRON deve ser:
  * * * * * /usr/bin/php  [path-to-project]/cron-networksave.php > /dev/null 2>&1

 *************************/


date_default_timezone_set ( 'America/Sao_Paulo' );


$pasta = __DIR__ . '/networksaved/' . date ( 'Y/m/d' );
$file  = date ( 'H-i' ) . '.txt';

shell_exec ( "mkdir -p $pasta" );
shell_exec ( "cat /proc/net/dev > $pasta/$file" );
