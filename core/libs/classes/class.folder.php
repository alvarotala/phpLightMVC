<?

/**
* @ Autor: Cesar Reyes
**/

class Folder {
	public static function require_folders($path, $recursive = false) {
		if (is_dir($path)) {
			if ($dh = opendir($path)) {
				while (($file = readdir($dh)) !== false) {
					if (!ereg('\.+', $file) && filetype($path . $file) == 'dir' && $recursive) {
						Folder::require_folders($path . $file . "/", $recursive);
					} else {
						if (ereg('\.php$', $file)) {
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
