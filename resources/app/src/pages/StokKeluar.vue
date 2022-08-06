<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <Toast />
                <Toolbar class="mb-4">
                    <template v-slot:start>
                        <div class="my-2">
                            <Button
                                label="New"
                                icon="pi pi-plus"
                                class="p-button-success mr-2"
                                @click="openNew"
                                
                            />
                            <!-- <Button
                                label="Delete"
                                icon="pi pi-trash"
                                class="p-button-danger"
                                @click="confirmDeleteSelected"
                                :disabled="
                                    !selectedProducts ||
                                    !selectedProducts.length
                                "
                            /> -->
                        </div>
                    </template>

                    <template v-slot:end>
                        <Button
                            label="Print"
                            icon="pi pi-print"
                            class="p-button-success mr-2"
                            @click="print_stok_keluar()"
                        />
                    </template>
                </Toolbar>

                <DataTable
                    ref="dt"
                    :value="products"
                    v-model:selection="selectedProducts"
                    dataKey="id"
                    :paginator="true"
                    :rows="10"
                    :filters="filters"
                    v-model:filters="filters"
                    responsiveLayout="scroll"
                    filterDisplay="menu"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products"
                    @value-change="onFiltered"
                >
                    <template #header>
                        <div
                            class="flex flex-column md:flex-row md:justify-content-between md:align-items-center"
                        >
                            <h5 class="m-0">Manage Stok Keluar</h5>
                            <span class="block mt-2 md:mt-0 p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="filters['global'].value"
                                    placeholder="Search..."
                                />
                            </span>
                        </div>
                    </template>

                    <!--   <Column
                        selectionMode="multiple"
                        headerStyle="width: 3rem"
                    ></Column> -->

                    <Column
                        field="name"
                        header="User ID"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <img width="32" src="/images/avatar/nurse.png" />
                            <span class="p-column-title">User ID</span>
                            {{ slotProps.data.name }}
                        </template>
                    </Column>
                    <Column
                        field="tgl_keluar"
                        header="Tgl Keluar"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Tgl Keluar</span>
                            {{
                                new Date(
                                    slotProps.data.tgl_keluar
                                ).toLocaleDateString("ID-id")
                            }}
                        </template>
                        <!-- <template #filter="{ filterModel }">
                            <InputText
                                type="text"
                                v-model="filterModel.value"
                                class="p-column-filter"
                                placeholder="By Kategori"
                            />
                        </template> -->
                    </Column>
                    <Column
                        field="category"
                        header="Category"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Category</span>
                            {{ slotProps.data.category }}
                        </template>
                        <!-- <template #filter="{ filterModel }">
                            <InputText
                                type="text"
                                v-model="filterModel.value"
                                class="p-column-filter"
                                placeholder="By Kategori"
                            />
                        </template> -->
                    </Column>

                    <Column
                        field="nama_barang"
                        header="Jenis Barang"
                        :sortable="true"
                        headerStyle="width:14%; min-width:8rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Jenis Barang</span>
                            {{ slotProps.data.nama_barang }}
                        </template>
                    </Column>
                    <Column
                        field="sub_id"
                        header="SUB ID"
                        v-if="!$hideIdColumn" 
                        :sortable="true"
                        headerStyle="width:14%; min-width:8rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">SUB ID</span>
                            {{ slotProps.data.sub_id }}
                        </template>
                    </Column>

                    <Column
                        field="barcode"
                        header="Barcode"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Barcode</span>
                            {{ slotProps.data.barcode }}
                        </template>
                    </Column>

                    <Column
                        field="uraian"
                        header="Uraian"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Uraian</span>
                            {{ slotProps.data.uraian }}
                        </template>
                    </Column>

                    <Column
                        field="jumlah"
                        header="Jumlah"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Jumlah</span>
                            {{ slotProps.data.jumlah }}
                        </template>
                    </Column>

                    <Column
                        field="satuan"
                        header="Satuan"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Satuan</span>
                            {{ slotProps.data.satuan }}
                        </template>
                    </Column>
                    <Column
                        field="harga_satuan"
                        header="Harga Satuan"
                        :sortable="true"
                        dataType="numeric"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Harga Satuan</span>
                            {{ formatCurrency(slotProps.data.harga_satuan) }}
                        </template>
                    </Column>

                    <Column
                        field="keterangan"
                        header="keterangan"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Keterangan</span>
                            {{ slotProps.data.keterangan }}
                        </template>
                    </Column>

                    <Column headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button
                                icon="pi pi-pencil"
                                class="p-button-rounded p-button-success mr-2"
                                @click="editProduct(slotProps.data)"
                            />
                            <Button
                                icon="pi pi-trash"
                                class="p-button-rounded p-button-warning mt-2"
                                @click="confirmDeleteProduct(slotProps.data)"
                            />
                        </template>
                    </Column>
                </DataTable>

                <Dialog
                    v-model:visible="productDialog"
                    :style="{ width: '1024px' }"
                    :header="`Stok Keluar ${mode_edit}`"
                    :modal="true"
                    class="p-fluid"
                >
                    <div class="grid">
                        <div class="field col-12 md:col-6">
                            <div class="grid">
                                <div class="field col-8">
                                    <label for="tgl_keluar">Tanggal Keluar</label>
                                    <Calendar
                                        :class="{
                                            'p-invalid':
                                                submitted && !product.tgl_keluar,
                                        }"
                                        id="tgl_keluar"
                                        v-model="product.tgl_keluar"
                                        dateFormat="dd-mm-yy"
                                    />
                                    <!-- dateFormat="dd-mm-yy" -->
                                </div>

                                <div class="field col-4">
                                    <label>Pilih/Input Barang</label>
                                    <SplitButton
                                        label="Pilih"
                                        :model="menuPickBarang"
                                        class="p-button-info p-button-raised mb-2"
                                    ></SplitButton>
                                </div>
                            </div>
                        </div>

                        <div class="grid col-12 md:col-6">
                            <div class="field col-8">
                                <label for="barcode">Barcode</label>
                                <InputText
                                    id="barcode"
                                    v-model.trim="product.barcode"
                                    required="false"
                                    autofocus
                                />
                            </div>
                            <div class="field col-4">
                                <label>Scan via HP</label>
                                <Button
                                    label="Scan"
                                    icon="pi pi-search"
                                    class="p-button-info"
                                    @click="scanNOW"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="grid">
                        <div class="field col-6 md:col-6">
                            <label for="idCategory">ID Category</label>
                            <InputText
                                id="idCategory"
                                v-model.trim="product.id_category"
                                disabled
                                autofocus
                                class="disable-input"
                                :class="{
                                    'p-invalid':
                                        submitted && !product.id_category,
                                }"
                            />
                        </div>

                        <div class="field col-6 md:col-6">
                            <label for="category">Kategori</label>
                            <InputText
                                id="category"
                                v-model.trim="product.category"
                                disabled
                                autofocus
                                class="disable-input"
                                :class="{
                                    'p-invalid': submitted && !product.category,
                                }"
                            />
                        </div>

                        <div class="field col-6 md:col-6">
                            <label for="idbarang">ID Barang</label>
                            <InputText
                                id="idbarang"
                                v-model.trim="product.id_barang"
                                disabled
                                autofocus
                                class="disable-input"
                                :class="{
                                    'p-invalid':
                                        submitted && !product.id_barang,
                                }"
                            />
                        </div>

                        <div class="field col-6 md:col-6">
                            <label for="barang">Jenis Barang</label>
                            <InputText
                                id="barang"
                                v-model.trim="product.nama_barang"
                                disabled
                                autofocus
                                class="disable-input"
                                :class="{
                                    'p-invalid':
                                        submitted && !product.nama_barang,
                                }"
                            />
                        </div>

                        <div class="field col-6 md:col-6">
                            <label for="uraian">Uraian</label>
                            <InputText
                                id="uraian"
                                v-model.trim="product.uraian"
                                disabled
                                autofocus
                                class="disable-input"
                                :class="{
                                    'p-invalid': submitted && !product.uraian,
                                }"
                            />
                        </div>

                        <div class="field col-6 md:col-6">
                            <span
                                class="field-checkbox justify-content-between mb-3"
                            >
                                <label for="hargasatuan">Harga Satuan</label>
                                
                            </span>
                            <InputText
                                id="hargasatuan"
                                v-model.trim="product.harga_satuan"
                                :disabled="!checkedHargaBaru"
                                autofocus
                                mode="currency"
                                currency="IDR"
                                locale="id-ID"
                                :class="{
                                    'disable-input': !checkedHargaBaru,
                                    'p-invalid':
                                        submitted && !product.harga_satuan,
                                }"
                            />
                        </div>

                        <div class="field col-6 md:col-6">
                            <label for="jumlah">Jumlah Keluar</label>
                            <InputNumber
                                id="jumlah"
                                v-model="product.jumlah"
                                integeronly
                            />
                        </div>
                        <div class="field col-6 md:col-6">
                            <label for="stok">Satuan</label>
                            <InputText
                                id="satuan"
                                v-model="product.satuan"
                                disabled
                                class="disable-input"
                            />
                        </div>
                        <div class="field col-12">
                            <label for="keterangan">Keterangan</label>
                            <InputText
                                id="keterangan"
                                v-model="product.keterangan"
                                :class="{
                                    'p-invalid':
                                        submitted && !product.harga_satuan,
                                }"
                            />
                        </div>
                    </div>

                    <template #footer>
                        <Button
                            label="Cancel"
                            icon="pi pi-times"
                            class="p-button-text"
                            @click="hideDialog"
                        />
                        <Button
                            label="Save"
                            icon="pi pi-check"
                            class="p-button-text"
                            @click="saveProduct"
                        />
                    </template>
                </Dialog>

                <Dialog
                    v-model:visible="deleteProductDialog"
                    :style="{ width: '450px' }"
                    header="Confirm"
                    :modal="true"
                >
                    <div class="flex align-items-center justify-content-center">
                        <i
                            class="pi pi-exclamation-triangle mr-3"
                            style="font-size: 2rem"
                        />
                        <span v-if="product"
                            >Anda yakin menghapus <b>{{ product.uraian }}</b
                            >?</span
                        >
                    </div>
                    <template #footer>
                        <Button
                            label="No"
                            icon="pi pi-times"
                            class="p-button-text"
                            @click="deleteProductDialog = false"
                        />
                        <Button
                            label="Yes"
                            icon="pi pi-check"
                            class="p-button-text"
                            @click="deleteProduct"
                        />
                    </template>
                </Dialog>

               <!--  <Dialog
                    v-model:visible="deleteProductsDialog"
                    :style="{ width: '450px' }"
                    header="Confirm"
                    :modal="true"
                >
                    <div class="flex align-items-center justify-content-center">
                        <i
                            class="pi pi-exclamation-triangle mr-3"
                            style="font-size: 2rem"
                        />
                        <span v-if="product"
                            >Anda yakin menghapus Keluar yang terpilih?</span
                        >
                    </div>
                    <template #footer>
                        <Button
                            label="No"
                            icon="pi pi-times"
                            class="p-button-text"
                            @click="deleteProductsDialog = false"
                        />
                        <Button
                            label="Yes"
                            icon="pi pi-check"
                            class="p-button-text"
                            @click="deleteSelectedProducts"
                        />
                    </template>
                </Dialog> -->

                <Dialog
                    v-model:visible="barcodeDialog"
                    :style="{ width: '450px' }"
                    header="Scan"
                    :modal="true"
                >
                    <div v-show="barcodeDialog">
                        <StreamBarcodeReader
                            @decode="onDecodeBarcode"
                        ></StreamBarcodeReader>
                    </div>
                </Dialog>
            </div>
        </div>
    </div>

    <PickBarang @selected="actionSelectedPickBarang" />
    <DynamicDialog />
