<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZThrow
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'throw ' . ZStatement::expr($expr['expr']) . ';';
		return $result;
	}

}
