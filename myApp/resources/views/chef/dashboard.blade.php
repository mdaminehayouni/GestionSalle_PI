@extends('layouts.chef')

@section('content')
<div class="p-8 fade-in">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Salles -->
        <div class="bg-white rounded-2xl p-6 shadow-sm card-hover border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                    </svg>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-800">
                {{ $countSalle }}
            </h3>
            <p class="text-sm text-gray-500">Total salles</p>
        </div>

        <!-- Réclamations (placeholder if not implemented yet) -->
        <div class="bg-white rounded-2xl p-6 shadow-sm card-hover border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-800">0</h3>
            <p class="text-sm text-gray-500">Réclamations</p>
        </div>

        <!-- Enseignants -->
        <div class="bg-white rounded-2xl p-6 shadow-sm card-hover border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-800">
                {{ $countEnseignant }}
            </h3>
            <p class="text-sm text-gray-500">Enseignants</p>
        </div>

    </div>

</div>
@endsection