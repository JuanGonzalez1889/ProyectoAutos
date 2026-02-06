<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use phpseclib3\Net\DNS;

class DomainValidationService
{
    /**
     * Validate domain format
     */
    public static function validateFormat(string $domain): array
    {
        $errors = [];

        // Normalize domain
        $domain = strtolower($domain);

        // Check if empty
        if (empty($domain)) {
            $errors[] = 'El dominio no puede estar vacío.';
        }

        // Check basic structure - domain should not start or end with hyphen or dot
        if (preg_match('/^-|-$|^\.|\.$/i', $domain)) {
            $errors[] = 'El dominio no puede comenzar o terminar con un guión o punto.';
        }

        // Check for double dots
        if (strpos($domain, '..') !== false) {
            $errors[] = 'El dominio no puede contener puntos consecutivos.';
        }

        // Check valid format with regex
        if (!preg_match('/^([a-z0-9]([a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,}$/i', $domain)) {
            $errors[] = 'Formato de dominio inválido.';
        }

        // Check for reserved TLDs
        $reservedTlds = ['test', 'localhost', 'invalid', 'example'];
        $parts = explode('.', $domain);
        $tld = end($parts);

        if (in_array($tld, $reservedTlds)) {
            $errors[] = 'Este TLD está reservado y no puede ser usado.';
        }

        // Check length
        if (strlen($domain) > 253) {
            $errors[] = 'El dominio es demasiado largo (máximo 253 caracteres).';
        }

        if (strlen($domain) < 3) {
            $errors[] = 'El dominio es demasiado corto (mínimo 3 caracteres).';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Check DNS records for domain
     */
    public static function checkDnsRecords(string $domain): array
    {
        $records = [
            'A' => [],
            'MX' => [],
            'CNAME' => [],
            'TXT' => [],
            'NS' => [],
        ];

        try {
            foreach (array_keys($records) as $type) {
                $result = dns_get_record($domain, constant("DNS_$type"));
                if ($result !== false) {
                    $records[$type] = $result;
                }
            }
        } catch (\Exception $e) {
            // DNS lookup failed
        }

        return [
            'records' => $records,
            'has_records' => !empty(array_filter($records)),
        ];
    }

    /**
     * Get DNS configuration suggestions
     */
    public static function getDnsSuggestions(string $domain): array
    {
        return [
            'A' => [
                'name' => 'Registro A',
                'type' => 'A',
                'description' => 'Apunta el dominio a una dirección IPv4',
                'example' => '192.0.2.1',
                'required' => true,
            ],
            'MX' => [
                'name' => 'Registro MX',
                'type' => 'MX',
                'description' => 'Define el servidor de correo electrónico',
                'example' => '10 mail.' . $domain,
                'required' => false,
            ],
            'CNAME' => [
                'name' => 'Registro CNAME',
                'type' => 'CNAME',
                'description' => 'Crea un alias para el dominio',
                'example' => 'www CNAME ' . $domain,
                'required' => false,
            ],
            'TXT' => [
                'name' => 'Registro TXT',
                'type' => 'TXT',
                'description' => 'Información de texto asociada al dominio',
                'example' => 'v=spf1 include:_spf.google.com ~all',
                'required' => false,
            ],
            'NS' => [
                'name' => 'Registros NS',
                'type' => 'NS',
                'description' => 'Servidores de nombre del dominio',
                'example' => 'ns1.ejemplo.com',
                'required' => true,
            ],
        ];
    }

    /**
     * Validate SSL certificate
     */
    public static function validateSslCertificate(string $domain): array
    {
        $result = [
            'valid' => false,
            'expires_at' => null,
            'issuer' => null,
            'common_name' => null,
            'error' => null,
        ];

        try {
            $context = stream_context_create([
                'ssl' => [
                    'capture_peer_cert' => true,
                    'verify_peer' => false,
                    'allow_self_signed' => true,
                ],
            ]);

            $sock = @stream_socket_client(
                'ssl://' . $domain . ':443',
                $errno,
                $errstr,
                30,
                STREAM_CLIENT_CONNECT,
                $context
            );

            if (!$sock) {
                $result['error'] = 'No se pudo conectar al dominio: ' . $errstr;
                return $result;
            }

            $cert = stream_context_get_params($sock)['options']['ssl']['peer_certificate'];
            fclose($sock);

            if (!$cert) {
                $result['error'] = 'No se encontró certificado SSL';
                return $result;
            }

            $certInfo = openssl_x509_parse($cert);

            if ($certInfo !== false) {
                $result['valid'] = true;
                $result['expires_at'] = date('Y-m-d H:i:s', $certInfo['validTo_time_t']);
                $result['issuer'] = $certInfo['issuer']['O'] ?? 'Desconocido';
                $result['common_name'] = $certInfo['subject']['CN'] ?? $domain;

                // Check if expired
                if ($certInfo['validTo_time_t'] < time()) {
                    $result['valid'] = false;
                    $result['error'] = 'El certificado SSL ha expirado';
                }
            }
        } catch (\Exception $e) {
            $result['error'] = 'Error al validar SSL: ' . $e->getMessage();
        }

        return $result;
    }

    /**
     * Get comprehensive domain report
     */
    public static function generateDomainReport(string $domain): array
    {
        $formatValidation = self::validateFormat($domain);
        $dnsRecords = self::checkDnsRecords($domain);
        $sslCertificate = self::validateSslCertificate($domain);
        $dnsSuggestions = self::getDnsSuggestions($domain);

        return [
            'domain' => $domain,
            'format_valid' => $formatValidation['valid'],
            'format_errors' => $formatValidation['errors'],
            'dns_records' => $dnsRecords['records'],
            'has_dns_records' => $dnsRecords['has_records'],
            'ssl_certificate' => $sslCertificate,
            'dns_suggestions' => $dnsSuggestions,
            'overall_status' => self::determineOverallStatus($formatValidation, $dnsRecords, $sslCertificate),
        ];
    }

    /**
     * Determine overall domain status
     */
    private static function determineOverallStatus(array $format, array $dns, array $ssl): string
    {
        if (!$format['valid']) {
            return 'invalid_format';
        }

        if (!$dns['has_records']) {
            return 'no_dns_records';
        }

        if ($ssl['valid']) {
            return 'fully_configured';
        }

        return 'partially_configured';
    }

    /**
     * Check domain availability (using WHOIS simulation)
     */
    public static function checkDomainAvailability(string $domain): array
    {
        // Simulate WHOIS check
        // In production, use a real WHOIS service like DomainTools API or similar
        
        $result = [
            'available' => false,
            'registered' => false,
            'registrar' => null,
            'expires_at' => null,
            'created_at' => null,
            'updated_at' => null,
        ];

        try {
            // Check if domain resolves
            $ips = @gethostbyname($domain);
            
            if ($ips !== false && $ips !== $domain) {
                $result['registered'] = true;
                $result['available'] = false;
            } else {
                $result['available'] = true;
                $result['registered'] = false;
            }
        } catch (\Exception $e) {
            $result['available'] = true;
            $result['registered'] = false;
        }

        return $result;
    }
}
