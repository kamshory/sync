<?php
namespace Sync;

class FileUpload
{
    private string $applicationDir = "";
    private string $baseDir = "";
    private array $filterBaseDir = array(
        "media.edu",
        "lib.sync"
    );
    public function __construct($applicationDir, $baseDir, $filterBaseDir = null)
    {
        $applicationDir = $this->trimPath($applicationDir);
        $baseDir = $this->trimPath($baseDir);
        $this->applicationDir = $applicationDir;
        $this->baseDir = $baseDir;
        if(isset($filterBaseDir) && is_array($filterBaseDir))
        {
            $this->filterBaseDir = $filterBaseDir;
        }
    }   

    private function trimPath($baseDir)
    {
        $baseDir = str_replace("\\", "/", $baseDir);
        $arr = explode("/", $baseDir);
        if(count($arr) > 2 && substr($baseDir, strlen($baseDir) - 1) == "/")
        {
            $baseDir = substr($baseDir, 0, strlen($baseDir) - 1);
        }
        return $baseDir;
    }

    private function validPath($relativePath)
    {
        foreach($this->filterBaseDir as $sub)
        {
            if(stripos($relativePath, $sub) === 0)
            {
                return true;
            }
        }
        return false;
    }

    public function getAbsolutePath($relativePath)
    {
        return $this->baseDir . "/" . $relativePath;
    }

    /**
	 * Prepare directory
	 * @param string $dir2prepared Path to be pepared
	 * @param string $dirBase Base directory
	 * @param int $permission File permission
	 * @param bool $sync Flag that renaming file will be synchronized or not
	 * @return void
	 */
	public function prepareDirectory($dir2prepared, $dirBase, $permission)
	{
		$dir = str_replace("\\", "/", $dir2prepared);
		$base = str_replace("\\", "/", $dirBase);
		$arrDir = explode("/", $dir);
		$arrBase = explode("/", $base);
		$base = implode("/", $arrBase);
		$dir2created = "";
		foreach($arrDir as $val)
		{
			$dir2created .= $val;
			if(stripos($base, $dir2created) !== 0 && !file_exists($dir2created))
			{
				$this->createDirecory($dir2created, $permission);
			}
			$dir2created .= "/";
		}
	}

	/**
	 * Create directory
	 * @param string $path Path to be created
	 * @param int $permission File permission
	 * @param bool $sync Flag that renaming file will be synchronized or not
	 * @return bool true on success or false on failure.
	 */
	public function createDirecory($path, $permission)
	{
		return @mkdir($path, $permission);
	}

    public function upload($relativePath, $files)
    {
        $success = false;
        $relativePath = ltrim($relativePath, "/\\");
        if($this->validPath($relativePath) && isset($files['tmp_name']))
        {
            $absolutePath = $this->getAbsolutePath($relativePath);
            $this->prepareDirectory(dirname($absolutePath), $this->applicationDir, 0755);
            if (isset($files['tmp_name'])) {
                $source = $files['tmp_name'];
                $success = @move_uploaded_file($source, $absolutePath);
                if(!$success && file_exists($source))
                {
                    $success = @copy($files['tmp_name'], $absolutePath);
                }
            }
        }
        return $success;
    }
}
