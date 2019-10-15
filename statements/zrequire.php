<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZRequire
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent);
		$result .= 'require(';
		$result .= ZStatement::expr($expr['expr']);
		$result .= ');' . PHP_EOL;
		return $result;
	}

}
