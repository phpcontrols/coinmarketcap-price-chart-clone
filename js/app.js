function percentageChangeFormatter (cellValue, options, rowData) {
    if (cellValue==0) return 'N/A';

    return (cellValue.indexOf('-') >= 0)  ? `<span style="color:red">${cellValue}</span>` : `<span style="color:green">${cellValue}</span>`;
}


function nameFormatter (cellValue, options, rowData){

    if (cellValue==0) return 'N/A';

    return `<img src="images/icons/${rowData['Coin']}.png" class="iconImg" />  ${cellValue}  <span class="symbol">${rowData['Coin']}</span>`; 

}

function volumeFormatter (cellValue, options, rowData){

    if (cellValue==0) return 'N/A';

    let volume24hTotalCoin = parseInt(rowData['Volume24H']/rowData['Price']);

    return `$${rowData['Volume24H'].toLocaleString(undefined,{})}
            <span class="volume24hTotalCoin">${volume24hTotalCoin.toLocaleString(undefined,{})} ${rowData['Coin']}</span>`; 

}

function circulatingSupplyFormatter (cellValue, options, rowData){

    if (cellValue==0) return 'N/A';

    let volume24hTotalCoin = parseInt(rowData['Volume24H']/rowData['Price']);

    if (!!rowData['MaxSupply']) {

        const percentageOfMaxSupply = parseInt((cellValue/rowData['MaxSupply']) * 100);

        return `<span class="circulating-supply">${cellValue.toLocaleString(undefined,{})}  ${rowData['Coin']}</span>` + 
               `<div width="160" class="maxsupply-bar" title="Percentage: ${percentageOfMaxSupply}% of Max Supply of ${rowData['MaxSupply']}"><div style="width:${percentageOfMaxSupply}px" class="percentage-of-maxsupply"></div></div>`; 

    }
    
    return `${cellValue.toLocaleString(undefined,{})}`; 

}

// make sparkline
function last7DaysFormatter (cellValue, options, rowData){

    if (cellValue==0) return 'N/A';

    let lineColor = (rowData['Percentage7D'].indexOf('-') >= 0) ? 'red' : 'green';

    return `<span class="sparklines" sparkLineColor="${lineColor}" values="${JSON.parse(cellValue).join()}"></span>`;

}

// real time data via Websocket  
$(document).ready(function(){    

    // apply sparkline
    $('.sparklines').sparkline('html', { enableTagOptions: true, fillColor:false, lineWidth:2, width:'100%', height:'50px' });

    let coins = ['BTC', 'ETH', 'BNB', 'USDT', 'SOL', 'ADA', 'XRP', 'DOT', 'USDC', 'DOGE'];

    coins.forEach(function(coin){

        var wss = new WebSocket(`wss://stream.binance.com:9443/ws/${coin.toLowerCase()}usdt@trade`);

        wss.onmessage = function (event) {
            var messageObject = JSON.parse(event.data)   
            $("#CoinMarket").jqGrid("setCell", coin, "Price", (messageObject.p));
        }

    })
})