<?php
namespace ZPhalcon\Convertions;

use ZPhalcon\ZStatement;

class ZMethod
{
	public static function convert($method, $indent = 1)
	{
		$abstract = false;
		$result = indent($indent);
		foreach ($method['visibility'] as $visibility) {
			if ($visibility == 'abstract') {
				$abstract = true;
			}
			$result .= $visibility . ' ';
		}

		$result .= 'function ' . $method['name'] . '(';

		if (isset($method['parameters'])) {
			foreach ($method['parameters'] as $idx => $parameter) {
				if ($idx != 0) {
					$result .= ', ';
				}
				$result .= '$' . $parameter['name'];
				$result .= ZStatement::parameterValue($parameter);
			}
		}

		$result .= ')' . PHP_EOL;
		if (!$abstract) {
			$result .= indent($indent) . "{" . PHP_EOL;
		}

		if (isset($method['statements'])) {
			foreach ($method['statements'] as $statement) {
				$result .= ZStatement::convert($statement, $indent + 1) . PHP_EOL;
			}
		}

		if (!$abstract) {
			$result .= indent($indent) . "}" . PHP_EOL;
		}
		$result .= PHP_EOL;
		return $result;
	}

}
