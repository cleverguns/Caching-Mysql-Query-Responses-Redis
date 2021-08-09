<?php
require './vendor/autoload.php';


$redis = new Predis\Client();
$cacheEntry = $redis->get('actor');
$t0 = 0;
$t1 = 0;


if($cacheEntry){
    //displaying result from cache

    echo "From Redis Cache";
    $t0 = microtime(true) * 1000;
    echo $cacheEntry;
    $t1 = microtime(true) * 1000;
    echo 'Time Taken:'. round($t1-$t0,4) ;
    exit();

}
else {
    # connect w/ database, get data - display cache in redis as well
    $conn = new mysqli('localhost:3306', 'root', '', 'dbname' );
    $sql = "Select Fname, Lname, from actor; ";

    $conn->query($sql);

    echo "From Database";

    while ( $row = $result->fetch_assoc()){
        echo $row['Fname'] . '<br>';
        echo $row['Lname'];
        $temp .= $row['Fname'] . ' ' .$row['Lname']  . '<br>';
    }
    $t1 = microtime(true) * 1000;
    echo 'Time Taken:'. round($t1-$t0,4) ;

        $redis->set('actor', $temp);
        $redis->expire('actor', 10);
        exit();



}


?>