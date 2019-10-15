<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZIf
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'if (';
		$result .= ZStatement::expr($expr['expr']);
		$result .= ')' . PHP_EOL . indent($indent) . '{' . PHP_EOL;
		foreach ($expr['statements'] as $idx => $expr) {
			$result .= ZStatement::convert($expr, $indent + 1) . PHP_EOL;
		}
		$result .= indent($indent) . '}' . PHP_EOL;
		return $result;
	}

}
