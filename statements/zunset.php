<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZUnset
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent);
		$result .= 'unset(';
		$result .= ZStatement::expr($expr['expr']);
		$result .= ');' . PHP_EOL;
		return $result;
	}

}
