@extends('layouts.app')

@section('page', 'home')
@section('title', 'Оригинальные диски BMW, Mercedes, Porsche в Санкт-Петербурге | ДискоДилер')
@section('description', 'ДискоДилер продает оригинальные OEM диски BMW, Mercedes-Benz, Porsche, Range Rover и Lamborghini в Санкт-Петербурге с подбором по VIN, гарантией подлинности и доставкой по РФ.')
@section('canonical', url('/'))

@section('content')
<main>
      <section class="hero">
        <div class="container hero-content">
          <div class="hero-meta">
            <span class="pill">OEM factory wheels</span>
            <span class="pill">99 000–330 000 ₽</span>
            <span class="pill">Санкт-Петербург</span>
          </div>
          <h1>Оригинальные диски BMW, Mercedes, Porsche — гарантия подлинности</h1>
          <p class="lead">Подберем точный комплект по VIN, сверим OEM-артикулы, PCD, вылет и диаметр, покажем маркировку перед оплатой, надежно упакуем и отправим по России.</p>
          <form class="wheel-quiz is-first-step" data-wheel-quiz aria-label="Квиз подбора дисков">
            <div class="quiz-stage">
              <section class="quiz-step is-active" data-quiz-step>
                <h2><span>01.</span> Выберите марку и модель авто</h2>
                <div class="quiz-selects">
                  <label class="sr-only" for="quiz-brand">Марка автомобиля</label>
                  <select class="quiz-field" id="quiz-brand" name="brand" required data-quiz-brand>
                    <option value="">Выберите МАРКУ</option>
                  </select>
                  <label class="sr-only" for="quiz-model">Модель автомобиля</label>
                  <select class="quiz-field" id="quiz-model" name="model" required data-quiz-model disabled>
                    <option value="">Выберите МОДЕЛЬ</option>
                  </select>
                </div>
              </section>
              <section class="quiz-step" data-quiz-step hidden>
                <div class="quiz-title">
                  <h2><span>02.</span> Какой диаметр дисков?</h2>
                  <p class="small">Можно выбрать несколько вариантов</p>
                </div>
                <div class="quiz-options quiz-options-grid" role="group" aria-label="Диаметр дисков">
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R15"><span>R15</span></label>
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R16"><span>R16</span></label>
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R17"><span>R17</span></label>
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R18"><span>R18</span></label>
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R19"><span>R19</span></label>
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R20"><span>R20</span></label>
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R21"><span>R21</span></label>
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R22"><span>R22</span></label>
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R23"><span>R23</span></label>
                  <label class="quiz-option" data-quiz-option><input type="checkbox" name="diameter" value="R24"><span>R24</span></label>
                </div>
              </section>
              <section class="quiz-step" data-quiz-step hidden>
                <h2><span>03.</span> Нужны ли вам шины?</h2>
                <div class="quiz-options quiz-options-two" role="radiogroup" aria-label="Нужны ли шины">
                  <label class="quiz-option" data-quiz-option><input type="radio" name="tires" value="Да, подберите варианты" required><span>Да, подберите варианты</span></label>
                  <label class="quiz-option" data-quiz-option><input type="radio" name="tires" value="Нет" required><span>Нет</span></label>
                </div>
              </section>
              <section class="quiz-step" data-quiz-step hidden>
                <h2><span>04.</span> Ваш город</h2>
                <label class="sr-only" for="quiz-city">Город</label>
                <textarea class="quiz-field" id="quiz-city" name="city" rows="2" placeholder="Спб" required></textarea>
              </section>
              <section class="quiz-step" data-quiz-step hidden>
                <div class="quiz-title">
                  <h2><span>05.</span> Отлично! Все готово</h2>
                  <p class="small">Оставьте контакты, и менеджер подготовит подборку.</p>
                </div>
                <div class="quiz-contact">
                  <div class="quiz-contact-method" role="radiogroup" aria-label="Способ связи">
                    <label class="quiz-option" data-quiz-option><input type="radio" name="contactMethod" value="Telegram" checked><span>Telegram</span></label>
                    <label class="quiz-option" data-quiz-option><input type="radio" name="contactMethod" value="Max"><span>Max</span></label>
                    <label class="quiz-option" data-quiz-option><input type="radio" name="contactMethod" value="Звонок"><span>Звонок</span></label>
                  </div>
                  <div class="quiz-contact-fields">
                    <label class="sr-only" for="quiz-name">Ваше имя</label>
                    <input class="quiz-field" id="quiz-name" name="name" autocomplete="name" placeholder="Ваше имя" required>
                    <label class="sr-only" for="quiz-phone">Телефон</label>
                    <input class="quiz-field" id="quiz-phone" name="phone" autocomplete="tel" inputmode="tel" placeholder="+7 (___) ___-__-__" required data-quiz-phone>
                  </div>
                  <label class="quiz-consent">
                    <input type="checkbox" name="consent" required>
                    <span>Я даю согласие на обработку персональных данных и принимаю условия публичной оферты</span>
                  </label>
                </div>
              </section>
            </div>
            <div class="quiz-footer">
              <div class="quiz-progress" aria-hidden="true">
                <div class="quiz-progress-bar"><span data-quiz-progress></span><b></b></div>
                <strong data-quiz-percent>6%</strong>
              </div>
              <div class="quiz-actions">
                <button class="btn secondary" type="button" data-quiz-prev hidden>Назад</button>
                <button class="btn" type="button" data-quiz-next disabled>Далее</button>
                <button class="btn" type="submit" data-quiz-submit hidden>Подобрать диски</button>
              </div>
            </div>
            <div class="notice" role="status"></div>
          </form>
        </div>
      </section>

      <section class="cta-band" aria-label="Гарантии">
        <div class="container trust-bar">
          <div class="trust-item">OEM-сертификат</div>
          <div class="trust-item">Партнёр BMW</div>
          <div class="trust-item">Доставка по РФ</div>
          <div class="trust-item">Trade-in</div>
          <div class="trust-item">Шиномонтаж</div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="section-head">
            <span class="section-kicker">Выбор марки</span>
            <h2>Каталог оригинальных дисков</h2>
            <p class="lead">Модельные линейки собраны по кодам кузова и заводским параметрам, чтобы не ошибиться с посадкой и вылетом.</p>
          </div>
          <div class="grid brand-grid">
            @foreach($brandCards as $card)
              <a class="brand-tile" href="{{ route('catalog.brand', $card['brand']) }}" style="background-image:url('{{ $card['image'] }}')">
                <h3>{{ $card['brand']->name }}</h3><span class="small">{{ $card['models'] }}</span>
              </a>
            @endforeach
          </div>
        </div>
      </section>

      <section class="section cta-band">
        <div class="container">
          <div class="section-head">
            <span class="section-kicker">Как подобрать</span>
            <h2>Три шага до правильного комплекта</h2>
          </div>
          <div class="grid steps">
            <article class="feature step">
              <h3>VIN или точная модель</h3>
              <p class="small">Отправьте VIN, код кузова или ссылку на интересующий стиль. Проверим комплектацию и допустимые диаметры.</p>
            </article>
            <article class="feature step">
              <h3>Подбор и проверка OEM</h3>
              <p class="small">Сверим парт-номер, PCD, DIA, вылет, ширину, цвет и маркировку производителя.</p>
            </article>
            <article class="feature step">
              <h3>Доставка или установка</h3>
              <p class="small">Упакуем с фотофиксацией, отправим ТК или установим на шиномонтаже на Салова 31с3.</p>
            </article>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="section-head">
            <span class="section-kicker">Популярные модели</span>
            <h2>Чаще всего подбираем</h2>
          </div>
          <div class="grid models-grid">
            @foreach($popularModelCards as $card)
              <a class="model-tile" href="{{ route('catalog.model', [$card['model']->brand, $card['model']->slug]) }}">
                <span class="model-code">{{ $card['code'] }}</span>
                <h3>{{ $card['title'] }}</h3>
                <p class="small">{{ $card['text'] }}</p>
              </a>
            @endforeach
            <button class="model-tile" type="button" data-open-modal="vin-modal" data-goal="popular_model_vin"><span class="model-code">VIN</span><h3>Не уверены?</h3><p class="small">Проверим совместимость</p></button>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="section-head">
            <span class="section-kicker">Услуги</span>
            <h2>Шиномонтаж и реставрация</h2>
            <p class="lead">Аккуратно работаем с большими диаметрами, RunFlat и оригинальными OEM-дисками: установим комплект, проверим посадку и подскажем, когда восстановление имеет смысл.</p>
          </div>
          <div class="grid services-grid service-primary-grid">
            <a class="service-card service-link-card" href="{{ route('services.premium-tire-fitting') }}" data-goal="home_service_fitting">
              <span class="section-kicker">Сервис</span>
              <h2>Премиальный шиномонтаж</h2>
              <p class="small">Оборудование для низкопрофильных шин, больших диаметров и аккуратной работы с премиальными дисками.</p>
              <span class="link-more">Перейти к услуге</span>
            </a>
            <a class="service-card service-link-card" href="{{ route('services.wheel-restoration') }}" data-goal="home_service_restoration">
              <span class="section-kicker">Ремонт</span>
              <h2>Восстановление, ремонт, реставрация</h2>
              <p class="small">Восстановление геометрии и внешнего вида, окрашивание и ремонт повреждений любой сложности.</p>
              <span class="link-more">Перейти к услуге</span>
            </a>
          </div>
          <div class="grid service-info-grid service-benefits-row">
            <article class="info-card">
              <h3>RunFlat</h3>
              <p class="small">Работаем с жестким бортом RunFlat, балансировкой и проверкой состояния шин перед установкой.</p>
            </article>
            <article class="info-card">
              <h3>Trade-in</h3>
              <p class="small">Принимаем оригинальные диски и колеса в сборе в зачет нового комплекта, финальная оценка после осмотра.</p>
            </article>
            <article class="info-card">
              <h3>Индивидуальная сборка</h3>
              <p class="small">Подберем шины и диски под задачу, соберем комплект и проверим посадку перед установкой.</p>
            </article>
          </div>
        </div>
      </section>

      <section class="section cta-band">
        <div class="container">
          <div class="section-head">
            <span class="section-kicker">Отзывы</span>
            <h2>Покупатели проверяют главное</h2>
          </div>
          <div class="grid reviews-grid">
            <article class="review">
              <div class="stars">★★★★★</div>
              <h3>BMW X5 G05, Алексей</h3>
              <p>Попросил фото маркировки и проверку по VIN. Показали парт-номера, объяснили разницу с репликой, доставили комплект в коробках.</p>
            </article>
            <article class="review">
              <div class="stars">★★★★★</div>
              <h3>Porsche Cayenne, Игорь</h3>
              <p>Сравнивал с дилером. Получил тот же OEM-артикул, понятную гарантию и цену ниже дилерской без ощущения серого рынка.</p>
            </article>
            <article class="review">
              <div class="stars">★★★★★</div>
              <h3>Range Rover Sport, Максим</h3>
              <p>Хотел визуальный апгрейд без ошибки по вылету. Подобрали R23, показали как будет смотреться, приняли старый комплект в trade-in.</p>
            </article>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container cta-inner">
          <div>
            <span class="section-kicker">Безопасная покупка</span>
            <h2>Проверьте комплект до оплаты</h2>
            <p class="lead">Попросите фото маркировки, видео осмотра, проверку по VIN и расчет экономии относительно дилера.</p>
          </div>
          <button class="btn" type="button" data-open-modal="vin-modal" data-goal="home_bottom_vin">Подобрать диски</button>
        </div>
      </section>
    </main>
@endsection
