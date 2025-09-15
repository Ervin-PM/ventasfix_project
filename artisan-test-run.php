<?php
// Helper script placed at project root: runs phpunit (artisan test) and logs output to storage/logs/test-run.log
chdir(__DIR__);
$cmd = 'php artisan test --filter ApiAuthTest -v 2>&1';
$out = [];
exec($cmd, $out, $exit);
$log = implode("\n", $out);
@file_put_contents(__DIR__ . '/storage/logs/test-run.log', $log);
echo "Logged test output to storage/logs/test-run.log (exit=$exit)\n";
exit($exit);
