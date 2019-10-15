<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZEcho
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'echo(';
		$result .= ZStatement::expr($expr['expressions'][0]);
		$result .= ');' . PHP_EOL;
		return $result;
	}

}
