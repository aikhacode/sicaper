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
                            <Button
                                label="Delete"
                                icon="pi pi-trash"
                                class="p-button-danger"
                                @click="confirmDeleteSelected"
                                :disabled="
                                    !selectedProducts ||
                                    !selectedProducts.length
                                "
                            />
                        </div>
                    </template>

                    <template v-slot:end>
						<Button
                                label="Print"
                                icon="pi pi-print"
                                class="p-button-success mr-2"
                                @click="printstok"
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
                    filterDisplay="menu"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products"
                    responsiveLayout="scroll"
                >
                    <template #header>
                        <div
                            class="flex flex-column md:flex-row md:justify-content-between md:align-items-center"
                        >
                            <h5 class="m-0">Manage Barang</h5>
                            <span class="block mt-2 md:mt-0 p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="filters['global'].value"
                                    placeholder="Search..."
                                />
                            </span>
                        </div>
                    </template>

                    <Column
                        selectionMode="multiple"
                        headerStyle="width: 3rem"
                    ></Column>
                    <Column
                        field="id_category"
                        header="ID Cat"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">ID Cat</span>
                            {{ slotProps.data.id_category }}
                        </template>
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
                        <template #filter="{filterModel}">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="By Kategori"/>
                        </template>

                    </Column>
                    <!-- <Column header="Image" headerStyle="width:14%; min-width:10rem;">
						<template #body="slotProps">
							<span class="p-column-title">Image</span>
							<img :src="'images/product/' + slotProps.data.image" :alt="slotProps.data.image" class="shadow-2" width="100" />
						</template>
					</Column> -->
                    <Column
                        field="id_barang"
                        header="ID Barang"
                        :sortable="true"
                        headerStyle="width:14%; min-width:8rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">ID Barang</span>
                            {{ slotProps.data.id_barang }}
                        </template>
                    </Column>
                    <Column
                        field="sub_id"
                        header="SUB ID"
                        :sortable="true"
                        headerStyle="width:14%; min-width:8rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">SUB ID</span>
                            {{ slotProps.data.sub_id }}
                        </template>
                    </Column>
                    <Column
                        field="nama_barang"
                        header="Nama Barang"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Nama Barang</span>
                            {{ slotProps.data.nama_barang }}
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
                        field="stok"
                        header="Stok"
                        :sortable="true"
                        headerStyle="width:14%; min-width:10rem;"
                    >
                        <template #body="slotProps">
                            <span class="p-column-title">Stok</span>
                            {{ slotProps.data.stok }}
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

                    <!-- <Column field="inventoryStatus" header="Status" :sortable="true" headerStyle="width:14%; min-width:10rem;">
						<template #body="slotProps">
							<span class="p-column-title">Status</span>
							<span :class="'product-badge status-' + (slotProps.data.inventoryStatus ? slotProps.data.inventoryStatus.toLowerCase() : '')">{{slotProps.data.inventoryStatus}}</span>
						</template>
					</Column> -->
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
                    :header="`Kartu Stok ${mode_edit}`"
                    :modal="true"
                    class="p-fluid"
                >
                <div class="grid">
                    <div class="grid col-12 md:col-6">
                     <div class="field col-12">
                            <label for="categoryPick" class="mb-3"
                                >Pilih Kategori</label
                            >
                            <Dropdown
                                id="categoryPick"
                                v-model="pickCategoryModel"
                                :options="categories.category"
                                optionLabel="label"
                                placeholder="Pilih Kategori"
                                 @change="changePickCategory"
                            >
                                <template #value="slotProps">
                                    <div
                                        v-if="
                                            slotProps.value && slotProps.value.value
                                        "
                                    >
                                        <span
                                            :class="
                                                'product-badge status-' +
                                                slotProps.value.value
                                            "
                                            >{{ slotProps.value.label }}</span
                                        >
                                    </div>
                                    <div
                                        v-else-if="
                                            slotProps.value &&
                                            !slotProps.value.value
                                        "
                                    >
                                        <span
                                            :class="
                                                'product-badge status-' +
                                                slotProps.value.toLowerCase()
                                            "
                                            >{{ slotProps.value }}</span
                                        >
                                    </div>
                                    <span v-else>
                                        {{ slotProps.placeholder }}
                                    </span>
                                </template>
                            </Dropdown>
                     </div>
                     <div class="field col-6">
                            <label for="idCategory">ID Category</label>
                            <InputText
                                id="idCategory"
                                v-model.trim="product.id_category"
                                disabled
                                autofocus
                                class="disable-input"
                                :class="{ 'p-invalid': submitted && !product.id_category }"
                            />
                           
                        </div>
                        <div class="field col-6">
                            <label for="valcategory">Kategori</label>
                            <InputText
                                id="valCategory"
                                v-model.trim="product.category"
                                disabled
                                autofocus
                                class="disable-input"
                                :class="{ 'p-invalid': submitted && !product.category }"
                            />
                            
                        </div>
                    </div>
                    <div class="grid col-12 md:col-6">

                         <div class="field col-12">
                            <label for="barangPick" class="mb-3"
                                >Pilih Jenis Barang</label>
                            <Dropdown
                                id="barangPick"
                                v-model="pickBarangModel"
                                :options="categories.nama_barang"
                                optionLabel="label"
                                placeholder="Pilih jenis barang"
                                @change="changePickBarang"
                            >
                                <template #value="slotProps">
                                    <div
                                        v-if="
                                            slotProps.value && slotProps.value.value
                                        "
                                    >
                                        <span
                                            :class="
                                                'product-badge status-' +
                                                slotProps.value.value
                                            "
                                            >{{ slotProps.value.label }}</span
                                        >
                                    </div>
                                    <div
                                        v-else-if="
                                            slotProps.value &&
                                            !slotProps.value.value
                                        "
                                    >
                                        <span
                                            :class="
                                                'product-badge status-' +
                                                slotProps.value.toLowerCase()
                                            "
                                            >{{ slotProps.value }}</span
                                        >
                                    </div>
                                    <span v-else>
                                        {{ slotProps.placeholder }}
                                    </span>
                                </template>
                            </Dropdown>
                        </div>
                           <div class="field col-6">
                        <label for="idbarang">ID barang</label>
                        <InputText
                            id="idbarang"
                            v-model.trim="product.id_barang"
                            disabled
                            required="true"
                            class="disable-input"
                            autofocus
                            :class="{ 'p-invalid': submitted && !product.id_barang }"
                        />
                        
                    </div>

                    <div class="field col-6">
                        <label for="valbarang">Jenis Barang</label>
                        <InputText
                            id="valbarang"
                            v-model.trim="product.nama_barang"
                            disabled
                            required="true"
                            class="disable-input"
                            autofocus
                            :class="{ 'p-invalid': submitted && !product.nama_barang }"
                        />
                       
                    </div>


                    </div>
                </div>
                     
                <div class="grid">

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
                        <StreamBarcodeReader v-if="readyBarcode"
                          @decode="onDecodeBarcode"
                          
                        ></StreamBarcodeReader>
   
                     </div>     
                </div>    
                    

                 
                

                    <div class="field">
                        <label for="uraian">Uraian</label>
                        <InputText
                            id="uraian"
                            v-model.trim="product.uraian"
                            required="true"
                            autofocus
                            :class="{ 'p-invalid': submitted && !product.uraian }"
                        />
                        <small
                            class="p-invalid"
                            v-if="submitted && !product.uraian"
                            >Uraian harus diisi.</small
                        >
                    </div>
                   

                    <!-- <div class="field">
                        <label for="inventoryStatus" class="mb-3"
                            >Inventory Status</label
                        >
                        <Dropdown
                            id="inventoryStatus"
                            v-model="product.inventoryStatus"
                            :options="statuses"
                            optionLabel="label"
                            placeholder="Select a Status"
                        >
                            <template #value="slotProps">
                                <div
                                    v-if="
                                        slotProps.value && slotProps.value.value
                                    "
                                >
                                    <span
                                        :class="
                                            'product-badge status-' +
                                            slotProps.value.value
                                        "
                                        >{{ slotProps.value.label }}</span
                                    >
                                </div>
                                <div
                                    v-else-if="
                                        slotProps.value &&
                                        !slotProps.value.value
                                    "
                                >
                                    <span
                                        :class="
                                            'product-badge status-' +
                                            slotProps.value.toLowerCase()
                                        "
                                        >{{ slotProps.value }}</span
                                    >
                                </div>
                                <span v-else>
                                    {{ slotProps.placeholder }}
                                </span>
                            </template>
                        </Dropdown>
                    </div> -->

                    <!-- <div class="field">
                        <label class="mb-3">Category</label>
                        <div class="formgrid grid">
                            <div class="field-radiobutton col-6">
                                <RadioButton
                                    id="category1"
                                    name="category"
                                    value="Accessories"
                                    v-model="product.category"
                                />
                                <label for="category1">Accessories</label>
                            </div>
                            <div class="field-radiobutton col-6">
                                <RadioButton
                                    id="category2"
                                    name="category"
                                    value="Clothing"
                                    v-model="product.category"
                                />
                                <label for="category2">Clothing</label>
                            </div>
                            <div class="field-radiobutton col-6">
                                <RadioButton
                                    id="category3"
                                    name="category"
                                    value="Electronics"
                                    v-model="product.category"
                                />
                                <label for="category3">Electronics</label>
                            </div>
                            <div class="field-radiobutton col-6">
                                <RadioButton
                                    id="category4"
                                    name="category"
                                    value="Fitness"
                                    v-model="product.category"
                                />
                                <label for="category4">Fitness</label>
                            </div>
                        </div>
                    </div> -->

                    <div class="formgrid grid">
                        <div class="field col-12 md:col-4">
                            <label for="harga">Harga Satuan</label>
                            <InputNumber
                                id="harga"
                                v-model="product.harga_satuan"
                                mode="currency"
                                currency="IDR"
                                locale="id-ID"
                                
                            />
                            <!-- mode="currency"
                                currency="IDR"
                                locale="id-ID"
                                mode="decimal" locale="en-US" :minFractionDigits="2"
                                 -->
                        </div>
                        <div class="field col-12 md:col-4">
                            <label for="stok">Stok</label>
                            <InputNumber
                                id="stok"
                                v-model="product.stok"
                                integeronly
                            />
                        </div>
                        <div class="field col-12 md:col-4">
                            <label for="stok">Satuan</label>
                            <InputText
                                id="satuan"
                                v-model="product.satuan"
                                
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
                            >Anda yakin menghapus
                            <b>{{ product.uraian }}</b
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

                <Dialog
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
                            >Anda yakin menghapus barang yang terpilih?</span
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
                </Dialog>
            </div>
        </div>
    </div>

    
