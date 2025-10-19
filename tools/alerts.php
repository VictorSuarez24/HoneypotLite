<?php
$path = __DIR__ . '/../honeypot/logs/connections.log';
$rows = [];

// Leer CSV
if (($handle = fopen($path,'r')) !== false) {
    fgetcsv($handle); // saltar header
    while (($data = fgetcsv($handle)) !== false) {
        $data = array_map(fn($v) => trim($v, "\"' "), $data);
        if (count($data) >= 5) {
            $rows[] = [
                'ts' => strtotime($data[0]),
                'src_ip' => $data[1],
                'src_port' => $data[2],
                'dst_port' => $data[3],
                'payload' => $data[4]
            ];
        }
    }
    fclose($handle);
}

// Regla A: brute-force por IP
function check_rule_a($rows,$th=5,$window=10){
    $alerts=[]; $ip_times=[];
    foreach($rows as $r) $ip_times[$r['src_ip']][] = $r['ts'];
    foreach($ip_times as $ip=>$times){
        sort($times); $left=0; $n=count($times);
        for($right=0;$right<$n;$right++){
            while($times[$right]-$times[$left]>$window*60)$left++;
            if($right-$left+1>=$th)$alerts[]= ['rule'=>'A','msg'=>"Brute-force $ip: ".($right-$left+1)." intentos","time"=>date('c',$times[$right])];
        }
    }
    return $alerts;
}

// Regla B: payload repetido
function check_rule_b($rows,$th=3,$window=60){
    $alerts=[]; $pl_times=[];
    foreach($rows as $r) $pl_times[$r['payload']][]=$r['ts'];
    foreach($pl_times as $pl=>$times){
        sort($times); $left=0; $n=count($times);
        for($right=0;$right<$n;$right++){
            while($times[$right]-$times[$left]>$window*60)$left++;
            if($right-$left+1>=$th)$alerts[]= ['rule'=>'B','msg'=>"Payload repetido '$pl'","time"=>date('c',$times[$right])];
        }
    }
    return $alerts;
}

// Regla C: puertos críticos
function check_rule_c($rows,$critical=[22,80,443,3306,3389]){
    $alerts=[];
    foreach($rows as $r){
        $dst=(int)$r['dst_port'];
        if(in_array($dst,$critical))$alerts[]= ['rule'=>'C','msg'=>"Puerto crítico $dst desde {$r['src_ip']}","time"=>date('c',$r['ts'])];
    }
    return $alerts;
}

// Ejecutar reglas y ordenar por tiempo descendente
$alerts=array_merge(check_rule_a($rows),check_rule_b($rows),check_rule_c($rows));
usort($alerts,fn($a,$b)=>strtotime($b['time'])<=>strtotime($a['time']));

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Alertas HoneypotLite</title>
<style>
body{font-family:Arial;padding:20px;background:#fafafa}
.alert{padding:10px;margin:10px 0;border-left:6px solid #f00;border-radius:5px}
.alert.A{border-color:#f59e0b;background:#fff7ed}
.alert.B{border-color:#ef4444;background:#fff5f5}
.alert.C{border-color:#0ea5e9;background:#f0f9ff}
</style>
</head>
<body>
<h1>Alertas HoneypotLite</h1>
<?php if(empty($alerts)): ?>
    <p>✅ Sin alertas</p>
<?php else: foreach($alerts as $a): ?>
    <div class="alert <?= $a['rule'] ?>"><strong>Regla <?= $a['rule'] ?>:</strong> <?= $a['msg'] ?><br><small><?= $a['time'] ?></small></div>
<?php endforeach; endif; ?>
</body>
</html>