<script setup>
import {computed, ref, reactive, onMounted} from 'vue';
const operationSummaryList = ref({
    operations: [],
    months: []
});
const props = defineProps(
    {
        authToken: String
    }
);

const isLoaded = ref(false);

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
        console.log(operationSummaryList.value.months);
        console.log(operationSummaryList.value.operations);
        console.log(operationSummaryList.value.table);
        isLoaded.value = true;
    }
    catch (error){
        console.log(error);
    }

}
</script>

<template>
    <h1 class="title is-3">Сводная страница</h1>
<!--    <pre>{{operationSummaryList}}</pre>-->



    <div v-if="isLoaded" class="table-container">
<!--        <table class="table is-bordered">-->
<!--            <tr>-->
<!--                <th>Категория</th>-->
<!--                <th v-for="mounth in operationSummaryList.months">-->
<!--                    {{ mounth }}-->
<!--                </th>-->
<!--                <th>Итого</th>-->
<!--            </tr>-->
<!--            <tr v-for="row in operationSummaryList.table">-->
<!--                <td>{{ row.category }}</td>-->
<!--                <td v-for="mounth in operationSummaryList.months">-->
<!--                    {{ row.amounts[mounth] }}-->
<!--                </td>-->
<!--            </tr>-->
<!--        </table>-->
    </div>
    <div v-else>Loaded...</div>

</template>

<style scoped>

</style>
