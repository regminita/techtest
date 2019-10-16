<?php
	$config['default_input_file'] = FCPATH."sample_users.csv";
	$config['supported_platform'] = array('ios', 'android', 'windows', 'web');
    $config['password_validation_rule'] = array('min_length'=>8);

    $config['output_file_location'] = FCPATH;
    $config['output_file_format'] = "json";

    $config['success_record_output_file'] = "sample_users_successful";
    $config['failure_record_output_file'] = "sample_users_failure";

    $config['success_record_output_path'] = $config['output_file_location'].''.$config['success_record_output_file'] .'.'.$config['output_file_format'];
    $config['error_record_output_path'] = $config['output_file_location'].''.$config['failure_record_output_file'] .'.'.$config['output_file_format'];


?>
