<?php 
function prime($start , $end)
{
    $count=0;
    $prime_arr=array();
     for ($i = $start; $i <= $end; $i++) 
  { 
    if($i % 2 != 1) continue; 
    $d = 3; 
    $x = sqrt($i); 
    while ($i % $d != 0 && $d < $x) $d += 2; 
        
         
    if((($i % $d == 0 && $i != $d) * 1) == 0) 
    {
        
        $prime_arr[$count]= $i; 
    
        $count++;
    }
  }
    return $prime_arr;
}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $q=$_POST["q"];
    $alpha=$_POST["alpha"];
    $public_key_m=$_POST["public_key"];


$arr=prime(0,$q);
$prime_number= $arr[array_rand($arr)];
    $public_key=fmod(pow($alpha,$prime_number), $q);
    
    $shared_key=fmod(pow($public_key_m,$prime_number) ,$q);
    echo $public_key,"&",$shared_key;
    
}
?>