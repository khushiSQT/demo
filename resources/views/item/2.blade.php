<?php

$library = array(
    array('artist' => 'Bob Dylan', 'album' => 'Highway 61 Revisited', 'year' => 1965),
    array('artist' => 'The Beatles', 'album' => 'Sgt. Pepper\'s Lonely Hearts Club Band', 'year' => 1967),
    array('artist' => 'Pink Floyd', 'album' => 'The Wall', 'year' => 1979),
    array('artist' => 'Led Zeppelin', 'album' => 'IV', 'year' => 1971),
    array('artist' => 'The Rolling Stones', 'album' => 'Exile on Main St.', 'year' => 1972)
);
echo "<pre>";
print_r($library);


echo "<pre>";
    $q=[];
foreach ($library as $key => $value) {
    print_r($value['year']);



        $abc=sort($value);
        echo "<pre>";
        print_r($abc);
}


?>
<?php

$schedule = array(
    'Monday' => array('class1' => 'Math', 'class2' => 'English', 'class3' => 'Science'),
    'Tuesday' => array('class1' => 'History', 'class2' => 'Math', 'class3' => 'Art'),
    'Wednesday' => array('class1' => 'Science', 'class2' => 'English', 'class3' => 'Math'),
    'Thursday' => array('class1' => 'Art', 'class2' => 'Science', 'class3' => 'History'),
    'Friday' => array('class1' => 'English', 'class2' => 'History', 'class3' => 'Art')
);


echo "<pre>";
print_r($schedule);
?>
