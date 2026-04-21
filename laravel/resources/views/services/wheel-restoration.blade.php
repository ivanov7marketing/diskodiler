@extends('layouts.app')

@section('page', 'services')
@section('title', 'Восстановление и ремонт дисков в СПб | ДискоДилер')
@section('description', 'Ремонт, восстановление геометрии и окраска оригинальных дисков в Санкт-Петербурге: осмотр, честная оценка, фотофиксация и аккуратная работа с OEM-комплектами.')
@section('canonical', url('/services/wheel-restoration'))

@php
  $faqItems = [
    [
      'question' => 'Когда ремонт диска имеет смысл?',
      'answer' => 'После осмотра смотрим геометрию, биение, трещины, состояние кромки и покрытия. Если ремонт экономически или технически не оправдан, скажем об этом до начала работ.',
    ],
    [
      'question' => 'Можно ли восстановить цвет оригинального диска?',
      'answer' => 'Да, подбираем близкий оттенок и согласуем ожидания до окраски. Для сложных покрытий отдельно обсуждаем возможное отличие от заводского финиша.',
    ],
    [
      'question' => 'Вы отправляете фото до и после?',
      'answer' => 'Да. Фиксируем состояние до работ, согласуем объем и можем отправить фото результата перед выдачей или доставкой.',
    ],
  ];
  $faqJsonLd = \App\Support\SeoSchema::faqPage($faqItems);
  $breadcrumbJsonLd = \App\Support\SeoSchema::breadcrumbList([
    ['name' => 'Главная', 'item' => route('home')],
    ['name' => 'Услуги', 'item' => route('services.index')],
    ['name' => 'Ремонт дисков', 'item' => url('/services/wheel-restoration')],
  ]);
@endphp

@push('head')
  <script type="application/ld+json">@json($breadcrumbJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
  <script type="application/ld+json">@json($faqJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
@endpush

@section('content')
<main class="container service-landing" data-service-landing>
  <nav class="breadcrumbs" aria-label="Хлебные крошки">
    <a href="{{ route('home') }}">Главная</a><span>→</span><a href="{{ route('services.index') }}">Услуги</a><span>→</span><span>Ремонт дисков</span>
  </nav>

  <section class="section compact service-hero service-hero-restoration">
    <div class="service-hero-copy">
      <span class="section-kicker">Wheel restoration</span>
      <h1>Восстановление, правка и окраска оригинальных дисков</h1>
      <p class="lead">Осмотрим геометрию, биение, кромки и покрытие. До работ честно скажем, что можно восстановить, сколько это займет и когда проще искать другой OEM-комплект.</p>
      <div class="hero-meta">
        <span class="badge accent">Осмотр до работ</span>
        <span class="badge">Фотофиксация</span>
        <span class="badge">Окраска и геометрия</span>
      </div>
    </div>
    <aside class="service-form-card" id="restoration-request">
      <span class="section-kicker">Заявка менеджеру</span>
      <h2>Опишите повреждение</h2>
      <p class="small">Напишите диаметр, модель автомобиля и что случилось с диском. Менеджер подскажет следующий шаг.</p>
      <form data-lead-form data-goal="wheel_restoration_request">
        <textarea class="textarea" name="message" placeholder="Например: Porsche Cayenne R22, замята внутренняя кромка"></textarea>
        <select class="select" name="contactMethod" aria-label="Удобный способ связи">
          <option value="Telegram">Telegram</option>
          <option value="Max">Max</option>
          <option value="Звонок">Звонок</option>
        </select>
        <div class="lead-fields-row">
          <input class="input" name="name" placeholder="Ваше имя" autocomplete="name">
          <input class="input" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel">
        </div>
        <button class="btn" type="submit">Отправить на оценку</button>
      </form>
      <div class="notice" role="status"></div>
    </aside>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Почему спокойно</span>
      <h2>Сначала диагностика, потом решение</h2>
    </div>
    <div class="grid service-trust-grid">
      <article class="feature"><h3>Честная оценка</h3><p class="small">Не обещаем восстановление вслепую: сначала осмотр, потом стоимость и сроки.</p></article>
      <article class="feature"><h3>Геометрия</h3><p class="small">Проверяем биение и посадку, чтобы диск не создавал вибрации после ремонта.</p></article>
      <article class="feature"><h3>Покрытие</h3><p class="small">Согласуем цвет, фактуру и ограничения по сложным заводским покрытиям.</p></article>
      <article class="feature"><h3>Фотофиксация</h3><p class="small">Показываем состояние до работ и результат после восстановления.</p></article>
    </div>
  </section>

  <section class="section compact cta-band">
    <div class="section-head">
      <span class="section-kicker">Процесс</span>
      <h2>Как проходит ремонт диска</h2>
    </div>
    <div class="grid steps service-process-grid">
      <article class="feature step"><h3>Осмотр</h3><p class="small">Фиксируем повреждения, проверяем кромки, биение и состояние покрытия.</p></article>
      <article class="feature step"><h3>Согласование</h3><p class="small">Объясняем объем работ, цену, сроки и риски по конкретному диску.</p></article>
      <article class="feature step"><h3>Выдача</h3><p class="small">Показываем результат, согласуем самовывоз, установку или доставку.</p></article>
    </div>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Кейсы</span>
      <h2>С какими задачами приезжают чаще всего</h2>
    </div>
    <div class="grid service-cases-grid">
      <article class="info-card"><h3>Замята внутренняя кромка</h3><p class="small">Проверяем геометрию, правим посадку и контролируем биение после работ.</p></article>
      <article class="info-card"><h3>Сколы и бордюрная болезнь</h3><p class="small">Оцениваем глубину повреждений и согласуем локальный ремонт или полную окраску.</p></article>
      <article class="info-card"><h3>Комплект перед продажей</h3><p class="small">Помогаем привести OEM-комплект в понятное состояние перед установкой или продажей.</p></article>
    </div>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">FAQ</span>
      <h2>Частые вопросы про восстановление дисков</h2>
    </div>
    <div class="faq">
      @foreach($faqItems as $item)
        <details>
          <summary>{{ $item['question'] }}</summary>
          <p>{{ $item['answer'] }}</p>
        </details>
      @endforeach
    </div>
  </section>

  <section class="section compact cta-band service-final-cta">
    <div class="cta-inner">
      <div class="section-head">
        <span class="section-kicker">Осмотр</span>
        <h2>Пришлите фото диска и краткое описание</h2>
        <p class="lead">Менеджер оценит, нужен ли ремонт, какие работы возможны и сколько времени заложить.</p>
      </div>
      <a class="btn" href="#restoration-request" data-goal="restoration_service_bottom_form">Оценить ремонт</a>
    </div>
  </section>
</main>
@endsection
