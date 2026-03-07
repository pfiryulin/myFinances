<script setup>
import {computed, ref, reactive} from 'vue';
import Cookies from 'js-cookie';

const emit = defineEmits(['update-token']);

const login = ref('');
const password = ref('');
const error = ref(null);

const userName = ref('');
const eserEmail = ref('');
const userPassword = ref('');

// const xsrfCoocks = Cookies.get('XSRF-TOKEN');
async function signUp()
{
    error.value = null;
    try
    {
        await fetch('/sanctum/csrf-cookie', {
            method: 'GET', headers: {
                "Accept": "application/json"
            }, credentials: "include"
        });

        let requestLogin;
        let body = new FormData();
        body.append('email', login.value);
        body.append('password', password.value);

        requestLogin = await fetch('/api/login', {
            method: 'POST',
            body: body,
            headers: {
                "Accept": "application/json",
                'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
            },
            credentials: "include"

        })

        if (!requestLogin.ok)
        {
            throw new Error("Login failed")
        }
        let responce = await requestLogin.json();
        console.log(responce);
    }
    catch (e)
    {
        error.value = e.message
        console.log(error.value);
    }
}

async function getOperations()
{
    let operations = await fetch('/api/operations', {
        method: 'GET', headers: {
            "Accept": "application/json"
        }, credentials: "include"
    })

    console.log(await operations.json());
}

async function logout()
{
    try
    {
        let logoutRequest = await fetch('/api/logout', {
            method: "POST", credentials: "include", headers: {
                "Accept": "application/json", 'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
            },
        });

        if (!logoutRequest.ok)
        {
            throw new new Error("Logout сломался");
        }
        console.log(logoutRequest.json());
    }
    catch (e)
    {
        console.log(e.message);
    }

}

async function getUser()
{
    let r = await fetch('api/user', {
        method: 'GET', credentials: 'include', headers: {
            "Accept": "application/json",
        }
    });

    console.log(r.json());
}

async function register()
{
    error.value = null;
    await fetch('/sanctum/csrf-cookie', {
        method: 'GET', headers: {
            "Accept": "application/json"
        }, credentials: "include"
    });

    try
    {
        let data = new FormData();
        data.append('name', userName.value);
        data.append('email', eserEmail.value);
        data.append('password', userPassword.value);

        let r = await fetch('api/user',{
            method: 'POST',
            headers:{
                "Accept": "application/json",
                'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
            },
            credentials: "include",
            body: data
        })
    }
    catch (e)
    {
        error.value = e.message;
        console.log(error.value)
    }
}

</script>

<template>
    <div>
        <form @submit.prevent="signUp">
            <div class="field">
                <input type="text" v-model.lazy="login">
            </div>
            <div class="field">
                <input type="password" name="" id="" v-model.lazy="password">
            </div>
            <div class="field">
                <button type="submit">login</button>
            </div>
        </form>
    </div>
    <div>
        <button @click="getOperations">Operations</button>
    </div>
    <div>
        <button @click="getUser">Get user</button>
    </div>

    <div>
        <form action="" class="form" @submit.prevent="register">
            <div class="fields">
                <input type="text" v-model="userName" placeholder="Имя">
            </div>
            <div class="fields">
                <input type="email" v-model="eserEmail" placeholder="email">
            </div>
            <div class="fields">
                <input type="password" v-model="userPassword" placeholder="Пароль">
            </div>
            <div class="fields">
                <input type="submit" value="Сохранить">
            </div>
        </form>
    </div>

    <div>
        <a @click.prevent="logout" href="#">LOGOUT</a>
    </div>


</template>

