<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZFor
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'foreach (';
		$result .= ZStatement::expr($expr['expr']) . ' as ';
		if (isset($expr['key'])) {
			$result .= '$' . $expr['key'] . ' => ';
		}
		$result .= '$' . $expr['value'];
		$result .= ') {' . PHP_EOL;
		foreach ($expr['statements'] as $statement) {
			$result .= ZStatement::convert($statement, $indent + 1);
		}
		$result .= indent($indent) . '}' . PHP_EOL;
		return $result;
	}

}
