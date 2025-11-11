<?php
// redirect.php
// IMPORTANT: no output or spaces before this block.

$target = 'https://www.google.com/search?q=alloratv';

// ---------- COUNTER ----------
$counterFile = __DIR__ . '/count.txt';

// Create file if missing
if (!file_exists($counterFile)) {
    file_put_contents($counterFile, "0");
}

// Open and increment safely
$fp = fopen($counterFile, 'c+');
if ($fp) {
    if (flock($fp, LOCK_EX)) {
        $count = (int)stream_get_contents($fp);
        $count++;
        rewind($fp);
        ftruncate($fp, 0);
        fwrite($fp, (string)$count);
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    fclose($fp);
}

// ---------- REDIRECT (same window) ----------
header('Cache-Control: no-store');
header('Location: ' . $target, true, 302);
exit;
