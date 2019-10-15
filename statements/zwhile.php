<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZWhile
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'while (' . ZStatement::expr($expr['expr']);
		$result .= ') {' . PHP_EOL;
		foreach ($expr['statements'] as $statement) {
			$result .= ZStatement::convert($statement, $indent +1);
		}
		$result .= indent($indent) . '}' . PHP_EOL;
		return $result;
	}

}
