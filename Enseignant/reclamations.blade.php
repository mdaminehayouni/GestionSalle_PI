@extends('enseignant.layouts.app')
@section('page-title', 'Réclamations')

@push('styles')
<style>
    .two-col {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
        align-items: start;
    }

    .card {
        background: white;
        border-radius: var(--radius);
        padding: 28px;
        box-shadow: var(--shadow);
    }

    .card h2 { font-size: 17px; font-weight: 700; margin-bottom: 24px; }

    .form-group { margin-bottom: 20px; }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text);
    }

    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        color: var(--text);
        outline: none;
        transition: border-color .2s;
        resize: vertical;
    }
    .form-group select:focus,
    .form-group textarea:focus { border-color: var(--blue); }

    .form-group textarea { min-height: 120px; }

    .btn-submit {
        width: 100%;
        padding: 14px;
        background: var(--blue);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: opacity .2s;
        font-family: inherit;
    }
    .btn-submit:hover { opacity: .9; }

    /* History */
    .history-list { display: flex; flex-direction: column; gap: 16px; }

    .history-item {
        padding: 16px;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        transition: box-shadow .2s;
    }
    .history-item:hover { box-shadow: var(--shadow); }

    .history-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .history-title {
        font-size: 14px;
        font-weight: 700;
    }

    .badge-resolved {
        padding: 4px 12px;
        background: var(--green-light);
        color: #1a7a4a;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-pending {
        padding: 4px 12px;
        background: var(--orange-light);
        color: #b7770d;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .history-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 6px; }
    .history-date { font-size: 11px; color: var(--text-muted); }

    .btn-delete-history {
        background: #fee2e2;
        color: #dc2626;
        border: none;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-delete-history:hover {
        background: #fecaca;
    }
</style>
@endpush

@section('content')

<div class="two-col">
    {{-- Form --}}
    <div class="card">
        <h2>Nouvelle réclamation</h2>

        @if(session('success'))
            <div style="background:var(--green-light);color:#1a7a4a;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;font-weight:600;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('enseignant.reclamations.store') }}">
            @csrf

            <div class="form-group">
                <label>Type de réclamation *</label>
                <select name="type" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="materiel">Problème matériel</option>
                    <option value="absence">Absence enseignant</option>
                    <option value="conflit">Conflit de réservation</option>
                    <option value="autre">Autre</option>
                </select>
            </div>

            <div class="form-group">
                <label>Salle concernée</label>
                <select name="salle_id">
                    <option value="">-- Aucune salle --</option>
                    @php
                        $salles = $salles ?? [];
                    @endphp
                    @forelse($salles as $s)
                        <option value="{{ $s->id ?? $s['id'] }}">{{ $s->nom ?? $s['nom'] ?? 'Salle' }}</option>
                    @empty
                    @endforelse
                </select>
            </div>

            <div class="form-group">
                <label>Titre (optionnel)</label>
                <input type="text" name="titre" placeholder="Résumé de votre réclamation..." style="width: 100%; padding: 10px 12px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: inherit;">
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" required placeholder="Décrivez votre problème en détail..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Envoyer au chef département</button>
        </form>
    </div>

    {{-- History --}}
    <div class="card">
        <h2>📋 Historique</h2>
        <div class="history-list">
            @forelse($reclamations as $r)
            <div class="history-item">
                <div class="history-header">
                    <div style="flex: 1;">
                        <div class="history-title">{{ $r->titre ?? $r->type }}</div>
                        <div class="history-desc">{{ \Str::limit($r->description, 60) }}</div>
                        <div class="history-date">{{ $r->created_at->format('d M Y') }}</div>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center; margin-left: 8px;">
                        <span class="badge-pending" style="white-space: nowrap;">{{ ucfirst($r->statut ?? 'en_attente') }}</span>
                        <form method="POST" action="{{ route('enseignant.reclamations.destroy', $r->id) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-history" title="Supprimer">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <p style="color:var(--text-muted);font-size:13px;text-align:center;padding:20px 0;">
                <i class="fa-regular fa-inbox"></i> Aucune réclamation envoyée.
            </p>
            @endforelse
        </div>
    </div>
</div>

@endsection
