@extends('layouts.app')

@section('page', 'catalog')
@section('title', $pageTitle ?? 'Оригинальные диски купить в Санкт-Петербурге | ДискоДилер')
@section('description', $pageDescription ?? 'Каталог оригинальных OEM дисков для BMW, Mercedes-Benz, Porsche, Range Rover и других марок: цена, наличие, подбор по VIN и доставка по России.')
@section('canonical', $canonicalUrl ?? url('/diski'))

@push('head')
  <script type="application/ld+json">@json($breadcrumbJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
  @if(!empty($faqJsonLd['mainEntity']))
    <script type="application/ld+json">@json($faqJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
  @endif
@endpush

@section('content')
<main class="container">
  <nav class="breadcrumbs" aria-label="Хлебные крошки">
    <a href="/">Главная</a><span>→</span><a href="/diski">Диски</a>
    @if($currentBrand)
      <span>→</span><a href="{{ route('catalog.brand', $currentBrand) }}">{{ $currentBrand->name }}</a>
    @endif
    @if($currentVehicleModel)
      <span>→</span><span>{{ $currentVehicleModel->name }}</span>
    @endif
  </nav>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">OEM catalog</span>
      <h1>{{ $pageH1 ?? 'Каталог оригинальных дисков' }}</h1>
      <p class="lead">Фильтруйте по кузову, году, диаметру, стилю и цвету. Если сомневаетесь, отправьте VIN — проверим совместимость до покупки.</p>
    </div>
  </section>

  <section class="catalog-shell" aria-label="Каталог дисков">
    <aside class="filters" aria-label="Фильтры каталога">
      <form method="GET" action="{{ $currentVehicleModel ? route('catalog.model', [$currentBrand, $currentVehicleModel->slug]) : ($currentBrand ? route('catalog.brand', $currentBrand) : route('catalog.index')) }}">
        <div class="filter-group">
          <label for="brand">Марка</label>
          <select class="select" id="brand" name="brand" @disabled($currentBrand !== null)>
            <option value="">Все марки</option>
            @foreach($brands as $brandOption)
              <option value="{{ $brandOption->name }}" @selected(($filters['brand'] ?? '') === $brandOption->name)>{{ $brandOption->name }}</option>
            @endforeach
          </select>
          @if($currentBrand)
            <input type="hidden" name="brand" value="{{ $currentBrand->name }}">
          @endif
        </div>
        <div class="filter-group">
          <label for="model">Модель</label>
          <select class="select" id="model" name="model" @disabled($currentVehicleModel !== null)>
            <option value="">Все модели</option>
            @foreach($vehicleModels as $modelOption)
              <option value="{{ $modelOption->name }}" @selected(($filters['model'] ?? '') === $modelOption->name)>{{ $modelOption->name }}</option>
            @endforeach
          </select>
          @if($currentVehicleModel)
            <input type="hidden" name="model" value="{{ $currentVehicleModel->name }}">
          @endif
        </div>
        <div class="filter-group">
          <label for="year">Год</label>
          <select class="select" id="year" name="year">
            <option value="">Любой</option>
            @foreach($years as $year)
              <option value="{{ $year }}" @selected(($filters['year'] ?? '') === $year)>{{ $year }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <label for="size">Диаметр</label>
          <select class="select" id="size" name="size">
            <option value="">R16–R23</option>
            @foreach($sizes as $size)
              <option value="{{ $size }}" @selected(($filters['size'] ?? '') === $size)>{{ $size }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <label for="style">Стиль</label>
          <select class="select" id="style" name="style">
            <option value="">Любой стиль</option>
            @foreach($styles as $style)
              <option value="{{ $style }}" @selected(($filters['style'] ?? '') === $style)>{{ $style }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <label for="color">Цвет</label>
          <select class="select" id="color" name="color">
            <option value="">Любой цвет</option>
            @foreach($colors as $color)
              <option value="{{ $color }}" @selected(($filters['color'] ?? '') === $color)>{{ $color }}</option>
            @endforeach
          </select>
        </div>
        <button class="btn" type="submit" data-goal="catalog_filter_apply">Показать</button>
        <a class="btn secondary" href="{{ $currentVehicleModel ? route('catalog.model', [$currentBrand, $currentVehicleModel->slug]) : ($currentBrand ? route('catalog.brand', $currentBrand) : route('catalog.index')) }}" data-goal="catalog_filter_reset">Сбросить</a>
      </form>
    </aside>

    <div>
      <div class="catalog-toolbar">
        <strong data-result-count>{{ $products->count() }} комплектов</strong>
        <button class="btn secondary" type="button" data-open-modal="vin-modal" data-goal="catalog_toolbar_vin">Проверить по VIN</button>
      </div>

      <div class="grid products-grid">
        @foreach($products as $product)
          <article class="product-card" data-product-card>
            <div class="product-media">
              <img src="{{ $product->primaryImage?->media_url }}" alt="{{ $product->primaryImage?->alt ?? $product->title }}" width="900" height="900" loading="lazy" decoding="async">
            </div>
            <div class="product-body">
              <div class="product-title">
                <span class="badge accent">{{ $product->fitment }}</span>
                <h3>{{ $product->title }}</h3>
                <p class="small">OEM: {{ $product->oem }}</p>
              </div>
              <p class="spec-list">{{ $product->specs }}<br>{{ $product->brand->name }} • {{ $product->vehicleModel->name }} • {{ $product->year }}</p>
              <div class="hero-meta">
                <span class="badge">{{ $product->color }}</span>
                <span class="badge">{{ $product->stock }}</span>
              </div>
              <p class="price">{{ $product->display_price }}</p>
              <div class="card-actions">
                <a class="btn" href="{{ route('products.show', $product) }}" data-goal="catalog_product_details">Подробнее</a>
              </div>
            </div>
          </article>
        @endforeach
      </div>

      <div class="empty-state @if($products->isEmpty()) is-visible @endif" data-empty-state>
        <h2>Нет точного совпадения</h2>
        <p class="small">OEM-склады меняются быстро. Отправьте VIN, и мы проверим наличие у дилерских поставщиков и центрального склада.</p>
        <button class="btn" type="button" data-open-modal="vin-modal" data-goal="catalog_empty_vin">Отправить VIN</button>
      </div>
    </div>
  </section>

  @if($seoText)
    <section class="section compact">
      <div class="section-head">
        <span class="section-kicker">Подбор</span>
        <h2>Проверим совместимость перед покупкой</h2>
        <p class="lead">{!! nl2br(e($seoText)) !!}</p>
      </div>
    </section>
  @endif

  @if($currentBrand)
    @if($brandSemantics)
      <section class="section compact">
        <div class="section-head">
          <span class="section-kicker">Популярные варианты</span>
          <h2>Что подбираем для {{ $currentVehicleModel ? $currentBrand->name . ' ' . $currentVehicleModel->name : $currentBrand->name }}</h2>
          <p class="lead">{{ $brandSemantics['sizing'] }}</p>
        </div>
        <div class="seo-chips" aria-label="Популярные варианты подбора">
          @foreach($brandSemantics['queries'] as $query)
            <span>{{ $query }}</span>
          @endforeach
        </div>
        <div class="grid seo-factor-grid">
          @foreach($brandSemantics['factors'] as $factor)
            <article class="feature">
              <h3>{{ $factor['title'] }}</h3>
              <p class="small">{{ $factor['text'] }}</p>
            </article>
          @endforeach
        </div>
      </section>
    @endif

    <section class="section compact">
      <div class="section-head">
        <span class="section-kicker">Модели {{ $currentBrand->name }}</span>
        <h2>Страницы под конкретный кузов</h2>
        <p class="lead">Так проще подобрать оригинальные диски по заводским параметрам конкретного автомобиля: VIN, кузову, допустимому диаметру, ширине и вылету.</p>
      </div>
      <div class="grid models-grid">
        @forelse($pageModels as $model)
          <a class="model-tile" href="{{ route('catalog.model', [$currentBrand, $model->slug]) }}">
            <span class="model-code">{{ $model->name }}</span>
            <h3>{{ $currentBrand->name }} {{ $model->name }}</h3>
            <p class="small">{{ $model->products_count }} комплектов в каталоге. Проверим совместимость по VIN перед оплатой.</p>
          </a>
        @empty
          <button class="model-tile" type="button" data-open-modal="vin-modal" data-goal="brand_models_empty_vin">
            <span class="model-code">VIN</span>
            <h3>Нужной модели пока нет</h3>
            <p class="small">Оставьте VIN, и менеджер проверит наличие оригинальных комплектов {{ $currentBrand->name }} под ваш автомобиль.</p>
          </button>
        @endforelse
      </div>
    </section>

    <section class="section compact cta-band">
      <div class="section-head">
        <span class="section-kicker">OEM-проверка</span>
        <h2>Что проверяем перед продажей</h2>
      </div>
      <div class="grid steps">
        <article class="feature step">
          <h3>Маркировка и парт-номер</h3>
          <p class="small">Сверяем OEM-артикулы, заводские клейма, размерность и соответствие конкретной линейке {{ $currentBrand->name }}.</p>
        </article>
        <article class="feature step">
          <h3>Посадочные параметры</h3>
          <p class="small">Проверяем PCD, DIA, ширину, вылет и допустимый диаметр, чтобы комплект не создавал проблем с посадкой.</p>
        </article>
        <article class="feature step">
          <h3>Фото и состояние</h3>
          <p class="small">Перед оплатой отправляем фото маркировки, состояния лицевой части, внутренней стороны и упаковки.</p>
        </article>
      </div>
    </section>

  @endif

  @if($faqItems)
    <section class="section compact">
      <div class="section-head">
        <span class="section-kicker">Вопросы</span>
        <h2>{{ $currentBrand ? 'Частые вопросы про диски ' . ($currentVehicleModel ? $currentBrand->name . ' ' . $currentVehicleModel->name : $currentBrand->name) : 'Частые вопросы про оригинальные диски' }}</h2>
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
  @endif

  <section class="section">
    <div class="section-head"><span class="section-kicker">Недавно смотрели</span><h2>Последние комплекты</h2></div>
    <div class="grid models-grid" data-recently-viewed></div>
  </section>
</main>
@endsection
