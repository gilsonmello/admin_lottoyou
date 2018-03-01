<?php
/**
 * SQL Dump element.  Dumps out SQL log information
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Elements
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if (!class_exists('ConnectionManager') || Configure::read('debug') < 2) {
	return false;
}

// VERIFICA SE TEM LOGS
$noLogs = !isset($logs);

if ($noLogs):
	$sources = ConnectionManager::sourceList();

	$logs = array();
	foreach ($sources as $source):
		$db = ConnectionManager::getDataSource($source);
		if (!method_exists($db, 'getLog')):
			continue;
		endif;
		$logs[$source] = $db->getLog();
	endforeach;
	/*if (Configure::read('checkPermissionInSession') == 1 && isset($logs['default'])){
		unset($logs['default']['log'][0]);
		unset($logs['default']['log'][1]);
		$logs['default']['count'] -= 2;
	}*/
endif;

if (isset($logs['default'])):
	if ($noLogs || isset($_forced_from_dbo_)):
		foreach ($logs as $source => $logInfo):
			$text = $logInfo['count'] > 1 ? 'queries' : 'query';		
		?>
		<?php
	        $summery = "{$logInfo['count']} {$text} took {$logInfo['time']} ms";
	        $header = array("Nr", "Query", "Error", "Affected", "Num. rows", "Took (ms)");
	        $body = array($header);
			foreach ($logInfo['log'] as $k => $i) :
				$i += array('error' => '');
				if (!empty($i['params']) && is_array($i['params'])) {
					$bindParam = $bindType = null;
					if (preg_match('/.+ :.+/', $i['query'])) {
						$bindType = true;
					}
					foreach ($i['params'] as $bindKey => $bindVal) {
						if ($bindType === true) {
							$bindParam .= h($bindKey) ." => " . h($bindVal) . ", ";
						} else {
							$bindParam .= h($bindVal) . ", ";
						}
					}
					$i['query'] .= " , params[ " . rtrim($bindParam, ', ') . " ]";
				}
	            $row = array(($k + 1), $i['query'], $i['error'], $i['affected'], $i['numRows'], $i['took']);
	            $body[] = $row;			
			endforeach;
	        fb(array($summery, $body), FirePHP::TABLE);
		?>
		<?php
		endforeach;
	else:
		echo '<p>Encountered unexpected $logs cannot generate SQL log</p>';
	endif;
endif;