<script setup>
import {onMounted, ref} from 'vue';
const operationsList = ref(null);

const props = defineProps(
    {
        authToken: String
    }
);
onMounted(getOperation());

async function getOperation(){
    try{
        let request = await fetch('/api/operations/',
            {
                method: 'post',
                headers: {
                    'Content-Type': 'aplication/json',
                    Accept: 'aplication/json',
                    Authorization: `Bearer ${props.authToken}`
                }
            }
        )
        operationsList.value = await (request.json());
        console.log(operationsList.value);
    }
    catch (error){
        console.log(error);
    }

}
// console.log(operation.value);

</script>

<template>
    <div class="operation__table">
        <table v-if="operationsList">
            <tr>
                <th>##</th>
                <th>Дата</th>
                <th>Тип</th>
                <th>Категория</th>
                <th>Сумма</th>
                <th>Комментарий</th>
            </tr>
            <tr v-for="(operation, index) in operationsList">
                <td>{{ index + 1 }}</td>
                <td>{{ operation.created_at }}</td>
                <td>{{ operation.type.name }}</td>
                <td>{{ operation.category.name }}</td>
                <td>{{ operation.amount }}</td>
                <td>{{ operation.comment }}</td>
            </tr>
        </table>
    </div>
</template>

<style scoped>

</style>
