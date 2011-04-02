<?

/**
* @ Autor: Cesar Reyes
**/

class Folder {
	public static function require_folders($path, $recursive = false) {
		if (is_dir($path)) {
			if ($dh = opendir($path)) {
				while (($file = readdir($dh)) !== false) {
					if (!preg_match("/\.+/", $file) && filetype($path . $file) == 'dir' && $recursive) {
						Folder::require_folders($path . $file . "/", $recursive);
					} else {
						if (preg_match("/\.php$/", $file)) {
							require_once($path . $file);
						}
					}
				}
				closedir($dh);
			}
		}
	}
}

?>
