<?php 
$repeticao = $dados['FinMovimentacao']['repeticao'];
$frequencia = $dados['FinMovimentacao']['frequencia'];
$periodicidade = $dados['FinMovimentacao']['periodicidade'];
$total_parcelas = $dados['FinMovimentacao']['total_parcelas'];
$parcela_inicial = $dados['FinMovimentacao']['parcela_inicial'];

switch ($repeticao) {
	case 'P':
		switch ($periodicidade) {
			case 'D':
				$periodicidade = ($frequencia == 1) ? 'dia' : 'dias';
			break;
			case 'S':
				$periodicidade = ($frequencia == 1) ? 'semana' : 'semanas';
			break;
			case 'M':
				$periodicidade = ($frequencia == 1) ? 'mês' : 'meses';
			break;
			case 'A':
				$periodicidade = ($frequencia == 1) ? 'ano' : 'anos';
			break;
		}

		echo $frequencia.' '.$periodicidade.' até '.$data_limite;
	break;
}
?>