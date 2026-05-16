@extends('enseignant.layouts.app')

@section('page-title', 'Salles disponibles maintenant')

@php
    /* ── Safe defaults so the view never crashes even if the controller
       forgets to pass these variables (e.g. old/wrong route binding). ── */
    $currentSeance = $currentSeance ?? null;
    $seances       = $seances ?? [
        ['num'=>1,'label'=>'Séance 1','time'=>'08:30 – 10:30','value'=>'08:30-10:30','start'=>'08:30','end'=>'10:30'],
        ['num'=>2,'label'=>'Séance 2','time'=>'10:30 – 12:30','value'=>'10:30-12:30','start'=>'10:30','end'=>'12:30'],
        ['num'=>3,'label'=>'Séance 3','time'=>'13:30 – 15:30','value'=>'13:30-15:30','start'=>'13:30','end'=>'15:30'],
        ['num'=>4,'label'=>'Séance 4','time'=>'15:30 – 18:00','value'=>'15:30-18:00','start'=>'15:30','end'=>'18:00'],
    ];
    $salles = $salles ?? collect();
@endphp

@push('styles')
<style>

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}
.page-header h2 {
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}
.page-header p {
    font-size: 13px;
    color: #6b7280;
    margin: 4px 0 0;
}

/* BANNER */
.slot-banner {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 12px;
    padding: 13px 18px;
    margin-bottom: 22px;
    font-size: 14px;
    font-weight: 600;
    color: #1d4ed8;
}
.slot-banner.no-seance {
    background: #f9fafb;
    border-color: #e5e7eb;
    color: #6b7280;
}

/* TABLE */
.table-card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
}
table { width: 100%; border-collapse: collapse; }
thead th {
    background: #f8fafc;
    padding: 12px 16px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7280;
    font-weight: 600;
    text-align: left;
}
tbody td {
    padding: 15px 16px;
    border-top: 1px solid #f0f0f0;
    font-size: 14px;
    color: #111827;
}
tbody tr:hover { background: #fafafa; }

.type-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 600;
    background: #f0f4ff;
    color: #3b5bdb;
}

.status-available {
    display: inline-block;
    background: #dcfce7;
    color: #15803d;
    padding: 5px 13px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.btn-reserve {
    background: #2563eb;
    color: white;
    padding: 9px 16px;
    border-radius: 9px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
    transition: 0.15s;
}
.btn-reserve:hover { background: #1d4ed8; }
.btn-reserve:disabled {
    background: #9ca3af;
    cursor: not-allowed;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #9ca3af;
}
.empty-state i { font-size: 42px; margin-bottom: 12px; display: block; opacity: 0.3; }
.empty-state p { font-size: 15px; }

/* MODAL */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}
.modal-overlay.active { display: flex; }

.modal-box {
    background: white;
    border-radius: 16px;
    padding: 28px;
    width: 460px;
    max-width: 95vw;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
}
.modal-box h3 {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 4px;
    color: #111827;
}
.modal-salle-meta {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 22px;
}

.field-group { margin-bottom: 18px; }
.field-group label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    color: #374151;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 7px;
}
.field-group input[type="date"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
    transition: 0.15s;
}
.field-group input[type="date"]:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}

.seances-list { display: flex; flex-direction: column; gap: 9px; margin-bottom: 24px; }

