<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Seo extends Component
{
    public string $title;
    public string $description;
    public ?string $keywords;
    public ?string $image;
    public ?string $url;
    public string $type;
    public ?string $twitterCard;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title = '',
        string $description = '',
        ?string $keywords = null,
        ?string $image = null,
        ?string $url = null,
        string $type = 'website',
        ?string $twitterCard = 'summary_large_image'
    ) {
        // Defaults
        $appName = config('app.name', 'AutoWeb Pro');
        $appUrl = config('app.url', 'http://localhost');

        $this->title = $title ?: "$appName - Gestión de Agencias de Autos";
        $this->description = $description ?: 'Plataforma SaaS para gestionar inventario de vehículos, leads y ventas en tu agencia automotriz.';
        $this->keywords = $keywords ?? 'autos, agencia, vehículos, inventario, CRM, leads, ventas';
        $this->image = $image ?? asset('images/og-default.jpg');
        $this->url = $url ?? url()->current();
        $this->type = $type;
        $this->twitterCard = $twitterCard;

        // Append app name to title if not already present
        if (!str_contains($this->title, $appName)) {
            $this->title .= " | $appName";
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.seo');
    }
}
