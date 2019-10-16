<?php
/**
 * @package	techtest-adapter-service
 * @author	Nita Regmi
 * @created 2019-10-16
 * @description library to handle data validation
 */
class Data_validation {
	protected $ci;

	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->config('csv_config');
	}

	/**
	 * @desc verifies if email address is valid
	 * @param string $email
	 * @return boolean
	 */
	public function isValidEmail($email)
	{
    	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    	{
           return false;
        }
        return true;
    }

	/**
     * @desc verifies if name string is valid
     * @param string $name
     * @return boolean
     * @todo get the validation rules from config file
     */
    public function isValidName($name)
    {
    	if(empty($name))
    	{
    		return false;
    	}
    	return true;
    }

	/**
     * @desc verifies if name string is valid
     * @param string $password
     * @return boolean
     */
    public function isValidPassword($password)
    {
    	$validationRules = $this->ci->config->item('password_validation_rule');
    	if(isset($validationRules['min_length']) ) {
    		if(strlen(trim($password)) < $validationRules['min_length'])
            {
               return false;
            }
    	}

        return true;
    }

    /**
     * @desc verifies if platforms are valid
     * @param array $platforms
     * @return boolean
     */
    public function isValidPlatform($platforms)
    {
    	$supportedPlatforms = $this->ci->config->item('supported_platform');
        foreach($platforms as $platform) {
        	if(!in_array($platform, $supportedPlatforms))
        			return false;
        }
    	return true;
    }
    /**
     * @desc check if row has valid data
     * @return void
     */
     public function checkValidExtension($file)
     {
    		$fileName = basename($file);
                $fileExtension = pathinfo($fileName,PATHINFO_EXTENSION);

                if($fileExtension !== 'csv') {
                	return false;
                }
                return true;
     }

}
