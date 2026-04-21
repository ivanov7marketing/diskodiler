@extends('layouts.app')

@section('page', 'about')
@section('title', 'О компании и гарантии OEM | ДискоДилер Санкт-Петербург')
@section('description', 'ДискоДилер: оригинальные колеса и диски премиальных брендов, сотрудничество с официальными дилерами BMW, адреса, контакты, гарантия подлинности.')
@section('canonical', url('/about.html'))

@section('content')
<main>
      <section class="section">
        <div class="container">
          <div class="section-head">
            <span class="section-kicker">Trust center</span>
            <h1>Оригинальные диски с проверяемым происхождением</h1>
            <p class="lead">ДискоДилер продает оригинальные колеса, премиальные диски и шины, сотрудничает с официальными дилерами BMW и центральным складом BMW в Москве.</p>
          </div>
          <div class="grid info-grid">
            <article class="info-card"><h3>Партнерство BMW</h3><p class="small">Сертификат и партнерский статус выносятся в отдельный блок доверия. Перед покупкой показываем документы и маркировку.</p></article>
            <article class="info-card"><h3>Оригинальность</h3><p class="small">Проверяем OEM-артикулы, заводские параметры, маркировку производителя, страну изготовления и качество покрытия.</p></article>
            <article class="info-card"><h3>Чистая сделка</h3><p class="small">Согласуем состояние, комплектность, упаковку, способ доставки и гарантийные условия до оплаты.</p></article>
          </div>
        </div>
      </section>

      <section class="section cta-band">
        <div class="container product-layout">
          <div>
            <span class="section-kicker">Как отличить OEM</span>
            <h2>Что проверяем перед продажей</h2>
            <div class="grid" style="margin-top:20px">
              <article class="feature"><h3>Заводская маркировка</h3><p class="small">Парт-номер, параметры диска, производитель, страна изготовления, цвет и клейма.</p></article>
              <article class="feature"><h3>Геометрия и посадка</h3><p class="small">PCD, DIA, вылет, ширина, диаметр и соответствие конкретному кузову.</p></article>
              <article class="feature"><h3>Покрытие и состояние</h3><p class="small">Осмотр лака, кромки, обратной стороны, следов ремонта и дефектов.</p></article>
            </div>
          </div>
          <aside class="summary-panel">
            <h2>Контакты</h2>
            <div class="spec-list" style="margin-top:12px">
              <span>Офис: ул. Салова 27АД, офис 316</span>
              <span>Склад + шиномонтаж: ул. Салова 31с3</span>
              <a href="tel:+79669264666">+7 (966) 926-46-66</a>
              <a href="https://wa.me/79669264666" data-goal="about_whatsapp">WhatsApp</a>
              <a href="mailto:shop@diskodiler.ru">shop@diskodiler.ru</a>
              <span>Пн-Пт 10:00–20:00</span>
              <span>Сб-Вс 12:00–17:00</span>
            </div>
            <a class="btn" style="margin-top:16px" href="https://yandex.ru/maps/?text=Санкт-Петербург%20Салова%2031с3" data-goal="about_map">Открыть на Яндекс Картах</a>
            <form data-lead-form data-goal="about_question_submit" style="display:grid;gap:10px;margin-top:16px">
              <input class="input" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel">
              <textarea class="textarea" name="message" placeholder="Ваш вопрос"></textarea>
              <button class="btn secondary" type="submit">Отправить вопрос</button>
            </form>
            <div class="notice" role="status"></div>
          </aside>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="section-head"><span class="section-kicker">FAQ</span><h2>Ответы на главные опасения</h2></div>
          <div class="faq">
            <details open><summary>Вы продаете реплики?</summary><p>Нет. Сайт позиционируется вокруг оригинальных OEM-дисков. Для каждого комплекта показываем артикулы, маркировку и параметры.</p></details>
            <details><summary>Как понять, что диск подойдет моему автомобилю?</summary><p>Мы проверяем совместимость по VIN: диаметр, ширину, вылет, PCD, DIA и допустимые размеры для конкретной комплектации.</p></details>
            <details><summary>Есть гарантия?</summary><p>На оригинальные товары указывается гарантия, для BMW-комплектов в интерфейсе используется блок «Оригинал BMW Group. Гарантия 2 года».</p></details>
            <details><summary>Можно ли сравнить цену с дилером?</summary><p>Да. Менеджер объяснит разницу с дилерской ценой и покажет, почему слишком низкая цена на рынке часто означает реплику или проблемный комплект.</p></details>
            <details><summary>Можно сдать старые колеса?</summary><p>Да, оригинальные диски и колеса в сборе можно предложить в trade-in или на выкуп. Оценка финализируется после осмотра.</p></details>
          </div>
        </div>
      </section>
    </main>
@endsection
