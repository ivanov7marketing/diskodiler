@extends('layouts.app')

@section('page', 'delivery')
@section('title', 'Доставка и оплата оригинальных дисков по России | ДискоДилер')
@section('description', 'Доставка оригинальных дисков и колес ДискоДилер по Санкт-Петербургу, России и странам СНГ: самовывоз, транспортные компании, Деловые Линии, упаковка, фото/видео фиксация и оплата.')
@section('canonical', url('/delivery'))

@php
  $faqItems = [
    [
      'question' => 'В какие города отправляете диски и колеса?',
      'answer' => 'Отправляем комплекты по России и в страны СНГ через транспортные компании. Перед отправкой согласуем город, терминал или доставку до адреса.',
    ],
    [
      'question' => 'Как упаковываете комплект перед отправкой?',
      'answer' => 'Каждый диск защищаем отдельно, фиксируем состояние на фото или видео и согласуем транспортную компанию с покупателем.',
    ],
    [
      'question' => 'Можно ли забрать комплект самостоятельно?',
      'answer' => 'Да. В Санкт-Петербурге можно согласовать самовывоз со склада и при необходимости установку на шиномонтаже.',
    ],
  ];
  $faqJsonLd = \App\Support\SeoSchema::faqPage($faqItems);
  $breadcrumbJsonLd = \App\Support\SeoSchema::breadcrumbList([
    ['name' => 'Главная', 'item' => route('home')],
    ['name' => 'Доставка', 'item' => route('delivery')],
  ]);
@endphp

@push('head')
  <script type="application/ld+json">@json($breadcrumbJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
  <script type="application/ld+json">@json($faqJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
@endpush

@section('content')
<main class="container">
  <nav class="breadcrumbs" aria-label="Хлебные крошки">
    <a href="{{ route('home') }}">Главная</a><span>→</span><span>Доставка</span>
  </nav>

  <section class="section compact product-layout">
    <div class="section-head">
      <span class="section-kicker">Delivery</span>
      <h1>Доставка и оплата оригинальных дисков</h1>
      <p class="lead">Отправляем комплекты по Санкт-Петербургу, России и странам СНГ. Перед передачей в транспортную компанию фиксируем состояние, показываем упаковку и согласуем удобный способ получения.</p>
      <div class="hero-meta">
        <span class="badge accent">Россия и СНГ</span>
        <span class="badge">Деловые Линии</span>
        <span class="badge">Фото/видео фиксация</span>
      </div>
    </div>
    <aside class="summary-panel">
      <span class="section-kicker">Быстро уточнить</span>
      <h2>Рассчитаем доставку комплекта</h2>
      <p class="small">Напишите город, модель автомобиля и ссылку на комплект. Менеджер подскажет варианты отправки, ориентир по срокам и условия оплаты.</p>
      <div class="product-cta-actions">
        <button class="btn" type="button" data-open-modal="vin-modal" data-goal="delivery_calc_request">Уточнить доставку</button>
        <a class="btn secondary" href="https://wa.me/79669264666" data-goal="delivery_whatsapp">WhatsApp</a>
      </div>
    </aside>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Способы получения</span>
      <h2>Как можно получить комплект</h2>
    </div>
    <div class="grid info-grid">
      <article class="info-card">
        <h3>Самовывоз в Санкт-Петербурге</h3>
        <p class="small">Можно согласовать осмотр и выдачу со склада. Если нужна установка, подскажем по шиномонтажу на Салова 31с3.</p>
      </article>
      <article class="info-card">
        <h3>Транспортная компания</h3>
        <p class="small">Основной вариант для регионов: отправка через согласованную ТК, в том числе через “Деловые Линии”.</p>
      </article>
      <article class="info-card">
        <h3>Доставка до адреса</h3>
        <p class="small">Если транспортная компания поддерживает доставку до двери в вашем городе, согласуем этот вариант перед отправкой.</p>
      </article>
    </div>
  </section>

  <section class="section compact cta-band">
    <div class="section-head">
      <span class="section-kicker">Порядок отправки</span>
      <h2>Что происходит перед передачей груза</h2>
    </div>
    <div class="grid steps">
      <article class="feature step">
        <h3>Подтверждаем комплект</h3>
        <p class="small">Сверяем OEM-номер, параметры, цену, состояние и совместимость по VIN, если это важно для покупки.</p>
      </article>
      <article class="feature step">
        <h3>Фиксируем состояние</h3>
        <p class="small">Отправляем фото или видео дисков, маркировки, лицевой стороны, внутренней части и кромок.</p>
      </article>
      <article class="feature step">
        <h3>Упаковываем и отправляем</h3>
        <p class="small">Защищаем каждый диск, передаем груз в ТК и отправляем данные для отслеживания после оформления.</p>
      </article>
    </div>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Оплата</span>
      <h2>Оплата комплекта и перевозки</h2>
      <p class="lead">Условия оплаты зависят от конкретного комплекта, города и выбранной транспортной компании. Перед сделкой менеджер фиксирует сумму, способ оплаты и порядок передачи.</p>
    </div>
    <div class="grid info-grid">
      <article class="info-card">
        <h3>Комплект</h3>
        <p class="small">Стоимость дисков или колес согласуется до отправки. Для редких OEM-комплектов условия резерва обсуждаются отдельно.</p>
      </article>
      <article class="info-card">
        <h3>Перевозка</h3>
        <p class="small">Стоимость доставки рассчитывается по тарифам транспортной компании с учетом города, веса, объема и дополнительных услуг.</p>
      </article>
      <article class="info-card">
        <h3>Документы</h3>
        <p class="small">После передачи груза отправляем данные по отправке и помогаем с отслеживанием, если у ТК возникают вопросы.</p>
      </article>
    </div>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Адреса</span>
      <h2>Где забрать или посмотреть комплект</h2>
    </div>
    <div class="grid info-grid">
      <article class="info-card">
        <h3>Офис</h3>
        <p class="small">Санкт-Петербург, ул. Салова 27АД, офис 316. Визит лучше согласовать заранее с менеджером.</p>
      </article>
      <article class="info-card">
        <h3>Склад и шиномонтаж</h3>
        <p class="small">Санкт-Петербург, ул. Салова 31с3. Здесь можно согласовать осмотр, выдачу и установку комплекта.</p>
      </article>
      <article class="info-card">
        <h3>Связь</h3>
        <p class="small">Телефон и WhatsApp: +7 (966) 926-46-66. E-mail: shop@diskodiler.ru.</p>
      </article>
    </div>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">FAQ</span>
      <h2>Частые вопросы про доставку</h2>
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
</main>
@endsection
