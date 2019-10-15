<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZDoWhile
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'do {' . PHP_EOL;
		foreach ($expr['statements'] as $statement) {
			$result .= ZStatement::convert($statement, $indent +1);
		}
		$result .= indent($indent) . '} while (';
		$result .= ZStatement::expr($expr['expr']) . ')';
		return $result;
	}

}
