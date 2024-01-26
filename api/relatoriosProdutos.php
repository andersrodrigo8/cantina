<?php
	$db = null;
	include('funcao.php'); 

	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	mb_internal_encoding("UTF-8"); 
	set_time_limit(0);
	ini_set('memory_limit', '-1');

	$produtos = selectProdutos($db);

	$table = null;
	$table .= '<table width="100%" >
            <tr>
              <td width="10%" style="text-align: center;"><strong>:: RELATÓRIO COPINHA ::</strong></td>  
            </tr>
          </table>';

	$table .= '<table border="1" style="width: 100%;">';
	    $table .= '<tr>';
	        $table .= '<th>Título</th>';
	        $table .= '<th>Validade</th>';
		$table .= '<th>Geladeira</th>';
	        $table .= '<th>Quantidade</th>';
	        $table .= '<th>Valor Unit.</th>';
		$table .= '<th>Valor Total</th>';
	    $table .= '</tr>';
	    foreach($produtos as $produto){
              //if($produto['quantidade'] > 0) {
	    	$table .= '<tr>';
		        $table .= '<td>'.$produto['titulo'].'</td>';
		        $table .= '<td style="text-align: center;">'.date('d/m/Y',strtotime($produto['validade'])).'</td>';
			$table .= '<td></td>';
		        $table .= '<td style="text-align: center;">'.$produto['quantidade'].'</td>';
		        $table .= '<td style="text-align: center;">R$ '.number_format($produto['valor'],2,",").'</td>';
			$table .= '<td style="text-align: center;">R$ '.number_format($produto['quantidade'] * $produto['valor'], 2, ",").'</td>';
		    $table .= '</tr>';
		    $somaqtd = $produto['quantidade'] + $somaqtd;
		    $somavalor = $somavalor + ($produto['quantidade'] * $produto['valor']);
		}
              //}
	$table .= '<tr>';
			$table .= '<td style="text-align: center;" colspan="3"> <strong>SOMATÓRIO</strong> </td>';
			$table .= '<td style="text-align: center;"><strong>'.$somaqtd.'</strong></td>';
			$table .= '<td style="text-align: center;"><strong>R$ '.number_format($somavalor,2,",").'</strong></td>';
		$table .= '</tr>';
	$table .= '</table>';	

    $table .= '<table width="100%">
            <tr>
              <td width="18%" style="text-align: right;"><span style="font-size:10pt;"><strong>Gerado em '.date('d/m/Y').'</strong></span></td> 
            </tr>
          </table>';
 	
 	$table .= '<form style="text-align: center;">
					<input type="button" value="Imprimir" onClick="window.print()"/>
			   </form>';

	echo $table;
 
?>
