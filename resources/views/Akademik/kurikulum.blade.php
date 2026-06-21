@extends('layouts.app')

@section('title', 'Kurikulum')
@section('description', 'Kurikulum SDN Dadapsari Semarang — prinsip, sistem pembelajaran, dan penilaian.')

@section('content')

    @include('partials.page-header', [
        'eyebrow' => 'Akademik',
        'title' => 'Kurikulum Sekolah',
        'subtitle' => 'Penerapan Kurikulum 2013 di SDN Dadapsari Semarang.',
    ])

    @include('partials.akademik.kurikulum-card', [
        'judulKurikulum' => $judulKurikulum,
        'blok' => $blok,
    ])

@endsection
