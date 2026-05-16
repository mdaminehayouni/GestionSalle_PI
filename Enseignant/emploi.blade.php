@extends('enseignant.layouts.app')
@section('page-title', 'Emploi du temps')

@push('styles')
<style>
    .edt-card {
        background: white;
        border-radius: var(--radius);
        padding: 28px;
        box-shadow: var(--shadow);
    }

    .edt-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }

    .edt-header h2 { font-size: 17px; font-weight: 700; }

    .nav-week {
        display: flex;
        gap: 8px;
    }

    .btn-nav {
        width: 36px; height: 36px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        background: white;
        cursor: pointer;
        display: grid; place-items: center;
        color: var(--text-muted);
        font-size: 14px;
        transition: all .2s;
    }
    .btn-nav:hover { border-color: var(--blue); color: var(--blue); }

    /* Grid */
    .edt-grid {
        display: grid;
        grid-template-columns: 110px repeat(6, 1fr);
        gap: 0;
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
    }

    .edt-header-cell {
        padding: 12px 8px;
        text-align: center;
        background: var(--bg);
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border);
    }

    .edt-time-cell {
        padding: 0 10px;
        display: flex;
        align-items: flex-start;
        padding-top: 10px;
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
        border-bottom: 1px solid var(--border);
        border-right: 1px solid var(--border);
        min-height: 90px;
    }

    .edt-slot {
        border-bottom: 1px solid var(--border);
        border-right: 1px solid var(--border);
        padding: 6px;
        min-height: 90px;
        position: relative;
    }

    .edt-slot:last-child { border-right: none; }

    .edt-event {
        border-radius: 8px;
        padding: 8px 10px;
        height: 100%;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .event-name {
        font-size: 12px;
        font-weight: 700;
    }
    .event-salle {
        font-size: 11px;
        opacity: .75;
    }

    .color-blue   { background: #dbeafe; color: #1d4ed8; }
    .color-orange { background: #fef3c7; color: #92400e; }
    .color-green  { background: #d1fae5; color: #065f46; }
    .color-purple { background: #ede9fe; color: #5b21b6; }
    .color-pink   { background: #fce7f3; color: #9d174d; }
    .color-teal   { background: #ccfbf1; color: #0f5132; }
</style>
@endpush

@section('content')

<div class="edt-card">
    <div class="edt-header">
        <h2>Mon emploi du temps – Semaine du {{ $weekLabel ?? 'en cours' }}</h2>
        <div class="nav-week">
            <button class="btn-nav"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="btn-nav"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>

    <div class="edt-grid">
        {{-- Header row --}}
        <div class="edt-header-cell"></div>
        @foreach($jours as $day)
            <div class="edt-header-cell">{{ $day }}</div>
        @endforeach

        @foreach($creneaux as $slot)
            <div class="edt-time-cell">{{ $slot['label'] }}</div>
            @foreach($jours as $day)
                <div class="edt-slot">
                    @if(isset($emploi[$slot['label']][$day]))
                        @php $event = $emploi[$slot['label']][$day]; @endphp
                        <div class="edt-event {{ $event['color'] ?? 'color-blue' }}">
                            <span class="event-name">{{ $event['matiere'] }}</span>
                            <span class="event-salle">{{ $event['salle'] }}</span>
                        </div>
                    @endif
                </div>
            @endforeach
        @endforeach
    </div>
</div>

@endsection
