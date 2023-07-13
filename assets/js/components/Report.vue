<template>
    <div>
        <div>
            <label>Выберите месяц</label>
            <VueDatePicker
                v-model="selectedDate"
                locale="ru-RU"
                select-text="Выбрать"
                cancel-text="Отмена"
                :max-date="new Date"
                month-picker
                @update:model-value="loadList()"
            />
        </div>

        <v-select
            v-model="selectedClientType"
            label="Тип клиента"
            :items="clientTypeList"
            item-title="title"
            item-value="value"
            @update:modelValue="loadList()"
        />

        <v-table>
            <thead>
                <tr>
                    <th />
                    <th class="text-left">
                        Услуга
                    </th>
                    <th class="text-left">
                        Баланс на начало периода
                    </th>
                    <th class="text-left">
                        Приход
                    </th>
                    <th class="text-left">
                        Расход
                    </th>
                    <th class="text-left">
                        Перерасчет
                    </th>
                    <th class="text-left">
                        Итого
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="item in reportList"
                    :key="item.id"
                >
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.balance }}</td>
                    <td>{{ item.income }}</td>
                    <td>{{ item.outcome }}</td>
                    <td>{{ item.recalculation }}</td>
                    <td>{{ item.total }}</td>
                </tr>
            </tbody>
        </v-table>
    </div>
</template>
<script>
export default {
    name: 'Report',
    data () {
        return {
            selectedDate: null,
            selectedClientType: null,
            clientTypeList: [
                { title: 'Все типы', value: null },
                { title: 'Физ.лицо', value: 0 },
                { title: 'Юр.лицо', value: 1 }
            ],
            reportList: []
        };
    },
    mounted () {
        this.loadList();
    },
    methods: {
        loadList () {
            axios
                .get(`/report`, {
                    params: {
                        date: this.selectedDate,
                        client_type: this.selectedClientType
                    }
                })
                .then(response => {
                    this.reportList = response.data;
                })
                .catch(error => {
                    alert(error);
                });
        }
    }
}
</script>
<style scoped>
</style>
