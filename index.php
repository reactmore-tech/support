<?php


require 'vendor/autoload.php';


// $key     = new \ReactMoreTech\Cloudflare\Auth\APIKey('user@example.com', 'apiKey');
// $adapter = new \ReactMoreTech\Cloudflare\Adapter\Guzzle($key);



$key = \ReactMoreTech\Cloudflare\Config\Services::cloudflare();
var_dump($key);
// var_dump($key->User()->getUserID([]));
die;