</template>

<script>
import { FilterMatchMode, FilterOperator } from "primevue/api";
import KeluarService from "../service/KeluarService.js";
import { StreamBarcodeReader } from "vue-barcode-reader";
import Cookie from "js-cookie";
import axios from "axios";
import PickBarang from "@/dialogs/PickBarang.vue";
import { useStore } from "@/store.js";
import { dayjs } from "@/dayjs.js";
import DialogPrint from "@/dialogs/DialogPrint.vue"

export default {
    // provide() {
    //     return {
    //         selectedpickbarang: this.actionSelectedPickBarang,
    //     };
    // },

    components: { StreamBarcodeReader, PickBarang },
    data() {
        return {
            categories: {
                category: [],
                nama_Keluar: [],
            },
            // loadingPickBarang:true,
            // pickBarangDialog:false,

            products: null,
            productDialog: false,
            deleteProductDialog: false,
            deleteProductsDialog: false,
            product: {},
            selectedProducts: null,
            filters: {},
            checkedHargaBaru: false,
            submitted: false,
            mode_edit: "Edit",
            pickCategoryModel: null,
            pickKeluarModel: null,
            modeEdit: "",
            barcodeDialog: false,
            filteredData: null,
            menuPickBarang: [
                {
                    label: "Pilih Barang",
                    icon: "pi pi-upload",
                    command: this.onPickBarang,
                },

               
            ],
        };
    },
    productService: null,
    created() {
        this.productService = new KeluarService();
        this.initFilters();
    },
    mounted() {
        this.productService.getKeluars().then((data) => {
            this.products = data;
            console.log("stokkeluar", this.products);
        });

        // this.productService
        //    .getKeluarCategory()
        //    .then((data) => {
        //        this.categories = data
        //        // console.log(this.categories)

        //        this.categories.category = this.categories.category.map((item)=>{
        //            let Keluar = {
        //                label: item.category,
        //                value: item.id_category
        //            }
        //            return Keluar
        //        })

        //        this.categories.nama_Keluar = this.categories.nama_Keluar.map((item)=>{
        //            let Keluar = {
        //                label: item.nama_Keluar,
        //                value: item.id_Keluar
        //            }
        //            return Keluar
        //        })

        //        console.log(this.categories)
        //    });
    },
    methods: {
        onPickBarang(keluar=true) {
            this.$emitter.emit("pick-barang-dialog", { visible: true, stokKeluar: keluar });
            // this.pickBarangDialog = true
        },
        formatCurrency(value) {
            // if (value)
            //     return value.toLocaleString("id-ID", {
            //         style: "currency",
            //         currency: "IDR",
            //     });
            // Create our number formatter.
            if (value) {
                var formatter = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",

                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });

                return formatter.format(value); /* $2,500.00 */
            }

            return;
        },
        changePickCategory() {
            this.product.id_category = this.pickCategoryModel.value;
            this.product.category = this.pickCategoryModel.label;
        },
        changePickKeluar() {
            this.product.id_Keluar = this.pickKeluarModel.value;
            this.product.nama_Keluar = this.pickKeluarModel.label;
        },

        openNew() {
            this.modeEdit = "new";
            this.product = {};
            this.product.user_id = this.productService.getUserId();
            this.submitted = false;
            this.mode_edit = "- Baru";
            this.productDialog = true;
        },
        hideDialog() {
            this.productDialog = false;
            this.submitted = false;
        },
        validate() {
            // this.product.tgl_keluar = (this.product.tgl_keluar) ? dayjs(this.product.tgl_keluar).tz("Asia/Jakarta").format('YYYY-MM-DD') : null
            this.product.tgl_keluar = dayjs(this.product.tgl_keluar).format(
                "YYYY-MM-DD"
            );
            console.log("validate", this.product.tgl_keluar);

            return (
                this.product.id_category &&
                this.product.category &&
                this.product.tgl_keluar &&
                this.product.id_barang &&
                this.product.nama_barang &&
                this.product.user_id &&
                this.product.jumlah &&
                this.product.sub_id &&
                this.product.keterangan &&
                this.product.tgl_keluar
            );
        },

        async saveProduct() {
            console.log("save", this.product);
            this.submitted = true;
            if (this.validate()) {
                if (this.modeEdit == "new") {
                  

                    this.productService
                        .saveKeluar(this.product, true)
                        .then((res) => {
                            console.log("save", res);
                            this.$toast.add({
                                severity: "success",
                                summary: "Successful",
                                detail: "Product Updated",
                                life: 3000,
                            });

                            this.productService.getKeluars().then((data) => {
                                this.products = data;
                                // console.log(this.products)
                            });
                            this.productDialog = false;
                            this.product = {};
                        });
                } else {
                    this.productService
                        .saveKeluar(this.product, false)
                        .then((res) => {
                            console.log("save edit", res);
                            this.$toast.add({
                                severity: "success",
                                summary: "Successful",
                                detail: "Product Updated",
                                life: 3000,
                            });

                            this.productService.getKeluars().then((data) => {
                                this.products = data;
                                // console.log(this.products)
                            });
                            this.productDialog = false;
                            this.product = {};
                        });
                }
            } else {
                this.$toast.add({
                    severity: "error",
                    summary: "Error saving",
                    detail: "Coba cek isiannya.",
                    life: 3000,
                });
                console.log(this.product);
            }
        },
        editProduct(product) {
            console.log("edit", product);
            // product.tgl_keluar = dayjs(product.tgl_keluar).format('DD-MM-YYYY')
            this.modeEdit = "edit";
            this.product = { ...product };
            this.product.user_id = this.productService.getUserId();
            this.mode_edit = "- Edit";
            this.productDialog = true;
        },
        confirmDeleteProduct(product) {
            this.product = product;
            this.deleteProductDialog = true;
        },
        deleteProduct() {
            // this.products = this.products.filter(
            //     (val) => val.id !== this.product.id
            // );
            this.productService.deleteKeluar(this.product.id).then((res) => {
                console.log("del", res);
                this.deleteProductDialog = false;
                this.product = {};
                this.$toast.add({
                    severity: "success",
                    summary: "Successful",
                    detail: "Product Deleted",
                    life: 3000,
                });
                this.productService.getKeluars().then((data) => {
                    this.products = data;
                    // console.log(this.products)
                });
            });
        },
        findIndexById(id) {
            let index = -1;
            for (let i = 0; i < this.products.length; i++) {
                if (this.products[i].id === id) {
                    index = i;
                    break;
                }
            }
            return index;
        },
        createId() {
            let id = "";
            var chars =
                "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 5; i++) {
                id += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return id;
        },
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        confirmDeleteSelected() {
            this.deleteProductsDialog = true;
        },
        deleteSelectedProducts() {
            // this.products = this.products.filter(
            //     (val) => !this.selectedProducts.includes(val)
            // );
            // console.log(this.selectedProducts)
            let del = this.selectedProducts.map((item) => {
                return this.productService.deleteKeluar(item.id);
            });

            Promise.all(del).then((val) => {
                console.log(val);
                this.productService.getKeluars().then((data) => {
                    this.products = data;
                    // console.log(this.products)
                    this.deleteProductsDialog = false;
                    this.selectedProducts = null;
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail: "Products Deleted",
                        life: 3000,
                    });
                });
            });
        },
        initFilters() {
            this.filters = {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                category: {
                    operator: FilterOperator.AND,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
            };
        },
        printstok() {
            // console.log(this.products)
            // axios.post(this.productService.parseWeb('/print/stok'),{data:this.filteredData})
            // .then((res) => {console.log(res)})

            window.open(this.productService.parseWeb("/print/stok/"), "_blank");
        },
        onFiltered(e) {
            this.filteredData = e;
            // Cookie.set('stokprint',JSON.stringify(this.filteredData))
        },
        scanNOW() {
            // this.barcodeDialog = true;
            if (
                navigator &&
                navigator.mediaDevices &&
                "enumerateDevices" in navigator.mediaDevices
            ) {
                this.barcodeDialog = true;
                console.log("yes");
            } else {
                console.log("no");
                this.$toast.add({
                    severity: "error",
                    summary: "Barcode not supported",
                    detail: "Silakan coba akses dari HP/address via https",
                    life: 3000,
                });
                this.barcodeDialog = false;
            }
        },
        onDecodeBarcode(e) {
            this.barcodeDialog = false;
            this.product.barcode = e;
            this.productService.getBarangByBarcode(e).then((selectedBarang) => {
                this.product.id_category = selectedBarang.id_category;
                this.product.category = selectedBarang.category;
                this.product.id_barang = selectedBarang.id_barang;
                this.product.nama_barang = selectedBarang.nama_barang;
                this.product.uraian = selectedBarang.uraian;
                this.product.satuan = selectedBarang.satuan;
                this.product.harga_satuan = selectedBarang.harga_satuan;
                this.product.sub_id = selectedBarang.sub_id;
                // alert(this.product.nama_barang)
            });
        },
        actionSelectedPickBarang(selectedBarang) {
            console.log(selectedBarang);
            this.product.id_category = selectedBarang.id_category;
            this.product.category = selectedBarang.category;
            this.product.id_barang = selectedBarang.id_barang;
            this.product.nama_barang = selectedBarang.nama_barang;
            this.product.uraian = selectedBarang.uraian;
            this.product.satuan = selectedBarang.satuan;
            this.product.harga_satuan = selectedBarang.harga_satuan;
            this.product.sub_id = selectedBarang.sub_id;
            this.product.barcode = selectedBarang.barcode;
        },
        print_stok_keluar() {
            // console.log(this.products)
            // axios.post(this.productService.parseWeb('/print/stok'),{data:this.filteredData})
            // .then((res) => {console.log(res)})

            // window.open(this.productService.parseWeb("/print/stok/"), "_blank");
            const dialogRef = this.$dialog.open(DialogPrint, {
                props: {
                    header: 'Print Stok Keluar',
                    style: {
                        width: '80vw',
                    },
                    breakpoints:{
                        '960px': '80vw',
                        '640px': '90vw'
                    },
                    modal: true
                },
                data:{
                    type:'print-stok-keluar',
                },
                templates: {
                    // footer: () => {
                    //     return [
                    //         h('div',{class:'p-3'}),
                         
                    //         h(Button, { label: "Close", icon: "pi pi-check", onClick: () => dialogRef.close({ buttonType: 'Yes' }), autofocus: true })
                    //     ]
                    // }
                },
                onClose: (options) => {
                    const data = options.data;
                    if (data) {
                        // this.refreshCategory()
                        // this.$toast.add({ severity:'info', 'ok', life: 3000 });
                    }
                }
            });
        },
    },
};
</script>

<style scoped lang="scss">
@import "../assets/demo/badges.scss";
.disable-input {
    color: green;
    font-weight: 600;
}
</style>
