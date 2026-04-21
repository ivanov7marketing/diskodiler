@extends('layouts.app')

@section('page', 'legal')
@section('title', 'Гарантия и проверка оригинальности дисков | ДискоДилер')
@section('description', 'Как ДискоДилер проверяет оригинальность OEM-дисков: маркировка, артикулы, параметры, фото перед оплатой и гарантийные условия.')
@section('canonical', url('/warranty'))

@section('content')
<main class="container"><section class="section compact"><div class="section-head"><span class="section-kicker">Warranty</span><h1>Гарантия и оригинальность OEM-дисков</h1><p class="lead">Для каждого комплекта проверяем заводскую маркировку, OEM-артикулы, параметры посадки и состояние до оплаты.</p></div><div class="grid info-grid"><article class="info-card"><h3>Маркировка</h3><p class="small">Парт-номер, производитель, страна, цвет, ширина, вылет и диаметр.</p></article><article class="info-card"><h3>Совместимость</h3><p class="small">Проверяем PCD, DIA, ET и допустимые размеры по VIN.</p></article><article class="info-card"><h3>Состояние</h3><p class="small">Фиксируем покрытие, кромки, следы ремонта и комплектность.</p></article></div></section></main>
@endsection
