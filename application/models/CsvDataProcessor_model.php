<?php
/**
 * @package	techtest-adapter-service
 * @author	Nita Regmi
 * @created 2019-10-16
 * @description model to handles csv data processing business logic
 */
class CsvDataProcessor_model extends CI_Model{
        private $csvData;
        private $csvHeaders;
        private $csvDataArray = array();
        private $successRecord = array();
        private $failureRecord = array();
		private $outputFileLocation = "";
		private $outputFileFormat = "";

		public function  __construct() {
			$this->load->library('data_validation');
			$this->load->library('File_generation');
			$this->load->helper('My_file_helper');
		}

		/**
		 * @desc defines steps to process CSV data
		 * @param string $file
		 * @return void
		 */
		public function processCSVData($file) {

			//uses My_file_helper
			$isValidExtension = check_valid_extension($file, 'csv');
			if(!$isValidExtension)
			{
				throw new Exception("Incorrect file format. Only csv files are allowed");
			}
			// read csv file
			$this->csvData = $this->readCSVFile($file);
			// format header
			$this->csvHeaders = $this->getFormattedCSVHeader();

			// get csvData as associative array
			$this->csvDataArray = $this->getDataAsAssociativeArray();

			$this->filterSuccessRows();

			$successFilePath = $this->config->item('success_record_output_path');
			$this->file_generation->generateFile($successFilePath, json_encode($this->successRecord));

			$errorFilePath = $this->config->item('error_record_output_path');
			$this->file_generation->generateFile($errorFilePath, json_encode($this->failureRecord));
		}

		/**
         * @desc read csv file
         * @param string $file
         * @return array
         */
        public function readCSVFile($file)
        {
              return array_map('str_getcsv', file($file));
        }

		/**
         * @desc converts csv header to lowercase - snake case format
         * @return array - formatted header
         */
        private function getFormattedCSVHeader()
        {
        	$csvHeaders = array_shift($this->csvData);
        	$lowerCaseSnakeCaseHeader = array();
            foreach($csvHeaders as $header)
            {
               // to lower case
               $lowercaseHeader = explode(' ',strtolower($header));
               // to snake case
               $lowerCaseSnakeCaseHeader[] = implode('_', $lowercaseHeader);
           	}
            return $lowerCaseSnakeCaseHeader;
        }

		/**
		 * convert csv data to key value pair with header
		 * @return array $csv
		 */
		public function getDataAsAssociativeArray()
		{
			$csv = array();
            foreach($this->csvData as $row)
            {
            	$csv[] = array_combine($this->csvHeaders, $row);
            }

			return $csv;
		}

		/**
		 * @desc filter rows by success or failure to import data
		 * @return void
		 */
		private function filterSuccessRows()
		{
            foreach($this->csvDataArray as $key=>$record) {
				if (array_key_exists('platforms', $record))
				{
                	$record['platforms'] = explode(',', $record['platforms']);
                }
				if(!$this->isValidRecord($record))
				{
					 $this->failureRecord[] = $record;
				}
				else
				{
					$this->successRecord[] = $record;
				}

             }
		}

		/**
         * @desc check if row has valid data
         * @param array $record
         * @return boolean
         * @todo check mandatory field using config
         */
		private function isValidRecord($record)
		{
			if(!$this->data_validation->isValidEmail($record['email']) ||
			!$this->data_validation->isValidName($record['first_name']) ||
			!$this->data_validation->isValidName($record['last_name']) ||
			!$this->data_validation->isValidPassword($record['password']) ||
			!$this->data_validation->isValidPlatform($record['platforms'])
            )
            {
            	return false;
            }
            return true;
		}

		/**
         *@desc returns records that passed the validation
         *@return array successRecord
         */
		public function getSuccessRecord()
		{
			return $this->successRecord;
		}

		/**
         *@desc returns records that failed the validation
         *@return array failureRecord
         */
		public function getFailedRecord()
		{
			return $this->failureRecord;
		}

		/**
		 *@desc returns total number of rows in csv file
		 *@return int count
		 */
		public function getTotalRows()
        {
        	return count($this->csvDataArray);
        }

}

?>
