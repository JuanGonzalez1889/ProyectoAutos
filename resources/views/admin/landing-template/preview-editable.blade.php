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
        .editable-section {
            position: relative;
            transition: all 0.2s;
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
            z-index: 50;
        }
        .editable-section:hover .edit-btn {
            display: flex;
        }
        .edit-btn:hover {
            background: #2563eb;
        }
    </style>
</head>
<body class="bg-gray-50" style="zoom: 1.25;">
    @include("public.templates.{$template}", [
        'settings' => $settings,
        'tenant' => $tenant,
        'vehicles' => [],
        'editMode' => true
    ])

    <!-- Modal para editar texto -->
    <div id="textModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
            <div class="p-6 border-b">
                <h3 class="text-xl font-bold" id="modalTitle">Editar Texto</h3>
            </div>
            <div class="p-6">
                <textarea id="modalTextarea" rows="6" class="w-full px-4 py-2 border rounded-lg text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>
            <div class="p-6 border-t flex justify-end gap-3">
                <button onclick="closeTextModal()" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
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
                <h3 class="text-xl font-bold">Cambiar Imagen</h3>
            </div>
            <div class="p-6">
                <label class="text-sm font-medium text-gray-700 mb-2 block">URL de la imagen</label>
                <input type="url" id="modalImageUrl" placeholder="https://ejemplo.com/imagen.jpg" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-xs text-gray-500 mt-2">Puedes usar Unsplash, Imgur, o cualquier URL de imagen</p>
            </div>
            <div class="p-6 border-t flex justify-end gap-3">
                <button onclick="closeImageModal()" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                    Cancelar
                </button>
                <button onclick="saveImage()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para editar contacto -->
    <div id="contactModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6 border-b">
                <h3 class="text-xl font-bold">Información de Contacto</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Teléfono</label>
                    <input type="text" id="modalPhone" placeholder="+54 9 11 1234-5678" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Email</label>
                    <input type="email" id="modalEmail" placeholder="contacto@ejemplo.com" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">WhatsApp</label>
                    <input type="text" id="modalWhatsapp" placeholder="+54 9 11 1234-5678" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
            <div class="p-6 border-t flex justify-end gap-3">
                <button onclick="closeContactModal()" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                    Cancelar
                </button>
                <button onclick="saveContact()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentField = null;

        // Editar texto
        function editText(field, title) {
            currentField = field;
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalTextarea').value = getFieldValue(field);
            document.getElementById('textModal').classList.remove('hidden');
        }

        function closeTextModal() {
            document.getElementById('textModal').classList.add('hidden');
            currentField = null;
        }

        function saveText() {
            if (!currentField) return;
            
            const value = document.getElementById('modalTextarea').value;
            updateField(currentField, value);
            closeTextModal();
        }

        // Editar imagen
        function editImage(field) {
            currentField = field;
            document.getElementById('modalImageUrl').value = getFieldValue(field);
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            currentField = null;
        }

        function saveImage() {
            if (!currentField) return;
            
            const value = document.getElementById('modalImageUrl').value;
            updateField(currentField, value);
            closeImageModal();
        }

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
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'PATCH');
            formData.append('phone', document.getElementById('modalPhone').value);
            formData.append('email', document.getElementById('modalEmail').value);
            formData.append('whatsapp', document.getElementById('modalWhatsapp').value);
            formData.append('template', '{{ $template }}');
            
            // Mantener valores actuales
            formData.append('home_description', getFieldValue('home_description'));
            formData.append('contact_message', getFieldValue('contact_message'));
            formData.append('logo_url', getFieldValue('logo_url'));
            formData.append('banner_url', getFieldValue('banner_url'));
            formData.append('primary_color', getFieldValue('primary_color'));
            formData.append('secondary_color', getFieldValue('secondary_color'));
            formData.append('facebook_url', getFieldValue('facebook_url'));
            formData.append('instagram_url', getFieldValue('instagram_url'));
            formData.append('linkedin_url', getFieldValue('linkedin_url'));
            formData.append('show_vehicles', '{{ $settings->show_vehicles ? "1" : "0" }}');
            formData.append('show_contact_form', '{{ $settings->show_contact_form ? "1" : "0" }}');

            fetch('{{ route("admin.landing-config.update") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                closeContactModal();
                window.parent.location.reload();
            })
            .catch(error => console.error('Error:', error));
        }

        // Helper para obtener valores actuales
        function getFieldValue(field) {
            const values = {
                home_description: '{{ addslashes($settings->home_description ?? "") }}',
                nosotros_description: 'Somos una agencia de autos con más de 15 años de experiencia en el mercado automotriz. Nos dedicamos a ofrecer vehículos de alta calidad con los mejores precios del mercado.\n\nNuestro equipo de profesionales está comprometido en brindarte la mejor atención y asesoramiento para que encuentres el vehículo perfecto que se adapte a tus necesidades.',
                contact_message: '{{ addslashes($settings->contact_message ?? "") }}',
                phone: '{{ $settings->phone ?? "" }}',
                email: '{{ $settings->email ?? "" }}',
                whatsapp: '{{ $settings->whatsapp ?? "" }}',
                facebook_url: '{{ $settings->facebook_url ?? "" }}',
                instagram_url: '{{ $settings->instagram_url ?? "" }}',
                linkedin_url: '{{ $settings->linkedin_url ?? "" }}',
                logo_url: '{{ $settings->logo_url ?? "" }}',
                banner_url: '{{ $settings->banner_url ?? "" }}',
                nosotros_image: 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=600&h=500&fit=crop',
                primary_color: '{{ $settings->primary_color ?? "#8b5cf6" }}',
                secondary_color: '{{ $settings->secondary_color ?? "#1e293b" }}'
            };
            return values[field] || '';
        }

        // Actualizar campo individual
        function updateField(field, value) {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('_method', 'PATCH');
            formData.append(field, value);
            formData.append('template', '{{ $template }}');
            
            // Mantener otros valores (excepto nosotros_description y nosotros_image que no se guardan en DB)
            const fields = ['home_description', 'contact_message', 'phone', 'email', 'whatsapp', 'logo_url', 'banner_url', 'primary_color', 'secondary_color', 'facebook_url', 'instagram_url', 'linkedin_url'];
            fields.forEach(f => {
                if (f !== field) {
                    formData.append(f, getFieldValue(f));
                }
            });
            
            formData.append('show_vehicles', '{{ $settings->show_vehicles ? "1" : "0" }}');
            formData.append('show_contact_form', '{{ $settings->show_contact_form ? "1" : "0" }}');

            fetch('{{ route("admin.landing-config.update") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Recargar la página completa del editor
                window.parent.location.reload();
            })
            .catch(error => console.error('Error:', error));
        }

        // Cerrar modales con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeTextModal();
                closeImageModal();
                closeContactModal();
            }
        });
    </script>
</body>
</html>
