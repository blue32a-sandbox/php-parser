<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpParser\Error;
use PhpParser\Node;
use PhpParser\NodeDumper;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

class MyNodeVisitor extends NodeVisitorAbstract
{
    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Expr\BinaryOp\Plus) {
            $node->right->value = 3;
        }
    }
}

$code = <<<'CODE'
<?php
$answer = 1 + 2;
CODE;

$parser = (new ParserFactory())->createForHostVersion();
$dumper = new NodeDumper();
$traverser = new NodeTraverser();
$prettyPrinter = new PrettyPrinter\Standard;

$traverser->addVisitor(new MyNodeVisitor);

try {
    $ast = $parser->parse($code);
    $newAst = $traverser->traverse($ast);
    $code = $prettyPrinter->prettyPrintFile($newAst);
    echo $code . "\n";

} catch (Error $error) {
    echo "Parse error: {$error->getMessage()}\n";
    return;
}
