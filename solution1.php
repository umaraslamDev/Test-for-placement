<?php


// You are given two json files:
// - stock.json: contains objects which represent the starting stock levels for given SKUS
// - transactions.json: contains an array of transactions since the stock levels were recorded in `stock.json`
// The objective is to create a function which is able to return the current stock levels for a given SKU by combining the data in these two files. These are the requirements.
// - The function must match the following signature: `(sku: string) => { sku: string, qty: number }`.
// - The function must read from the `stock` and `transactions` files on each invocation (totals cannot be precomputed)
// - The function must throw an error where the SKU does not exist
// Notes:
// - Transactions may exist for SKUs which are not present in `stock.json`. It should be assumed that the starting quantity for these is 0.

$stock = file_get_contents('stock.json');
$json_data = json_decode($stock,true);
$transaction = file_get_contents('transactions.json');
$json_data1 = json_decode($transaction,true);


check("DOK019240/66/49"); // here we will pass SKU

function check($string){

     global $json_data, $json_data1;
     $sku=null;
     $quantity =null;
     $total=null;
     $val=null;
     $stock=null;

     $return_obj=[];
     if(!$string){
          echo "please Enter SKU";
          die;
     }

     foreach($json_data as $product){
          if($product['sku'] == $string){
               $sku = $product['sku'];
               $stock=$product['stock']; 
          }
     }
     foreach($json_data1 as $transaction){
          if($transaction['sku'] == $string){
               $quantity = $transaction;
                
               $val =$transaction['qty'];
               if($transaction['type']=='order')
               {
                    $stock+=$val;
               }
               elseif ($transaction['type']=='refund') {
                    $stock-=$val;
               }
               
               

          }
     }

     $return_obj["sku"] =(isset($sku)) ? $sku : ($quantity["sku"]) ? $quantity["sku"] : null;
     $return_obj["qty"] =(isset($sku)) ? $stock : 0;

     if($sku == null && $quantity == null){
          echo "SKU ".$string." not exist";
          die;
     }
     $json_data = json_encode($return_obj,true);
     echo $json_data;
}

?>  