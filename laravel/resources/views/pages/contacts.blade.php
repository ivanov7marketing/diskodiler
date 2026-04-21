@extends('layouts.app')

@section('page', 'contacts')
@section('title', 'Контакты ДискоДилер в Санкт-Петербурге')
@section('description', 'Контакты ДискоДилер: офис, склад и шиномонтаж в Санкт-Петербурге, телефон, WhatsApp, email и заявка на подбор оригинальных дисков.')
@section('canonical', url('/contacts'))

@section('content')
<main class="container">
  <nav class="breadcrumbs" aria-label="Хлебные крошки"><a href="{{ route('home') }}">Главная</a><span>→</span><span>Контакты</span></nav>
  <section class="section compact product-layout">
    <div><div class="section-head"><span class="section-kicker">Contacts</span><h1>Контакты ДискоДилер</h1><p class="lead">Свяжитесь с менеджером, чтобы проверить наличие, совместимость по VIN, доставку или записаться на шиномонтаж.</p></div></div>
    <aside class="summary-panel">
      <h2>Быстрая связь</h2>
      <div class="spec-list" style="margin-top:12px"><a href="tel:+79669264666">+7 (966) 926-46-66</a><a href="https://wa.me/79669264666">WhatsApp</a><a href="mailto:shop@diskodiler.ru">shop@diskodiler.ru</a></div>
      <form data-lead-form data-goal="contacts_question_submit" style="display:grid;gap:10px;margin-top:16px">
        <input class="input" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel">
        <textarea class="textarea" name="message" placeholder="Ваш вопрос"></textarea>
        <button class="btn" type="submit">Отправить вопрос</button>
      </form>
      <div class="notice" role="status"></div>
    </aside>
  </section>
</main>
@endsection
