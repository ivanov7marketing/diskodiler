@extends('layouts.app')

@section('page', 'services')
@section('title', 'Шиномонтаж, ремонт дисков, trade-in и RunFlat | ДискоДилер')
@section('description', 'Премиальные услуги ДискоДилер в Санкт-Петербурге: шиномонтаж RunFlat, ремонт и окраска дисков, trade-in, выкуп колес, индивидуальная сборка и подбор OEM-комплектов.')
@section('canonical', url('/services'))

@section('content')
<main>
  <section class="section">
    <div class="container">
      <div class="section-head">
        <span class="section-kicker">Сервис</span>
        <h1>Шиномонтаж, ремонт дисков, trade-in, RunFlat</h1>
        <p class="lead">Премиальный сервис для колес больших диаметров: осмотр перед покупкой, аккуратная установка, восстановление геометрии и зачёт старого OEM-комплекта.</p>
      </div>

      <div class="grid services-grid service-primary-grid">
        <a class="service-card service-link-card" href="{{ route('services.premium-tire-fitting') }}" data-goal="services_index_fitting">
          <span class="section-kicker">Сервис</span>
          <h2>Премиальный шиномонтаж</h2>
          <p class="small">Оборудование для низкопрофильных шин, больших диаметров и аккуратной работы с премиальными дисками.</p>
          <span class="link-more">Перейти к услуге</span>
        </a>
        <a class="service-card service-link-card" href="{{ route('services.wheel-restoration') }}" data-goal="services_index_restoration">
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
        <span class="section-kicker">Цены</span>
        <h2>Ориентиры по услугам</h2>
        <p class="lead">Точная цена зависит от диаметра, профиля, состояния диска и объема работ.</p>
      </div>
      <table class="pricing-table">
        <thead><tr><th>Услуга</th><th>Цена</th><th>Что входит</th></tr></thead>
        <tbody>
          <tr><td>Шиномонтаж R18-R20</td><td>от 4 800 ₽</td><td>Демонтаж, монтаж, балансировка</td></tr>
          <tr><td>Шиномонтаж R21-R23</td><td>от 6 900 ₽</td><td>Работа с большими диаметрами</td></tr>
          <tr><td>RunFlat</td><td>от 7 900 ₽</td><td>Монтаж с учетом жесткого борта</td></tr>
          <tr><td>Ремонт геометрии</td><td>от 3 500 ₽</td><td>Осмотр, правка, контроль биения</td></tr>
          <tr><td>Окраска диска</td><td>от 8 000 ₽</td><td>Подбор цвета, подготовка, покраска</td></tr>
          <tr><td>Trade-in</td><td>Индивидуально</td><td>Оценка оригинального комплекта после осмотра</td></tr>
        </tbody>
      </table>
      <button class="btn" type="button" data-open-modal="service-modal" data-goal="service_price_book">Записаться в сервис</button>
    </div>
  </section>

</main>
@endsection
