@extends('app')
@section('content')
    <div>
        Свободные средства: {{ $freeMoney }} ₽
    </div>
    <table>
        <tr>
            <th>№</th>
            <th>Сумма</th>
            <th>Категория</th>
            <th>Тип</th>
            <th>Дата внесения</th>
            <th>Комментарий</th>
        </tr>
        @foreach($opertaions as $operation)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $operation->amount }}</td>
                <td>{{ $operation->category->name }}</td>
                <td>{{ $operation->type->name }}</td>
                <td>{{ $operation->created_at->format('d.m.Y') }}</td>
                <td>{{ $operation->comment }}</td>
            </tr>
        @endforeach
    </table>

    <form action="{{ route('operation') }}" method="post">
        @csrf
        <input type="number" name="summ" step="any">
        <br>
        <label for="">Категория</label>
        <select name="type" id="">
            @foreach($types as $type)
                <option value="{{ $type->id }}"> {{ $type->name }} </option>
            @endforeach
        </select>
        <select name="category">
            @foreach($categories as $category)
                <option value="{{ $category->id }}"> {{ $category->name }} </option>
            @endforeach
        </select>
        <br>
        <label for="">Комментарий</label>
        <input type="text" name="comment" id="">
        <input type="submit" value="Сохранить">
    </form>
@endsection
