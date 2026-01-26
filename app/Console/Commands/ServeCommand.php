<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeCommand extends Command
{
    protected $signature = 'serve {--host=127.0.0.1} {--port=8000}';
    
    protected $description = 'Iniciar el servidor de desarrollo de Laravel';

    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');
        
        $this->info("Servidor Laravel iniciado en http://{$host}:{$port}");
        $this->info('Presiona Ctrl+C para detener el servidor');
        $this->newLine();
        
        $process = new Process([
            PHP_BINARY,
            '-S',
            "{$host}:{$port}",
            '-t',
            'public'
        ], base_path());
        
        $process->setTimeout(null);
        
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });
        
        return 0;
    }
}
