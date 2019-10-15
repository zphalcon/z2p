<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZSwitch
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'switch (' . ZStatement::expr($expr['expr'], $indent + 1);
		$result .= ') {' . PHP_EOL;
		foreach ($expr['clauses'] as $clause) {
			$result .= indent($indent + 1) . $clause['type'];
			if ($clause['type'] == 'case') {
				$result .= ' ' . ZStatement::expr($clause['expr']);
			}
			$result .= ':' . PHP_EOL;
			if (isset($clause['statements'])) {
				foreach ($clause['statements'] as $statement) {
					$result .= ZStatement::convert($statement, $indent + 2);
				}
			}
		}
		$result .= PHP_EOL . indent($indent) . '}' . PHP_EOL;
		return $result;
	}

}
