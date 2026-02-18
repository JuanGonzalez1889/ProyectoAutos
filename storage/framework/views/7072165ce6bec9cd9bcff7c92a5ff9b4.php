<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($tenant->name ?? 'Agencia de Autos'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php
        $font = $settings->font_family ?? '';
        $googleFonts = [
            'Roboto, sans-serif' => 'Roboto',
            'Open Sans, sans-serif' => 'Open+Sans',
            'Montserrat, sans-serif' => 'Montserrat',
            'Lato, sans-serif' => 'Lato',
            'Poppins, sans-serif' => 'Poppins',
            'Inter, sans-serif' => 'Inter',
            'Nunito, sans-serif' => 'Nunito',
            'Oswald, sans-serif' => 'Oswald',
            'Raleway, sans-serif' => 'Raleway',
            'Merriweather, serif' => 'Merriweather',
            'Playfair Display, serif' => 'Playfair+Display',
            'Muli, sans-serif' => 'Muli',
            'Quicksand, sans-serif' => 'Quicksand',
            'Source Sans Pro, sans-serif' => 'Source+Sans+Pro',
            'Work Sans, sans-serif' => 'Work+Sans',
            'PT Sans, sans-serif' => 'PT+Sans',
            'Ubuntu, sans-serif' => 'Ubuntu',
            'Fira Sans, sans-serif' => 'Fira+Sans',
        ];
        $fontUrl = isset($googleFonts[$font]) ? 'https://fonts.googleapis.com/css?family=' . $googleFonts[$font] . ':400,700&display=swap' : null;
    ?>
    <?php if($fontUrl): ?>
        <link href="<?php echo e($fontUrl); ?>" rel="stylesheet">
    <?php endif; ?>
    <style>
        :root {
            --primary-color: <?php echo e($settings && $settings->primary_color ? $settings->primary_color : '#00d084'); ?>;
            --secondary-color: <?php echo e($settings && $settings->secondary_color ? $settings->secondary_color : '#0a0f14'); ?>;
            --tertiary-color: <?php echo e($settings && $settings->tertiary_color ? $settings->tertiary_color : '#ffaa00'); ?>;
        }
        body { font-family: <?php echo e($settings->font_family ?? 'inherit'); ?>; }

        * { scroll-behavior: smooth; }

        .hero-text {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .vehicle-card {
            position: relative;
            overflow: hidden;
        }

        .vehicle-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .vehicle-card:hover::after {
            left: 100%;
        }

        <?php if(isset($editMode) && $editMode): ?>
        .editable-section {
            position: relative;
            transition: all 0.2s;
            cursor: pointer;
        }
        .editable-section:hover {
            outline: 2px dashed #3b82f6;
            outline-offset: 4px;
        }
        .edit-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #3b82f6;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            z-index: 100000 !important;
        }
        .editable-section:hover .edit-btn {
            display: flex;
        }
        .edit-btn:hover {
            background: #2563eb;
            transform: scale(1.1);
        }
        <?php endif; ?>
    </style>
</head>
<body style="background-color: var(--secondary-color);" class="text-white">
    <?php if(isset($editMode) && $editMode): ?>
    <script>
        // Eliminar declaración duplicada de currentField para evitar errores JS
        // let currentField = null;
        // ...existing code...

        async function saveImage() {
            if (!currentField) return;
            
            const fileInput = document.getElementById('modalImageFile');
            const urlInput = document.getElementById('modalImageUrl');
            const saveBtn = document.getElementById('imageSaveText');
            
            saveBtn.textContent = 'Guardando...';
            
            // Si hay un archivo seleccionado, subirlo
            if (fileInput.files && fileInput.files[0]) {
                const formData = new FormData();
                formData.append('image', fileInput.files[0]);
                formData.append('field', currentField);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                
                try {
                    const response = await fetch('<?php echo e(route("admin.landing-config.upload-image")); ?>', {
                        method: 'POST',
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        updateField(currentField, data.url);
                        closeImageModal();
                    } else {
                        alert('Error al subir la imagen: ' + (data.message || 'Error desconocido'));
                        saveBtn.textContent = 'Guardar';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error al subir la imagen');
                    saveBtn.textContent = 'Guardar';
                }
            } 
            // Si no hay archivo, usar la URL
            else if (urlInput.value) {
                updateField(currentField, urlInput.value);
                closeImageModal();
            } else {
                alert('Por favor selecciona una imagen o ingresa una URL');
                saveBtn.textContent = 'Guardar';
            }
        }

        // Preview de imagen al seleccionar archivo
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('modalImageFile');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            document.getElementById('imagePreviewImg').src = event.target.result;
                            document.getElementById('imagePreview').classList.remove('hidden');
                        };
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            }
        });

        // Editar contacto
        function editContact() {
            document.getElementById('modalPhone').value = getFieldValue('phone');
            document.getElementById('modalEmail').value = getFieldValue('email');
            document.getElementById('modalWhatsapp').value = getFieldValue('whatsapp');
            document.getElementById('contactModal').classList.remove('hidden');
        }

        function closeContactModal() {
            document.getElementById('contactModal').classList.add('hidden');
        }

        function saveContact() {
            const phone = document.getElementById('modalPhone').value;
            const email = document.getElementById('modalEmail').value;
            const whatsapp = document.getElementById('modalWhatsapp').value;

            if (!phone && !email && !whatsapp) {
                alert('Por favor completa al menos un campo de contacto');
                return;
            }

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'PATCH');
            formData.append('phone', phone);
            formData.append('email', email);
            formData.append('whatsapp', whatsapp);
            formData.append('template', '<?php echo e($template ?? "deportivo"); ?>');
            
            // Mantener valores actuales
            const fields = ['home_description', 'nosotros_description', 'nosotros_url', 'contact_message', 'logo_url', 'banner_url', 'primary_color', 'secondary_color', 'facebook_url', 'instagram_url', 'linkedin_url'];
            fields.forEach(f => formData.append(f, getFieldValue(f)));
            formData.append('show_vehicles', '<?php echo e($settings->show_vehicles ?? 1); ?>');
            formData.append('show_contact_form', '<?php echo e($settings->show_contact_form ?? 1); ?>');

            fetch('<?php echo e(route("admin.landing-config.update")); ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeContactModal();
                    alert('✅ Datos de contacto guardados correctamente');
                    location.reload();
                } else {
                    alert('Error al guardar: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar los cambios');
            });
        }

        // Editar estadísticas
        function editStats() {
            document.getElementById('modalStat1').value = getFieldValue('stat1') || '150+';
            document.getElementById('modalStat2').value = getFieldValue('stat2') || '98%';
            document.getElementById('modalStat3').value = getFieldValue('stat3') || '24h';
            document.getElementById('statsModal').classList.remove('hidden');
        }

        function closeStatsModal() {
            document.getElementById('statsModal').classList.add('hidden');
        }

        function saveStats() {
            const stat1 = document.getElementById('modalStat1').value || '150+';
            const stat2 = document.getElementById('modalStat2').value || '98%';
            const stat3 = document.getElementById('modalStat3').value || '24h';

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'PATCH');
            formData.append('stat1', stat1);
            formData.append('stat2', stat2);
            formData.append('stat3', stat3);
            formData.append('template', '<?php echo e($template ?? "deportivo"); ?>');
            
            // Mantener valores actuales
            const fields = ['home_description', 'nosotros_description', 'nosotros_url', 'contact_message', 'phone', 'email', 'whatsapp', 'logo_url', 'banner_url', 'primary_color', 'secondary_color', 'facebook_url', 'instagram_url', 'linkedin_url'];
            fields.forEach(f => formData.append(f, getFieldValue(f)));
            formData.append('show_vehicles', '<?php echo e($settings->show_vehicles ?? 1); ?>');
            formData.append('show_contact_form', '<?php echo e($settings->show_contact_form ?? 1); ?>');

            fetch('<?php echo e(route("admin.landing-config.update")); ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeStatsModal();
                    alert('✅ Estadísticas guardadas correctamente');
                    location.reload();
                } else {
                    alert('Error al guardar: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar los cambios');
            });
        }

        // Helper para obtener valores actuales
        function getFieldValue(field) {
            const values = {
                home_description: <?php echo json_encode($settings->home_description ?? '', 15, 512) ?>,
                nosotros_description: <?php echo json_encode($settings->nosotros_description ?? '', 15, 512) ?>,
                nosotros_url: <?php echo json_encode($settings->nosotros_url ?? '', 15, 512) ?>,
                agency_name: <?php echo json_encode($tenant->name ?? '', 15, 512) ?>,
                contact_message: <?php echo json_encode($settings->contact_message ?? '', 15, 512) ?>,
                phone: <?php echo json_encode($settings->phone ?? '', 15, 512) ?>,
                email: <?php echo json_encode($settings->email ?? '', 15, 512) ?>,
                whatsapp: <?php echo json_encode($settings->whatsapp ?? '', 15, 512) ?>,
                facebook_url: <?php echo json_encode($settings->facebook_url ?? '', 15, 512) ?>,
                instagram_url: <?php echo json_encode($settings->instagram_url ?? '', 15, 512) ?>,
                linkedin_url: <?php echo json_encode($settings->linkedin_url ?? '', 15, 512) ?>,
                logo_url: <?php echo json_encode($settings->logo_url ?? '', 15, 512) ?>,
                banner_url: <?php echo json_encode($settings->banner_url ?? '', 15, 512) ?>,
                primary_color: <?php echo json_encode($settings->primary_color ?? '#8b5cf6', 15, 512) ?>,
                secondary_color: <?php echo json_encode($settings->secondary_color ?? '#1e293b', 15, 512) ?>,
                stat1: <?php echo json_encode($settings->stat1 ?? '150+', 15, 512) ?>,
                stat2: <?php echo json_encode($settings->stat2 ?? '98%', 15, 512) ?>,
                stat3: <?php echo json_encode($settings->stat3 ?? '24h', 15, 512) ?>
            };
            return values[field] || '';
        }

        // Actualizar campo individual
        function updateField(field, value) {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'PATCH');
            formData.append(field, value);
            formData.append('template', '<?php echo e($template ?? "deportivo"); ?>');
            
            // Mantener otros valores
            const fields = ['home_description', 'nosotros_description', 'nosotros_url', 'contact_message', 'phone', 'email', 'whatsapp', 'logo_url', 'banner_url', 'primary_color', 'secondary_color', 'facebook_url', 'instagram_url', 'linkedin_url'];
            fields.forEach(f => {
                if (f !== field) {
                    formData.append(f, getFieldValue(f));
                }
            });
            
            formData.append('show_vehicles', '<?php echo e($settings->show_vehicles ?? 1); ?>');
            formData.append('show_contact_form', '<?php echo e($settings->show_contact_form ?? 1); ?>');

            fetch('<?php echo e(route("admin.landing-config.update")); ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al guardar: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar los cambios');
            });
        }

        // Cerrar modales con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeTextModal();
                closeImageModal();
                closeContactModal();
                closeStatsModal();
            }
        });
    </script>
    <?php endif; ?>
    
    <!-- Navbar Deportivo -->
    <nav class="sticky top-0 z-50 backdrop-blur-lg border-b" style="border-color: var(--primary-color);">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section inline-block">
                        <?php if($settings && $settings->logo_url): ?>
                            <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-10 object-contain">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-full" style="background: linear-gradient(135deg, var(--primary-color), white);"></div>
                        <?php endif; ?>
                        <div class="edit-btn" onclick="editImage('logo_url')">
                            <i class="fa fa-pencil"></i>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="inline-block relative">
                        <?php if($settings && $settings->logo_url): ?>
                            <img src="<?php echo e($settings->logo_url); ?>" alt="<?php echo e($tenant->name); ?>" class="h-10 object-contain">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-full" style="background: linear-gradient(135deg, var(--primary-color), white);"></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section inline-block">
                        <span class="font-black text-xl tracking-wider" style="color: <?php echo e($settings->agency_name_color ?? '#fff'); ?>"><?php echo e($tenant->name); ?></span>
                        <div class="edit-btn" onclick="editText('agency_name', 'Editar Nombre de Agencia')">
                            <i class="fa fa-pencil"></i>
                        </div>
                    </div>
                <?php else: ?>
                    <span class="font-black text-xl tracking-wider"><?php echo e($tenant->name); ?></span>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-6">
                <div class="hidden md:flex gap-6">
                    <a href="#inicio" class="font-bold" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">INICIO</a>
                    <a href="<?php echo e(route('public.vehiculos')); ?>" class="font-bold" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">VEHÍCULOS</a>
                    <a href="#nosotros" class="font-bold" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">NOSOTROS</a>
                    <a href="#contacto" class="font-bold" style="color: <?php echo e($settings->navbar_links_color ?? 'var(--navbar-text-color, #fff)'); ?>">CONTACTO</a>
                </div>
                
            </div>
        </div>
    </nav>

    <!-- Inicio -->
    <div id="inicio"></div>

    <!-- Hero Deportivo -->
    <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <?php if(isset($editMode) && $editMode): ?>
            <div class="editable-section absolute inset-0">
                <?php if($settings && $settings->banner_url): ?>
                    <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="w-full h-full object-cover blur-sm opacity-50">
                <?php endif; ?>
                <div style="position:absolute;top:16px;right:16px;z-index:1001;">
                    <button class="edit-btn" style="display:inline-flex !important;align-items:center;justify-content:center;background:var(--primary-color);color:#fff;border-radius:50%;font-size:18px;padding:4px;box-shadow:0 2px 8px rgba(0,0,0,0.15);border:none;z-index:1001;" onclick="editImage('banner_url')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                    </button>
                </div>
                <?php if(!($settings && $settings->banner_url)): ?>
                    <div class="w-full h-full flex items-center justify-center bg-gray-700">
                        <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="absolute inset-0">
                <?php if($settings && $settings->banner_url): ?>
                    <img src="<?php echo e($settings->banner_url); ?>" alt="Banner" class="w-full h-full object-cover blur-sm opacity-50">
                <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center bg-gray-700">
                        <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="absolute inset-0" style="background: linear-gradient(135deg, var(--primary-color)22 0%, var(--secondary-color) 100%);"></div>
        
        <div class="relative text-center z-10 px-6 max-w-5xl mx-auto">
            <div class="mb-6 inline-block px-4 py-2 rounded-full" style="background-color: var(--primary-color); color: var(--secondary-color);">
                <span class="font-bold text-sm tracking-widest">BIENVENIDO</span>
            </div>
            
            <?php if(isset($editMode) && $editMode): ?>
                <div class="editable-section block mb-6">
                    <h1 class="text-7xl md:text-8xl font-black hero-text tracking-tighter" style="color: <?php echo e($settings->agency_name_color ?? '#fff'); ?>">
                        <?php echo e($tenant->name); ?>

                    </h1>
                    <div class="edit-btn" onclick="editText('agency_name', 'Editar Título Principal')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                    </div>
                </div>
            <?php else: ?>
                <h1 class="text-7xl md:text-8xl font-black mb-6 hero-text tracking-tighter" style="color: <?php echo e($settings->agency_name_color ?? '#fff'); ?>">
                    <?php echo e($tenant->name); ?>

                </h1>
            <?php endif; ?>
            
            <?php if(isset($editMode) && $editMode): ?>
                <div class="editable-section block mb-8">
                    <p class="text-2xl md:text-3xl hero-text font-light max-w-3xl mx-auto" style="color: <?php echo e($settings->home_description_color ?? '#fff'); ?>">
                        <?php echo e($settings->home_description ?? 'El poder en tus manos'); ?>

                    </p>
                    <div class="edit-btn" onclick="editText('home_description', 'Editar Descripción Principal')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-2xl md:text-3xl mb-8 hero-text font-light max-w-3xl mx-auto" style="color: <?php echo e($settings->home_description_color ?? '#fff'); ?>">
                    <?php echo e($settings->home_description ?? 'El poder en tus manos'); ?>

                </p>
            <?php endif; ?>
    <?php if(isset($editMode) && $editMode): ?>
        <?php echo $__env->make('public.templates.partials.editor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

            <div class="mt-8">
                <a href="<?php echo e(route('public.vehiculos')); ?>" class="inline-block px-8 py-4 rounded-full font-bold text-lg transition hover:shadow-2xl hover:scale-105" style="background-color: var(--primary-color); color: var(--secondary-color);">
                    EXPLORAR CATÁLOGO ↓
                </a>
            </div>
        </div>
    </div>

    <!-- Vehículos Deportivos -->
    <?php if($settings->show_vehicles && count($vehicles) > 0): ?>
        <div id="vehiculos" class="max-w-7xl mx-auto px-6 py-20">
            <div class="mb-16">
                <h2 class="text-6xl font-black mb-4 auto-contrast-title">NUESTRO ARSENAL</h2>
                <div class="w-24 h-2" style="background-color: var(--primary-color);"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="vehicle-card group">
                        <div class="relative">
                            <div class="aspect-square bg-gray-800 overflow-hidden rounded-lg">
                                <img src="<?php echo e($vehicle->main_image); ?>" alt="<?php echo e($vehicle->title); ?>" class="w-full h-full object-cover group-hover:scale-125 transition duration-700">
                            </div>
                            <div class="absolute top-3 right-3 px-3 py-1 rounded-lg backdrop-blur-md" style="background-color: var(--primary-color); color: var(--secondary-color);">
                                <span class="font-black text-xs">$<?php echo e(number_format($vehicle->price)); ?></span>
                            </div>
                            <div class="absolute bottom-3 left-3 backdrop-blur-md px-2 py-1 rounded text-xs font-bold">
                                <?php echo e($vehicle->year); ?>

                            </div>
                        </div>

                        <div class="mt-3">
                            <h3 class="text-base font-black mb-1 line-clamp-1"><?php echo e($vehicle->title); ?></h3>
                            <p class="text-gray-400 mb-2 text-xs"><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?></p>
                            
                            <p class="text-gray-300 text-xs mb-3 line-clamp-1"><?php echo e(Str::limit($vehicle->description, 50)); ?></p>

                            <button onclick="openForm('<?php echo e($vehicle->id); ?>', '<?php echo e($vehicle->title); ?>')" class="w-full py-2 rounded-lg font-black text-xs text-white transition hover:shadow-lg" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                                CONSULTAR
                            </button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Nosotros Deportivo -->
    <div id="nosotros" class="max-w-7xl mx-auto px-6 py-20 border-t" style="border-color: rgba(239, 68, 68, 0.2);">
        <div class="mb-16">
            <h2 class="text-6xl font-black mb-4 auto-contrast-title">SOBRE NOSOTROS</h2>
            <div class="w-24 h-2" style="background-color: var(--primary-color);"></div>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center">
                <?php if(isset($editMode) && $editMode): ?>
                    <div class="editable-section">
                        <div>
                            <p class="text-lg mb-8 leading-relaxed font-semibold whitespace-pre-line" style="color: <?php echo e($settings->nosotros_description_color ?? '#222'); ?>;">
                                <?php echo e($settings->nosotros_description ?? 'Somos una agencia de autos con más de 15 años de experiencia en el mercado automotriz. Nos dedicamos a ofrecer vehículos de alta calidad con los mejores precios del mercado.\n\nNuestro equipo de profesionales está comprometido en brindarte la mejor atención y asesoramiento para que encuentres el vehículo perfecto que se adapte a tus necesidades.'); ?>

                            </p>
                        </div>
                        <div class="edit-btn" onclick="editText('nosotros_description', 'Editar Sección Nosotros')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="18" height="18" fill="currentColor" style="vertical-align:middle"><path d="M12.146 2.146a1 1 0 0 1 1.414 0l.294.294a1 1 0 0 1 0 1.414l-8.5 8.5a1 1 0 0 1-.293.207l-2.5 1.25a.5.5 0 0 1-.66-.66l1.25-2.5a1 1 0 0 1 .207-.293l8.5-8.5zm1.414-1.414a2 2 0 0 0-2.828 0l-8.5 8.5a2 2 0 0 0-.414.586l-1.25 2.5A1.5 1.5 0 0 0 2.5 14.5l2.5-1.25a2 2 0 0 0 .586-.414l8.5-8.5a2 2 0 0 0 0-2.828l-.294-.294z"/></svg>
                        </div>
                        <div class="editable-section grid grid-cols-3 gap-4">
                            <div class="p-4 rounded-lg text-center" style="background: linear-gradient(135deg, var(--primary-color)22, var(--primary-color)11); border: 1px solid var(--primary-color);">
                                <div class="text-4xl font-black" style="color: var(--primary-color);"><?php echo e($settings->stat1 ?? '150+'); ?></div>
                                <p class="text-gray-400 text-sm font-bold mt-2"><?php echo e($settings->stat1_label ?? 'AUTOS VENDIDOS'); ?></p>
                            </div>
                            <div class="p-4 rounded-lg text-center" style="background: linear-gradient(135deg, var(--primary-color)22, var(--primary-color)11); border: 1px solid var(--primary-color);">
                                <div class="text-4xl font-black" style="color: var(--primary-color);"><?php echo e($settings->stat2 ?? '98%'); ?></div>
                                <p class="text-gray-400 text-sm font-bold mt-2"><?php echo e($settings->stat2_label ?? 'SATISFACCIÓN'); ?></p>
                            </div>
                            <div class="p-4 rounded-lg text-center" style="background: linear-gradient(135deg, var(--primary-color)22, var(--primary-color)11); border: 1px solid var(--primary-color);">
                                <div class="text-4xl font-black" style="color: var(--primary-color);"><?php echo e($settings->stat3 ?? '24h'); ?></div>
                                <p class="text-gray-400 text-sm font-bold mt-2"><?php echo e($settings->stat3_label ?? 'ATENCIÓN'); ?></p>
                            </div>
                            <div class="edit-btn" onclick="editStats()">
                                <i class="fa fa-pencil"></i>
                            </div>
                        </div>
                    </div>
                <div class="editable-section rounded-lg overflow-hidden shadow-2xl">
                    <img src="<?php echo e($settings->nosotros_url ?? 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop'); ?>" alt="Nosotros" class="w-full h-full object-cover">
                    <div class="edit-btn" onclick="editImage('nosotros_url')">
                        <i class="fa fa-pencil"></i>
                    </div>
                </div>
            <?php else: ?>
                <div>
                    <p class="text-lg mb-8 leading-relaxed font-semibold whitespace-pre-line" style="color: <?php echo e($settings->nosotros_description_color ?? '#222'); ?>"><?php echo e($settings->nosotros_description ?? 'Somos una agencia de autos con más de 15 años de experiencia en el mercado automotriz. Nos dedicamos a ofrecer vehículos de alta calidad con los mejores precios del mercado.\n\nNuestro equipo de profesionales está comprometido en brindarte la mejor atención y asesoramiento para que encuentres el vehículo perfecto que se adapte a tus necesidades.'); ?></p>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 rounded-lg text-center" style="background: linear-gradient(135deg, var(--primary-color)22, var(--primary-color)11); border: 1px solid var(--primary-color);">
                            <div class="text-4xl font-black" style="color: var(--primary-color);"><?php echo e($settings->stat1 ?? '150+'); ?></div>
                            <p class="text-gray-400 text-sm font-bold mt-2"><?php echo e($settings->stat1_label ?? 'AUTOS VENDIDOS'); ?></p>
                        </div>
                        <div class="p-4 rounded-lg text-center" style="background: linear-gradient(135deg, var(--primary-color)22, var(--primary-color)11); border: 1px solid var(--primary-color);">
                            <div class="text-4xl font-black" style="color: var(--primary-color);"><?php echo e($settings->stat2 ?? '98%'); ?></div>
                            <p class="text-gray-400 text-sm font-bold mt-2"><?php echo e($settings->stat2_label ?? 'SATISFACCIÓN'); ?></p>
                        </div>
                        <div class="p-4 rounded-lg text-center" style="background: linear-gradient(135deg, var(--primary-color)22, var(--primary-color)11); border: 1px solid var(--primary-color);">
                            <div class="text-4xl font-black" style="color: var(--primary-color);"><?php echo e($settings->stat3 ?? '24h'); ?></div>
                            <p class="text-gray-400 text-sm font-bold mt-2"><?php echo e($settings->stat3_label ?? 'ATENCIÓN'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg overflow-hidden shadow-2xl">
                    <img src="<?php echo e($settings->nosotros_url ?? 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop'); ?>" alt="Nosotros" class="w-full h-full object-cover">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Contacto Deportivo -->
    <?php if($settings->show_contact_form): ?>
        <div id="contacto" class="relative py-20 px-6 overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background: linear-gradient(45deg, var(--primary-color) 0%, transparent 50%);"></div>
            
            <div class="max-w-7xl mx-auto relative z-10">
                <div class="mb-16">
                    <h2 class="text-6xl font-black mb-4 auto-contrast-title">CONTACTO</h2>
                        <script>
                        // Contraste automático para títulos principales y de sección
                        function getContrastYIQ(hexcolor) {
                            hexcolor = hexcolor.replace('#', '');
                            if(hexcolor.length === 3) hexcolor = hexcolor.split('').map(x=>x+x).join('');
                            var r = parseInt(hexcolor.substr(0,2),16);
                            var g = parseInt(hexcolor.substr(2,2),16);
                            var b = parseInt(hexcolor.substr(4,2),16);
                            var yiq = ((r*299)+(g*587)+(b*114))/1000;
                            return (yiq >= 180) ? '#222' : '#fff';
                        }
                        function applyTitleContrast() {
                            let bg = getComputedStyle(document.body).backgroundColor;
                            let hex = window.getComputedStyle(document.body).getPropertyValue('--secondary-color') || '#fff';
                            if(hex.startsWith('#')) {
                                // ok
                            } else if(bg) {
                                // fallback: rgb to hex
                                let rgb = bg.match(/\d+/g);
                                if(rgb) hex = '#' + rgb.map(x=>(+x).toString(16).padStart(2,'0')).join('');
                            }
                            document.querySelectorAll('.auto-contrast-title').forEach(el=>{
                                el.style.color = getContrastYIQ(hex.trim());
                            });
                        }
                        document.addEventListener('DOMContentLoaded', applyTitleContrast);
                        window.addEventListener('settings:updated', applyTitleContrast);
                        </script>
                    <div class="w-24 h-2" style="background-color: var(--primary-color);"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-12">
                    <div>
                        <?php if(isset($editMode) && $editMode): ?>
                            <div class="editable-section mb-8">
                                <p class="text-xl text-gray-300"><?php echo e($settings->contact_message); ?></p>
                                <div class="edit-btn" onclick="editText('contact_message', 'Editar Mensaje de Contacto')">
                                    <i class="fa fa-pencil"></i>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-xl text-gray-300 mb-8"><?php echo e($settings->contact_message); ?></p>
                        <?php endif; ?>
                        
                        <?php if(isset($editMode) && $editMode): ?>
                            <div class="editable-section">
                                <div class="space-y-6">
                                    <?php if($settings->phone): ?>
                                        <div>
                                            <p class="text-sm text-gray-400 mb-2 tracking-wider">TELÉFONO</p>
                                            <a href="tel:<?php echo e($settings->phone); ?>" class="text-2xl font-bold hover:text-yellow-400 transition"><?php echo e($settings->phone); ?></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($settings->email): ?>
                                        <div>
                                            <p class="text-sm text-gray-400 mb-2 tracking-wider">EMAIL</p>
                                            <a href="mailto:<?php echo e($settings->email); ?>" class="text-2xl font-bold hover:text-yellow-400 transition"><?php echo e($settings->email); ?></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($settings->whatsapp): ?>
                                        <div>
                                            <p class="text-sm text-gray-400 mb-2 tracking-wider">WHATSAPP</p>
                                            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $settings->whatsapp)); ?>" target="_blank" class="text-2xl font-bold hover:text-yellow-400 transition"><?php echo e($settings->whatsapp); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="edit-btn" onclick="editContact()">
                                    <i class="fa fa-pencil"></i>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="space-y-6">
                                <?php if($settings->phone): ?>
                                    <div>
                                        <p class="text-sm text-gray-400 mb-2 tracking-wider">TELÉFONO</p>
                                        <a href="tel:<?php echo e($settings->phone); ?>" class="text-2xl font-bold hover:text-yellow-400 transition"><?php echo e($settings->phone); ?></a>
                                    </div>
                                <?php endif; ?>
                                <?php if($settings->email): ?>
                                    <div>
                                        <p class="text-sm text-gray-400 mb-2 tracking-wider">EMAIL</p>
                                        <a href="mailto:<?php echo e($settings->email); ?>" class="text-2xl font-bold hover:text-yellow-400 transition"><?php echo e($settings->email); ?></a>
                                    </div>
                                <?php endif; ?>
                                <?php if($settings->whatsapp): ?>
                                    <div>
                                        <p class="text-sm text-gray-400 mb-2 tracking-wider">WHATSAPP</p>
                                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $settings->whatsapp)); ?>" target="_blank" class="text-2xl font-bold hover:text-yellow-400 transition"><?php echo e($settings->whatsapp); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="flex gap-4 mt-8">
                            <?php if($settings->facebook_url): ?>
                                <a href="<?php echo e($settings->facebook_url); ?>" target="_blank" class="text-3xl hover:scale-110 transition">📘</a>
                            <?php endif; ?>
                            <?php if($settings->instagram_url): ?>
                                <a href="<?php echo e($settings->instagram_url); ?>" target="_blank" class="text-3xl hover:scale-110 transition">📷</a>
                            <?php endif; ?>
                            <?php if($settings->linkedin_url): ?>
                                <a href="<?php echo e($settings->linkedin_url); ?>" target="_blank" class="text-3xl hover:scale-110 transition">💼</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <form id="contactForm" action="<?php echo e(\App\Helpers\RouteHelper::publicContactRoute()); ?>" method="POST" class="space-y-4 relative z-0" style="z-index:0 !important;">
                            <?php echo csrf_field(); ?>
                            <input type="text" name="name" placeholder="NOMBRE COMPLETO" required class="w-full px-4 py-3 bg-gray-800 text-white placeholder-gray-500 border-b-2" style="border-color: var(--primary-color);">
                            <input type="email" name="email" placeholder="CORREO ELECTRÓNICO" required class="w-full px-4 py-3 bg-gray-800 text-white placeholder-gray-500 border-b-2" style="border-color: var(--primary-color);">
                            <input type="tel" name="phone" placeholder="TELÉFONO" required class="w-full px-4 py-3 bg-gray-800 text-white placeholder-gray-500 border-b-2" style="border-color: var(--primary-color);">
                            <textarea name="message" placeholder="MENSAJE" rows="5" required class="w-full px-4 py-3 bg-gray-800 text-white placeholder-gray-500 border-b-2 focus:outline-none" style="border-color: var(--primary-color);"></textarea>
                            <input type="hidden" name="vehicle_id" id="vehicle_id">
                            <button type="submit" class="w-full py-4 rounded-lg font-black text-lg transition hover:shadow-2xl" style="background: linear-gradient(135deg, var(--primary-color), var(--tertiary-color));">
                                ENVIAR MENSAJE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="border-t" style="border-color: var(--primary-color); background-color: rgba(0,0,0,0.5);">
        <div class="max-w-7xl mx-auto px-6 py-8 text-center text-gray-400">
            <p class="font-bold">© <?php echo e(date('Y')); ?> <?php echo e($tenant->name); ?> - TODOS LOS DERECHOS RESERVADOS</p>
        </div>
    </footer>

    <script>
        function openForm(vehicleId, title) {
            document.getElementById('vehicle_id').value = vehicleId;
            document.querySelector('textarea[name="message"]').value = `CONSULTA: ${title}\n`;
            document.getElementById('contacto').scrollIntoView({ behavior: 'smooth' });
            document.querySelector('input[name="name"]').focus();
        }
    </script>

        <?php if(isset($editMode) && $editMode): ?>
        <script>
        // Bloquear interacción del formulario de contacto cuando el modal está abierto
        function setContactFormPointerEvents(block) {
            var form = document.getElementById('contactForm');
            if(form) form.style.pointerEvents = block ? 'none' : '';
        }
        // Hook en la apertura/cierre del modal de contacto
        (function() {
            var origEditContact = window.editContact;
            window.editContact = function() {
                setContactFormPointerEvents(true);
                origEditContact();
            };
            var origCloseContactModal = window.closeContactModal;
            window.closeContactModal = function() {
                setContactFormPointerEvents(false);
                origCloseContactModal();
            };
        })();
        </script>
    <!-- Modal para editar texto -->
    <div id="textModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
            <div class="p-6 border-b">
                <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Editar Texto</h3>
            </div>
            <div class="p-6">
                <textarea id="modalTextarea" rows="6" class="w-full px-4 py-2 border rounded-lg text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Escribe el texto aquí o déjalo vacío para eliminar..."></textarea>
                <div id="noNameOption" class="mt-4 hidden flex items-center gap-2">
                    <input type="checkbox" id="noNameCheckbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="noNameCheckbox" class="text-gray-800 text-sm select-none">Usar sin nombre</label>
                </div>
                <div id="noNameTip" class="mt-4 text-gray-500 text-sm flex items-center gap-2">
                    <span>💡 Tip: Puedes borrar todo el contenido para ocultar esta sección</span>
                </div>
            </div>
            <div class="p-6 border-t flex justify-end gap-3">
                <button onclick="closeTextModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancelar
                </button>
                <button onclick="saveText()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para editar imagen -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6 border-b">
                <h3 class="text-xl font-bold text-gray-900">Cambiar Imagen</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">📁 Subir desde tu dispositivo</label>
                    <input type="file" id="modalImageFile" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (máx. 5MB)</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex-1 h-px bg-gray-300"></div>
                    <span class="text-xs text-gray-500">O</span>
                    <div class="flex-1 h-px bg-gray-300"></div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">🔗 URL de imagen</label>
                    <input type="url" id="modalImageUrl" placeholder="https://ejemplo.com/imagen.jpg" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                    <p class="text-xs text-gray-500 mt-1">Unsplash, Imgur, o cualquier URL</p>
                </div>
                <div id="imagePreview" class="hidden mt-4">
                    <img id="imagePreviewImg" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg">
                </div>
            </div>
            <div class="p-6 border-t flex justify-end gap-3">
                <button onclick="closeImageModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancelar
                </button>
                <button onclick="saveImage()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <span id="imageSaveText">Guardar</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para editar contacto (único, funcional, centrado y oculto por defecto) -->
    <!-- Modal para editar contacto (siempre al final del body, z-index máximo) -->
    <div id="contactModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4" style="z-index:999999999 !important;">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6 border-b">
                <h3 class="text-xl font-bold text-gray-900">Información de Contacto</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Teléfono</label>
                    <input type="text" id="modalPhone" class="w-full px-4 py-2 border rounded-lg text-gray-900">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Email</label>
                    <input type="email" id="modalEmail" class="w-full px-4 py-2 border rounded-lg text-gray-900">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Whatsapp</label>
                    <input type="text" id="modalWhatsapp" class="w-full px-4 py-2 border rounded-lg text-gray-900">
                </div>
            </div>
            <div class="p-6 border-t flex justify-end gap-3">
                <button onclick="closeContactModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancelar
                </button>
                <button onclick="saveContact()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </div>
        </div>

        <script>
        // Mover el modal al final del body para evitar stacking context
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('contactModal');
            if (modal && modal.parentNode !== document.body) {
                document.body.appendChild(modal);
            }
        });
        </script>

    <!-- Modal para editar estadísticas -->
    <div id="statsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6 border-b">
                <h3 class="text-xl font-bold text-gray-900">Editar Estadísticas</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Autos Vendidos</label>
                    <input type="text" id="modalStat1" placeholder="150+" class="w-full px-4 py-2 border rounded-lg text-gray-900">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Satisfacción</label>
                    <input type="text" id="modalStat2" placeholder="98%" class="w-full px-4 py-2 border rounded-lg text-gray-900">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Atención</label>
                    <input type="text" id="modalStat3" placeholder="24h" class="w-full px-4 py-2 border rounded-lg text-gray-900">
                </div>
            </div>
            <div class="p-6 border-t flex justify-end gap-3">
                <button onclick="closeStatsModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Cancelar
                </button>
                <button onclick="saveStats()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <?php endif; ?>

        <?php if(isset($editMode) && $editMode): ?>
        <script>
        window.addEventListener('DOMContentLoaded', function() {
            if (typeof editText === 'function') {
                const originalEditText = editText;
                editText = function(field, title) {
                    originalEditText(field, title);
                    const noNameOption = document.getElementById('noNameOption');
                    const noNameCheckbox = document.getElementById('noNameCheckbox');
                    const noNameTip = document.getElementById('noNameTip');
                    if(field === 'agency_name') {
                        noNameOption.classList.remove('hidden');
                        if(noNameTip) noNameTip.classList.remove('hidden');
                        noNameCheckbox.checked = (document.getElementById('modalTextarea').value.trim() === '');
                        noNameCheckbox.onchange = function() {
                            if(this.checked) {
                                document.getElementById('modalTextarea').value = '';
                            }
                        };
                    } else {
                        noNameOption.classList.add('hidden');
                        if(noNameTip) noNameTip.classList.add('hidden');
                        noNameCheckbox.onchange = null;
                    }
                }
            }
        });
        </script>
        <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Proyectos\ProyectoAutos\resources\views/public/templates/deportivo.blade.php ENDPATH**/ ?>