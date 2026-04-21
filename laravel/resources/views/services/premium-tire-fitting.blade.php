@extends('layouts.app')

@section('page', 'services')
@section('title', 'Премиальный шиномонтаж RunFlat R18-R23 в СПб | ДискоДилер')
@section('description', 'Премиальный шиномонтаж в Санкт-Петербурге для OEM-дисков R18-R23, низкопрофильных шин и RunFlat: аккуратный монтаж, балансировка и запись.')
@section('canonical', url('/services/premium-tire-fitting'))

@php
  $faqItems = [
    [
      'question' => 'Работаете ли вы с RunFlat и низким профилем?',
      'answer' => 'Да. Учитываем жесткий борт RunFlat, большой диаметр и риск повреждения покрытия на премиальных OEM-дисках.',
    ],
    [
      'question' => 'Можно ли совместить покупку дисков и шиномонтаж?',
      'answer' => 'Да. Если комплект есть в наличии, можно согласовать осмотр, установку, балансировку и выдачу в один визит.',
    ],
    [
      'question' => 'Нужно ли записываться заранее?',
      'answer' => 'Да, лучше оставить заявку заранее: менеджер уточнит диаметр, тип шин, удобное время и подготовит пост.',
    ],
  ];
  $faqJsonLd = \App\Support\SeoSchema::faqPage($faqItems);
  $breadcrumbJsonLd = \App\Support\SeoSchema::breadcrumbList([
    ['name' => 'Главная', 'item' => route('home')],
    ['name' => 'Услуги', 'item' => route('services.index')],
    ['name' => 'Шиномонтаж', 'item' => url('/services/premium-tire-fitting')],
  ]);
@endphp

@push('head')
  <script type="application/ld+json">@json($breadcrumbJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
  <script type="application/ld+json">@json($faqJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
@endpush

@section('content')
<main class="container service-landing" data-service-landing>
  <nav class="breadcrumbs" aria-label="Хлебные крошки">
    <a href="{{ route('home') }}">Главная</a><span>→</span><a href="{{ route('services.index') }}">Услуги</a><span>→</span><span>Шиномонтаж</span>
  </nav>

  <section class="section compact service-hero service-hero-fitting">
    <div class="service-hero-copy">
      <span class="section-kicker">RunFlat service</span>
      <h1>Премиальный шиномонтаж RunFlat и дисков R18-R23</h1>
      <p class="lead">Аккуратно работаем с большими диаметрами, низким профилем и оригинальными дисками. Перед записью уточняем размер, тип шин и задачу, чтобы подготовить пост.</p>
      <div class="hero-meta">
        <span class="badge accent">R18-R23</span>
        <span class="badge">RunFlat</span>
        <span class="badge">Балансировка</span>
      </div>
    </div>
    <aside class="service-form-card" id="fitting-request">
      <span class="section-kicker">Запись на сервис</span>
      <h2>Уточним время и размер</h2>
      <p class="small">Оставьте контакты, диаметр и тип шин. Менеджер подтвердит свободное время.</p>
      <form data-lead-form data-goal="premium_tire_fitting_book">
        <textarea class="textarea" name="message" placeholder="Например: BMW X5 G05, R20, RunFlat, нужно переобуть комплект"></textarea>
        <select class="select" name="contactMethod" aria-label="Удобный способ связи">
          <option value="Telegram">Telegram</option>
          <option value="Max">Max</option>
          <option value="Звонок">Звонок</option>
        </select>
        <div class="lead-fields-row">
          <input class="input" name="name" placeholder="Ваше имя" autocomplete="name">
          <input class="input" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel">
        </div>
        <button class="btn" type="submit">Записаться</button>
      </form>
      <div class="notice" role="status"></div>
    </aside>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Доверие</span>
      <h2>Почему премиальные диски лучше доверить профильному сервису</h2>
    </div>
    <div class="grid service-trust-grid">
      <article class="feature"><h3>Большие диаметры</h3><p class="small">Работаем с R18-R23 и учитываем особенности низкого профиля.</p></article>
      <article class="feature"><h3>RunFlat</h3><p class="small">Аккуратно снимаем и ставим жесткий борт без лишнего риска для покрытия.</p></article>
      <article class="feature"><h3>OEM-диски</h3><p class="small">Бережно обращаемся с оригинальными комплектами и декоративным покрытием.</p></article>
      <article class="feature"><h3>Проверка</h3><p class="small">После монтажа контролируем давление, балансировку и состояние посадки.</p></article>
    </div>
  </section>

  <section class="section compact cta-band">
    <div class="section-head">
      <span class="section-kicker">Цены</span>
      <h2>Ориентиры по шиномонтажу</h2>
      <p class="lead">Финальная стоимость зависит от диаметра, профиля, RunFlat и состояния комплекта.</p>
    </div>
    <table class="pricing-table service-pricing-table">
      <tbody>
        <tr><td>Шиномонтаж R18-R20</td><td>от 4 800 ₽</td><td>Демонтаж, монтаж, балансировка</td></tr>
        <tr><td>Шиномонтаж R21-R23</td><td>от 6 900 ₽</td><td>Большие диаметры и низкий профиль</td></tr>
        <tr><td>RunFlat</td><td>от 7 900 ₽</td><td>Работа с жестким бортом</td></tr>
      </tbody>
    </table>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Кейсы</span>
      <h2>Когда лучше записаться заранее</h2>
    </div>
    <div class="grid service-cases-grid">
      <article class="info-card"><h3>Низкий профиль R21-R23</h3><p class="small">Подготовим оборудование и время, чтобы спокойно работать с жесткой посадкой.</p></article>
      <article class="info-card"><h3>RunFlat после сезона</h3><p class="small">Проверим состояние борта, давление и балансировку перед установкой.</p></article>
      <article class="info-card"><h3>Новый OEM-комплект</h3><p class="small">Можно совместить осмотр, установку и выдачу комплекта в один визит.</p></article>
    </div>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">FAQ</span>
      <h2>Частые вопросы про премиальный шиномонтаж</h2>
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
        <span class="section-kicker">Запись</span>
        <h2>Подготовим пост под ваш комплект</h2>
        <p class="lead">Напишите модель, диаметр и тип шин. Менеджер подтвердит время и подскажет, сколько заложить на работу.</p>
      </div>
      <a class="btn" href="#fitting-request" data-goal="fitting_service_bottom_form">Записаться</a>
    </div>
  </section>
</main>
@endsection
