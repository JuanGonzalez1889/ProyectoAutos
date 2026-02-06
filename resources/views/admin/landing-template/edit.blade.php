<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editor Visual - {{ ucfirst($template) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: {{ $settings->primary_color ?? '#8b5cf6' }};
            --secondary-color: {{ $settings->secondary_color ?? '#1e293b' }};
            --tertiary-color: {{ $settings->tertiary_color ?? '#ffaa00' }};
        }
    </style>
</head>
<body class="bg-black text-white m-0 p-0">
    <!-- Barra Superior Flotante -->
    <div class="fixed top-0 left-0 right-0 z-40 bg-slate-900 border-b border-slate-700 shadow-2xl">
        <div class="h-24 px-8 flex items-center justify-between">
            <!-- Izquierda: Logo y título -->
            <div class="flex items-center gap-6">
                                <!-- Eliminado: ahora el color de links navbar está junto a los otros colores principales -->
                                <!-- Eliminado: ahora el color de links navbar está junto a los otros colores principales -->
                <a href="{{ route('admin.landing-template.select') }}" class="flex items-center gap-2 hover:opacity-70 transition">
                    <i class="fas fa-arrow-left text-white text-xl"></i>
                    <span class="text-base font-medium text-gray-400">Volver</span>
                </a>
                <div class="w-px h-8 bg-slate-700"></div>
                <div>
                    <h2 class="text-white font-bold text-xl">Editor Visual</h2>
                    <p class="text-sm text-gray-400">{{ ucfirst($template) }} — Clickea los elementos para editar</p>
                </div>
            </div>

            <!-- Centro: Selectores de Color -->
            <div class="flex items-center gap-6">
                <div>
                    <label class="text-sm text-gray-400 block mb-2 font-medium">🎨 Color Primario</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" id="primaryColor" value="{{ $settings->primary_color ?? '#8b5cf6' }}" class="h-11 w-16 rounded cursor-pointer border border-slate-700">
                        <input type="text" id="primaryColorText" value="{{ $settings->primary_color ?? '#8b5cf6' }}" class="w-28 px-2 h-11 bg-slate-800 border border-slate-700 rounded text-sm font-mono text-white" readonly>
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-400 block mb-2 font-medium">🎨 Color Secundario</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" id="secondaryColor" value="{{ $settings->secondary_color ?? '#1e293b' }}" class="h-11 w-16 rounded cursor-pointer border border-slate-700">
                        <input type="text" id="secondaryColorText" value="{{ $settings->secondary_color ?? '#1e293b' }}" class="w-28 px-2 h-11 bg-slate-800 border border-slate-700 rounded text-sm font-mono text-white" readonly>
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-400 block mb-2 font-medium">🎨 Color Terciario</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" id="tertiaryColor" value="{{ $settings->tertiary_color ?? '#ffaa00' }}" class="h-11 w-16 rounded cursor-pointer border border-slate-700">
                        <input type="text" id="tertiaryColorText" value="{{ $settings->tertiary_color ?? '#ffaa00' }}" class="w-28 px-2 h-11 bg-slate-800 border border-slate-700 rounded text-sm font-mono text-white" readonly>
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-400 block mb-2 font-medium">🔗 Color Links Navbar</label>
                    <div class="flex gap-2 items-center">
                        <input type="color" id="navbarLinksColor" value="{{ $settings->navbar_links_color ?? '#ffffff' }}" class="h-11 w-16 rounded cursor-pointer border border-slate-700">
                        <input type="text" id="navbarLinksColorText" value="{{ $settings->navbar_links_color ?? '#ffffff' }}" class="w-28 px-2 h-11 bg-slate-800 border border-slate-700 rounded text-sm font-mono text-white" readonly>
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-400 block mb-2 font-medium">🔤 Fuente Global</label>
                    <select id="fontFamilySelect" class="h-11 w-56 bg-slate-800 border border-slate-700 rounded text-sm text-white px-2">
                        <option value="" {{ empty($settings->font_family) ? 'selected' : '' }}>(Por defecto)</option>
                        <option value="Roboto, sans-serif" {{ $settings->font_family === 'Roboto, sans-serif' ? 'selected' : '' }}>Roboto</option>
                        <option value="Open Sans, sans-serif" {{ $settings->font_family === 'Open Sans, sans-serif' ? 'selected' : '' }}>Open Sans</option>
                        <option value="Montserrat, sans-serif" {{ $settings->font_family === 'Montserrat, sans-serif' ? 'selected' : '' }}>Montserrat</option>
                        <option value="Lato, sans-serif" {{ $settings->font_family === 'Lato, sans-serif' ? 'selected' : '' }}>Lato</option>
                        <option value="Poppins, sans-serif" {{ $settings->font_family === 'Poppins, sans-serif' ? 'selected' : '' }}>Poppins</option>
                        <option value="Inter, sans-serif" {{ $settings->font_family === 'Inter, sans-serif' ? 'selected' : '' }}>Inter</option>
                        <option value="Nunito, sans-serif" {{ $settings->font_family === 'Nunito, sans-serif' ? 'selected' : '' }}>Nunito</option>
                        <option value="Oswald, sans-serif" {{ $settings->font_family === 'Oswald, sans-serif' ? 'selected' : '' }}>Oswald</option>
                        <option value="Raleway, sans-serif" {{ $settings->font_family === 'Raleway, sans-serif' ? 'selected' : '' }}>Raleway</option>
                        <option value="Merriweather, serif" {{ $settings->font_family === 'Merriweather, serif' ? 'selected' : '' }}>Merriweather</option>
                        <option value="Playfair Display, serif" {{ $settings->font_family === 'Playfair Display, serif' ? 'selected' : '' }}>Playfair Display</option>
                        <option value="Muli, sans-serif" {{ $settings->font_family === 'Muli, sans-serif' ? 'selected' : '' }}>Muli</option>
                        <option value="Quicksand, sans-serif" {{ $settings->font_family === 'Quicksand, sans-serif' ? 'selected' : '' }}>Quicksand</option>
                        <option value="Source Sans Pro, sans-serif" {{ $settings->font_family === 'Source Sans Pro, sans-serif' ? 'selected' : '' }}>Source Sans Pro</option>
                        <option value="Work Sans, sans-serif" {{ $settings->font_family === 'Work Sans, sans-serif' ? 'selected' : '' }}>Work Sans</option>
                        <option value="PT Sans, sans-serif" {{ $settings->font_family === 'PT Sans, sans-serif' ? 'selected' : '' }}>PT Sans</option>
                        <option value="Ubuntu, sans-serif" {{ $settings->font_family === 'Ubuntu, sans-serif' ? 'selected' : '' }}>Ubuntu</option>
                        <option value="Fira Sans, sans-serif" {{ $settings->font_family === 'Fira Sans, sans-serif' ? 'selected' : '' }}>Fira Sans</option>
                        <option value="Arial, Helvetica, sans-serif" {{ $settings->font_family === 'Arial, Helvetica, sans-serif' ? 'selected' : '' }}>Arial</option>
                        <option value="Tahoma, Geneva, sans-serif" {{ $settings->font_family === 'Tahoma, Geneva, sans-serif' ? 'selected' : '' }}>Tahoma</option>
                        <option value="Verdana, Geneva, sans-serif" {{ $settings->font_family === 'Verdana, Geneva, sans-serif' ? 'selected' : '' }}>Verdana</option>
                        <option value="Times New Roman, Times, serif" {{ $settings->font_family === 'Times New Roman, Times, serif' ? 'selected' : '' }}>Times New Roman</option>
                        <option value="Georgia, serif" {{ $settings->font_family === 'Georgia, serif' ? 'selected' : '' }}>Georgia</option>
                        <option value="Courier New, Courier, monospace" {{ $settings->font_family === 'Courier New, Courier, monospace' ? 'selected' : '' }}>Courier New</option>
                        <option value="monospace" {{ $settings->font_family === 'monospace' ? 'selected' : '' }}>Monospace</option>
                    </select>
                </div>
            </div>

            <!-- Derecha: Botones de acción -->
            <div class="flex items-center gap-3">
                <button onclick="publishLanding()" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg text-base font-semibold transition flex items-center gap-2 shadow-lg" id="publishBtn">
                    <i class="fas fa-rocket"></i>
                    Publicar
                </button>
                <a href="{{ $previewUrl }}" target="_blank" class="px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white rounded-lg text-base font-semibold transition flex items-center gap-2 shadow-lg" @if($primaryDomain) title="Abrirá {{ $primaryDomain->domain }}. En local, agregá {{ $primaryDomain->domain }} -> 127.0.0.1 en hosts." @endif>
                    <i class="fas fa-external-link-alt"></i>
                    Previsualizar
                </a>
            </div>
        </div>
    </div>

    <!-- Contenedor principal (debajo de la barra) -->
    <div class="h-screen w-screen overflow-hidden" style="padding-top: 120px;">
        <iframe src="{{ route('landing.preview', $template) }}?edit=true" class="w-full h-full border-none" title="Vista previa editable de la landing page" id="editorFrame"></iframe>
    </div>

    <!-- Botón flotante de guardado (fallback si no se ve la barra superior) -->
    <button onclick="publishLanding()" class="fixed bottom-6 right-6 z-50 px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-full text-sm font-semibold transition flex items-center gap-2 shadow-2xl" id="publishBtnFloating">
        <i class="fas fa-save"></i>
        Guardar cambios
    </button>

    <script>
        function updateColor(type, value) {
            if (type === 'primary') {
                document.getElementById('primaryColorText').value = value;
            } else if (type === 'secondary') {
                document.getElementById('secondaryColorText').value = value;
            } else if (type === 'tertiary') {
                document.getElementById('tertiaryColorText').value = value;
            } else if (type === 'navbarLinks') {
                document.getElementById('navbarLinksColorText').value = value;
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
                home_description: @json($settings->home_description ?? ''),
                agency_name: @json($tenant->name ?? ''),
                contact_message: @json($settings->contact_message ?? ''),
                phone: @json($settings->phone ?? ''),
                email: @json($settings->email ?? ''),
                whatsapp: @json($settings->whatsapp ?? ''),
                logo_url: @json($settings->logo_url ?? ''),
                banner_url: @json($settings->banner_url ?? ''),
                nosotros_image: 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop'
            };
            return values[field] || '';
        }

        window.publishLanding = function() {
            const btn = document.getElementById('publishBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Publicando...';

            const primaryColor = document.getElementById('primaryColor').value;
            const secondaryColor = document.getElementById('secondaryColor').value;
            const tertiaryColor = document.getElementById('tertiaryColor').value;
            const navbarLinksColor = document.getElementById('navbarLinksColor').value;
            const fontFamily = document.getElementById('fontFamilySelect').value;

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'PATCH');
            formData.append('primary_color', primaryColor);
            formData.append('secondary_color', secondaryColor);
            formData.append('tertiary_color', tertiaryColor);
            formData.append('navbar_links_color', navbarLinksColor);
            formData.append('font_family', fontFamily);
            formData.append('template', '{{ $template }}');

            // Mantener valores actuales usando un objeto
            const currentValues = {
                home_description: @json($settings->home_description ?? ''),
                nosotros_description: @json($settings->nosotros_description ?? ''),
                nosotros_url: @json($settings->nosotros_url ?? ''),
                contact_message: @json($settings->contact_message ?? ''),
                phone: @json($settings->phone ?? ''),
                email: @json($settings->email ?? ''),
                whatsapp: @json($settings->whatsapp ?? ''),
                logo_url: @json($settings->logo_url ?? ''),
                banner_url: @json($settings->banner_url ?? ''),
                facebook_url: @json($settings->facebook_url ?? ''),
                instagram_url: @json($settings->instagram_url ?? ''),
                linkedin_url: @json($settings->linkedin_url ?? ''),
                stat1: @json($settings->stat1 ?? ''),
                stat2: @json($settings->stat2 ?? ''),
                stat3: @json($settings->stat3 ?? ''),
                stat1_label: @json($settings->stat1_label ?? ''),
                stat2_label: @json($settings->stat2_label ?? ''),
                stat3_label: @json($settings->stat3_label ?? '')
            };

            // Agregar solo campos no vacíos
            Object.keys(currentValues).forEach(key => {
                if (currentValues[key]) {
                    formData.append(key, currentValues[key]);
                }
            });

            formData.append('show_vehicles', '{{ $settings->show_vehicles ? "1" : "0" }}');
            formData.append('show_contact_form', '{{ $settings->show_contact_form ? "1" : "0" }}');

            fetch('{{ route("admin.landing-config.update") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                if (data.success) {
                    // Mostrar notificación de éxito
                    showNotification('✅ Landing page publicada correctamente', 'success');
                    // Recargar después de 1.5 segundos
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification('❌ Error al publicar: ' + (data.message || 'Error desconocido'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                btn.innerHTML = originalText;
                showNotification('❌ Error al publicar', 'error');
            });
        };

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-6 right-6 px-6 py-3 rounded-lg text-white font-semibold z-50 animate-fadeIn ${
                type === 'success' ? 'bg-green-600' : 'bg-red-600'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }

        // Permitir publicar con Ctrl+S
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                publishLanding();
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
        document.getElementById('navbarLinksColor').addEventListener('change', function() {
            updateColor('navbarLinks', this.value);
        });
    </script>
</body>
</html>
