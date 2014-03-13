<!DOCTYPE html>
<html>
<head>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="header">
<h1>BTC manager</h1>
<h4>Based on <span class='coin'>coinbase</span></h4>
</div>

<?php
#$page = $_SERVER['PHP_SELF'];
#$sec = "5";
#header("Refresh: $sec; url=$page");
date_default_timezone_set('America/Los_Angeles');
require_once("/Users/shahm6/Sites/mybtc/coinbase-php/lib/Coinbase.php");
echo "<hr></hr>";
$api_key="zmPEjhFNa0lQJL0L";
$api_secret="eh0cTyTcDkwbe8fdLxcr0dRQJ6O9FJoL";

$coinbase=Coinbase::withApiKey($api_key,$api_secret);

$balance = $coinbase->getBalance();

echo "<br>Current Balance: $". $balance." BTC";
#echo 'Balance: ' . $coinbase->getBalance() . '<br>';

$val=getCurrentValue($coinbase);
echo "<br>Current Value: $".$val;

function getCurrentValue($coinbase)
{
    $x = $coinbase->getSellPrice('1');
    $bal = $coinbase->getBalance();
    $val = $x * $bal;
    return $val;
}


$sell_price = getCurrentSellPrice($coinbase);
echo "<br>Sell Price: $".$sell_price;

function getCurrentSellPrice($coinbase)
{
    
    return $coinbase->getSellPrice('1');
}

$buy_price=getCurrentBuyPrice($coinbase);
echo "<br>Buy Price: $".$buy_price;

function getCurrentBuyPrice($coinbase)
{    
    #echo "<br>This price includes Coinbase's fee of 1% and the bank transfer fee of $0.15.<br>";

    return $coinbase->getBuyPrice('1');
}

#getTransactions($coinbase);

function getTransactions($coinbase)
{
    echo "<br>";
    $response = $coinbase->getTransactions();
    echo "Number of transactions you have made so far : ".$response->total_count;
    echo "<br>1st Transaction reported on : ".$response->transactions[0]->created_at;
    echo "<br>1st Transaction amount is : ".$response->transactions[0]->amount->amount;

    echo "<pre>";
    var_dump($response);
    echo "</pre>";
}


dispTransactions($coinbase);

function dispTransactions($coinbase)
{
    # 
    $response = $coinbase->getTransactions();
    $noOfPages= $response->num_pages;
    $noOfTrans = $response->total_count;

    #echo "Number of pages is ".$noOfPages;
    #echo "Number of transactions".$noOfTrans;

    echo "<div id=\"transTable\">";
    echo "<br>Your transaction history till now";
    echo "<table>";
    #$tableHeader = "<tr><th>No</th><th>Date</th><th>Amount</th><th>Sell/Buy</th><th>Status</th><th>Notes</th></tr>";
    $tableHeader = "<tr><th>No</th><th>Date</th><th>Amount</th><th>Status</th><th>Notes</th></tr>";
    echo $tableHeader;
    
    for ( $i=1; $i<=$noOfPages; $i++)
    {

        $response = $coinbase->getTransactions($i);
        $tCount = count($response->transactions);
       
        for ( $j=0; $j<$tCount; $j++)
        {   

            $id = $j+1;
            $tmp_date = $response->transactions[$j]->created_at;
            $date = format_date($tmp_date);
            $amount = $response->transactions[$j]->amount->amount;
            #$request = $response->transactions[$j]->request; # This logic later from the API webpage
            
            $status = $response->transactions[$j]->status;
            $notes = explode(". ",$response->transactions[$j]->notes);


            #echo "<tr><td>".$id."</td><td>".$date."</td><td>".$amount."</td><td>".$request."</td><td>".$status."</td><td>".$notes[0]."</td></tr>";
            echo "<tr><td>".$id."</td><td>".$date."</td><td>".$amount."</td><td>".$status."</td><td>".$notes[0]."</td></tr>";
            
        }

    }


    echo "</table>";
    echo "</div>";

    #var_dump($response);
}


function format_date($date)
{
    $dt = substr($date, 0,10); # Retrieve the date
    $time = substr($date, 11,8); # Retrieve the time

    $final_dt = $dt." ".$time; # join the two

    return date('F d, Y h:i:s A', strtotime($final_dt));
}

function calculate_difference($coinbase)
{
    # This function will sum all your current BTC transactions and give you an idea of how much will you earn / lose
    # if you sell it now

    # Parse notes of each transaction to get the amount
    # Sum them up

    # Get current value 

    # Print the difference
}
?>

</body>
</html>
