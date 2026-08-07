<?php

/**
 * Fix double-encoded UTF-8 emoji data
 * Uses PHP mb_convert_encoding with Windows-1252 as the intermediate charset.
 * Run: php fix_emoji.php (dry-run) | php fix_emoji.php --apply (execute)
 */

$apply = in_array('--apply', $argv ?? []);

$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=undangan_digital;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Find corrupted rows
$pattern = hex2bin('C3B0'); // The byte sequence C3 B0 (first byte of mojibake ð)
$stmt = $pdo->prepare("SELECT id, deskripsi FROM undangan_cetaks WHERE CAST(deskripsi AS BINARY) LIKE CONCAT('%', ?, '%')");
$stmt->execute([$pattern]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Rows to fix: " . count($rows) . "\n";

if (count($rows) === 0) {
    echo "No corrupted data found.\n";
    exit(0);
}

// Show preview
echo "\n--- Preview ---\n";
foreach (array_slice($rows, 0, 3) as $row) {
    $fixed = mb_convert_encoding($row['deskripsi'], 'Windows-1252', 'UTF-8');
    // Extract just the emoji part
    preg_match('/.{0,40}(\xF0[\x90-\xBF][\x80-\xBF][\x80-\xBF]).{0,40}/s', $row['deskripsi'], $m1);
    preg_match('/.{0,40}(\xF0[\x90-\xBF][\x80-\xBF][\x80-\xBF]).{0,40}/s', $fixed, $m2);
    $before = $m1[0] ?? substr($row['deskripsi'], 100, 60);
    $after  = $m2[0] ?? substr($fixed, 100, 60);
    echo "ID {$row['id']}: " . trim(str_replace(["\r", "\n"], ' ', $before)) . "\n";
    echo "         → " . trim(str_replace(["\r", "\n"], ' ', $after)) . "\n\n";
}

if (!$apply) {
    echo "Dry run complete. Add --apply to execute the fix.\n";
    exit(0);
}

// Apply fix
echo "\n=== APPLYING FIX ===\n";
$pdo->beginTransaction();
try {
    $update = $pdo->prepare("UPDATE undangan_cetaks SET deskripsi = ? WHERE id = ?");
    $count = 0;
    foreach ($rows as $row) {
        $fixed = mb_convert_encoding($row['deskripsi'], 'Windows-1252', 'UTF-8');
        $update->execute([$fixed, $row['id']]);
        $count++;
    }
    $pdo->commit();
    echo "Fixed $count rows successfully!\n";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

// Verify
$stmt = $pdo->prepare("SELECT COUNT(*) FROM undangan_cetaks WHERE CAST(deskripsi AS BINARY) LIKE CONCAT('%', ?, '%')");
$stmt->execute([$pattern]);
$remaining = $stmt->fetchColumn();
echo "Rows remaining with mojibake: $remaining (should be 0)\n";
echo "Done.\n";
