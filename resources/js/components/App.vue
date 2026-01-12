<script setup>
import {computed, ref, reactive} from 'vue';
import Cookies from 'js-cookie';
import LoginForm from "./forms/LoginForm.vue";

const userToken = ref(null);
const types = ref(null);
const categories = ref(null);
const operations = ref(null);
const authToken = ref(Cookies.get('authToken'));

console.log(authToken);


async function getToken()
{
    let userData = {
        email: 'pfirulin@yandex.ru', password: 123456
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

async function getOperation()
{
    if (authToken)
    {
        const operationRes = await fetch('https://myfinances.test/api/operations/',
            {
                method: 'post',
                headers: {
                    'Content-Type': 'aplication/json',
                    Accept: 'aplication/json',
                    Authorization: `Bearer ${authToken}`
                }
            });

        operations.value = await operationRes.json();
        console.log(operations);
        types.value = operations.value.types
        categories.value = operations.value.categories
    }
    else
    {
        console.log('Auth token not exist');
    }
}

function updateToken(){
    authToken.value = Cookies.get('authToken');
}
</script>

<template>
    <Header />
    <div class="container">
        <div v-if="!authToken" class="login form">
            <LoginForm
                @update-token="updateToken"
            />
        </div>
        <div v-else>{{ authToken }}</div>
<!--        <div>-->
<!--            <button @click="getToken">Get Token</button>-->
<!--        </div>-->
<!--        <div>-->
<!--            <button @click="getOperation">Get Operation</button>-->
<!--        </div>-->
    </div>
<!--    {{ a }}-->
<!--    <br>-->
<!--    <pre>{{ types }}</pre>-->
<!--    <br>-->
<!--    <hr>-->
<!--    <i class="fa-solid fa-user"></i>-->

<!--    <pre>{{ categories }}</pre>-->
    <Footer />
</template>

<style scoped>

</style>
