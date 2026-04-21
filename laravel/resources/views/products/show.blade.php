@extends('layouts.app')

@section('page', 'product')
@section('title', $product->seoTitle())
@section('description', $product->seoDescription())
@section('canonical', route('products.show', $product))

@push('head')
  <script type="application/ld+json">@json($productJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
  <script type="application/ld+json">@json($productBreadcrumbJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
  @if(!empty($productFaqJsonLd['mainEntity']))
    <script type="application/ld+json">@json($productFaqJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
  @endif
@endpush

@section('content')
@php
  $images = $product->images->isNotEmpty() ? $product->images : collect([$product->primaryImage])->filter();
  $mainImage = $images->first();
  $brandUrl = route('catalog.brand', $product->brand);
  $modelUrl = route('catalog.model', [$product->brand, $product->vehicleModel->slug]);
  $fitmentLabel = $product->fitment ?: $product->brand->name . ' ' . $product->vehicleModel->name;
@endphp

<main class="container" data-product-view data-title="{{ $product->title }}" data-price="{{ $product->display_price }}">
  <nav class="breadcrumbs" aria-label="Хлебные крошки">
    <a href="/">Главная</a><span>→</span><a href="/diski">Диски</a><span>→</span><a href="{{ $brandUrl }}">{{ $product->brand->name }}</a><span>→</span><a href="{{ $modelUrl }}">{{ $product->vehicleModel->name }}</a><span>→</span><span>{{ $product->title }}</span>
  </nav>

  <section class="section compact product-hero">
    <div class="gallery" aria-label="Галерея товара">
      <div class="gallery-main">
        <img data-gallery-main src="{{ $mainImage?->media_url }}" alt="{{ $mainImage?->alt ?? $product->title }}" width="1000" height="1000">
        @if($images->count() > 1)
          <div class="gallery-controls">
            <button class="icon-btn" type="button" data-gallery-prev aria-label="Предыдущее фото">‹</button>
            <button class="icon-btn" type="button" data-gallery-next aria-label="Следующее фото">›</button>
          </div>
        @endif
      </div>
      @if($images->count() > 1)
        <div class="thumbs">
          @foreach($images as $image)
            <button class="thumb" type="button" data-gallery-thumb data-large="{{ $image->media_url }}" data-alt="{{ $image->alt ?? $product->title }}">
              <img src="{{ $image->media_url }}" alt="" width="240" height="240" loading="lazy">
            </button>
          @endforeach
        </div>
      @endif
      @if($product->resolved_video_url)
        <div class="product-video-panel">
          <h2>Видео осмотра комплекта</h2>
          <p class="small">Покажем состояние, маркировку и кромки перед оплатой.</p>
          <video controls preload="metadata" poster="{{ $product->resolved_video_poster_url }}">
            <source src="{{ $product->resolved_video_url }}">
          </video>
        </div>
      @endif
    </div>

    <aside class="product-summary">
      <div class="summary-panel product-buy-box">
        <div class="hero-meta product-status-row">
          <span class="badge accent">Подходит для {{ $fitmentLabel }}</span>
          <span class="badge">{{ $product->stock_status_label }}</span>
          <span class="badge">{{ $product->set_condition_label }}</span>
        </div>
        <h1>{{ $product->pageH1() }}</h1>
        <div class="product-key-facts" aria-label="Ключевые параметры товара">
          <span><strong>Бренд</strong>{{ $product->brand->name }}</span>
          <span><strong>Модель</strong>{{ $product->vehicleModel->name }}</span>
          <span><strong>OEM</strong>{{ $product->oem ?: 'Уточним по маркировке' }}</span>
        </div>
        <p class="price product-price">{{ $product->display_price }}</p>
        <div class="product-availability">
          <span><strong>Статус наличия</strong>{{ $product->stock_status_label }}</span>
          @if($product->stock)
            <span><strong>Остаток</strong>{{ $product->stock }}</span>
          @endif
        </div>
        <p class="lead">{{ $product->description }}</p>
        <div class="product-cta-actions">
          <button class="btn" type="button" data-open-modal="product-reserve-modal" data-goal="product_reserve_click">Забронировать</button>
          <button class="btn secondary" type="button" data-open-modal="product-details-modal" data-goal="product_details_click">Уточнить детали</button>
        </div>
        <div class="product-link-row" aria-label="Внутренние ссылки товара">
          <a href="{{ $brandUrl }}">Все диски {{ $product->brand->name }}</a>
          <a href="{{ $modelUrl }}">Диски {{ $product->brand->name }} {{ $product->vehicleModel->name }}</a>
        </div>
      </div>
      <div class="product-service-tabs" aria-label="Условия покупки">
        <input type="radio" name="product-service-tabs" id="product-tab-delivery" checked>
        <input type="radio" name="product-service-tabs" id="product-tab-warranty">
        <input type="radio" name="product-service-tabs" id="product-tab-return">
        <div class="product-tab-list" role="tablist" aria-label="Доставка, гарантия и возврат">
          <label for="product-tab-delivery" role="tab">Доставка</label>
          <label for="product-tab-warranty" role="tab">Гарантия</label>
          <label for="product-tab-return" role="tab">Возврат</label>
        </div>
        <div class="product-tab-panels">
          <section class="product-tab-panel product-tab-delivery" aria-label="Доставка">
            <h2>Доставка</h2>
            <p class="small">Отправляем по России транспортной компанией после подтверждения комплекта. Перед отправкой фиксируем состояние на фото и аккуратно упаковываем каждый диск.</p>
          </section>
          <section class="product-tab-panel product-tab-warranty" aria-label="Гарантия">
            <h2>Гарантия</h2>
            <p class="small">Проверяем OEM-маркировку, посадочные параметры и состояние. На оригинальность и соответствие заявленному комплекту даем гарантию перед сделкой.</p>
          </section>
          <section class="product-tab-panel product-tab-return" aria-label="Возврат">
            <h2>Возврат</h2>
            <p class="small">Если комплект не соответствует описанию или согласованным параметрам, менеджер разберет ситуацию и согласует обмен или возврат по условиям сделки.</p>
          </section>
        </div>
      </div>
    </aside>
  </section>

  <section class="section compact product-specs-section">
    <div class="section-head">
      <span class="section-kicker">Параметры комплекта</span>
      <h2>Характеристики дисков {{ $product->brand->name }} {{ $product->vehicleModel->name }}</h2>
      <p class="lead">Эти параметры важны для посадки: диаметр, ширина, вылет, PCD, DIA, OEM и совместимость с конкретной моделью.</p>
    </div>
    <div class="spec-table product-spec-table">
      <dl>
        @foreach($product->specRows() as $label => $value)
          <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
        @endforeach
      </dl>
    </div>
  </section>

  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Почему можно брать спокойно</span>
      <h2>Проверяем комплект до оплаты</h2>
      <p class="lead">Менеджер подтверждает оригинальность, состояние и совместимость этого комплекта {{ $product->brand->name }} с вашим автомобилем.</p>
    </div>
    <div class="grid product-trust-grid">
      <article class="feature">
        <h3>Оригинальность</h3>
        <p class="small">Сверяем OEM-артикул {{ $product->oem ?: 'по маркировке' }}, заводские клейма и параметры на самом диске.</p>
      </article>
      <article class="feature">
        <h3>Помощь по VIN</h3>
        <p class="small">Проверяем, подойдет ли комплект для {{ $fitmentLabel }} без догадок по таблицам.</p>
      </article>
      <article class="feature">
        <h3>Доставка по России</h3>
        <p class="small">Согласуем транспортную компанию, фиксируем состояние и упаковываем каждый диск перед отправкой.</p>
      </article>
      <article class="feature">
        <h3>Самовывоз и осмотр</h3>
        <p class="small">В Санкт-Петербурге можно осмотреть комплект перед покупкой и обсудить установку или шиномонтаж.</p>
      </article>
      <article class="feature">
        <h3>Состояние комплекта</h3>
        <p class="small">{{ $product->set_condition_label }}. По запросу отправим дополнительные фото кромок, внутренней стороны и маркировки.</p>
      </article>
    </div>
  </section>

  <section class="section compact product-seo-block">
    <div class="section-head">
      <span class="section-kicker">OEM-подбор</span>
      <h2>Комплект {{ $product->title }} для {{ $fitmentLabel }}</h2>
      <p class="lead">Эта страница помогает быстро понять, подойдет ли комплект под автомобиль, в каком он состоянии и как оставить заявку менеджеру.</p>
    </div>
    <div class="product-copy">
      <div>
        <h3>Что важно перед покупкой</h3>
        <p>Перед оплатой стоит сверить OEM-номер, посадочные параметры, состояние покрытия и совместимость по VIN. Мы проверяем эти пункты по конкретному комплекту, а не по усредненной выдаче каталога.</p>
        @if($product->seo_text)
          <p>{!! nl2br(e($product->seo_text)) !!}</p>
        @endif
      </div>
      <div>
        <h3>Полезные разделы</h3>
        <div class="product-seo-links">
          <a href="{{ route('catalog.index') }}">Каталог оригинальных дисков</a>
          <a href="{{ $brandUrl }}">Диски {{ $product->brand->name }}</a>
          <a href="{{ $modelUrl }}">Диски {{ $product->brand->name }} {{ $product->vehicleModel->name }}</a>
          <button type="button" data-open-modal="vin-modal" data-goal="product_seo_vin">Проверить этот комплект по VIN</button>
        </div>
      </div>
    </div>
  </section>

  @if($productFaqItems)
    <section class="section compact product-faq">
      <div class="section-head">
        <span class="section-kicker">Вопросы по комплекту</span>
        <h2>Что уточнить перед покупкой {{ $product->brand->name }} {{ $product->vehicleModel->name }}</h2>
        <p class="lead">Коротко отвечаем на вопросы, которые обычно решают перед резервом: оригинальность, совместимость, осмотр и доставка.</p>
      </div>
      <div class="faq">
        @foreach($productFaqItems as $item)
          <details>
            <summary>{{ $item['question'] }}</summary>
            <p>{{ $item['answer'] }}</p>
          </details>
        @endforeach
      </div>
    </section>
  @endif

  <section class="section compact cta-band product-bottom-cta">
    <div class="cta-inner">
      <div class="section-head">
        <span class="section-kicker">Вопрос менеджеру</span>
        <h2>Уточните наличие и совместимость</h2>
        <p class="lead">Напишите в удобный мессенджер. Менеджер проверит посадочные параметры, состояние и доставку.</p>
      </div>
      <div class="messenger-actions" aria-label="Написать менеджеру в мессенджер">
        <button class="messenger-btn" type="button" data-open-modal="contact-modal" data-goal="product_bottom_telegram">
          <img src="/assets/img/messengers/icon-telegram.png" alt="" width="28" height="28" loading="lazy">
          <span>Написать в Telegram</span>
        </button>
        <button class="messenger-btn" type="button" data-open-modal="contact-modal" data-goal="product_bottom_max">
          <img src="/assets/img/messengers/icon-max.png" alt="" width="28" height="28" loading="lazy">
          <span>Написать в Max</span>
        </button>
        <a class="messenger-btn" href="https://wa.me/79669264666" data-goal="product_bottom_whatsapp">
          <img src="/assets/img/messengers/icon-whatsapp.png" alt="" width="28" height="28" loading="lazy">
          <span>Написать в WhatsApp</span>
        </a>
      </div>
    </div>
  </section>

  @if($relatedProducts->isNotEmpty())
    <section class="section product-related">
      <div class="related-header">
        <div class="section-head">
          <span class="section-kicker">Похожие комплекты</span>
          <h2>Похожие диски для {{ $product->brand->name }} {{ $product->vehicleModel->name }}</h2>
          <p class="lead">Смотрите комплекты этой же марки и модели или оставьте VIN, если нужен другой диаметр, цвет или стиль.</p>
        </div>
        <a class="btn secondary" href="{{ $modelUrl }}" data-goal="product_related_landing">Все диски для {{ $product->vehicleModel->name }}</a>
      </div>
      <div class="grid products-grid">
        @foreach($relatedProducts as $related)
          <article class="product-card">
            <div class="product-media">
              <img src="{{ $related->primaryImage?->media_url }}" alt="{{ $related->primaryImage?->alt ?? $related->title }}" width="900" height="900" loading="lazy" decoding="async">
            </div>
            <div class="product-body">
              <div class="product-title">
                <span class="badge accent">{{ $related->fitment }}</span>
                <h3>{{ $related->title }}</h3>
                <p class="small">OEM: {{ $related->oem }}</p>
              </div>
              <p class="spec-list">{{ $related->specs }}<br>{{ $related->brand->name }} • {{ $related->vehicleModel->name }} • {{ $related->year }}</p>
              <div class="hero-meta">
                <span class="badge">{{ $related->color }}</span>
                <span class="badge">{{ $related->stock ?: $related->stock_status_label }}</span>
                <span class="badge">{{ $related->set_condition_label }}</span>
              </div>
              <p class="price">{{ $related->display_price }}</p>
              <div class="card-actions">
                <a class="btn" href="{{ route('products.show', $related) }}" data-goal="product_related_details">Подробнее</a>
              </div>
            </div>
          </article>
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
