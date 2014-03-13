<?php
require_once(dirname(__FILE__) . '/../lib/Coinbase.php');

// Create an API key at https://coinbase.com/account/api and set these values accordingly
$_API_KEY = "zmPEjhFNa0lQJL0L";
$_API_SECRET = "eh0cTyTcDkwbe8fdLxcr0dRQJ6O9FJoL";

$coinbase = Coinbase::withApiKey($_API_KEY, $_API_SECRET);
echo 'Balance: ' . $coinbase->getBalance() . '<br>';
echo $coinbase->createButton("Alpaca socks", "10.00", "CAD")->embedHtml;