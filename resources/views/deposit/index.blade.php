@extends('app')
@section('content')
    <div class="deposits">
        <table>
            <tr>
                <th>№</th>
                <th>Название</th>
                <th>Сумма</th>
                <th>Комментарий</th>
                <th>Редактировать</th>
            </tr>
            @forelse($deposits as $deposit)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $deposit->name }}</td>
                    <td>{{ $deposit->amount }}</td>
                    <td>{{ $deposit->comment ?? $deposit->comment }}</td>
                    <td>{{ $deposit->id }}</td>
                </tr>
            @empty
                Нет депозитов
            @endforelse
        </table>
    </div>
    <br>
    <h3>Создать депозит</h3>
    <form action="{{ route('deposit-create') }}" method="post">
        @csrf
        <label for="name">Название</label>
        <input type="text" name="name">
        <br>
        <label for="amount">Сумма</label>
        <input type="number" name="amount" id="" step="any">
        <br>
        <label for="">Комментарий</label>
        <input type="text" name="comment" id="">
        <br>
        <input type="submit" value="Сохранить">
    </form>

    <hr>

    <h3>Редактировать депозит</h3>
    <form action="{{ route('deposit-update') }}" method="post">
        @csrf
        <label for="amount">Сумма</label>
        <input type="number" name="amount" step="any">
        <br>
        @if($deposits->isEmpty())
            Нет депозитов. Создайте новый
        @else
            <label for="">Депозит</label>
            <select name="deposites-id" id="">
                @forelse($deposits as $deposit)
                    <option value="{{ $deposit->id }}"> {{ $deposit->name }} </option>
                @empty
                    Создайте депозит
                @endforelse
            </select>
        @endif
        <br>
        <label for="">Комментарий</label>
        <input type="text" name="comment" id="">
        <input type="submit" value="Сохранить">
    </form>
@endsection

