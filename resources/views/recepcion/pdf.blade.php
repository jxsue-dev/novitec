<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }} — {{ $branchName }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1e293b; padding: 20px; }
        h1 { font-size: 16px; font-weight: 700; margin-bottom: 4px; }
        .meta { font-size: 11px; color: #64748b; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background: #1e293b; color: #fff; padding: 8px 10px; text-align: left; font-size: 11px; font-weight: 600; letter-spacing: .03em; }
        td { padding: 7px 10px; font-size: 11px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        tr:nth-child(even) td { background: #f8fafc; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 600; }
        .green { background: #dcfce7; color: #166534; }
        .amber { background: #fef3c7; color: #92400e; }
        .blue { background: #dbeafe; color: #1e40af; }
        .red { background: #fee2e2; color: #991b1b; }
        .footer { margin-top: 20px; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
        @media print {
            .no-print { display: none; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>

<div class="no-print" style="margin-bottom:16px;">
    <button onclick="window.print()"
            style="background:#2563eb;color:#fff;border:none;padding:8px 20px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;">
        🖨️ Imprimir / Guardar PDF
    </button>
    <a href="{{ route('recepcion.dashboard', ['tab' => request('tipo', 'listas')]) }}"
       style="margin-left:10px;font-size:12px;color:#64748b;text-decoration:none;">← Volver</a>
</div>

<h1>{{ $titulo }}</h1>
<p class="meta">
    {{ $branchName }} · Generado el {{ now()->format('d/m/Y H:i') }} · {{ $rows->count() }} órdenes
</p>

@if($rows->isEmpty())
<p style="color:#94a3b8;margin-top:20px;">No hay órdenes que mostrar.</p>
@else
<table>
    <thead>
        <tr>
            <th>Nro. Orden</th>
            <th>Cliente</th>
            <th>Equipo</th>
            <th>Serie</th>
            <th>Estado</th>
            <th>Técnico</th>
            <th>Teléfono</th>
            @if($tipo === 'listas')<th>Ingresada</th>@endif
            @if($tipo === 'atrasadas')<th>Prometida</th>@endif
            @if($tipo === 'hoy')<th>Hora ingreso</th>@endif
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $o)
        @php
            $nombre = trim(($o->nombres ?? '').' '.($o->apellidos ?? '')) ?: ($o->cliente ?? '—');
            $equipo = trim(implode(' ', array_filter([$o->tipo ?? '', $o->marca ?? '', $o->modelo ?? ''])));
            $badgeCls = match($o->estado_orden ?? '') {
                'Finalizada'    => 'badge green',
                'En Revisión'   => 'badge amber',
                'En Reparacion' => 'badge blue',
                'Anulada'       => 'badge red',
                default         => 'badge',
            };
        @endphp
        <tr>
            <td><strong style="font-family:monospace;">{{ $o->nro_orden }}</strong></td>
            <td>{{ $nombre }}</td>
            <td>{{ $equipo }}</td>
            <td style="font-family:monospace;font-size:10px;">{{ $o->serie ?? '—' }}</td>
            <td><span class="{{ $badgeCls }}">{{ $o->estado_orden ?? '—' }}</span></td>
            <td>{{ $o->tecnico ?? '—' }}</td>
            <td style="font-family:monospace;">{{ $o->numero_contacto ?? '—' }}</td>
            @if($tipo === 'listas')<td>{{ $o->fecha_de_ingreso_fmt ?? '—' }}</td>@endif
            @if($tipo === 'atrasadas')<td style="color:#dc2626;font-weight:600;">{{ $o->fecha_prometido_fmt ?? '—' }}</td>@endif
            @if($tipo === 'hoy')<td>{{ $o->fecha_de_ingreso_fmt ?? '—' }}</td>@endif
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div class="footer">
    Novitecnología Cia. Ltda. · {{ $branchName }} · novitec.com.ec
</div>

</body>
</html>
