<?php
namespace ZPhalcon\Convertions;

use ZPhalcon\ZConvertion;
use ZPhalcon\ZStatement;

class ZInterface
{
	public static function convert($class, $indent = 0)
	{
		$result = PHP_EOL . indent($indent) . 'interface ';
		$result .= $class['name'];

		if (isset($class['extends'])) {
			$result .= ' extends ';
			if (is_array($class['extends'])) {
				foreach ($class['extends'] as $idx => $extends) {
					if ($idx > 0) {
						$result .= ', ';
					}
					$result .= $extends['value'];
				}
			} else {
				$result .= $class['extends'];
			}
		}

		if (isset($class['implements'])) {
			$result .= ' implements ';
			foreach ($class['implements'] as $idx => $implement) {
				if ($idx > 0) {
					$result .= ', ';
				}
				$result .= $implement['value'];
			}
		}
		$result .= PHP_EOL . indent($indent) . '{' . PHP_EOL;

		if (isset($class['definition']['constants'])) {
			foreach ($class['definition']['constants'] as $constant) {
				$result .= indent($indent + 1) . "const " . $constant['name'];
				$result .= ZStatement::parameterValue($constant);
				$result .= ';' . PHP_EOL;
			}
			$result .= PHP_EOL;
		}

		if (isset($class['definition']['properties'])) {
			foreach ($class['definition']['properties'] as $property) {
				$result .= indent($indent + 1);
				foreach ($property['visibility'] as $visibility) {
					$result .= $visibility . ' ';
				}
				$result .= '$' . $property['name'];
				$result .= ZStatement::parameterValue($property);
				$result .= ';' . PHP_EOL;
			}
			$result .= PHP_EOL;
		}

		if (isset($class['definition']['methods'])) {
			foreach ($class['definition']['methods'] as $method) {
				$result .= ZConvertion::convert($method, $indent + 1);
			}
		}

		$result .= PHP_EOL . indent($indent) . '}';
		return $result;
	}

}
