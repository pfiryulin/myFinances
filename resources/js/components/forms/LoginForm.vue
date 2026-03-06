<script setup>
    import {computed, ref, reactive} from 'vue';
    import Cookies from 'js-cookie';

    const emit = defineEmits(['update-token']);

    const login = ref('');
    const password = ref('');
    const error = ref(null);

    // const xsrfCoocks = Cookies.get('XSRF-TOKEN');
    async function signUp(){
        error.value = null;
        try{
            // if(Cookies.get('XSRF-TOKEN'))
            // {
                await fetch('/sanctum/csrf-cookie', {
                    method: 'GET',
                    headers: {
                        "Accept": "application/json"
                    },
                    credentials: "include"
                });
            // }

            let requestLogin;
            let body = new FormData();
            body.append('email', login.value);
            body.append('password', password.value);

            requestLogin = await fetch('/api/login',{
                method: 'POST',
                body: body,
                headers: {
                    "Accept": "application/json",
                    'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
                },
                credentials: "include"

            })

            if(!requestLogin.ok){
                throw new Error("Login failed")
            }
            let responce = await requestLogin.json();
            console.log(responce);
        }
        catch (e) {
            error.value = e.message
            console.log(error.value);
        }
    }

    async function getOperations()
    {
        let operations = await fetch('/api/operations',{
            method: 'GET',
            headers: {
                "Accept": "application/json"
            },
            credentials: "include"
        })

        console.log(await operations.json());
    }



</script>

<template>

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

    <button @click="getOperations">Operations</button>


</template>

