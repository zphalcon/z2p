<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZLoop
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'while (true) {' . PHP_EOL;
		foreach ($expr['statements'] as $statement) {
			$result .= ZStatement::convert($statement, $indent +1);
		}
		$result .= indent($indent) . '}' . PHP_EOL;
		return $result;
	}

}
