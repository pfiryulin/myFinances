import { createApp } from 'vue';

import App from './components/App.vue';
import Header from './components/header/Header.vue';
import Footer from './components/footer/Footer.vue';

const app = createApp(App);
app.component('Header', Header);
app.component('Footer', Footer);
app.mount('#app');