</template>
<script>

import {FilterMatchMode,FilterOperator} from 'primevue/api';
import BarangService from "../service/BarangService.js";
import { StreamBarcodeReader } from "vue-barcode-reader";

export default {
    components:{StreamBarcodeReader},
    data() {
        return {
            categories: {
                category:[],
                nama_barang:[]
            } ,
            products: null,
            productDialog: false,
            deleteProductDialog: false,
            deleteProductsDialog: false,
            product: {},
            selectedProducts: null,
            filters: {},
            submitted: false,
            mode_edit:'Edit',
            pickCategoryModel: null,
            pickBarangModel:null,
            modeEdit:'',
            readyBarcode:false,
            isMediaStreamAPISupported:
                navigator &&
                navigator.mediaDevices &&
                "enumerateDevices" in navigator.mediaDevices
            
        };
    },
    productService: null,
    created() {
        this.productService = new BarangService();
        this.initFilters();
    },
    mounted() {

        this.productService
            .getBarangs()
            .then((data) => {
                this.products = data
                // console.log(this.products)
                });

         this.productService
            .getBarangCategory()
            .then((data) => { 
                this.categories = data 
                // console.log(this.categories)

                this.categories.category = this.categories.category.map((item)=>{
                    let barang = {
                        label: item.category,
                        value: item.id_category
                    }
                    return barang
                })

                this.categories.nama_barang = this.categories.nama_barang.map((item)=>{
                    let barang = {
                        label: item.nama_barang,
                        value: item.id_barang
                    }
                    return barang
                })

                console.log(this.categories)
            });
    },
    methods: {
        formatCurrency(value) {
            // if (value)
            //     return value.toLocaleString("id-ID", {
            //         style: "currency",
            //         currency: "IDR",
            //     });
            // Create our number formatter.
            if (value) {
                  var formatter = new Intl.NumberFormat('id-ID', {
                  style: 'currency',
                  currency: 'IDR',

                  // These options are needed to round to whole numbers if that's what you want.
                  //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                  //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                });

                return formatter.format(value); /* $2,500.00 */
            }
           

            return;
        },
        changePickCategory(){
            this.product.id_category = this.pickCategoryModel.value
            this.product.category = this.pickCategoryModel.label
        },
        changePickBarang(){
            this.product.id_barang = this.pickBarangModel.value
            this.product.nama_barang = this.pickBarangModel.label
        },
        
        openNew() {
            this.modeEdit = 'new'
            this.product = {
                harga_satuan: 0,
                stok:0,
                satuan:'bj'
            };
            this.submitted = false;
            this.mode_edit = '- Baru';
            this.productDialog = true;
        },
        hideDialog() {
            this.productDialog = false;
            this.submitted = false;
        },
        saveProduct() {
            console.log(this.product)
            this.submitted = true;
            if (this.product.category.trim()) {
                if (this.modeEdit=='new'){
                    this.productService.saveBarang(this.product,true).then((res) => {
                        console.log('save',res)
                        this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail: "Product Updated",
                        life: 3000,
                        });
                
                    this.productService
                        .getBarangs()
                        .then((data) => {
                            this.products = data
                            // console.log(this.products)
                            });
                        this.productDialog = false;
                        this.product = {};
                    })
                } else {
                    this.productService.saveBarang(this.product,false).then((res) => {
                        console.log('save edit',res)
                        this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail: "Product Updated",
                        life: 3000,
                        });
                
                    this.productService
                        .getBarangs()
                        .then((data) => {
                            this.products = data
                            // console.log(this.products)
                            });
                        this.productDialog = false;
                        this.product = {};
                    })
                }
                
            }
        },
        editProduct(product) {
            console.log(product)
            this.modeEdit = 'edit'
            this.product = { ...product };
            this.mode_edit = '- Edit';
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
            this.productService.deleteBarang(this.product.id).then((res) => {
                console.log('del',res)
                this.deleteProductDialog = false;
                this.product = {};
                this.$toast.add({
                    severity: "success",
                    summary: "Successful",
                    detail: "Product Deleted",
                    life: 3000,
                });   
                this.productService
                        .getBarangs()
                        .then((data) => {
                            this.products = data
                            // console.log(this.products)
                            }); 
            })

            
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
                return this.productService.deleteBarang(item.id)  
            })
            
            Promise.all(del).then((val) => {
                console.log(val)
                this.productService
                        .getBarangs()
                        .then((data) => {
                            this.products = data
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
            }) 
            
            
        },
        initFilters() {
            this.filters = {
                'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
                'category': {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.STARTS_WITH}]},
            };
        },
        printstok(){
            window.open(
                  this.productService.parseWeb('/print/stok'),
                  '_blank' // <- This is what makes it open in a new window.
                );
        },
        onDecodeBarcode(result)
        {
            this.product.barcode = JSON.stringify(result)
            this.readyBarcode = false
        },
        scanNOW(){
            if (this.isMediaStreamAPISupported){
                this.readyBarcode = true  
            } else {
                 this.$toast.add({
                    severity: "error",
                    summary: "Barcode media camera not supported",
                    detail: "Coba di HP kamu",
                    life: 3000,
                });   
            }
        }
    },
};
</script>

<style scoped lang="scss">
@import "../assets/demo/badges.scss";
.disable-input{
        color: green;
    font-weight: 600;
}
</style>
