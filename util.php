<?php

function camelize($s, $sep = '_')
{
	$s = str_replace($sep, " ", strtolower($s));
	return ltrim(str_replace(" ", "", ucwords($s)), $sep);
}

function uncamelize($s, $sep = '_')
{
	return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $sep . "$2", $s));
}

function indent($n = 0)
{
	$result = '';
	for ($i = 0; $i < $n; $i++) {
		$result .= "\t";
	}
	return $result;
}

function memstr($haystack, $needle, $offset = 0)
{
	return strpos($haystack, $needle, $offset = 0);
}

function starts_with($string , $starts) {
	return substr($string, 0, strlen($starts)) == $starts;
}

function ends_with($string , $ends)
{
	return substr($string, -strlen($ends)) == $ends;
}

function apc_fetch() {

}

function apc_store() {

}

function apcu_fetch() {

}

function apcu_store() {

}

function prepare_virtual_path() {

}

function xcache_get() {

}

function xcache_set() {

}

function phannot_parse_annotations() {

}

function phalcon_cssmin() {

}

function phalcon_jsmin() {

}

function compare_mtime() {

}

function apc_inc() {

}

function apc_dec() {

}

function apc_delete() {

}

function iterator() {

}

function apc_exists() {

}

function apcu_inc() {

}

function apcu_dec() {

}

function apcu_delete() {

}

function apcu_exists() {

}

function xcache_isset() {

}

function xcache_inc() {

}

function xcache_dec() {

}

function xcache_unset() {

}

function igbinary_serialize() {

}

function igbinary_unserialize() {

}

function msgpack_pack() {

}

function msgpack_unpack() {

}

function get_class_ns() {

}

function get_ns_class() {

}

function yaml_parse_file() {

}

function hash_hmac_algos() {

}

function globals_get() {

}

function customFunction() {

}

function globals_set() {

}

function create_instance_params() {

}

function phalcon_is_basic_charset() {

}

function phalcon_escape_css() {

}

function phalcon_escape_js() {

}

function get_class_lower() {

}

function unique_key() {

}

function phalcon_orm_destroy_cache() {

}

function phql_parse_phql() {

}

function phalcon_orm_singlequotes() {

}

function phalcon_get_uri() {

}

function phalcon_replace_paths() {

}

function unique_path_key() {

}

function phvolt_parse_view() {

}

function create_symbol_table() {

}

function yaml_parse() {

}

function convert() {

}
