<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background:#f8fafc; margin:0; padding:0; }
        .container { max-width:600px; margin:40px auto; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .header { background:linear-gradient(135deg,#1d4ed8,#4f46e5); padding:32px; text-align:center; }
        .header img { height:36px; filter:brightness(0) invert(1); }
        .header h1 { color:#fff; font-size:20px; margin:12px 0 0; font-weight:600; }
        .body { padding:32px; }
        .field { margin-bottom:20px; }
        .field label { display:block; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#94a3b8; margin-bottom:6px; }
        .field p { font-size:15px; color:#1e293b; margin:0; line-height:1.6; }
        .mensaje { background:#f8fafc; border-left:3px solid #3b82f6; padding:16px; border-radius:0 8px 8px 0; }
        .footer { background:#f1f5f9; padding:20px 32px; text-align:center; font-size:12px; color:#94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nuevo mensaje de contacto</h1>
        </div>
        <div class="body">
            <div class="field">
                <label>Nombre</label>
                <p>{{ $nombre }}</p>
            </div>
            <div class="field">
                <label>Correo electrónico</label>
                <p>{{ $email }}</p>
            </div>
            @if($telefono)
            <div class="field">
                <label>Teléfono</label>
                <p>{{ $telefono }}</p>
            </div>
            @endif
            <div class="field">
                <label>Asunto</label>
                <p>{{ $asunto }}</p>
            </div>
            <div class="field">
                <label>Mensaje</label>
                <div class="mensaje">
                    <p>{{ $mensaje }}</p>
                </div>
            </div>
        </div>
        <div class="footer">
            © 2026 Novitecnología Cia. Ltda. — Este mensaje fue enviado desde el formulario de contacto del sitio web.
        </div>
    </div>
</body>
</html>
