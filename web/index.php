<?php
require_once __DIR__ . '/config.php';  
require_once __DIR__ . '/../tools/alerts.php'; 

// Leer logs
function read_logs($path) {
    $rows = [];
    if (($handle = fopen($path, 'r')) !== false) {
        fgetcsv($handle); 
        while (($data = fgetcsv($handle)) !== false) {
            $data = array_map(function($v) {
                return trim(trim($v), "\"'");
            }, $data);
            if (count($data) >= 5) {
                $rows[] = [
                    'ts_raw'  => $data[0],
                    'src_ip'  => $data[1],
                    'src_port'=> $data[2],
                    'dst_port'=> $data[3],
                    'payload' => $data[4],
                ];
            }
        }
        fclose($handle);
    }
    return $rows;
}

$rows = read_logs($LOGFILE);

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Dashboard HoneypotLite</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Dashboard HoneypotLite</h1>

    <!-- Alertas -->
    <div class="panel">
        <h2>Alertas recientes</h2>
        <?php if (!empty($alerts_c)) : ?>
            <?php foreach ($alerts_c as $a) : ?>
                <div class="alert"><?= htmlspecialchars($a['msg']) ?> <br><small><?= htmlspecialchars($a['time']) ?></small></div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="ok">✅ No se detectaron alertas críticas.</p>
        <?php endif; ?>
    </div>

    <!-- Tabla de logs -->
    <div class="panel table-wrap">
        <h2>Logs de conexiones</h2>
        <table>
            <tr><th>Fecha</th><th>IP</th><th>Puerto Origen</th><th>Puerto Destino</th><th>Payload</th></tr>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td><?= htmlspecialchars($r['ts_raw']) ?></td>
                    <td><?= htmlspecialchars($r['src_ip']) ?></td>
                    <td><?= htmlspecialchars($r['src_port']) ?></td>
                    <td><?= htmlspecialchars($r['dst_port']) ?></td>
                    <td class="payload"><?= htmlspecialchars($r['payload']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</body>
</html>
