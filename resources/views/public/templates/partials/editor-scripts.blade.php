@php /* Reutilizable en plantillas en modo edición */ @endphp
@if(isset($editMode) && $editMode)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script>
let currentField = null;

function editText(field, title){
  currentField = field;
  document.getElementById('modalTitle').textContent = title;
  document.getElementById('modalTextarea').value = getFieldValue(field);
  // Cargar el color correspondiente si existe
  let colorField = field + '_color';
  let colorValue = getFieldValue(colorField);
  if (!colorValue || !/^#[0-9A-Fa-f]{6}$/.test(colorValue)) {
    // fallback por campo
    if(field === 'home_description' || field === 'agency_name') colorValue = '#fff';
    else if(field === 'nosotros_description') colorValue = '#222';
    else colorValue = '#fff';
  }
  document.getElementById('modalTextColor').value = colorValue;
  document.getElementById('textModal').classList.remove('hidden');
}
function closeTextModal(){
  document.getElementById('textModal').classList.add('hidden');
  currentField = null;
}
function saveText(){
  if(!currentField) return;
  const value = document.getElementById('modalTextarea').value;
  const color = document.getElementById('modalTextColor').value;
  // Enviar ambos campos juntos
  const fd = new FormData();
  fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
  fd.append('_method','PATCH');
  fd.append(currentField, value);
  fd.append(currentField + '_color', color);
  fd.append('template','{{ $template ?? "moderno" }}');
  const fields=['home_description','nosotros_description','nosotros_url','contact_message','phone','email','whatsapp','logo_url','banner_url','primary_color','secondary_color','facebook_url','instagram_url','linkedin_url','agency_name','navbar_agency_name','hero_title','hero_title_color'];
  fields.forEach(f=>{ if(f!==currentField && f!==(currentField+'_color')){ fd.append(f, getFieldValue(f)); } });
  fd.append('show_vehicles','{{ $settings->show_vehicles ?? 1 }}');
  fd.append('show_contact_form','{{ $settings->show_contact_form ?? 1 }}');
  fetch('{{ route("admin.landing-config.update") }}',{method:'POST', headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}, body:fd})
    .then(r=>r.json()).then(d=>{ if(d.success){ location.reload(); } else { alert('Error al guardar'); } })
    .catch(e=>{ console.error(e); alert('Error al guardar'); });
  closeTextModal();
}

function editImage(field){
  currentField = field;
  document.getElementById('modalImageUrl').value = getFieldValue(field);
  document.getElementById('modalImageFile').value = '';
  document.getElementById('imagePreview').classList.add('hidden');
  document.getElementById('imageModal').classList.remove('hidden');
}
function closeImageModal(){
  document.getElementById('imageModal').classList.add('hidden');
  document.getElementById('modalImageFile').value = '';
  document.getElementById('modalImageUrl').value = '';
  document.getElementById('imagePreview').classList.add('hidden');
  currentField = null;
}
async function saveImage(){
  if(!currentField) return;
  const fileInput = document.getElementById('modalImageFile');
  const urlInput = document.getElementById('modalImageUrl');
  const saveBtn = document.getElementById('imageSaveText');
  saveBtn.textContent='Guardando...';
  if(fileInput.files && fileInput.files[0]){
    const formData = new FormData();
    formData.append('image', fileInput.files[0]);
    formData.append('field', currentField);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    try{
      const resp = await fetch('{{ route("admin.landing-config.upload-image") }}',{method:'POST', body:formData});
      const data = await resp.json();
      if(data.success){
        updateField(currentField, data.url);
        closeImageModal();
      }else{
        alert('Error al subir la imagen: '+(data.message||'Error desconocido'));
        saveBtn.textContent='Guardar';
      }
    }catch(e){ console.error(e); alert('Error al subir la imagen'); saveBtn.textContent='Guardar'; }
  }else if(urlInput.value){
    updateField(currentField, urlInput.value);
    closeImageModal();
  }else{
    alert('Por favor selecciona una imagen o ingresa una URL');
    saveBtn.textContent='Guardar';
  }
}

