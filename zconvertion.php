<?php
namespace ZPhalcon;

class ZConvertion
{
	public static function converter($source, $dest, $recurse = true)
	{
		if (is_dir($source)) {
			$dir = opendir($source);
			while (($file = readdir($dir)) !== false) {
				if (in_array($file, ['.', '..'])) {
					continue;
				}

				$sourceFile = $source . DIRECTORY_SEPARATOR . $file;
				$destFile = $dest . DIRECTORY_SEPARATOR . $file;

				if (is_dir($sourceFile)) {
					if ($recurse) {
						static::converter($sourceFile, $destFile, $recurse);
					}
				} else {
					$info = pathinfo($destFile);
					$destPath = $info['dirname'];

					if (!is_dir($destPath)) {
						mkdir($destPath, 0777, true);
					}

					$destFile = $destPath . DIRECTORY_SEPARATOR . $info['filename'] . '.php';

					$content = file_get_contents($sourceFile);
					$result = '<?php' . PHP_EOL;
					$parts = zephir_parse_file($content, $sourceFile);
					foreach ($parts as $part) {
						if ($part == 'error') {
							echo $sourceFile; exit;
						}
						$result .= static::convert($part);
					}
					file_put_contents($destFile, $result);
				}
			}
			closedir($dir);
		}
	}

	public static function convert($source, $indent = 0)
	{
		$converter = str_replace('-', '_', $source['type']);
		$converterName = 'Z' . camelize($converter);
		$converterClass = '\\ZPhalcon\\Convertions\\' . $converterName;
		return $converterClass::convert($source, $indent);
	}

}
