<?php
require_once './inc/poche/Tools.class.php';
include dirname(__FILE__).'/inc/poche/config.inc.php';

header('Content-Type: text/cache-manifest');
echo "CACHE MANIFEST\n";

$hashes = "";
echo './?view=home' . "\n";
echo './?view=fav' . "\n";
echo './?view=archive' . "\n";
echo 'tpl/css/knacss.css' . "\n";
echo 'tpl/css/style.css' . "\n";
echo 'tpl/css/style-light.css' . "\n";
echo 'tpl/css/print.css' . "\n";
echo 'tpl/img/favicon.ico' . "\n";
echo 'tpl/img/logo.png' . "\n";
echo 'tpl/img/light/backtotop.png' . "\n";
echo 'tpl/img/light/checkmark-off.png' . "\n";
echo 'tpl/img/light/checkmark-on.png' . "\n";
echo 'tpl/img/light/down.png' . "\n";
echo 'tpl/img/light/envelop.png' . "\n";
echo 'tpl/img/light/flattr.png' . "\n";
echo 'tpl/img/light/left.png' . "\n";
echo 'tpl/img/light/remove.png' . "\n";
echo 'tpl/img/light/shaarli.png' . "\n";
echo 'tpl/img/light/star-off.png' . "\n";
echo 'tpl/img/light/star-on.png' . "\n";
echo 'tpl/img/light/top.png' . "\n";
echo 'tpl/img/light/twitter.png' . "\n";
echo 'tpl/js/jquery-2.0.3.min.js' . "\n";

$entries = $poche->store->getEntriesByView('all', 0);
foreach ($entries as $key => $entry) {
    $url = 'index.php?view=view&id=' . $entry['id'];
    echo $url . "\n";
    $hashes .= md5($url);
}

echo "# Hash: " . md5($hashes) . "\n";

echo 'FALLBACK:' . "\n";
echo '/ offline.html' . "\n";

echo 'NETWORK:' . "\n";
echo '*' . "\n";