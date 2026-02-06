<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'template',
        'logo_url',
        'banner_url',
        'primary_color',
        'secondary_color',
        'tertiary_color',
        'home_description',
        'home_description_color',
        'nosotros_description',
        'nosotros_description_color',
        'hero_title',
        'hero_title_color',
        'font_family',
        'agency_name_color',
        'navbar_agency_name',
        'navbar_agency_name_color',
        'navbar_links_color',
        'nosotros_url',
        'contact_message',
        'phone',
        'email',
        'whatsapp',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'show_contact_form',
        'show_vehicles',
        'stat1',
        'stat2',
        'stat3',
        'stat1_label',
        'stat2_label',
        'stat3_label',
    ];

    protected $casts = [
        'show_contact_form' => 'boolean',
        'show_vehicles' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
}
