<form action="{{ route('registration') }}" method="POST">
    @csrf
    <input type="text" name="name" id="" placeholder="Имя" value="{{ old('name') }}"><br>
    <input type="email" name="email" id="" placeholder="email" value="{{ old('email') }}"><br>
    @error('email')
        <span>{{ $message }}</span><br>
    @enderror
    <input type="password" name="password" id="" placeholder="password"><br>
    @error('password')
        <span>{{ $message }}</span><br>
    @enderror
    <input type="password" name="password_confirmation" id="" placeholder="confirm password"><br>
    <button type="submit">Регистрация</button>
</form>

<span>
    Уже есть <a href="{{ route('login') }}"> аккаунт </a>
</span>
