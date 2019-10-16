<?php
if ( ! function_exists('check_valid_extension'))
{

	/**
     * @desc check if file has same extension as required
     * @param string $file - filepath
     * @param string extension
     * @return boolean
     */
     function check_valid_extension($file, $extension)
     {
    	$fileName = basename($file);
        $fileExtension = pathinfo($fileName,PATHINFO_EXTENSION);
        if($fileExtension !== $extension) {
           return false;
        }
        return true;
     }
}
?>
