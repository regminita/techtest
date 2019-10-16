<?php
/**
 * @package	techtest-adapter-service
 * @author	Nita Regmi
 * @created 2019-10-16
 * @description generates the file
 * @todo invoke different file create method based on file type
 */

class File_generation {
	/**
     * File type
     * @var	string
     */
	public $fileType = '';
   /**
	* File Name
	* @var string
	*/
	private $fileName = '';
	/**
     * data to store in a file
     */
	private $data;

	/**
	 * generates the file based on file type
	 * @return void
	 * @throws exception if file type or filename not valid
	 */
	public function generateFile($fileName, $data)
	{
		$this->setFileName($fileName);
		$this->setData($data);
		$this->createFile();

	}

	/**
     * generates the file
     * @return void
     */
	private function createFile()
	{
        $handle = fopen($this->fileName, 'w') or die('Cannot open file:  '.$this->fileName);
        fwrite($handle, $this->data);
	}

	/**
	 * setter for file name
	 * @param string $fileName
	 */
	private function setFileName($fileName)
	{
		if(empty($fileName) ) {
        	throw new Exception("Invalid file name supplied.");
        }
		$this->fileName = $fileName;
	}

	/**
     * setter for file name
     * @param string $fileName
     */
     private function setData($data)
     {
    	$this->data = $data;
     }

}
