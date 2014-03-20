
<head>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <div id="header">
    <h1>BTC manager</h1>
    <h4>Based on <a href="https://coinbase.com/" target="_blank"> <span class='coin'>coinbase</span></a></h4>

<?php

    date_default_timezone_set('America/Los_Angeles');
    $date = date('F d, Y h:i:s a', time());
    echo "<h5>".$date;
        
?>

    <hr style="color:white;"></hr>
    </div>
</head>
