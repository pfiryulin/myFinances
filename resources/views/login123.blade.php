<form action="{{ route('signin') }}" method="post">
    @csrf
    <div>
        <label for="">Login:</label>
        <input type="text" name="email" id=""> <br>
        @error('email')
            {{$message}}
        @enderror
        <br>
        <label for="">Password</label>
        <input type="password" name="password" id=""><br>
        @error('password')
            {{ $message }}
        @enderror
        <button type="submit">Enter</button>
    </div>
</form>
<a href="{{ route('registration') }}">Регистарция</a>

