<?php

require 'vendor/autoload.php';
use Pheanstalk\Pheanstalk;


$workerNum = 10;

$pool = new Swoole\Process\Pool($workerNum);

$pool->on('WorkerStart',function($pool,$workerId){
  echo 'start';
  $pheanstalk = new Pheanstalk('127.0.0.1',11300);
  while(true){
    $job = $pheanstalk->watch('userReg')->ignore('default')->reserve();
    $data = json_decode($job->getData(),true);
    if($data){
       try{
         print_r($workerId);
         print_r($data);
         $pheanstalk->delete($job);
       }
       catch(Exception $e){
         $pheanstalk->release($job);
         echo 'Error'.$e->getMessage();
       }
    }
  }

});

$pool->on('WorkerStop',function($pool,$workerId){
  echo 'stopped';
});

$pool->start();


