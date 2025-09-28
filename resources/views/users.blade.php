@foreach($users as $user)
    {{ $user->name }}<br>
    {{ $user->email }}<br>
    {{ $user->created_at }}<br>
    <hr>
@endforeach
