<?php
namespace ZPhalcon\Statements;

use ZPhalcon\ZStatement;

class ZTryCatch
{
	public static function convert($expr, $indent = 3)
	{
		$result = indent($indent) . 'try {' . PHP_EOL;
		foreach ($expr['statements'] as $statement) {
			$result .= ZStatement::convert($statement, $indent + 1);
		}
		foreach ($expr['catches'] as $statement) {
			$result .= indent($indent) . '} catch (';
			foreach ($statement['classes'] as $class) {
				$result .= $class['value'] . ' ';
			}
			$result .= ZStatement::expr($statement['variable']);
			$result .= ') {' . PHP_EOL;
			foreach ($statement['statements'] as $statement) {
				$result .= ZStatement::convert($statement, $indent + 1);
			}
			$result .= PHP_EOL . indent($indent) . '}';
		}
		return $result;
	}

}
