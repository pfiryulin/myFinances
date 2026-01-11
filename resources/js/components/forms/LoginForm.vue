<script setup>
    import {computed, ref, reactive} from 'vue';
    import Cookies from 'js-cookie';

    const login = ref('');
    const password = ref('');
    const error = ref(null);
    const userToken = ref(null);


    async function handleSubmitLogin(){
        let userData = {
            email: login.value, password: password.value
        }
        const res = await fetch('https://myfinances.test/api/login/', {
            method: 'post', headers: {
                'Content-Type': 'aplication/json', 'Accept': 'aplication/json'
            }, body: JSON.stringify(userData)
        });
        userToken.value = await res.json();
        console.log(userToken.value.token)
        await Cookies.set('authToken', userToken.value.token, {expires: 2});
    }
</script>

<template>
    <form action="" @submit.prevent="handleSubmitLogin">
        <div class="form__items">
            <div class="form__item">
                <input type="text" name="login" id="" placeholder="Логин" required v-model="login">
            </div>
            <div class="form__item">
                <input type="password" name="password" id="" placeholder="Пароль" required v-model="password">
            </div>
            <div class="form__item">
                <input class="form__submit" type="submit" value="Войти">
            </div>
            <div class="form__item error" v-if="error">
                <span>{{ error }}</span>
            </div>
        </div>
        <div class="form__links">
            <a href="">Регистрация</a>
            <a href="">Забыли пароль?</a>
        </div>
    </form>
</template>

<style scoped>

</style>
