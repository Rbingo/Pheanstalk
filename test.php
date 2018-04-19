<?php

// Hopefully you're using Composer autoloading.

include './vendor/autoload.php';

use Pheanstalk\Pheanstalk;

try {
    $pheanstalk = new Pheanstalk('127.0.0.1');
} catch (Exception $e) {
    echo 222;
    var_dump($e);
    die;
}
//var_dump($pheanstalk->getConnection()->isServiceListening());
echo 111;die;


// ----------------------------------------
// producer (queues jobs)

$pheanstalk
    ->useTube('testtube')
    ->put("job payload goes here\n");

// ----------------------------------------
// worker (performs jobs)

$job = $pheanstalk
    ->watch('testtube')
    ->ignore('default')
    ->reserve();

echo $job->getData();

$pheanstalk->delete($job);

// ----------------------------------------
// check server availability

$pheanstalk->getConnection()->isServiceListening(); // true or false