  <div class="modal">
      <div class="modal-header">
          <h2 id="modalTitle">Registrar Dieta</h2>
          <button class="close-btn" onclick="closeModal()">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                  <line x1="18" y1="6" x2="6" y2="18" />
                  <line x1="6" y1="6" x2="18" y2="18" />
              </svg>
          </button>
      </div>

      <form id="dietForm" method="POST" action="{{ route('dietas.store') }}">
          @csrf
          <div class="modal-body">
              <div id="dupWarning" class="info-banner" style="display:none">
                  <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                      <circle cx="12" cy="12" r="10" />
                      <line x1="12" y1="8" x2="12" y2="12" />
                      <line x1="12" y1="16" x2="12.01" y2="16" />
                  </svg>
                  <span id="dupWarningText"></span>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      <label>Habitación <span class="req">*</span></label>
                      <input type="text" id="f-habitacion" name="habitation" placeholder="Ej. 205" oninput="checkDuplicate()" />
                  </div>
                  <div class="form-group">
                      <label>Nombre del Paciente <span class="req">*</span></label>
                      <input type="text" id="f-paciente" name="name_patient" placeholder="Nombre completo" />
                  </div>
              </div>
              <!-- ══════════════════════════════════════════════
     TIME FOOD – CHIP SELECT
     ══════════════════════════════════════════════ -->

              <div class="form-group">
                  <label>Tiempo de comida</label>

                  <div class="chip-select blue-focus" id="cs-timeFood" onclick="toggleChipSelect('cs-timeFood')">

                      <div class="chips-display" id="chips-timeFood"></div>

                      <div class="chip-options" id="opts-timeFood">
                          <span class="chip-option" data-val="Desayuno" onclick="selectChip(event,'cs-tiempo','timeFood','Desayuno')">Desayuno</span>
                          <span class="chip-option" data-val="Almuerzo" onclick="selectChip(event,'cs-tiempo','timeFood','Almuerzo')">Almuerzo</span>
                          <span class="chip-option" data-val="Cena" onclick="selectChip(event,'cs-tiempo','timeFood','Cena')">Cena</span>
                          <span class="chip-option" data-val="Fraccionada" onclick="selectChip(event,'cs-tiempo','timeFood','Fraccionada')">Fraccionada</span>
                          <span class="chip-option" data-val="Colación" onclick="selectChip(event,'cs-tiempo','timeFood','Colación')">Colación</span>
                      </div>
                  </div>
                  <div id="hidden-timeFood"></div>

              </div>
              <!-- ══════════════════════════════════════════════
     CONSISTENCY – CHIP SELECT
     ══════════════════════════════════════════════ -->

              <div class="form-group">
                  <label>Consistencia</label>

                  <div class="chip-select blue-focus" id="cs-consistency" onclick="toggleChipSelect('cs-consistency')">

                      <div class="chips-display" id="chips-consistency"></div>

                      <div class="chip-options" id="opts-consistency">
                          <span class="chip-option" data-val="Liquida completa" onclick="selectChip(event,'cs-consistency','consistency','Liquida completa')">Liquida completa</span>
                          <span class="chip-option" data-val="Liquida clara" onclick="selectChip(event,'cs-consistency','consistency','Liquida clara')">Liquida clara</span>
                          <span class="chip-option" data-val="Muy blanda" onclick="selectChip(event,'cs-consistency','consistency','Muy blanda')">Muy blanda</span>
                          <span class="chip-option" data-val="Blanda mecanica" onclick="selectChip(event,'cs-consistency','consistency','Blanda mecanica')">Blanda mecánica</span>
                          <span class="chip-option" data-val="Normal" onclick="selectChip(event,'cs-consistency','consistency','Normal')">Normal</span>
                          <span class="chip-option" data-val="Papilla" onclick="selectChip(event,'cs-consistency','consistency','Papilla')">Papilla</span>
                      </div>
                  </div>
                  <!-- Inputs hidden -->
                  <div id="hidden-consistency"></div>
              </div>

              <!-- ══════════════════════════════════════════════
     SPECIFICATIONS – CHIP SELECT
     ══════════════════════════════════════════════ -->

              <div class="form-group">
                  <label>Especificaciones</label>

                  <div class="chip-select blue-focus" id="cs-specifications" onclick="toggleChipSelect('cs-specifications')">

                      <div class="chips-display" id="chips-specifications"></div>

                      <div class="chip-options" id="opts-specifications">
                          <span class="chip-option" data-val="Sin irritantes" onclick="selectChip(event,'cs-specifications','specifications')">Sin irritantes</span>
                          <span class="chip-option" data-val="Hipercalorica" onclick="selectChip(event,'cs-specifications','specifications')">Hipercalórica</span>
                          <span class="chip-option" data-val="Hiperproteica" onclick="selectChip(event,'cs-specifications','specifications')">Hiperproteica</span>
                          <span class="chip-option" data-val="Hiposodica" onclick="selectChip(event,'cs-specifications','specifications')">Hiposódica</span>
                          <span class="chip-option" data-val="Hipograsa" onclick="selectChip(event,'cs-specifications','specifications')">Hipograsa</span>
                          <span class="chip-option" data-val="Hipoglucida" onclick="selectChip(event,'cs-specifications','specifications')">Hipoglúcida</span>
                          <span class="chip-option" data-val="Astringente" onclick="selectChip(event,'cs-specifications','specifications')">Astringente</span>
                          <span class="chip-option" data-val="Sin lacteos" onclick="selectChip(event,'cs-specifications','specifications')">Sin lácteos</span>
                          <span class="chip-option" data-val="Sin gluten" onclick="selectChip(event,'cs-specifications','specifications')">Sin gluten</span>
                          <span class="chip-option" data-val="Sin fibra" onclick="selectChip(event,'cs-specifications','specifications')">Sin fibra</span>
                      </div>
                  </div>

                  <!-- Inputs hidden -->
                  <div id="hidden-specifications"></div>
              </div>

              <div class="form-group">
                  <label>Observaciones</label>
                  <textarea id="f-observaciones" name="observations" placeholder="Notas adicionales para cocina…"></textarea>
              </div>
              <div class="form-row">
                  <div class="form-group">
                      <label>Aislamiento</label>
                      <select id="f-aislamiento" name="isolation">
                          <option value="No">No</option>
                          <option value="Sí">Sí</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Cambios en la dieta</label>
                      <select id="f-cambios" name="changes" onchange="toggleReasonCategory()">
                          <option value="NA">N/A</option>
                          <option value="con_cambios">Con cambios</option>
                      </select>
                  </div>
              </div>
              <div id="editReasonGroup" style="display:none">
                  <div class="form-group">
                      <label>Categoría del cambio <span class="req">*</span></label>
                      <select id="f-motivoCategoria" name="motivo_categoria">
                          <option value="">Seleccione una categoría…</option>
                          <option>Cambio por evolución clínica</option>
                          <option>Intolerancia reportada</option>
                          <option>Orden médica</option>
                          <option>Error de registro</option>
                          <option>Cambio de servicio o habitación</option>
                          <option>Ajuste nutricional</option>
                          <option>Otro</option>
                      </select>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button class="btn btn-primary" type="submit" id="saveBtnText"></button>
          </div>
      </form>
  </div>
  </div>