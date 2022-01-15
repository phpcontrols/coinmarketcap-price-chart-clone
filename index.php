<?php
// crypto icons
// http://cryptoicons.co/

// sample and historical data
// coinmarketcap.com

// Binance websocket trade stream API
https://docs.binance.org/api-reference/dex-api/ws-streams.html

use phpCtrl\C_DataGrid;

require_once("phpGrid/conf.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>phpGrid | CoinMarketCap.com Clone</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/app.css" type="text/css" />
</head>
<body>

<h1>Coinmarketcap.com Price Chart Clone</h1>

<?php
$url = "data/coinmarket_top10.json";
$data = file_get_contents($url);
$json_output = json_decode($data, true);


$dg = new C_DataGrid($json_output, "id", "CoinMarket");

// more readable column names
$dg->set_col_title('Percentage24H', '24h %');
$dg->set_col_title('Percentage7D', '7d %');
$dg->set_col_title('MarketCap', 'Market Cap');
$dg->set_col_title('Volume24H', 'Volume(24h)');
$dg->set_col_title('CirculatingSupply', 'Circulating Supply');
$dg->set_col_title('Last7Days', 'Last 7 Days');


// hide columns not showing
$dg->set_col_hidden("Coin");
$dg->set_col_hidden("MaxSupply");

$dg->set_theme('bootstrap');

// remove caption
$dg->set_caption(false);

$dg->enable_rownumbers(true);

// align numbers
$dg->set_col_align('Price', 'right');
$dg->set_col_align('Percentage24H', 'right');
$dg->set_col_align('Percentage7D', 'right');
$dg->set_col_align('MarketCap', 'right');
$dg->set_col_align('Volume24H', 'right');
$dg->set_col_align('CirculatingSupply', 'right');


// price formatter
$dg->set_col_currency('Price', '$');
$dg->set_col_currency('MarketCap', '$');
$dg->set_col_currency('Volume24H', '$');
$dg->set_col_currency('CirculatingSupply', '');

// column style
$dg->set_col_property('Coin', array('classes'=>'coin'));
$dg->set_col_property('Name', array('classes'=>'name'));

// row color and hightlight
$dg -> set_row_color('white', 'white', 'white');

// currency sort fix (default string type)
$dg -> set_col_property("Price",  array("sorttype"=>"currency")); 
$dg -> set_col_property("MarketCap",  array("sorttype"=>"currency"));
$dg -> set_col_property("Volume24H",  array("sorttype"=>"currency")); 
$dg -> set_col_property("CirculatingSupply",  array("sorttype"=>"integer")); 

// custom formatter (icon name symbol)
$dg->set_col_property('Name', array('formatter'=>'###nameFormatter###')); // must have ###
$dg->set_col_property('Volume24H', array('formatter'=>'###volumeFormatter###')); // must have ###
$dg->set_col_property('CirculatingSupply', array('formatter'=>'###circulatingSupplyFormatter###')); // must have ###
$dg->set_col_property('Last7Days', array('formatter'=>'###last7DaysFormatter###')); // must have ###
$dg->set_col_property('Percentage24H', array('formatter'=>'###percentageChangeFormatter###')); // must have ###
$dg->set_col_property('Percentage7D', array('formatter'=>'###percentageChangeFormatter###')); // must have ###


// use tick symbol as key 
$dg->set_sql_key('Coin');

// responsive grid
$dg -> enable_autowidth(true);

$dg -> display();
?>



<script src="js/app.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js" type="text/javascript"></script>

</body>
</html>