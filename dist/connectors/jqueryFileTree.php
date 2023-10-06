<?php
if( !array_key_exists('HTTP_REFERER', $_SERVER) ) exit('No direct script access allowed');

$root = $_SERVER['DOCUMENT_ROOT'];
if( !$root ) exit("ERROR: Root filesystem directory not set in jqueryFileTree.php");

$postDir = rawurldecode($root.(isset($_POST['dir']) ? $_POST['dir'] : null ));

// set checkbox if multiSelect set to true
$checkbox = ( isset($_POST['multiSelect']) && $_POST['multiSelect'] == 'true' ) ? "<input type='checkbox' />" : null;
$onlyFolders = ( isset($_POST['onlyFolders']) && $_POST['onlyFolders'] == 'true' ) ? true : false;
$onlyFiles = ( isset($_POST['onlyFiles']) && $_POST['onlyFiles'] == 'true' ) ? true : false;

if( file_exists($postDir) ) {

	$files		= scandir($postDir);
	$returnDir	= substr($postDir, strlen($root));

	natcasesort($files);

	if( count($files) > 2 ) { // The 2 accounts for . and ..

		echo "<ul class='jqueryFileTree'>";

		foreach( $files as $file ) {
			$htmlRel	= htmlentities($returnDir . $file,ENT_QUOTES);
			$htmlName	= htmlentities($file);
			$ext		= preg_replace('/^.*\./', '', $file);

			if( file_exists($postDir . $file) && $file != '.' && $file != '..' ) {
				if( is_dir($postDir . $file) && (!$onlyFiles || $onlyFolders) ){
					echo "<li class=\"directory collapsed\">
                        <a rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">
                        <i class=\"fa-xl fa-regular fa-folder\"></i>
                         " . htmlentities($file) . "
                         </a>
                      </li>";
				}
				else if (!$onlyFolders || $onlyFiles){
					$documentExtensions = ['doc', 'dot', 'dotx', 'wbk', 'docx', 'docm', 'docb', 'wll', 'wwl'];
					$excelExtensions = ['xls', 'xlt', 'xlm', 'xll_', 'xla_', 'xla5', 'xla8', 'xlsx', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xlam', 'xll', 'xlw'];
					$powerpointExtensions = ['ppt', 'pot', 'pps', 'ppa', 'ppam', 'pptx', 'pptm', 'potx', 'potm', 'ppsx', 'sldx', 'pa', 'sldm', 'pa'];
					$videoExtensions = ['mp4', 'mov', 'avi', 'wmv', 'mkv'];
					$imageExtensions = ['jpg', 'png', 'gif', 'webp', 'tiff', 'psd', 'raw', 'bmp', 'heif', 'indd', 'svg', 'ai', 'eps','tif'];
					$zipExtensions = ['zip', 'rar', 'tar', 'gz', '7z'];
					$audioExtensions = ['mp3', 'wav', 'aiff', 'falc', 'aac', 'ogg','m4a'];
					$codeExtensions = ['php', 'html', 'css', 'js', 'py', 'ini','xml'];
					$emailmsgExtensions = ['msg'];
					$txtExtensions = ['txt'];

					if (in_array($ext, array('pdf'))) {
						$ext = 'fa-regular fa-file-pdf';
					}
					elseif (in_array($ext, $documentExtensions)) {
						$ext = 'fa-regular fa-file-word';
					}
					elseif (in_array($ext, $excelExtensions)) {
						$ext = 'fa-regular fa-file-excel';
					}
					elseif (in_array($ext, $powerpointExtensions)) {
						$ext = 'fa-regular fa-file-powerpoint';
					}
					elseif (in_array($ext, $videoExtensions)) {
						$ext = 'fa-regular fa-file-video';
					}
					elseif (in_array($ext, array('db'))) {
						$ext = 'fa-solid fa-database';
					}
					elseif (in_array($ext, $imageExtensions)) {
						$ext = 'fa-regular fa-file-image';
					}
					elseif (in_array($ext, $zipExtensions)) {
						$ext = 'fa-regular fa-file-zipper';
					}
					elseif (in_array($ext, array('csv'))) {
						$ext = 'fa-solid fa-file-csv';
					}
					elseif (in_array($ext, $codeExtensions)) {
						$ext = 'fa-regular fa-file-code';
					}
					elseif (in_array($ext, $txtExtensions)) {
						$ext = 'fa-regular fa-file-lines';
					}
					elseif (in_array($ext, $audioExtensions)) {
						$ext = 'fa-regular fa-file-audio';
					}
					elseif (in_array($ext, $emailmsgExtensions)) {
						$ext = 'fa-regular fa-envelope';
					}
					else {
						$ext = 'fa-regular fa-file';
					}
					echo "<li><a rel='" . $htmlRel . "'><i class=\"fa-fw fa-xl $ext\"></i>  " . $htmlName . "</a></li>";
				}
			}
		}

		echo "</ul>";
	}
}

?>
