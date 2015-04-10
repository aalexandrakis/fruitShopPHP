<?php
echo "<h2>Test e-shop</h2>";
echo getenv('FRUITSHOP_URL');
header('Location: '.getenv('FRUITSHOP_URL').'fruit-e-shop');
?>