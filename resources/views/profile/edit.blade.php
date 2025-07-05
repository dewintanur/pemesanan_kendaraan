@extends('layouts.app')

@section('content')
    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Header --}}
            <div class="mb-6">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Profile') }}
                </h2>
            </div>

            {{-- Update Profile Info --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">✏️ Perbarui Informasi Profil</h3>
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

        </div>
    </div>
@endsection
