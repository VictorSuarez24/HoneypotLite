# SAFETY.md

**Proyecto:** HoneypotLite  
**Autor:** Victor Suarez Cruz  
**Fecha:** 2025-10-3
---

## Objetivo del documento
Este archivo establece reglas, límites y buenas prácticas para el uso del laboratorio **HoneypotLite**. Su propósito es garantizar que las pruebas realizadas sean **éticas, legales y seguras**, y que los datos potencialmente sensibles se manejen adecuadamente.

---

## Reglas obligatorias (NO negociables)
1. **Uso exclusivo en entorno controlado:** Este honeypot sólo se debe ejecutar en redes privadas aisladas (host-only / internal network / VPC privada). Bajo ningún concepto debe usarse contra hosts o redes públicas sin permiso explícito por escrito del propietario.  
2. **Consentimiento y permisos:** Antes de interactuar con cualquier sistema que no sea propiedad tuya, obtén autorización por escrito.  
3. **No escalación fuera del laboratorio:** No intentes pivotar a redes externas ni aprovechar vulnerabilidades fuera del entorno del laboratorio.  
4. **No ejecutar código remoto:** El honeypot debe **registrar** datos, no ejecutar comandos recibidos. Nunca canalices entrada recibida hacia un intérprete sin sanitizar y autorización.  
5. **Aislamiento de red:** Usa redes *host-only* o internas y desactiva el bridging/NAT con redes públicas durante las pruebas.  
6. **Datos sanitizados para publicación:** Antes de publicar logs, ejemplos o demos en GitHub/LinkedIn, **sanitiza** todas las IPs, payloads y credenciales. Nunca subas datos reales de terceros.  
7. **Snapshots y backups:** Antes de cualquier prueba potente (fuzzing, bruteforce), crea un snapshot de la VM. Documenta el snapshot y la hora.  
8. **Privacidad y GDPR:** Si llegas a capturar datos personales (p. ej. emails, credenciales), trátalos como información sensible: bórralos inmediatamente y no los compartas.  
9. **Acceso restringido al repo:** Si tu repositorio contiene ejemplos de configuración o logs reales, mantenlo **privado** hasta haber sanitizado todo.  
10. **Responsable del laboratorio:** Anota el nombre de la persona responsable del lab y un contacto en caso de incidente.

---

## Procedimientos en caso de incidente
1. Si por error el honeypot generó tráfico a Internet, corta la red del host inmediatamente (apaga la interfaz host-only o desconecta la VM).  
2. Documenta el incidente (timestamp, acciones realizadas, outputs) y crea un snapshot del estado actual.  
3. Notifica al responsable del laboratorio. Si el incidente afecta a terceros, evalúa informar al administrador de la red y seguir la política de notificación correspondiente.

---

## Buenas prácticas recomendadas
- Mantén el sistema operativo actualizado solo para el host de gestión; los targets vulnerables pueden necesitar versiones antiguas para pruebas pero deben permanecer aislados.  
- Usa credenciales ficticias y no reutilices contraseñas reales.  
- Mantén un archivo `CHANGELOG` con las pruebas realizadas y resultados (sin datos sensibles).  
- Automatiza la limpieza: snapshots y scripts de reset que borren logs sensibles tras la sesión.

---

## Checklist rápido antes de ejecutar pruebas
- [ ] Entorno en host-only / internal network.  
- [ ] Snapshot creado de la VM (o backup).  
- [ ] SAFETY.md revisado y firmado (nombre y fecha).  
- [ ] Repo en privado o datos sanitizados.  
- [ ] Responsable del lab identificado.
