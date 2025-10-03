# 🛡️ HoneypotLite

**HoneypotLite** es un laboratorio educativo ligero para capturar intentos de conexión y estudiar el comportamiento de bots/atacantes en un entorno controlado.  
Está pensado para **aprendizaje y pruebas en laboratorio** (VMs/Docker en red aislada).

> ⚠️ **IMPORTANTE:** Este proyecto es **exclusivamente educativo**. No lo uses en redes o sistemas que no controles. Lee `SAFETY.md` antes de empezar.

---

## 📌 Tabla de contenidos
- [Objetivo](#objetivo)  
- [Características](#caracter%C3%ADsticas)  
- [Estado del proyecto](#estado-del-proyecto)  
- [Estructura del repositorio](#estructura-del-repositorio)  
- [Requisitos](#requisitos)  
- [Quickstart (resumen)](#quickstart-resumen)  
- [Formato de logs recomendado](#formato-de-logs-recomendado)  
- [Buenas prácticas / Seguridad](#buenas-pr%C3%A1cticas--seguridad)  
- [Documentación y reportes](#documentaci%C3%B3n-y-reportes)  
- [Contribuir](#contribuir)  
- [Licencia y contacto](#licencia-y-contacto)

---

## 🎯 Objetivo
Montar un honeypot básico que:
- Escuche en puertos seleccionados (por ejemplo 22, 80, 8080).  
- Registre eventos con un formato consistente (timestamp, src_ip, src_port, dst_port, payload_snippet).  
- Ofrezca un dashboard web simple (PHP/HTML/CSS) para visualizar actividad.  
- Permita experimentar con reglas de detección y alertas en un entorno aislado.

---

## ✨ Características
- Entorno pensado para laboratorio (VMs host-only / internal network).  
- Captura de metadatos y snippets de payload (primeros N bytes).  
- Dashboard ligero para visualización y filtrado.  
- Plantillas para reportes y procedimientos reproducibles.

---

## 📦 Estado del proyecto
- **Estado:** En desarrollo  
- **Autor:** Victor Suarez Cruz  

---

## 📂 Estructura del repositorio
