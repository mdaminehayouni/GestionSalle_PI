@extends('enseignant.layouts.app')
@section('page-title', 'Tableau de bord')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: grid; place-items: center;
        font-size: 18px;
    }

    .stat-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .badge-green { background: var(--green-light); color: var(--green); }
    .badge-blue  { background: var(--blue-light);  color: var(--blue); }
    .badge-orange{ background: var(--orange-light); color: var(--orange); }
    .badge-purple{ background: #f0ebf8; color: var(--purple); }

    .icon-green  { background: var(--green-light); color: var(--green); }
    .icon-blue   { background: var(--blue-light);  color: var(--blue); }
    .icon-orange { background: var(--orange-light); color: var(--orange); }
    .icon-purple { background: #f0ebf8;             color: var(--purple); }

    .stat-value { font-size: 34px; font-weight: 700; line-height: 1; }
    .stat-label { font-size: 13px; color: var(--text-muted); }

    /* ── BOTTOM GRID ── */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow);
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .card-title { font-size: 16px; font-weight: 700; }

    .see-all {
        font-size: 13px;
        color: var(--blue);
        text-decoration: none;
        font-weight: 600;
    }
    .see-all:hover { text-decoration: underline; }

    /* Reservation list */
    .resa-list { display: flex; flex-direction: column; gap: 14px; }

    .resa-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px 16px;
        border-radius: 10px;
        border: 1px solid var(--border);
        transition: box-shadow .2s;
    }
    .resa-item:hover { box-shadow: var(--shadow); }

    .resa-badge {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: grid; place-items: center;
        font-size: 12px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .resa-info { flex: 1; }
    .resa-info strong { display: block; font-size: 14px; font-weight: 600; }
    .resa-info span { font-size: 12px; color: var(--text-muted); }

    .status-pill {
        font-size: 11px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        background: var(--blue-light);
        color: var(--blue);
    }

    /* Quick actions */
    .quick-actions { display: flex; flex-direction: column; gap: 12px; }

    .qa-btn {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 18px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: transform .15s, box-shadow .15s;
    }
    .qa-btn:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

    .qa-btn .qa-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: grid; place-items: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .qa-blue { background: var(--blue-light); color: var(--blue); }
    .qa-blue .qa-icon { background: var(--blue); color: white; }

    .qa-purple { background: #f0ebf8; color: var(--purple); }
    .qa-purple .qa-icon { background: var(--purple); color: white; }

    .qa-green { background: var(--green-light); color: #1a7a4a; }
    .qa-green .qa-icon { background: var(--green); color: white; }
</style>
@endpush

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon icon-green"><i class="fa-solid fa-circle-check"></i></div>
            <span class="stat-badge badge-green">Maintenant</span>
        </div>
        <div class="stat-value">{{ $sallesDisponibles ?? 24 }}</div>
        <div class="stat-label">Salles disponibles</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-calendar-days"></i></div>
            <span class="stat-badge badge-blue">Cette semaine</span>
        </div>
        <div class="stat-value">{{ $mesReservations ?? 8 }}</div>
        <div class="stat-label">Mes réservations</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-clock"></i></div>
            <span class="stat-badge badge-orange">En attente</span>
        </div>
        <div class="stat-value">{{ $demandesEnCours ?? 3 }}</div>
        <div class="stat-label">Demandes en cours</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-comment-exclamation"></i></div>
            <span class="stat-badge badge-purple">Ce mois</span>
        </div>
        <div class="stat-value">{{ $reclamationsEnvoyees ?? 2 }}</div>
        <div class="stat-label">Réclamations envoyées</div>
    </div>
</div>

{{-- Bottom --}}
<div class="bottom-grid">
    {{-- Mes réservations --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">📅 Mes réservations</h2>
            <a href="{{ route('enseignant.reservations') }}" class="see-all">Voir tout</a>
        </div>
        <div class="resa-list">
            @forelse($reservationsRecentes ?? [] as $r)
                <div class="resa-item">
                    <div class="resa-badge" style="background:{{ $r['color'] }};color:{{ $r['text'] }}">
                        {{ $r['code'] }}
                    </div>
                    <div class="resa-info">
                        <strong>{{ $r['salle'] }}</strong>
                        <span>{{ $r['time'] }}</span>
                    </div>
                    <span class="status-pill">Réservée</span>
                </div>
            @empty
                <div class="resa-item">
                    <div class="resa-info">
                        <strong>Aucune réservation à venir</strong>
                        <span>Réservez une salle ou consultez vos demandes.</span>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Actions et navigation --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">🚀 Actions</h2>
        </div>
        <div class="quick-actions">
            <a href="{{ route('enseignant.salles') }}" class="qa-btn qa-blue">
                <div class="qa-icon"><i class="fa-solid fa-door-open"></i></div>
                <span>Réserver une salle</span>
            </a>
            <a href="{{ route('enseignant.reclamations') }}" class="qa-btn qa-purple">
                <div class="qa-icon"><i class="fa-solid fa-comment-exclamation"></i></div>
                <span>Envoyer réclamation</span>
            </a>
            <a href="{{ route('enseignant.messages') }}" class="qa-btn qa-green">
                <div class="qa-icon"><i class="fa-solid fa-envelope"></i></div>
                <span>Envoyer message étudiant</span>
            </a>
        </div>
    </div>
</div>

@endsection
