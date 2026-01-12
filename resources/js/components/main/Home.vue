<script setup>
import {computed, ref, reactive, onMounted} from 'vue';
const operationSummaryList = ref(null);
const props = defineProps(
    {
        authToken: String
    }
);

onMounted(getOperation());

async function getOperation(){
    try{
        let request = await fetch('/api/home/',
            {
                method: 'post',
                headers: {
                    'Content-Type': 'aplication/json',
                    Accept: 'aplication/json',
                    Authorization: `Bearer ${props.authToken}`
                }
            }
        )
        operationSummaryList.value = await (request.json());
        console.log(operationSummaryList.value.mounth);
        console.log(operationSummaryList.value.operations);
    }
    catch (error){
        console.log(error);
    }

}
</script>

<template>
    <h1 class="title is-3">Сводная страница</h1>
<!--    <div class="table-container">-->
<!--        <table class="tabel">-->
<!--            <tr>-->
<!--                <th v-for="mounth in operationSummaryList.mounth">-->
<!--                    {{ mounth }}-->
<!--                </th>-->
<!--            </tr>-->
<!--        </table>-->
<!--    </div>-->

</template>

<style scoped>

</style>
