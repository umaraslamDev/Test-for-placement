<!DOCTYPE html>
<html>
<head>
     <title></title>
</head>
<body>
     <div>

          <form action="solution1.php" method="post">
               <label>SKU</label>
               <input type="text" name="sku" id="sku">
               <button type="submit">Submit</button>
          </form>
         <!--  <?php
          if(isset($_POST['sku'])){
          ?>
          <input type="text" name="newval" value="<?= $_POST['sku']?>" >
          <?php
          }
          ?> -->
     </div>
</body>
</html>


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

class stock 
{
     public $sku;
     public $stock;     
     public $transaction;


     public function setSku($sku){
          if(!is_string($sku)){
               throw new Exception('$sku must be a string!');
          }
          $this->sku = $sku;
     }
    
     public function getSku(){
          return $this->sku;
     }

     public function getStock(){
          $stock = file_get_contents('stock.json');
          return  json_decode($stock,true);
     }

     public function getTransacton(){
          $transaction = file_get_contents('transactions.json');
          return json_decode($transaction,true);
     }

     public function getSkuQuantity($string , $stocks , $transactions){

          $sku=null;
          $quantity =null;
          $total=null;
          $val=null;
          $return_obj=[];
          if(!$string){
               echo "please Enter SKU";
               die;
          }

          foreach($stocks as $product){
               if($product['sku'] == $string){
                    $sku = $product['sku'];
                    $total=$product['stock'];  
               }
          }
          foreach($transactions as $transaction){
          if($transaction['sku'] == $string){
               $quantity = $transaction;
                
               $val =$transaction['qty'];
               if($transaction['type']=='order')
               {
                    $total-=$val;
               }
               elseif ($transaction['type']=='refund') {
                    $total+=$val;
               }
               
               

          }
     }

          $return_obj["sku"] =(isset($sku)) ? $sku : ($quantity["sku"]) ? $quantity["sku"] : null;
          $return_obj["qty"] =(isset($sku)) ? $total : 0;

          if($sku == null && $quantity == null){
               echo "SKU ".$string." not exist";
               die;
          }
          $json_data = json_encode($return_obj,true);
          return $json_data;
     }
     
}    
    
     $stock = new stock();

     if(isset($_POST['sku'])){

          $stock->setSku($_POST['sku']);
          $result = $stock->getSkuQuantity($stock->getSku() , $stock->getStock() , $stock->getTransacton());
          $array_formated = json_decode($result , true);
          
          echo "<h1>".$array_formated['sku']."</h1>";
          echo "<h1>".$array_formated['qty']."</h1>";

     }
     

?> 


