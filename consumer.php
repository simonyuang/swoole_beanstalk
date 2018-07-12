<?php

require 'vendor/autoload.php';

use Pheanstalk\Pheanstalk;

$pheanstalk = new Pheanstalk('127.0.0.1',11300);

#$i = 0;

//$job = $pheanstalk->watch('userReg')->ignore('default')->reserve();

//$data = json_decode($job->getData(),true);

//print_r($data);

//$pheanstalk->delete($job);

while(true){
   #sleep(1);
   #$i++;
   $job = $pheanstalk->watch('userReg')->ignore('default')->reserve();
   
   //if(!$job){
   //   sleep(1);
   //   continue;
   //}
   $data = json_decode($job->getData(),true);
   #print_r($data);
   if($data){
      try{
      	print_r($data);
      	$pheanstalk->delete($job);
        //sleep(1);
      }
      catch(Exception $e){
         $pheanstalk->release($job);
     	 echo 'Error'.$e->getMessage();
     	 #$job->release($job);
      }
   }
   #if($i%30==0){
   #   sleep(1);
   #}
   sleep(1);
}





