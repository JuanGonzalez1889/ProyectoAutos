<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'AutoWeb Pro')</title>
    <style>
        /* Reset */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
        a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important; }
        
        /* Base */
        body {
            background-color: #0a0f14;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #e2e8f0;
            margin: 0;
            padding: 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #0a0f14;
        }
        
        .email-header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 40px 24px;
            text-align: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        
        .email-body {
            padding: 40px 24px;
            background-color: #1a1f2e;
            border-left: 1px solid #334155;
            border-right: 1px solid #334155;
        }
        
        .email-content {
            color: #cbd5e1;
            font-size: 15px;
            line-height: 1.7;
        }
        
        h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 20px 0;
            line-height: 1.3;
        }
        
        h2 {
            color: #f1f5f9;
            font-size: 20px;
            font-weight: 600;
            margin: 32px 0 16px 0;
        }
        
        p {
            margin: 0 0 16px 0;
            color: #cbd5e1;
        }
        
        .button {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            margin: 24px 0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .button:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }
        
        .info-box {
            background-color: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 20px;
            margin: 24px 0;
        }
        
        .info-box-header {
            font-size: 14px;
            font-weight: 600;
            color: #60a5fa;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            padding: 10px 0;
            border-bottom: 1px solid #334155;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            display: table-cell;
            font-size: 13px;
            color: #94a3b8;
            width: 40%;
        }
        
        .info-value {
            display: table-cell;
            font-size: 14px;
            color: #f1f5f9;
            font-weight: 600;
        }
        
        .highlight {
            color: #60a5fa;
            font-weight: 600;
        }
        
        .success {
            color: #34d399;
        }
        
        .warning {
            color: #fbbf24;
        }
        
        .danger {
            color: #f87171;
        }
        
        ul {
            margin: 16px 0;
            padding-left: 24px;
        }
        
        ul li {
            margin-bottom: 8px;
            color: #cbd5e1;
        }
        
        .divider {
            height: 1px;
            background-color: #334155;
            margin: 32px 0;
        }
        
        .email-footer {
            background-color: #0f172a;
            padding: 32px 24px;
            text-align: center;
            border: 1px solid #334155;
            border-top: none;
        }
        
        .footer-text {
            font-size: 13px;
            color: #64748b;
            margin: 8px 0;
        }
        
        .footer-links {
            margin: 16px 0;
        }
        
        .footer-link {
            color: #60a5fa;
            text-decoration: none;
            margin: 0 12px;
            font-size: 13px;
        }
        
        .footer-link:hover {
            color: #93c5fd;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-link {
            display: inline-block;
            margin: 0 8px;
        }
        
        /* Mobile Responsive */
        @media screen and (max-width: 600px) {
            .email-header,
            .email-body,
            .email-footer {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
            
            h1 {
                font-size: 20px !important;
            }
            
            .button {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box;
            }
            
            .info-row {
                display: block;
            }
            
            .info-label,
            .info-value {
                display: block;
                width: 100%;
            }
            
            .info-label {
                margin-bottom: 4px;
            }
        }
    </style>
</head>
<body>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #0a0f14;">
        <tr>
            <td style="padding: 40px 0;">
                <div class="email-container">
                    <!-- Header -->
                    <div class="email-header">
                        <a href="{{ config('app.url') }}" class="logo">🚗 AutoWeb Pro</a>
                    </div>
                    
                    <!-- Body -->
                    <div class="email-body">
                        <div class="email-content">
                            @yield('content')
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="email-footer">
                        <p class="footer-text">
                            <strong>AutoWeb Pro</strong> - La plataforma completa para tu agencia automotriz
                        </p>
                        
                        <div class="footer-links">
                            <a href="{{ config('app.url') }}/ayuda" class="footer-link">Centro de Ayuda</a>
                            <a href="{{ config('app.url') }}/contacto" class="footer-link">Contacto</a>
                            <a href="{{ config('app.url') }}/terminos" class="footer-link">Términos</a>
                            <a href="{{ config('app.url') }}/privacidad" class="footer-link">Privacidad</a>
                        </div>
                        
                        <p class="footer-text" style="margin-top: 24px;">
                            Este correo fue enviado a <strong>{{ $user->email ?? 'tu correo' }}</strong>
                        </p>
                        
                        <p class="footer-text" style="font-size: 12px; color: #475569; margin-top: 16px;">
                            © {{ date('Y') }} AutoWeb Pro. Todos los derechos reservados.<br>
                            No respondas a este correo. Si necesitas ayuda, <a href="mailto:soporte@autowebpro.com" style="color: #60a5fa;">contacta a soporte</a>.
                        </p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
