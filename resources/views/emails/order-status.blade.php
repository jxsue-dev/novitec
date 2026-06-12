<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f8fafc; margin:0; padding:0; }
        .container { max-width:600px; margin:40px auto; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .header { background:linear-gradient(135deg,#020817,#0c1a35); padding:32px; text-align:center; }
        .header h1 { color:#fff; font-size:22px; margin:0; font-weight:600; }
        .header p { color:#60a5fa; font-size:13px; margin:6px 0 0; font-weight:400; text-transform:uppercase; letter-spacing:0.05em; }
        .body { padding:32px; }
        .greeting { font-size:16px; color:#1e293b; margin-bottom:24px; line-height:1.6; }
        .greeting strong { color:#0f172a; }
        .status-box { background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:20px; text-align:center; margin-bottom:28px; }
        .status-box span { display:block; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#3b82f6; margin-bottom:6px; }
        .status-box h2 { font-size:24px; color:#1e3a8a; margin:0; font-weight:700; }
        .field-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:28px; }
        .field { margin-bottom:16px; }
        .field label { display:block; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#94a3b8; margin-bottom:4px; }
        .field p { font-size:14px; color:#334155; margin:0; font-weight:500; }
        .cta-wrap { text-align:center; margin:32px 0 12px; }
        .btn { display:inline-block; background:#2563eb; color:#ffffff !important; font-size:14px; font-weight:600; text-decoration:none; padding:12px 32px; border-radius:8px; box-shadow:0 4px 12px rgba(37,99,235,0.2); transition:all 0.2s ease; }
        .footer { background:#f1f5f9; padding:24px 32px; text-align:center; font-size:12px; color:#94a3b8; line-height:1.5; }
        .footer a { color:#3b82f6; text-decoration:none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <p>Soporte Técnico Oficial</p>
            <h1>Actualización de tu orden</h1>
        </div>
        <div class="body">
            <p class="greeting">
                Hola, <strong>{{ $cliente }}</strong>:<br>
                Queremos informarte que tu orden de trabajo en nuestro centro de servicios tecnológicos ha avanzado a un nuevo estado.
            </p>

            <div class="status-box">
                <span>Estado actual de tu equipo</span>
                <h2>{{ $estado }}</h2>
            </div>

            <div style="border-top:1px solid #f1f5f9; padding-top:20px;">
                <div class="field" style="margin-bottom:12px;">
                    <label>Número de orden</label>
                    <p style="font-size:16px; font-weight:700; color:#0f172a;">{{ $nro_orden }}</p>
                </div>
                <div class="field" style="margin-bottom:12px;">
                    <label>Equipo / Dispositivo</label>
                    <p>{{ $equipo }}</p>
                </div>
                <div class="field" style="margin-bottom:12px;">
                    <label>Sucursal de Atención</label>
                    <p>{{ $sucursal }}</p>
                </div>
            </div>

            <div class="cta-wrap">
                <a href="{{ config('app.url') }}/garantias" target="_blank" class="btn">
                    Ver en el Roadmap de Garantías
                </a>
            </div>
        </div>
        <div class="footer">
            © 2026 Novitecnología Cia. Ltda. — Todos los derechos reservados.<br>
            Si tienes dudas, puedes responder a este correo o contactarnos en <a href="mailto:soporte@novitec.com.ec">soporte@novitec.com.ec</a>.
        </div>
    </div>
</body>
</html>
