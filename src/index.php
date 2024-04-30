<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpParser\Error;
use PhpParser\Node;
use PhpParser\NodeDumper;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;

class MyNodeVisitor extends NodeVisitorAbstract
{
    private int $level = 0;

    public function enterNode(Node $node)
    {
        echo str_repeat('  ', $this->level) . '-> ' . $node->getType() . "\n";
        $this->level++;
    }

    public function leaveNode(Node $node)
    {
        $this->level--;
        echo str_repeat('  ', $this->level) . '<- ' . $node->getType() . "\n";
    }
}

$code = <<<'CODE'
<?php
$answer = 1 + 2;
CODE;

$parser = (new ParserFactory())->createForHostVersion();
$dumper = new NodeDumper();
$traverser = new NodeTraverser();

$traverser->addVisitor(new MyNodeVisitor);

try {
    $ast = $parser->parse($code);
    echo $dumper->dump($ast) . "\n";
    echo "\n";

    $traverser->traverse($ast);

} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}
