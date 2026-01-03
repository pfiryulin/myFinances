
<button id="button">Жмяк</button>
<button id="button2">Жмяк ещё раз</button>

<script>
    let token = '';
    button.onclick = async function(){
        let b = {
            email: 'pfirulin@yandex.ru',
            password: '123456'
        };
        let responce = await fetch(
            '/api/login/',
            {
                method: 'POST',
                body: JSON.stringify(b),
                headers: {  // добавляем обязательные заголовки!
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            }
        );
        let result = await responce.json();
        // console.log(JSON.parse(result));
        token = result.token;
    }

    button2.onclick = async function(){
        let responce = await fetch('/api/operations/',
            {
                method: 'POST',
                headers: {  // добавляем обязательные заголовки!
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
            }
        );
        let result = await responce.json();
        console.log(result);
    }
</script>
