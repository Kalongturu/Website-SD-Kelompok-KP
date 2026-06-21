@extends('layouts.app')

@section('title', 'Kalender Akademik')
@section('description', 'Kalender akademik (kaldik) SDN Dadapsari Kota Semarang dari tahun ke tahun.')

@section('content')

    @include('partials.page-header', [
        'eyebrow' => 'Akademik',
        'title' => 'Kalender Akademik',
        'subtitle' => 'Unduh kalender pendidikan SDN Dadapsari Kota Semarang sesuai tahun pelajaran.',
    ])

    @include('partials.akademik.kaldik-card', [
        'judulKaldik' => $judulKaldik,
        'kaldik' => $kaldik,
    ])

@endsection
