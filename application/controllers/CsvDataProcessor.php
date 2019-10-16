<?php
/**
 * @package	techtest-adapter-service
 * @author	Nita Regmi
 * @created 2019-10-16
 * @description handles csv data processing
 */
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class CsvDataProcessor extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->config('csv_config');
        $this->load->model('CsvDataProcessor_model', 'csvModel');
	}

	/**
	 * @desc method to handle csv data processing
	 * @param string file - csv file uploaded
	 * @return void
	 */
	public function processCSVData_post()
	{
		$file = isset($_POST['filepath']) ? $_POST['filepath'] : '';

		if(!isset($file) || $file == '') {
			$file = $this->config->item('default_input_file');
		}
		$successExports = array();
		$this->csvModel->processCSVData($file);
		$result = $this->getProcessedResult();

		$this->response($result);
	}

	/**
     * @desc responds with the pass/fail records in JSON Format
     * @return array
     */
	private function getProcessedResult()
	{
		$successRecord = $this->csvModel->getSuccessRecord();
        $failureRecord = $this->csvModel->getFailedRecord();

      	$successFilePath = $this->config->item('success_record_output_path');
        $errorFilePath  = $this->config->item('error_record_output_path');

        $result["total_rows"] = $this->csvModel->getTotalRows();
        $result["success_rows"] = count($successRecord);
        $result["error_rows"] =  count($failureRecord);

        if(file_exists($successFilePath))
        {
			 $result["success_file_path"] = $successFilePath;
        }

		if(file_exists($errorFilePath))
        {
        	$result["error_file_path"] = $errorFilePath;
        }
		return $result;
	}
}


?>
