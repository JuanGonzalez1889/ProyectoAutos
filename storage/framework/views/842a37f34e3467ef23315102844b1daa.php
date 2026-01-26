<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Editor Visual - <?php echo e(ucfirst($template)); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: <?php echo e($settings->primary_color ?? '#8b5cf6'); ?>;
            --secondary-color: <?php echo e($settings->secondary_color ?? '#1e293b'); ?>;
            --tertiary-color: <?php echo e($settings->tertiary_color ?? '#ffaa00'); ?>;
        }
    </style>
</head>
<body class="bg-black text-white m-0 p-0">
    <!-- Barra Superior Flotante -->
    <div class="fixed top-0 left-0 right-0 z-40 bg-slate-900 border-b border-slate-700 shadow-2xl">
        <div class="h-20 px-8 flex items-center justify-between">
            <!-- Izquierda: Logo y título -->
            <div class="flex items-center gap-6">
                <a href="<?php echo e(route('admin.landing-template.select')); ?>" class="flex items-center gap-2 hover:opacity-70 transition">
                    <i class="fas fa-arrow-left text-white text-lg"></i>
                    <span class="text-sm font-medium text-gray-400">Volver</span>
                </a>
                <div class="w-px h-8 bg-slate-700"></div>
                <div>
                    <h2 class="text-white font-bold text-lg">Editor Visual</h2>
                    <p class="text-xs text-gray-400"><?php echo e(ucfirst($template)); ?> — Clickea los elementos para editar</p>
                </div>
            </div>

            <!-- Centro: Selectores de Color -->
            <div class="flex items-center gap-6">
                <div>
                    <label class="text-xs text-gray-400 block mb-2 font-medium">🎨 Color Primario</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" id="primaryColor" value="<?php echo e($settings->primary_color ?? '#8b5cf6'); ?>" class="h-9 w-14 rounded cursor-pointer border border-slate-700">
                        <input type="text" id="primaryColorText" value="<?php echo e($settings->primary_color ?? '#8b5cf6'); ?>" class="w-24 px-2 h-9 bg-slate-800 border border-slate-700 rounded text-xs font-mono text-white" readonly>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-gray-400 block mb-2 font-medium">🎨 Color Secundario</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" id="secondaryColor" value="<?php echo e($settings->secondary_color ?? '#1e293b'); ?>" class="h-9 w-14 rounded cursor-pointer border border-slate-700">
                        <input type="text" id="secondaryColorText" value="<?php echo e($settings->secondary_color ?? '#1e293b'); ?>" class="w-24 px-2 h-9 bg-slate-800 border border-slate-700 rounded text-xs font-mono text-white" readonly>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-gray-400 block mb-2 font-medium">🎨 Color Terciario</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" id="tertiaryColor" value="<?php echo e($settings->tertiary_color ?? '#ffaa00'); ?>" class="h-9 w-14 rounded cursor-pointer border border-slate-700">
                        <input type="text" id="tertiaryColorText" value="<?php echo e($settings->tertiary_color ?? '#ffaa00'); ?>" class="w-24 px-2 h-9 bg-slate-800 border border-slate-700 rounded text-xs font-mono text-white" readonly>
                    </div>
                </div>
            </div>

            <!-- Derecha: Botones de acción -->
            <div class="flex items-center gap-3">
                <button onclick="saveColors()" class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-lg">
                    <i class="fas fa-check"></i>
                    Guardar
                </button>
                <a href="<?php echo e(route('public.landing')); ?>" target="_blank" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-lg">
                    <i class="fas fa-external-link-alt"></i>
                    Ver en vivo
                </a>
            </div>
        </div>
    </div>

    <!-- Contenedor principal (debajo de la barra) -->
    <div class="h-screen w-screen overflow-hidden" style="padding-top: 100px;">
        <iframe src="<?php echo e(route('landing.preview', $template)); ?>?edit=true" class="w-full h-full border-none" title="Vista previa editable de la landing page" id="editorFrame"></iframe>
    </div>

    <script>
        function updateColor(type, value) {
            if (type === 'primary') {
                document.getElementById('primaryColorText').value = value;
            } else if (type === 'secondary') {
                document.getElementById('secondaryColorText').value = value;
            } else if (type === 'tertiary') {
                document.getElementById('tertiaryColorText').value = value;
            }
        }

        // Funciones para editar desde dentro del iframe
        window.editText = function(field, title) {
            const iframe = document.getElementById('editorFrame');
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            const modalTitle = iframeDoc.getElementById('modalTitle');
            const modalTextarea = iframeDoc.getElementById('modalTextarea');
            const textModal = iframeDoc.getElementById('textModal');
            
            if (modalTitle && modalTextarea && textModal) {
                modalTitle.textContent = title;
                modalTextarea.value = getFieldValueFromIframe(field, iframe);
                textModal.classList.remove('hidden');
                window.currentField = field;
            }
        };

        window.editImage = function(field) {
            const iframe = document.getElementById('editorFrame');
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            const modalImageUrl = iframeDoc.getElementById('modalImageUrl');
            const imageModal = iframeDoc.getElementById('imageModal');
            
            if (modalImageUrl && imageModal) {
                modalImageUrl.value = getFieldValueFromIframe(field, iframe);
                imageModal.classList.remove('hidden');
                window.currentField = field;
            }
        };

        window.editContact = function() {
            const iframe = document.getElementById('editorFrame');
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            const contactModal = iframeDoc.getElementById('contactModal');
            
            if (contactModal) {
                iframeDoc.getElementById('modalPhone').value = getFieldValueFromIframe('phone', iframe);
                iframeDoc.getElementById('modalEmail').value = getFieldValueFromIframe('email', iframe);
                iframeDoc.getElementById('modalWhatsapp').value = getFieldValueFromIframe('whatsapp', iframe);
                contactModal.classList.remove('hidden');
            }
        };

        window.editStats = function() {
            const iframe = document.getElementById('editorFrame');
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            const statsModal = iframeDoc.getElementById('statsModal');
            
            if (statsModal) {
                statsModal.classList.remove('hidden');
            }
        };

        function getFieldValueFromIframe(field, iframe) {
            const values = {
                home_description: <?php echo json_encode($settings->home_description ?? ''); ?>,
                agency_name: <?php echo json_encode($tenant->name ?? ''); ?>,
                contact_message: <?php echo json_encode($settings->contact_message ?? ''); ?>,
                phone: <?php echo json_encode($settings->phone ?? ''); ?>,
                email: <?php echo json_encode($settings->email ?? ''); ?>,
                whatsapp: <?php echo json_encode($settings->whatsapp ?? ''); ?>,
                logo_url: <?php echo json_encode($settings->logo_url ?? ''); ?>,
                banner_url: <?php echo json_encode($settings->banner_url ?? ''); ?>,
                nosotros_image: 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop'
            };
            return values[field] || '';
        }

        window.saveColors = function() {
            const primaryColor = document.getElementById('primaryColor').value;
            const secondaryColor = document.getElementById('secondaryColor').value;
            const tertiaryColor = document.getElementById('tertiaryColor').value;

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'PATCH');
            formData.append('primary_color', primaryColor);
            formData.append('secondary_color', secondaryColor);
            formData.append('tertiary_color', tertiaryColor);
            formData.append('template', '<?php echo e($template); ?>');

            // Mantener valores actuales usando un objeto
            const currentValues = {
                home_description: <?php echo json_encode($settings->home_description ?? ''); ?>,
                nosotros_description: <?php echo json_encode($settings->nosotros_description ?? ''); ?>,
                nosotros_url: <?php echo json_encode($settings->nosotros_url ?? ''); ?>,
                contact_message: <?php echo json_encode($settings->contact_message ?? ''); ?>,
                phone: <?php echo json_encode($settings->phone ?? ''); ?>,
                email: <?php echo json_encode($settings->email ?? ''); ?>,
                whatsapp: <?php echo json_encode($settings->whatsapp ?? ''); ?>,
                logo_url: <?php echo json_encode($settings->logo_url ?? ''); ?>,
                banner_url: <?php echo json_encode($settings->banner_url ?? ''); ?>,
                facebook_url: <?php echo json_encode($settings->facebook_url ?? ''); ?>,
                instagram_url: <?php echo json_encode($settings->instagram_url ?? ''); ?>,
                linkedin_url: <?php echo json_encode($settings->linkedin_url ?? ''); ?>,
                stat1: <?php echo json_encode($settings->stat1 ?? ''); ?>,
                stat2: <?php echo json_encode($settings->stat2 ?? ''); ?>,
                stat3: <?php echo json_encode($settings->stat3 ?? ''); ?>,
                stat1_label: <?php echo json_encode($settings->stat1_label ?? ''); ?>,
                stat2_label: <?php echo json_encode($settings->stat2_label ?? ''); ?>,
                stat3_label: <?php echo json_encode($settings->stat3_label ?? ''); ?>

            };

            // Agregar solo campos no vacíos
            Object.keys(currentValues).forEach(key => {
                if (currentValues[key]) {
                    formData.append(key, currentValues[key]);
                }
            });

            formData.append('show_vehicles', '<?php echo e($settings->show_vehicles ? "1" : "0"); ?>');
            formData.append('show_contact_form', '<?php echo e($settings->show_contact_form ? "1" : "0"); ?>');

            fetch('<?php echo e(route("admin.landing-config.update")); ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Recargar página completa para ver los cambios
                    location.reload();
                } else {
                    alert('❌ Error al guardar: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Error al guardar');
            });
        }

        // Permitir guardar con Ctrl+S
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                saveColors();
            }
        });

        // Actualizar color cuando cambian los inputs
        document.getElementById('primaryColor').addEventListener('change', function() {
            updateColor('primary', this.value);
        });
        document.getElementById('secondaryColor').addEventListener('change', function() {
            updateColor('secondary', this.value);
        });
        document.getElementById('tertiaryColor').addEventListener('change', function() {
            updateColor('tertiary', this.value);
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\Juan Gonzalez\Desktop\JuanMauro\ProyectoAutos\resources\views/admin/landing-template/edit.blade.php ENDPATH**/ ?>