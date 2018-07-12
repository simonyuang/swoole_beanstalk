<?php

require 'vendor/autoload.php';

use Pheanstalk\Pheanstalk;

$pheanstalk = new Pheanstalk('127.0.0.1',11300);

#print_r($pheanstalk->stats());die;

$data = array('id'=>1,'name'=>'test'.time().rand(1000,9999));

$id = $pheanstalk->useTube('userReg')->put(
json_encode($data),
1024,10
);

#$job = $pheanstalk->peek($id);

print_r($id);


