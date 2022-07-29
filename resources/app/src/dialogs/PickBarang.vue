<template>
    <Dialog
        v-model:visible="flagVisible"
        :style="{ width: '1024px' }"
        header="Pilih Barang"
        :modal="true"
        class="p-fluid"
    >
        <div class="card">
            <DataTable
                :value="pickBarang"
                selectionMode="single"
                dataKey="id"
                responsiveLayout="scroll"
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
                </template>

                <Column field="barcode" header="Barcode"></Column>
                <Column field="sub_id" header="Sub ID"></Column>
                <Column field="category" header="Kategori"></Column>
                <Column field="nama_barang" header="Jenis Barang"></Column>
                <Column field="harga_satuan" header="Harga Satuan"></Column>
                <Column field="uraian" header="Uraian"></Column>
            </DataTable>
        </div>
    </Dialog>
</template>
<script setup>
import { ref, reactive, inject, onMounted } from "vue";
import emitter from "@/emit.js";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import MasukService from "@/service/MasukService.js";

// const selected = inject('selectedpickbarang')
const emit = defineEmits(["selected"]);
const productService = new MasukService();
const flagVisible = ref(false);
const pickBarang = ref();
const loading = ref(false);

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

    productService.getPickBarang().then((data) => {
        pickBarang.value = data;
    });
});

onMounted(() => {
    loading.value = true;
});
</script>
