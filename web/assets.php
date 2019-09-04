<?php 
/**
 * Provides functions and global environment variables needed for excecution and using of libaries and modules.
 * 
 * @author JDPDO
 */

/* Init global variables. */
// Init path values
$_GLOBAL['path_root'] = dirname(__DIR__);
$_GLOBAL['path_assets'] = $_GLOBAL['path_root'] . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$_GLOBAL['path_config'] = $_GLOBAL['path_root'] . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
$_GLOBAL['path_lib'] = $_GLOBAL['path_root'] . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
$_GLOBAL['path_modules'] = $_GLOBAL['path_root'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;

/**
 * Enumeration containing configuration types.
 */
class CONFIG_TYPES{ const INI = 0; const JSON = 1; }

/**
 * Provides key value pairs of configuration file.
 * 
 * @todo Return nested arrays, if files configuration content is object like (i.e.: JSON format).
 * 
 * @param string $name Name of the configuration file to use.
 * @param CONFIG_TYPES $type Configuration type of the file.
 * 
 * @return array
 */
function parse_conifg($name, $type = CONFIG_TYPES::INI){
    $file_path = $_GLOBAL['path_config'] . $name;
    $file_configuration;
    switch($type){
        default:
        case CONFIG_TYPES::INI:
            $file_configuration = parse_ini_file($file_path);
            break;
        case CONFIG_TYPES::JSON:
            throw new Exception('Not implemented yet.'); 
            break;
    }
    return $file_configuration;
}

/**
 * Includes all libary files defined in *lib.ini*.
 * 
 * @return void
 */
function include_libs(){
    $used_libs = parse_conifg('lib.ini');
    $item_array = array_diff(scandir($_GLOBAL['path_lib']), array('..', '.'));
    foreach($item_array as $item){
        if(array_key_exists(pathinfo($item)['filename'], $used_libs)) include_lib($item);
    }
}

/**
 * Includes an libary.
 * 
 * @param string $name Name of the libary file to include.
 * 
 * @return void
 */
function include_lib($name)
{
    include($_GLOBAL['path_lib'] . $name);
}

/**
 * Includes all modules defined in *modules.ini*.
 * 
 * @return void
 */
function include_modules(){
    $used_libs = parse_conifg('modules.ini');
    $item_array = array_diff(scandir($_GLOBAL['path_modules']), array('..', '.'));
    foreach($item_array as $item){
        if(array_key_exists(pathinfo($item)['filename'], $used_libs)) include_module($item);
    }
}

/**
 * Includes an module.
 * 
 * @param string $name Name of the file or directory to include.
 * 
 * @return void
 */
function include_module($name)
{
    include($_GLOBAL['path_modules'] . $name);
}

include_libs();
include_assets();
?>