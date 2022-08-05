<template>
    <Dialog
        v-model:visible="flagVisible"
        :style="{ width: '95%' }"
        header="Pilih Barang"
        :modal="true"
        class="p-fluid"
    >
    
        <div class="card">
            <DataTable
                showGridlines 
                class="p-datatable-sm"
                :value="pickBarang"
                selectionMode="single"
                dataKey="id"
                responsiveLayout="stack"
                scrollable
                scrollHeight="400px"
                :virtualScrollerOptions="{ itemSize: 46 }"
                :filters="filtersPickBarang"
                v-model:filters="filtersPickBarang"
                filterDisplay="menu"
                @rowSelect="onRowSelect"
            >
                <template #header>
                    <div
                        class="flex flex-row justify-content-between align-items-center"
                    >
                        <span class="w-18rem block p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText
                                v-model="filtersPickBarang.global.value"
                                placeholder="Search..."
                            />
                        </span>
                        <Button
                            label="Pilih"
                            icon="pi pi-check"
                            @click="onPilihBarang"
                            class="w-12rem p-button-success"
                        />
                    </div>
                </template>
                <template #empty>
                    Barang tidak ditemukan. Tunggu sebentar...
                    <i
                        class="pi pi-spin pi-spinner"
                        style="font-size: 2rem; margin-left: 2rem"
                    ></i>
                </template>

                <Column
                    v-if="isDesktop()"
                    field="barcode"
                    header="Barcode"
                ></Column>
                <Column
                    v-if="isDesktop()"
                    field="sub_id"
                    header="Sub ID"
                ></Column>
                <Column
                    v-if="isDesktop()"
                    field="category"
                    header="Kategori"
                ></Column>
                <Column
                    v-if="isDesktop()"
                    field="nama_barang"
                    header="Jenis Barang"
                ></Column>
                <Column v-if="keluar" header="Stok Akhir">
                    <template #body="slotProps">
                        <span
                            class="flex justify-content-center"
                            style="width: 100%"
                        >
                            {{
                                slotProps.data.stok +
                                slotProps.data.stok_masuk -
                                slotProps.data.stok_keluar
                            }}
                        </span>
                    </template>
                </Column>
                <Column  field="harga_satuan" header="Harga Satuan">
                    <template #body="slotProps">
                        <span class="p-column-title">Harga Satuan</span>
                        {{ formatCurrency(slotProps.data.harga_satuan) }}
                    </template>
                </Column>
                <Column  field="uraian" header="Uraian"></Column>
            </DataTable>
        </div>
    </Dialog>
</template>
<script setup>
import { ref, reactive, inject, onMounted } from "vue";
import emitter from "@/emit.js";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import MasukService from "@/service/MasukService.js";
import { isDesktop } from "@/func.js";

// const selected = inject('selectedpickbarang')
const emit = defineEmits(["selected"]);
const productService = new MasukService();
const flagVisible = ref(false);
const pickBarang = ref();
const loading = ref(false);
const keluar = ref("false");

// const selectedPickbarang = ref()
const filtersPickBarang = reactive({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const onPilihBarang = () => {
    // console.log(selectedPickbarang.value)
    flagVisible.value = false;
};

const onRowSelect = (e) => {
    // selected(e.data)
    emit("selected", e.data);
};

emitter.on("pick-barang-dialog", (e) => {
    flagVisible.value = e.visible;
    pickBarang.value = [];

    if (e.stokKeluar) {
        keluar.value = true;
        productService.getPickBarangStokAda().then((data) => {
            pickBarang.value = data;
        });
    } else {
        keluar.value = false;
        productService.getPickBarang().then((data) => {
            pickBarang.value = data;
        });
    }
});

const formatCurrency = (value) => {
    if (value) {
        var formatter = new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
        });

        return formatter.format(value); /* $2,500.00 */
    }

    return;
};

onMounted(() => {
    loading.value = true;
});
</script>
