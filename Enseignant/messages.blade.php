@extends('enseignant.layouts.app')
@section('page-title', 'Envoyer un message')

@push('styles')
<style>
    .msg-card {
        background: white;
        border-radius: var(--radius);
        padding: 32px;
        box-shadow: var(--shadow);
        max-width: 680px;
    }

    .msg-card h2 { font-size: 20px; font-weight: 700; margin-bottom: 10px; }
    .msg-card p { font-size: 13px; color: var(--text-muted); margin-bottom: 28px; }

    .form-group { margin-bottom: 22px; }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 9px;
    }

    .form-group textarea {
        width: 100%;
        padding: 14px 16px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        color: var(--text);
        outline: none;
        resize: vertical;
        min-height: 150px;
        transition: border-color .2s;
    }
    .form-group textarea:focus { border-color: var(--blue); }

    .btn-send {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 13px 28px;
        background: var(--blue);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        font-family: inherit;
        transition: opacity .2s;
    }
    .btn-send:hover { opacity: .9; }

    .success-alert {
        background: var(--green-light);
        color: #1a7a4a;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

<div class="msg-card">
    <h2>📨 Envoyer un message aux étudiants</h2>
    <p>Communicez directement avec vos étudiants</p>

    @if(session('success'))
        <div class="success-alert">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('enseignant.messages.store') }}">
        @csrf

        <div class="form-group">
            <label>Votre message *</label>
            <textarea name="contenu" required placeholder="Écrivez votre message ici..." maxlength="2000"></textarea>
        </div>

        <button type="submit" class="btn-send">
            <i class="fa-solid fa-paper-plane"></i> Envoyer aux étudiants
        </button>
    </form>
</div>

@endsection