.seance-item {
    display: flex;
    align-items: center;
    gap: 13px;
    border: 1.5px solid #e5e7eb;
    border-radius: 11px;
    padding: 12px 15px;
    cursor: pointer;
    transition: 0.15s;
}
.seance-item:hover  { border-color: #2563eb; background: #f5f8ff; }
.seance-item.active { border-color: #2563eb; background: #eff6ff; }
.seance-item.past   { opacity: 0.4; pointer-events: none; }

.seance-item input[type="radio"] {
    accent-color: #2563eb;
    width: 16px; height: 16px;
    flex-shrink: 0;
    cursor: pointer;
}
.seance-label  { font-weight: 600; font-size: 14px; color: #111827; }
.seance-time   { font-size: 12px; color: #6b7280; margin-top: 2px; }
.seance-badge  {
    margin-left: auto;
    background: #fef3c7;
    color: #92400e;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 999px;
    white-space: nowrap;
}

.modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
.btn-cancel {
    background: #f3f4f6;
    color: #374151;
    padding: 10px 18px;
    border-radius: 9px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
}
.btn-cancel:hover { background: #e5e7eb; }
.btn-confirm {
    background: #2563eb;
    color: white;
    padding: 10px 20px;
    border-radius: 9px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
}
.btn-confirm:hover { background: #1d4ed8; }

</style>
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="page-header">
    <div>
        <h2>Salles disponibles maintenant</h2>
        @if($currentSeance)
            <p>{{ $currentSeance['label'] }} · {{ $currentSeance['time'] }}</p>
        @else
            <p>Aucune séance en cours</p>
        @endif
    </div>
</div>

{{-- BANNER --}}
@if($currentSeance)
    <div class="slot-banner">
        <i class="fa-solid fa-clock"></i>
        {{ $currentSeance['label'] }} en cours ({{ $currentSeance['time'] }}) — salles ci-dessous libres maintenant
    </div>
@else
    <div class="slot-banner no-seance">
        <i class="fa-solid fa-moon"></i>
        Aucune séance active en ce moment — revenez pendant les horaires de cours
    </div>
@endif

{{-- TABLE --}}
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Salle</th>
                <th>Département</th>
                <th>Capacité</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

        @forelse($salles as $salle)
            <tr>
                <td><b>{{ $salle['nom'] }}</b></td>
                <td>{{ $salle['dept'] ?? 'N/A' }}</td>
                <td>{{ $salle['cap'] }} places</td>
                <td><span class="status-available">Disponible</span></td>
                <td>
                    @if($currentSeance)
                        <button class="btn-reserve"
                            onclick="openModal({{ $salle['id'] }}, '{{ addslashes($salle['nom']) }}', {{ $salle['cap'] }})">
                            Réserver
                        </button>
                    @else
                        <button class="btn-reserve" disabled>Indisponible</button>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <i class="fa-regular fa-calendar-xmark"></i>
                        <p>
                            @if($currentSeance)
                                Toutes les salles sont occupées pour cette séance
                            @else
                                Aucune séance en cours actuellement
                            @endif
                        </p>
                    </div>
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>

{{-- MODAL --}}
<div id="modal" class="modal-overlay">
    <div class="modal-box">

        <h3>Réserver une salle</h3>
        <p class="modal-salle-meta" id="modalMeta"></p>

        <form method="POST" action="{{ route('enseignant.reservations.store') }}" id="resaForm">
            @csrf
            <input type="hidden" name="salle_id" id="salle_id">

            <div class="field-group">
                <label>Date</label>
                <input type="date" name="date" id="dateInput" required>
            </div>

            <div class="field-group">
                <label>Séance</label>
                <div class="seances-list">
                    @foreach($seances as $s)
                    <label class="seance-item" id="seance-card-{{ $s['num'] }}">
                        <input type="radio" name="creneau"
                               value="{{ $s['value'] }}"
                               id="seance-radio-{{ $s['num'] }}">
                        <div>
                            <div class="seance-label">{{ $s['label'] }}</div>
                            <div class="seance-time">{{ $s['time'] }}</div>
                        </div>
                        @if($currentSeance && $currentSeance['num'] === $s['num'])
                            <span class="seance-badge">En cours</span>
                        @endif
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Annuler</button>
                <button type="submit" class="btn-confirm">Confirmer</button>
            </div>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
const SEANCES = @json($seances);
const CURRENT_NUM = {{ $currentSeance ? $currentSeance['num'] : 'null' }};

function timeToMinutes(t) {
    const [h, m] = t.split(':').map(Number);
    return h * 60 + m;
}
function nowMinutes() {
    const d = new Date();
    return d.getHours() * 60 + d.getMinutes();
}

function openModal(id, nom, cap) {
    document.getElementById('salle_id').value = id;
    document.getElementById('modalMeta').textContent = nom + ' · ' + cap + ' places';

    const today = new Date().toISOString().split('T')[0];
    document.getElementById('dateInput').value = today;
    document.getElementById('dateInput').min   = today;

    applySeanceStates();
    document.getElementById('modal').classList.add('active');
}

function closeModal() {
    document.getElementById('modal').classList.remove('active');
}

document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

function applySeanceStates() {
    const m = nowMinutes();
    let autoSelected = false;

    SEANCES.forEach(s => {
        const card  = document.getElementById('seance-card-' + s.num);
        const radio = document.getElementById('seance-radio-' + s.num);
        const past  = timeToMinutes(s.end) <= m;

        card.classList.toggle('past', past);
        radio.disabled = past;

        // Auto-select the current séance (or first future one)
        if (!autoSelected && !past) {
            if (CURRENT_NUM === null || s.num === CURRENT_NUM) {
                radio.checked = true;
                card.classList.add('active');
                autoSelected = true;
            }
        }
    });
}

// Toggle active styling on manual selection
document.querySelectorAll('input[name="creneau"]').forEach(r => {
    r.addEventListener('change', () => {
        document.querySelectorAll('.seance-item').forEach(c => c.classList.remove('active'));
        r.closest('.seance-item').classList.add('active');
    });
});

// Validate on submit
document.getElementById('resaForm').addEventListener('submit', function(e) {
    if (!this.querySelector('input[name="creneau"]:checked')) {
        e.preventDefault();
        alert('Veuillez sélectionner une séance.');
    }
});
</script>
@endpush
