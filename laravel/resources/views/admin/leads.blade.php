@extends('layouts.app')

@section('page', 'admin')
@section('robots', 'noindex,nofollow')
@section('title', 'Заявки MVP | ДискоДилер')
@section('description', 'Менеджерский список заявок Lean SEO MVP.')

@section('content')
<main class="container">
  <section class="section compact">
    <div class="section-head">
      <span class="section-kicker">Lead inbox</span>
      <h1>Заявки MVP</h1>
      <p class="lead">Заявки из VIN-форм, квиза и страниц услуг сохраняются в SQLite. Это рабочий промежуточный слой перед Filament.</p>
    </div>
    @if ($leads->isEmpty())
      <div class="empty-state is-visible"><h2>Заявок пока нет</h2><p class="small">Отправьте форму на сайте, и запись появится здесь.</p></div>
    @else
      <table class="pricing-table">
        <thead><tr><th>Дата</th><th>Тип</th><th>Контакт</th><th>Запрос</th><th>Страница</th></tr></thead>
        <tbody>
          @foreach ($leads as $lead)
            <tr>
              <td>{{ $lead->created_at->format('d.m.Y H:i') }}</td>
              <td>{{ $lead->type }}</td>
              <td>{{ $lead->phone ?: $lead->telegram ?: $lead->name ?: '—' }}</td>
              <td>{{ $lead->vin ?: $lead->message ?: '—' }}</td>
              <td>{{ $lead->source_page }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{ $leads->links() }}
    @endif
  </section>
</main>
@endsection
