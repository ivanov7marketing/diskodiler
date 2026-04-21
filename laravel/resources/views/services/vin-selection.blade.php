@extends('layouts.app')

@section('page', 'services')
@section('title', 'Подбор оригинальных дисков по VIN | ДискоДилер')
@section('description', 'Подбор OEM-дисков по VIN: проверка совместимости, заводских артикулов, PCD, DIA, вылета, ширины и допустимых размеров перед покупкой.')
@section('canonical', url('/services/vin-selection'))

@php
  $faqItems = [
    [
      'question' => 'Зачем нужен VIN при подборе дисков?',
      'answer' => 'VIN помогает сверить кузов, комплектацию, тормоза, допустимый диаметр, ширину, вылет, PCD, DIA и OEM-артикулы до оплаты комплекта.',
    ],
    [
      'question' => 'Можно ли подобрать диски, если VIN нет под рукой?',
      'answer' => 'Да. Напишите марку, модель, кузов, год и желаемый диаметр. VIN все равно лучше прислать перед финальным подтверждением совместимости.',
    ],
    [
      'question' => 'Что вы отправляете после проверки?',
      'answer' => 'Менеджер предложит подходящие комплекты, объяснит параметры, пришлет фото маркировки и состояния, а также условия самовывоза или доставки.',
    ],
  ];
  $faqJsonLd = \App\Support\SeoSchema::faqPage($faqItems);
  $breadcrumbJsonLd = \App\Support\SeoSchema::breadcrumbList([
    ['name' => 'Главная', 'item' => route('home')],
    ['name' => 'Услуги', 'item' => route('services.index')],
    ['name' => 'Подбор по VIN', 'item' => url('/services/vin-selection')],
  ]);
@endphp

@push('head')
  <script type="application/ld+json">@json($breadcrumbJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
  <script type="application/ld+json">@json($faqJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
@endpush

@section('content')
<main class="container service-landing" data-service-landing>
  <nav class="breadcrumbs" aria-label="Хлебные крошки">
    <a href="{{ route('home') }}">Главная</a><span>→</span><a href="{{ route('services.index') }}">Услуги</a><span>→</span><span>Подбор по VIN</span>
  </nav>

  <section class="section compact service-hero service-hero-vin">
    <div class="service-hero-copy">
      <span class="section-kicker">VIN selection</span>
      <h1>Подбор оригинальных дисков по VIN без ошибки по посадке</h1>
      <p class="lead">Сверим комплектацию автомобиля, OEM-артикулы, диаметр, ширину, вылет, PCD и DIA. Перед покупкой будет понятно, какие диски действительно подходят вашему кузову.</p>
      <div class="hero-meta">
        <span class="badge accent">OEM-артикулы</span>
        <span class="badge">PCD / DIA / ET</span>
        <span class="badge">Фото маркировки</span>
      </div>
    </div>
    <aside class="service-form-card vin-panel" id="vin-request">
      <span class="section-kicker">Заявка менеджеру</span>
      <h2>Проверим совместимость</h2>
      <p class="small">Оставьте VIN или данные автомобиля. Менеджер подготовит подборку и объяснит разницу по параметрам.</p>
      <form data-vin-form data-goal="vin_selection_page_submit">
        <input class="input" name="vin" placeholder="VIN или модель автомобиля" autocomplete="off">
        <div class="lead-fields-row">
          <input class="input" name="name" placeholder="Ваше имя" autocomplete="name">
          <input class="input" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel">
        </div>
        <button class="btn" type="submit">Проверить по VIN</button>
      </form>
      <div class="notice" role="status"></div>
    </aside>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Что проверяем</span>
      <h2>Не только диаметр, а всю посадку комплекта</h2>
    </div>
    <div class="grid service-trust-grid">
      <article class="feature"><h3>Кузов и комплектация</h3><p class="small">Проверяем поколение, тормоза, заводские ограничения и допустимые размеры.</p></article>
      <article class="feature"><h3>OEM-номера</h3><p class="small">Сверяем артикулы и маркировку на дисках, чтобы не купить похожий, но чужой комплект.</p></article>
      <article class="feature"><h3>Посадочные параметры</h3><p class="small">Смотрим ширину, ET, PCD, DIA и необходимость дополнительных колец или болтов.</p></article>
      <article class="feature"><h3>Состояние комплекта</h3><p class="small">Перед сделкой отправляем фото лица, внутренней стороны, кромок и маркировки.</p></article>
    </div>
  </section>

  <section class="section compact cta-band">
    <div class="section-head">
      <span class="section-kicker">Как проходит подбор</span>
      <h2>От VIN до понятного предложения</h2>
    </div>
    <div class="grid steps service-process-grid">
      <article class="feature step"><h3>Получаем данные</h3><p class="small">VIN, модель, год, желаемый диаметр и пожелания по стилю или цвету.</p></article>
      <article class="feature step"><h3>Сверяем параметры</h3><p class="small">Проверяем заводские допуски и выбираем комплекты из наличия или ближайшей поставки.</p></article>
      <article class="feature step"><h3>Отправляем варианты</h3><p class="small">Показываем фото, цену, состояние, сроки доставки и посадочные параметры.</p></article>
    </div>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Кейсы</span>
      <h2>Типовые задачи, где VIN экономит время</h2>
    </div>
    <div class="grid service-cases-grid">
      <article class="info-card"><h3>BMW X5 G05 R20</h3><p class="small">Сверяем разноширокий комплект, вылет и совместимость с тормозами M Sport.</p></article>
      <article class="info-card"><h3>Porsche Cayenne R22</h3><p class="small">Проверяем OEM-номер, ширину перед/зад и состояние покрытия перед резервом.</p></article>
      <article class="info-card"><h3>Mercedes-Benz GLE</h3><p class="small">Подбираем допустимый диаметр и объясняем разницу между AMG и обычной посадкой.</p></article>
    </div>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">FAQ</span>
      <h2>Частые вопросы про подбор дисков по VIN</h2>
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
        <span class="section-kicker">Подбор менеджером</span>
        <h2>Пришлите VIN, остальное проверим сами</h2>
        <p class="lead">Подберем оригинальные комплекты, сверим параметры и отправим варианты с фото, ценой и условиями доставки.</p>
      </div>
      <a class="btn" href="#vin-request" data-goal="vin_service_bottom_form">Отправить VIN</a>
    </div>
  </section>
</main>
@endsection
