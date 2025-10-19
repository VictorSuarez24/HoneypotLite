# Escucha en un puerto, captura hasta N bytes y escribe CSV en connections.log (con flock).

import socket, csv, os, fcntl
from datetime import datetime, timezone

LOG = "/var/honeypot/logs/connections.log"   # <<-- ruta en servidor (ajusta si quieres otra)
HOST = "0.0.0.0"
PORT = 8080
MAX_READ = 512

os.makedirs(os.path.dirname(LOG), exist_ok=True)

# crear header si no existe
if not os.path.exists(LOG) or os.path.getsize(LOG) == 0:
    with open(LOG, "a", newline='') as f:
        fcntl.flock(f, fcntl.LOCK_EX)
        csv.writer(f).writerow(["timestamp","src_ip","src_port","dst_port","payload_snippet"])
        fcntl.flock(f, fcntl.LOCK_UN)

sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
sock.bind((HOST, PORT))
sock.listen(5)
print(f"[honeypot_listener] listening on {HOST}:{PORT}")

try:
    while True:
        conn, addr = sock.accept()
        try:
            conn.settimeout(2.0)
            data = b''
            while len(data) < MAX_READ:
                try:
                    chunk = conn.recv(min(1024, MAX_READ - len(data)))
                    if not chunk:
                        break
                    data += chunk
                except socket.timeout:
                    break
            snippet = data.decode(errors="replace").replace("\n"," ").replace("\r"," ")
            snippet = snippet[:500]
            ts = datetime.now(timezone.utc).isoformat()
            src_ip, src_port = addr[0], addr[1]
            dst_port = PORT
            with open(LOG, "a", newline='') as f:
                fcntl.flock(f, fcntl.LOCK_EX)
                csv.writer(f).writerow([ts, src_ip, src_port, dst_port, snippet])
                fcntl.flock(f, fcntl.LOCK_UN)
        finally:
            try: conn.close()
            except: pass
except KeyboardInterrupt:
    print("[honeypot_listener] stopped by user")
finally:
    sock.close()