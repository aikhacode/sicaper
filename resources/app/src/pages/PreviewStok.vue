<template>
    <div class="card">
        <Toolbar class="mb-4">
            <template v-slot:end>
                <!--   <Button
                                label="Preview"
                                icon="pi pi-chevron-up"
                                class="p-button-success mr-2"
                                @click="previewstok"
                            /> -->
                <Button
                    label="Back"
                    icon="pi pi-chevron-left"
                    class="p-button-success mr-2"
                    @click="$router.go(-1)"
                />
            </template>
        </Toolbar>

        <div v-if="data" class="p-fluid grid formgrid">
            <div v-for="item in header" class="field col-12 md:col-6">
                <label>{{ parseTitle(item) }} </label>
                <InputText class="input" id="" disabled v-model="data[item]" />
            </div>
        </div>
        <div v-if="products" class="p-fluid grid formgrid">
            <div class="field col-12">
                <DataTable
                    showGridlines
                    :value="products"
                    dataKey="id"
                    responsiveLayout="scroll"
                >
                    <ColumnGroup type="header">
                        <Row>
                            <Column header="Sub ID" :rowspan="2" />
                            <Column header="Harga Satuan" :rowspan="2" />
                            <Column :colspan="4"
                                ><template #header
                                    ><div class="text-center w-full">
                                        Stok
                                    </div></template
                                >
                            </Column>
                            <Column header="Rupiah" :rowspan="2" />
                        </Row>
                        <Row>
                            <Column field="stok">
                                <template #header
                                    ><div class="text-center w-full">
                                        Awal
                                    </div></template
                                >
                            </Column>
                            <Column field="stok_masuk"
                                ><template #header
                                    ><div class="text-center w-full">
                                        Masuk
                                    </div></template
                                >
                            </Column>
                            <Column field="stok_keluar"
                                ><template #header
                                    ><div class="text-center w-full">
                                        Keluar
                                    </div></template
                                >
                            </Column>
                            <Column
                                ><template #header
                                    ><div class="text-center w-full">
                                        Sisa
                                    </div></template
                                >
                            </Column>
                        </Row>
                    </ColumnGroup>

                    <Column field="sub_id" header="Sub ID"></Column>
                    <Column field="harga_satuan" header="Harga Satuan">
                        <template #body="slotProps">
                            {{ formatCurrency(slotProps.data.harga_satuan*1) }}
                        </template>
                    </Column>
                    <Column field="stok" header="Stok Awal"
                        ><template #footer>{{ sum.awal }}</template></Column
                    >
                    <Column field="stok_masuk" header="Stok Masuk"
                        ><template #footer>{{ sum.masuk }}</template></Column
                    >
                    <Column field="stok_keluar" header="Stok Keluar"
                        ><template #footer>{{ sum.keluar }}</template></Column
                    >
                    <Column header="Sisa">
                        <template #body="slotProps">
                            {{
                                slotProps.data.stok*1 +
                                slotProps.data.stok_masuk*1 -
                                slotProps.data.stok_keluar*1
                            }}
                        </template>
                        <template #footer>{{ sum.sisa }}</template>
                    </Column>
                    <Column header="Rupiah">
                        <template #body="slotProps">
                            <div class="text-right w-full">
                                {{
                                    formatCurrency((slotProps.data.stok*1 +
                                        slotProps.data.stok_masuk*1 -
                                        slotProps.data.stok_keluar*1) *
                                    slotProps.data.harga_satuan)
                                }}
                            </div>
                        </template>
                        <template #footer
                            ><div class="text-right w-full">
                                {{ formatCurrency(sum.rupiah) }}
                            </div></template
                        >
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
import { useStore } from "@/store.js";
import { parseApi } from "@/func.js";
import axios from "axios";
import Row from "primevue/row";
import ColumnGroup from "primevue/columngroup";

const props = defineProps({
    id: [String, Number],
});

const data = ref();
const products = ref();
const sum = reactive({});
const header = ref([
    "barcode",
    "id_category",
    "id_barang",
    "category",
    "nama_barang",
    "uraian",
]);

const parseTitle = (text) => {
    let ret = text.replace("_", " ");
    return ret.toUpperCase();
};

const getBarangs = async (barcode) => {
    return axios({
        url: parseApi(`/barang/stok/barcode/${barcode}`),
        method: "GET",

        headers: {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        },
    }).then((res) => res.data);
};

onMounted(async () => {
    data.value = useStore().previewstok;
    products.value = await getBarangs(data.value.barcode);
    sum.awal = 0;
    sum.masuk = 0;
    sum.keluar = 0;
    sum.sisa = 0;
    sum.rupiah = 0;

    products.value.map((item) => {
        console.log('item',item)
        //convert string to number

        sum.awal += item.stok *1;
        sum.masuk += item.stok_masuk * 1 ;
        sum.keluar += item.stok_keluar * 1 ;
        sum.rupiah +=
            (item.stok*1 + item.stok_masuk*1 - item.stok_keluar*1) *
            item.harga_satuan;

        return item;
    });

    sum.sisa = sum.awal*1 + sum.masuk*1 - sum.keluar*1;

    console.log("hasil", products.value);

    data.value.stok_awal = data.value.stok;
    data.value.sisa_stok = 0;
    data.value.rupiah = data.value.harga_satuan * data.value.sisa_stok;
    console.log(data.value);
});

const formatCurrency = (value) => {
    console.log("fc", value);
    return value.toLocaleString("id-ID", {
        style: "currency",
        currency: "IDR",
    });
};
</script>
<style>
.input {
    color: black;
    font-weight: 700;
}
</style>
