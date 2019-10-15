<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZMcall
{
	public static function convert($expr, $indent = 3)
	{
		return indent($indent) . ZStatement::expr($expr['expr']) . ';' . PHP_EOL;
	}

}
