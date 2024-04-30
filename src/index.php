<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;

$code = <<<'CODE'
<?php
$answer = 1 + 2;
CODE;

$parser = (new ParserFactory())->createForHostVersion();
$dumper = new NodeDumper();

try {
    $ast = $parser->parse($code);
    echo $dumper->dump($ast) . "\n";

} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}
