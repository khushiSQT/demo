<?php

$cart = array(
    array('id' => 'p001', 'name' => 'Product 1', 'price' => 10.99, 'quantity' => 2),
    array('id' => 'p002', 'name' => 'Product 2', 'price' => 25.50, 'quantity' => 1),
    array('id' => 'p003', 'name' => 'Product 3', 'price' => 8.75, 'quantity' => 4)
);

echo "<pre>";
print_r($cart);
$new=[];
foreach ($cart as $key => $value) {
    echo '<pre>';
    //print_r($value['price']);

    echo '<pre>';
    $new[$key]=$value['price'];

    echo '<pre>';

}

   $a=array_sum($new);
   print_r($a);//sum

   echo '<pre>';
   $count=count($new);
   print_r($count);//count

   echo '<pre>';
   $avg=$a/$count;
   print_r($avg);


    echo "<pre>";
    print_r($cart);
    print_r($avg);

?>
