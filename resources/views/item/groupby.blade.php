<?php
$a = array(
    array('Alice', 87, 93, 91),
    array('Bob', 91, 89, 92),
    array('Charlie', 78, 81, 82),
    array('David', 84, 82, 85),
    array('Eve', 97, 98, 96)
);
echo "<pre>";
print_r($a);

$grade="";

foreach ($a as $key => $value)
 {
    $total=array_sum($value);

    echo $total.'<br>'.'<br>';

      $p=array_shift($value);


      print_r($p.'<br>'.'<br>');

     print_r($value);
     
    $sum=count($value);

    echo $sum.'<br>';



    $avg=$total/$sum;

    echo $avg.'<br>';

    if($avg>=90)
    {
        $grade="A";
    }
    else if($avg>=80 && $avg<90)
    {
        $grade="B";
    }
    else
    {
    $grade = "C";
    }

    echo "The Grade= '" . $grade . "'\n\n\n\n";

}

?>