function editContact(){
  document.getElementById('modalPhone').value = getFieldValue('phone');
  document.getElementById('modalEmail').value = getFieldValue('email');
  document.getElementById('modalWhatsapp').value = getFieldValue('whatsapp');
  document.getElementById('contactModal').classList.remove('hidden');
}
function closeContactModal(){
  document.getElementById('contactModal').classList.add('hidden');
}
function saveContact(){
  const phone = document.getElementById('modalPhone').value;
  const email = document.getElementById('modalEmail').value;
  const whatsapp = document.getElementById('modalWhatsapp').value;
  const fd = new FormData();
  fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
  fd.append('_method','PATCH');
  fd.append('phone', phone); fd.append('email', email); fd.append('whatsapp', whatsapp);
  fd.append('template','{{ $template ?? "moderno" }}');
  ;['home_description','nosotros_description','nosotros_url','contact_message','logo_url','banner_url','primary_color','secondary_color','facebook_url','instagram_url','linkedin_url','agency_name','navbar_agency_name'].forEach(f=>fd.append(f,getFieldValue(f)));
  fd.append('show_vehicles','{{ $settings->show_vehicles ?? 1 }}');
  fd.append('show_contact_form','{{ $settings->show_contact_form ?? 1 }}');
  fetch('{{ route("admin.landing-config.update") }}',{method:'POST', headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}, body:fd})
  .then(r=>r.json()).then(d=>{ if(d.success){ closeContactModal(); location.reload(); } else { alert('Error al guardar: '+(d.message||'Error desconocido')); } })
  .catch(e=>{ console.error(e); alert('Error al guardar'); });
}

function editStats(){
  document.getElementById('modalStat1').value = getFieldValue('stat1') || '150+';
  document.getElementById('modalStat2').value = getFieldValue('stat2') || '98%';
  document.getElementById('modalStat3').value = getFieldValue('stat3') || '24h';
  document.getElementById('statsModal').classList.remove('hidden');
}
function closeStatsModal(){ document.getElementById('statsModal').classList.add('hidden'); }
function saveStats(){
  const fd = new FormData();
  fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
  fd.append('_method','PATCH');
  fd.append('stat1', document.getElementById('modalStat1').value||'150+');
  fd.append('stat2', document.getElementById('modalStat2').value||'98%');
  fd.append('stat3', document.getElementById('modalStat3').value||'24h');
  fd.append('template','{{ $template ?? "moderno" }}');
  ;['home_description','nosotros_description','nosotros_url','contact_message','phone','email','whatsapp','logo_url','banner_url','primary_color','secondary_color','facebook_url','instagram_url','linkedin_url','agency_name','navbar_agency_name'].forEach(f=>fd.append(f,getFieldValue(f)));
  fd.append('show_vehicles','{{ $settings->show_vehicles ?? 1 }}');
  fd.append('show_contact_form','{{ $settings->show_contact_form ?? 1 }}');
  fetch('{{ route("admin.landing-config.update") }}',{method:'POST', headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}, body:fd})
  .then(r=>r.json()).then(d=>{ if(d.success){ closeStatsModal(); location.reload(); } else { alert('Error al guardar'); } })
  .catch(e=>{ console.error(e); alert('Error al guardar'); });
}

function getFieldValue(field){
  const values = {
    home_description: @json($settings->home_description ?? ''),
    home_description_color: @json($settings->home_description_color ?? '#fff'),
    nosotros_description: @json($settings->nosotros_description ?? ''),
    nosotros_description_color: @json($settings->nosotros_description_color ?? '#222'),
    hero_title: @json($settings->hero_title ?? 'Título principal del sitio'),
    hero_title_color: @json($settings->hero_title_color ?? '#fff'),
    agency_name: @json($settings->agency_name ?? $tenant->name ?? ''),
    agency_name_color: @json($settings->agency_name_color ?? '#fff'),
    navbar_agency_name: @json($settings->navbar_agency_name ?? $tenant->name ?? ''),
    navbar_agency_name_color: @json($settings->navbar_agency_name_color ?? '#fff'),
    nosotros_url: @json($settings->nosotros_url ?? ''),
    contact_message: @json($settings->contact_message ?? ''),
    phone: @json($settings->phone ?? ''),
    email: @json($settings->email ?? ''),
    whatsapp: @json($settings->whatsapp ?? ''),
    facebook_url: @json($settings->facebook_url ?? ''),
    instagram_url: @json($settings->instagram_url ?? ''),
    linkedin_url: @json($settings->linkedin_url ?? ''),
    logo_url: @json($settings->logo_url ?? ''),
    banner_url: @json($settings->banner_url ?? ''),
    primary_color: @json($settings->primary_color ?? '#8b5cf6'),
    secondary_color: @json($settings->secondary_color ?? '#1e293b'),
    stat1: @json($settings->stat1 ?? '150+'),
    stat2: @json($settings->stat2 ?? '98%'),
    stat3: @json($settings->stat3 ?? '24h')
  };
  return values[field] || '';
}

