<form action="{{ route('registration') }}" method="POST">
    @csrf
    <input type="text" name="name" id="" placeholder="Имя"><br>
    <input type="email" name="email" id="" placeholder="email"><br>
    <input type="password" name="password" id="" placeholder="password"><br>
    <input type="password" name="password-confirmation" id="" placeholder="confirm password"><br>
    <button type="submit">Регистрация</button>
</form>

<span>
    Уже есть <a href="{{ route('home') }}"> аккаунт </a>
</span>
