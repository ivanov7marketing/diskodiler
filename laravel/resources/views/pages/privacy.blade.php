@extends('layouts.app')

@section('page', 'legal')
@section('robots', 'noindex,follow')
@section('title', 'Политика обработки персональных данных | ДискоДилер')
@section('description', 'Политика обработки персональных данных ДискоДилер для заявок на подбор дисков, услуги, доставку и обратную связь.')
@section('canonical', url('/privacy'))

@section('content')
<main class="container"><section class="section compact"><div class="section-head"><span class="section-kicker">Privacy</span><h1>Политика обработки персональных данных</h1><p class="lead">Данные из форм используются для обработки заявки: подбора дисков, проверки VIN, услуги, доставки и связи с клиентом.</p></div><div class="faq"><details open><summary>Какие данные собираются?</summary><p>Имя, телефон, Telegram, VIN, комментарий, источник страницы и UTM-метки.</p></details><details><summary>Зачем нужны данные?</summary><p>Чтобы менеджер мог проверить совместимость, наличие, цену, доставку или запись на услугу.</p></details></div></section></main>
@endsection
