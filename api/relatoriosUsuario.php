<?php
	$db = null;
	include('funcao.php'); 

	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	mb_internal_encoding("UTF-8"); 
	set_time_limit(0);
	ini_set('memory_limit', '-1');

	/*$mes = date('M');

	$mes_extenso = array(
        'Jan' => 'JANEIRO',
        'Feb' => 'FEVEREIRO',
        'Mar' => 'MARÇO',
        'Apr' => 'ABRIL',
        'May' => 'MAIO',
        'Jun' => 'JUNHO',
        'Jul' => 'JULHO',
        'Aug' => 'AGOSTO',
        'Nov' => 'NOVEMBRO',
        'Sep' => 'STEBMRO',
        'Oct' => 'OUTUBRO',
        'Dec' => 'DEZEMBRO'
    );*/

	$mes = date('d/m/Y', strtotime('-1 month'));
	$array = explode('/', $mes);

	$mes_extenso = array(
        '01' => 'JANEIRO',
        '02' => 'FEVEREIRO',
        '03' => 'MARÇO',
        '04' => 'ABRIL',
        '05' => 'MAIO',
        '06' => 'JUNHO',
        '07' => 'JULHO',
        '08' => 'AGOSTO',
        '09' => 'NOVEMBRO',
        '10' => 'STEBMRO',
        '11' => 'OUTUBRO',
        '12' => 'DEZEMBRO'
    );

	$usuarios = selectUsuarioConsumoGeral($db);

	$table = null;
	$table .= '<table width="100%" >
            <tr>
              <td width="10%" style="text-align: center;"><strong><h1>:: RELATÓRIO COPINHA MÊS REFÊRENCIA '.$mes_extenso["$array[1]"].'/'.date('Y').' ::</h1></strong></td>  
            </tr>
          </table>';

	$table .= '<table border="1" style="width: 100%;">';
	    $table .= '<tr>';
	        $table .= '<th>Usuários</th>';
	        $table .= '<th>Valor Pendente</th>';
	    $table .= '</tr>';
	    $soma = 0;
	    foreach($usuarios as $usuario){
	    	$table .= '<tr>';
		        $table .= '<td>'.$usuario['nome'].'</td>';
		        $table .= '<td style="text-align: center;">R$ '.number_format($usuario['total'],2,",").'</td>';
		    $table .= '</tr>';
		    $soma = $soma + number_format($usuario['total'],2,",");
			}

			$table .= '<tr>';
	        $table .= '<td> Total Receber</td>';
	        $table .= '<td style="text-align: center;">R$ '.number_format($soma,2,",").'</td>';
	    $table .= '</tr>';
	$table .= '</table>';	

  $table .= '<table width="100%">
  						<tr>
		            <td style="text-align: center;"><h2>:: Por Favor, Enviar Comprovante do PIX para Administração ::</h2></td> 
		          </tr>
  						<tr>
		            <td style="text-align: center;"><img src="img/PIX.jpeg" width=500px height=700px> </td> 
		          </tr>
		          <tr>
		            <td width="18%" style="text-align: right;"><span style="font-size:10pt;"><strong>Gerado em '.date('d/m/Y').'</strong></span></td> 
		          </tr>
		        </table>';

 	
 	$table .= '<form style="text-align: center;">
					<input type="button" value="Imprimir" onClick="window.print()"/>
			   </form>';

	echo $table;
 
?>
