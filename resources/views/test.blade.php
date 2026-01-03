
<button id="button">Жмяк</button>

<script>
    button.onclick = async function(){
        let b = {
            email: 'pfirulin@yandex.ru',
            password: '12345'
        };
        let responce = await fetch(
            '/api/login/',
            {
                method: 'POST',
                body: JSON.stringify(b)
            }
        );
        let result = await responce.json();
        console.log(result);
    }
</script>
