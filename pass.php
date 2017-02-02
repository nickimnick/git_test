<?php

//COMMENT
$slugStr = $_GET['slug'];

echo 'URL -> '.$slugStr.'<br />';

$slgDefs = array(
  'suv' => array('id' => 1, 'group' => 'bdy', 'order' => 1),
  'cabrio' => array('id' => 2, 'group' => 'bdy', 'order' => 3),
  'hatchback' => array('id' => 3, 'group' => 'bdy', 'order' => 2),
  'sedan' => array('id' => 4, 'group' => 'bdy', 'order' => 4),
  'station-wagon' => array('id' => 5, 'group' => 'bdy', 'order' => 5),
  'benzin' => array('id' => 1, 'group' => 'flt', 'order' => 1),
  'dizel' => array('id' => 2, 'group' => 'flt', 'order' => 2),
  'lpg' => array('id' => 3, 'group' => 'flt', 'order' => 3),
  'hibrit' => array('id' => 4, 'group' => 'flt', 'order' => 4),
  'manuel' => array('id' => 1, 'group' => 'trs', 'order' => 1),
  'otomatik' => array('id' => 2, 'group' => 'trs', 'order' => 2)
);

$curr = array('bdy' => array(), 'flt' => array(), 'trs' => array());
$real = array('slug' => array(), 'qs' => '');
$slug = explode('-', $slugStr);
$filterCheck = TRUE;
$i = 0;
$l = count($slug);

while($i < $l){
  
  if(isset($slgDefs[$slug[$i]])){

    $curr[$slgDefs[$slug[$i]]['group']][$slgDefs[$slug[$i]]['order']] = $slgDefs[$slug[$i]];
    $curr[$slgDefs[$slug[$i]]['group']][$slgDefs[$slug[$i]]['order']]['slug'] = $slug[$i];
    
    $i++;
    
  }elseif(isset($slgDefs[$slug[$i].'-'.$slug[$i+1]])){
    
    $curr[$slgDefs[$slug[$i].'-'.$slug[$i+1]]['group']][$slgDefs[$slug[$i].'-'.$slug[$i+1]]['order']] = $slgDefs[$slug[$i].'-'.$slug[$i+1]];
    $curr[$slgDefs[$slug[$i].'-'.$slug[$i+1]]['group']][$slgDefs[$slug[$i].'-'.$slug[$i+1]]['order']]['slug'] = $slug[$i].'-'.$slug[$i+1];
    
    $i = $i + 2;
  
  }else{
    
    $filterCheck = FALSE;
    
  }
  
}

if($filterCheck){

  foreach($curr as $k => $s){
    
    ksort($curr[$k]);
    
    $temp = '';
    $real['qs'] .= ($real['qs'] == '') ? $k.'=' : '&'.$k.'=';
    
    foreach($curr[$k] as $p){
      $real['slug'][] = $p['slug'];
      $temp .= ($temp == '') ? $p['id'] : ','.$p['id'];
    }
    
    $real['qs'] .= $temp;
    
  }
  
  $real['slug'] = implode('-', $real['slug']);
  
   if($real['slug'] == $slugStr)
    echo 'MATCH';
  else
    echo 'REDIRECT TO -> '.$real['slug'].'<br />';
  
  echo 'QS -> ?'.$real['qs'];
  
}else{
  
  echo '404';
  
}

?>