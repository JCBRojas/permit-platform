<x-app-layout>

  <div class="main">

    <div class="content page active" id="page-reportes">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">


        @php
        $activeDiets = $diets->where('status', 1);
        $cancelledDiets = $diets->where('status', 0);
        $isolatedCount = $diets->filter(fn($diet) => optional($diet->currentVersion)->isolation === 'Sí')->count();
        $changesCount = $diets->filter(fn($diet) => optional($diet->currentVersion)->changes && optional($diet->currentVersion)->changes !== '')->count();
        $todayCount = $diets->filter(fn($diet) => optional($diet->created_at)->isToday())->count();
        @endphp

        <div x-data="{ tab: 'active' }">
          <div class="stats-grid">
            <div class="stat-card green">
              <div class="stat-label">Dietas activas</div>
              <div class="stat-value">{{ $activeDiets->count() }}</div>
              <div class="stat-sub">Pacientes en seguimiento</div>
            </div>
            <div class="stat-card red">
              <div class="stat-label">Canceladas</div>
              <div class="stat-value">{{ $cancelledDiets->count() }}</div>
              <div class="stat-sub">Total histórico</div>
            </div>
            <div class="stat-card amber">
              <div class="stat-label">En aislamiento</div>
              <div class="stat-value">{{ $isolatedCount }}</div>
              <div class="stat-sub">Protocolo especial</div>
            </div>
            <div class="stat-card blue">
              <div class="stat-label">Con cambios</div>
              <div class="stat-value">{{ $changesCount }}</div>
              <div class="stat-sub">Dietas modificadas</div>
            </div>
          </div>

          <div class="tabs-wrapper mb-4">
            <button type="button"
              class="btn btn-info"
              :class="tab === 'active' ? 'active' : ''"
              @click="tab = 'active'">
              Activas
            </button>

            <button type="button"
              class="btn btn-ghost"
              :class="tab === 'cancelled' ? 'active' : ''"
              @click="tab = 'cancelled'">
              Canceladas
            </button>

            <button class="btn btn-primary float-right" id="btnRegistrar" onclick="openCreateModal()">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
              </svg>
              Registrar Dieta
            </button>

            <div class="overlay" id="modalOverlay">
              <x-modal-create-diets></x-modal-create-diets>
            </div>
          </div>

<div class="card">
  <div class="table-responsive">

    <!-- TABLA ACTIVA -->
    <div x-show="tab === 'active'">
      <table class="table-wrap">
        <thead>
          <tr>
            <th>Hab.</th>
            <th>Paciente</th>
            <th>Tiempo</th>
            <th>Consistencia</th>
            <th>Especificaciones</th>
            <th>Observaciones</th>
            <th>Aislam.</th>
            <th>Cambios</th>
            <th class="text-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($activeDiets as $diet)
            <x-diet-row :diet="$diet"></x-diet-row>
            <x-modal-edit-diets :diet="$diet" />
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- TABLA CANCELADA -->
    <div x-show="tab === 'cancelled'" x-cloak>
      <table class="table-wrap">
        <thead>
          <tr>
            <th>Hab.</th>
            <th>Paciente</th>
            <th>Tiempo</th>
            <th>Consistencia</th>
            <th>Especificaciones</th>
            <th>Observaciones</th>
            <th>Aislam.</th>
            <th>Cambios</th>
            <th class="text-right">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($cancelledDiets as $diet)
          <tr></tr>
            <td>hello world</td>
          </tr>
            <!-- <x-diet-row :diet="$diet"></x-diet-row> -->
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</div>

        </div>

      </div>
    </div>


  </div>
</x-app-layout>




<script>
  // ══════════════════════════════════════════════
  //  MODAL OPEN/CLOSE
  // ══════════════════════════════════════════════
  function openCreateModal() {
    // if (!perm('canCreate')) {
    //   toast('No tiene permisos para registrar dietas', 'error');
    //   return;
    // }
    editingId = null;
    // resetForm();
    document.getElementById('modalTitle').textContent = 'Registrar Dieta';
    document.getElementById('saveBtnText').textContent = 'Registrar';
    document.getElementById('modalOverlay').classList.add('open');
  }

  function closeModal() {
    document.getElementById('modalOverlay').classList.remove('open');
    editingId = null;
  }


  // ══════════════════════════════════════════════
  //  STATE
  // ══════════════════════════════════════════════
  let selections = {
    timeFood: [],
    consistency: [],
    specifications: []
  };

  const inputMap = {
    timeFood: 'f-tiempo',
    consistency: 'f-consist',
    specifications: 'f-espec'
  };


  // ══════════════════════════════════════════════
  //  CHIP SELECT
  // ══════════════════════════════════════════════

  // Abre/cierra el selector
  function toggleChipSelect(id) {
    const el = document.getElementById(id);
    const was = el.classList.contains('open');
    document.querySelectorAll('.chip-select.open').forEach(e => e.classList.remove('open'));
    if (!was) el.classList.add('open');
  }

  // Cierra si se hace clic fuera
  document.addEventListener('click', e => {
    if (!e.target.closest('.chip-select')) {
      document.querySelectorAll('.chip-select.open').forEach(el => el.classList.remove('open'));
    }
  });

  // Seleccionar/deseleccionar chip
  function selectChip(e, csId, key) {
    e.stopPropagation();
    const val = e.target.dataset.val;

    selections[key] = selections[key].includes(val) ?
      selections[key].filter(v => v !== val) : [...selections[key], val];

    renderChips(csId, key);
  }

  // Eliminar chip desde la X
  function removeChip(key, val) {
    selections[key] = selections[key].filter(v => v !== val);

    const map = {
      tiempo: 'cs-tiempo',
      consist: 'cs-consist',
      especificacions: 'cs-espec'
    };

    renderChips(map[key], key);
  }

  // Renderizar chips y crear inputs hidden como arrays reales
  function renderChips(csId, key) {
    const chipContainer = document.getElementById('chips-' + key);
    const opts = document.querySelectorAll(`#opts-${key} .chip-option`);
    const hiddenContainer = document.getElementById('hidden-' + key);

    // Mostrar chips seleccionados
    chipContainer.innerHTML = selections[key]
      .map(v => `
            <span class="chip">
                ${v}
                <span class="remove" onclick="removeChip('${key}','${v}'); event.stopPropagation()">×</span>
            </span>
        `)
      .join('');

    // Marcar opciones seleccionadas
    opts.forEach(o => {
      o.classList.toggle('selected', selections[key].includes(o.dataset.val));
    });

    // Crear inputs hidden como arrays reales
    hiddenContainer.innerHTML = '';
    selections[key].forEach(v => {
      hiddenContainer.innerHTML += `<input type="hidden" name="${key}[]" value="${v}">`;
    });
  }
</script>

<!-- <script src="{{ asset('assets/libs/jquery-nice-select/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/libs/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap4.js') }}"></script>

    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/dataTables.buttons.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/buttons.print.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> -->
<!-- App js -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>