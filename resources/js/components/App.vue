<script setup>
import {computed, ref, reactive} from 'vue';
import Cookies from 'js-cookie';
import LoginForm from "./forms/LoginForm.vue";
import Operation from "./main/Operation.vue";
import Home from "./main/Home.vue";

const authToken = ref(Cookies.get('authToken'));
const currentTab = ref('Operation');
const tabs = ref({ Operation, Home });

function updateToken()
{
    authToken.value = Cookies.get('authToken');
}
</script>

<template>
    <Header/>
    APP PAGE
    <div class="container">
        APP PAGE2
        <div v-if="!authToken" class="login form">
            <LoginForm
                @update-token="updateToken"
            />
        </div>
        <div v-else class="content">
            <component :is="tabs[currentTab]" :authToken="authToken"></component>
            <span>APP PAGE 3</span>
        </div>
    </div>
    <Footer/>
</template>

<style scoped>

</style>
