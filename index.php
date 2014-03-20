<!DOCTYPE html>

<?php 

echo "<html>";
echo "<body>";
echo "<div id=\"container\">";
require_once("header.php");
require_once("api_key.php");
require_once("coinbase-php/lib/Coinbase.php");

$page = $_SERVER['PHP_SELF'];
$sec = "15";
header("Refresh: $sec; url=$page");

date_default_timezone_set('America/Los_Angeles');

echo "<div id=\"body\">";

$coinbase=Coinbase::withApiKey($api_key,$api_secret);

$sell_price = getCurrentSellPrice($coinbase);
$buy_price=getCurrentBuyPrice($coinbase);
$balance = $coinbase->getBalance();
$val=getCurrentValue($coinbase);

echo "<p style=\"float:left;margin-left:15%\">Balance: $". $balance." BTC";
echo "&nbsp&nbsp Value: $".$val."</p>";
echo "<p style=\"float:right;margin-right:15%\">";  
echo "&nbsp Sell: $".$sell_price;
echo "&nbsp Buy: $".$buy_price."</p><br>";
echo "<br><hr style=\"border;none;width:75%;color:white;\">";

dispTransactions($coinbase);

function getCurrentSellPrice($coinbase)
{
    #This price includes Coinbase's fee of 1% and the bank transfer fee of $0.15.
    return $coinbase->getSellPrice('1');
}

function getCurrentBuyPrice($coinbase)
{    
    #This price includes Coinbase's fee of 1% and the bank transfer fee of $0.15.
    return $coinbase->getBuyPrice('1');
}

function getCurrentValue($coinbase)
{
    $x = $coinbase->getSellPrice('1');
    $bal = $coinbase->getBalance();
    $val = $x * $bal;
    return $val;
}

function dispTransactions($coinbase)
{
 
    $response = $coinbase->getTransactions();
    $noOfPages= $response->num_pages;
    $noOfTrans = $response->total_count;

    #echo "Number of pages is ".$noOfPages;
    #echo "Number of transactions".$noOfTrans;

    echo "<div id=\"transTable\">";
    
    echo "<table class=\"center\">";
    echo "<caption>Transaction History</caption>";
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
            
            $status = $response->transactions[$j]->status;
            $notes = explode(". ",$response->transactions[$j]->notes);

            echo "<tr><td>".$id."</td><td>".$date."</td><td>".$amount."</td><td>".$status."</td><td>".$notes[0]."</td></tr>";
            
        }

    }


    echo "</table>";
    echo "</div>";

}


function format_date($date)
{
    $dt = substr($date, 0,10); # Retrieve the date
    $time = substr($date, 11,8); # Retrieve the time

    $final_dt = $dt." ".$time; # join the two

    return date('F d, Y h:i:s A', strtotime($final_dt));
}


echo "</div>";
echo "</body>";

require_once("footer.php");

echo "</div>";
echo "</html>";
?>