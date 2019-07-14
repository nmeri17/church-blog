<?php

$words = array('grime', 'dirt', 'grease');
foreach ($words as $word) {
$replacement = array_fill(0, mb_strlen($word), '*');
$wordData[$word] = implode('', $replacement);
}

$bad = array_keys($wordData);
$good = array_values($wordData);

$repl = array_fill(32, mb_strlen('mmay'), 5);
var_dump($repl, $repl[15]);
?>