function updateField(field, value){
  const fd = new FormData();
  fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
  fd.append('_method','PATCH');
  fd.append(field, value);
  fd.append('template','{{ $template ?? "moderno" }}');
  const fields=['home_description','nosotros_description','nosotros_url','contact_message','phone','email','whatsapp','logo_url','banner_url','primary_color','secondary_color','facebook_url','instagram_url','linkedin_url','agency_name','navbar_agency_name'];
  fields.forEach(f=>{ if(f!==field){ fd.append(f, getFieldValue(f)); } });
  fd.append('show_vehicles','{{ $settings->show_vehicles ?? 1 }}');
  fd.append('show_contact_form','{{ $settings->show_contact_form ?? 1 }}');
  fetch('{{ route("admin.landing-config.update") }}',{method:'POST', headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}, body:fd})
  .then(r=>r.json()).then(d=>{ if(d.success){ location.reload(); } else { alert('Error al guardar'); } })
  .catch(e=>{ console.error(e); alert('Error al guardar'); });
}
</script>

<!-- Modales -->
<div id="textModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-[99999] p-4">
  <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
    <div class="p-6 border-b"><h3 class="text-xl font-bold text-gray-900" id="modalTitle">Editar Texto</h3></div>
    <div class="p-6">
          <textarea id="modalTextarea" rows="6" class="w-full px-4 py-2 border rounded-lg text-gray-900 focus:ring-2 focus:ring-blue-500"></textarea>
          <div class="mt-4 flex items-center gap-3">
            <label for="modalTextColor" class="text-gray-800 text-sm">Color de tipografía:</label>
            <input type="color" id="modalTextColor" value="#ffffff" class="h-8 w-12 p-0 border-0 bg-transparent" />
          </div>
          <div id="noNameOption" class="mt-4 hidden flex items-center gap-2">
            <input type="checkbox" id="noNameCheckbox" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
            <label for="noNameCheckbox" class="text-gray-800 text-sm select-none">Usar sin nombre</label>
          </div>
          <div id="noNameTip" class="mt-4 text-gray-500 text-sm flex items-center gap-2">
            <span>💡 Tip: Puedes borrar todo el contenido para ocultar esta sección</span>
          </div>
    </div>
    <div class="p-6 border-t flex justify-end gap-3">
      <button onclick="closeTextModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Cancelar</button>
      <button onclick="saveText()" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Guardar</button>
    </div>
  </div>
</div>

@if(isset($editMode) && $editMode)
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
@endif
  </script>

<div id="imageModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-[99999] p-4">
  <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
    <div class="p-6 border-b"><h3 class="text-xl font-bold text-gray-900">Cambiar Imagen</h3></div>
    <div class="p-6 space-y-4">
      <div>
        <label class="block text-sm text-gray-700 mb-1">Subir archivo</label>
        <input type="file" id="modalImageFile" class="w-full text-gray-900" accept="image/*" />
      </div>
      <div>
        <label class="block text-sm text-gray-700 mb-1">o URL</label>
        <input type="text" id="modalImageUrl" class="w-full px-3 py-2 border rounded text-gray-900" placeholder="https://..." />
      </div>
      <div id="imagePreview" class="hidden"><img id="imagePreviewImg" class="max-h-48 rounded" /></div>
    </div>
    <div class="p-6 border-t flex justify-end gap-3">
      <button onclick="closeImageModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Cancelar</button>
      <button onclick="saveImage()" class="px-4 py-2 bg-blue-600 text-white rounded-lg"><span id="imageSaveText">Guardar</span></button>
    </div>
  </div>
</div>

<div id="contactModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-[99999] p-4">
  <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
    <div class="p-6 border-b"><h3 class="text-xl font-bold text-gray-900">Información de Contacto</h3></div>
    <div class="p-6 space-y-3">
      <input type="text" id="modalPhone" class="w-full px-3 py-2 border rounded text-gray-900" placeholder="Teléfono" />
      <input type="email" id="modalEmail" class="w-full px-3 py-2 border rounded text-gray-900" placeholder="Email" />
      <input type="text" id="modalWhatsapp" class="w-full px-3 py-2 border rounded text-gray-900" placeholder="WhatsApp" />
    </div>
    <div class="p-6 border-t flex justify-end gap-3">
      <button onclick="closeContactModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Cancelar</button>
      <button onclick="saveContact()" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Guardar</button>
    </div>
  </div>
</div>

<div id="statsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-[99999] p-4">
  <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
    <div class="p-6 border-b"><h3 class="text-xl font-bold text-gray-900">Estadísticas</h3></div>
    <div class="p-6 space-y-3">
      <input type="text" id="modalStat1" class="w-full px-3 py-2 border rounded text-gray-900" placeholder="Stat 1" />
      <input type="text" id="modalStat2" class="w-full px-3 py-2 border rounded text-gray-900" placeholder="Stat 2" />
      <input type="text" id="modalStat3" class="w-full px-3 py-2 border rounded text-gray-900" placeholder="Stat 3" />
    </div>
    <div class="p-6 border-t flex justify-end gap-3">
      <button onclick="closeStatsModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">Cancelar</button>
      <button onclick="saveStats()" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Guardar</button>
    </div>
  </div>
</div>
@endif
