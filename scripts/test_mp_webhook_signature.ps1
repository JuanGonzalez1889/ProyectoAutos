param(
    [string]$Url = "http://127.0.0.1:8000/webhooks/mercadopago",
    [string]$Secret = "",
    [string]$Type = "payment",
    [string]$DataId = "123456789",
    [string]$RequestId = "req-test-001",
    [switch]$InvalidSignature,
    [switch]$UseTopic
)

if ([string]::IsNullOrWhiteSpace($Secret)) {
    Write-Error "Debes enviar -Secret con MERCADOPAGO_WEBHOOK_SECRET"
    exit 1
}

$timestamp = [DateTimeOffset]::UtcNow.ToUnixTimeSeconds().ToString()
$manifest = "id:$DataId;request-id:$RequestId;ts:$timestamp;"

$hmac = [System.Security.Cryptography.HMACSHA256]::new([Text.Encoding]::UTF8.GetBytes($Secret))
$hashBytes = $hmac.ComputeHash([Text.Encoding]::UTF8.GetBytes($manifest))
$signature = ([System.BitConverter]::ToString($hashBytes)).Replace('-', '').ToLowerInvariant()

if ($InvalidSignature) {
    $signature = "deadbeef$($signature.Substring(8))"
}

$xSignature = "ts=$timestamp,v1=$signature"

$payload = if ($UseTopic) {
    @{
        topic = $Type
        data = @{ id = $DataId }
    }
} else {
    @{
        type = $Type
        data = @{ id = $DataId }
    }
}

$jsonBody = $payload | ConvertTo-Json -Depth 5

Write-Host "=== Enviando webhook Mercado Pago ==="
Write-Host "URL: $Url"
Write-Host "Manifest: $manifest"
Write-Host "X-Signature: $xSignature"
Write-Host "X-Request-Id: $RequestId"
Write-Host "Body: $jsonBody"

try {
    $response = Invoke-WebRequest `
        -Method Post `
        -Uri $Url `
        -UseBasicParsing `
        -Headers @{
            "X-Signature" = $xSignature
            "X-Request-Id" = $RequestId
            "Content-Type" = "application/json"
        } `
        -Body $jsonBody

    Write-Host "\n=== Respuesta ==="
    Write-Host "StatusCode: $($response.StatusCode)"
    Write-Host "Body: $($response.Content)"
}
catch {
    Write-Host "\n=== Error HTTP ==="
    if ($_.Exception.Response) {
        $status = [int]$_.Exception.Response.StatusCode
        Write-Host "StatusCode: $status"

        try {
            $stream = $_.Exception.Response.GetResponseStream()
            $reader = New-Object System.IO.StreamReader($stream)
            $errorBody = $reader.ReadToEnd()
            Write-Host "Body: $errorBody"
        } catch {
            Write-Host "No se pudo leer el body de error"
        }
    } else {
        Write-Host $_.Exception.Message
    }
}
