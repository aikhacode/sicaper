<template>
	<div>
        <!-- <div class="flex justify-content-end mt-1 mb-3">
            <Button icon="pi pi-external-link" label="Nested Dialog" class="p-button-outlined p-button-success" @click="showInfo" />
        </div> -->

        <div class="card">
        <DataTable :value="products" responsiveLayout="scroll" scrollable :paginator="true"
                    :rows="10"  paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} products">
            <template #header>
                        <div
                            class="flex flex-column md:flex-row md:align-items-center"
                        >
                            
                           <Button
                                label="New"
                                icon="pi pi-plus"
                                class="p-button-success mr-2"
                                @click="modeEdit=false;showNew()"
                                
                               
                            />
                           
                        </div>
                    </template>
			<Column field="id_category" header="ID Category"></Column>
			<Column field="category" header="Kategori"></Column>
            <Column field="id_barang" header="ID Barang"></Column>
			<Column field="nama_barang" header="Nama Barang"></Column>
            <Column headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button
                                icon="pi pi-pencil"
                                class="p-button-rounded p-button-success mr-2"
                                @click="modeEdit=true;editProduct(slotProps.data)"
                            />
                            <Button
                                icon="pi pi-trash"
                                class="p-button-rounded p-button-warning mt-2"
                                @click="confirmDeleteProduct(slotProps.data)"
                            />
                        </template>
                    </Column>
            
		</DataTable>
        </div>
	</div>

    <Dialog
                    v-model:visible="productDialog"
                    :style="{ width: '75vw' }"
                    header="Tambah Kategori / Jenis Barang"
                    :modal="true"
                    class="p-fluid"
                >
                <div class="grid">
                             
                     

                     <div class="field col-6">
                            <label for="idCategory">ID Category</label>
                            <InputText
                                id="idCategory"
                                v-model.trim="product.id_category"
                                
                                autofocus
                                class="disable-input"
                                :class="{ 'p-invalid': submitted && !product.id_category }"
                            />
                            <small
                            class="p-invalid"
                            v-if="submitted && !product.id_category"
                            >harus diisi.</small
                        >
                           
                        </div>
                        
                           <div class="field col-6">
                        <label for="idbarang">ID barang</label>
                        <InputText
                            id="idbarang"
                            v-model.trim="product.id_barang"
                            
                            required="true"
                            class="disable-input"
                            autofocus
                            :class="{ 'p-invalid': submitted && !product.id_barang }"
                        /> <small
                            class="p-invalid"
                            v-if="submitted && !product.id_barang"
                            >harus diisi.</small
                        >
                        
                    </div>

                    <div class="field col-6">
                        <label for="valcat">Kategori</label>
                        <InputText
                            id="valcat"
                            v-model.trim="product.category"
                            
                            required="true"
                            class="disable-input"
                            autofocus
                            :class="{ 'p-invalid': submitted && !product.category }"
                        /> <small
                            class="p-invalid"
                            v-if="submitted && !product.category"
                            >harus diisi.</small
                        >
                       
                    </div>

                    <div class="field col-6">
                        <label for="valbarang">Jenis Barang</label>
                        <InputText
                            id="valbarang"
                            v-model.trim="product.nama_barang"
                            
                            required="true"
                            class="disable-input"
                            autofocus
                            :class="{ 'p-invalid': submitted && !product.nama_barang }"
                        /> <small
                            class="p-invalid"
                            v-if="submitted && !product.nama_barang"
                            >harus diisi.</small
                        >
                       
                    </div>


                    </div>
                
                    <template #footer>
                        <Button
                            label="Cancel"
                            icon="pi pi-times"
                            class="p-button-text"
                            @click="productDialog = false; submitted = false"
                        />
                        <Button
                            label="Save"
                            icon="pi pi-check"
                            class="p-button-text"
                            @click="saveProduct"
                        />
                    </template>
                </Dialog>
</template>

<script>
import ProductService from '@/service/CategoryService.js';



export default {
    inject: ['dialogRef'],
    data() {
        return {
            products: null,
            product:{},
            productDialog:false,
            deleteProductDialog:false,
            submitted:false,
            modeEdit:false,
        }
    },
    productService: null,
    created() {
        this.productService = new ProductService();
    },
    mounted() {
        this.productService.getCategories().then((data) => {
            this.products = data.category
            this.max = data.max
        });
    },
    methods: {
        selectProduct(data) {
            this.dialogRef.close(data);
        },
         showNew() {
           this.submitted = false 
           this.product = {
                id_category: this.max.category ,
                id_barang: this.max.barang  ,
                category: '',
                nama_barang: '',
           }
           this.productDialog = true
        },
        validate(){
            return  this.product.category && this.product.id_category && this.product.id_barang && this.product.nama_barang
        },

        saveProduct(){
            this.submitted = true
            if (this.validate()){

                this.productService.saveCategory(!this.modeEdit,this.product.id,this.product).then((data)=>{
                    this.productDialog = false
                    this.$toast.add({
                        severity: "success",
                        summary: "Successful",
                        detail: "Updated",
                        life: 3000,
                        });
                     this.productService.getCategories().then((data) => {
                            this.products = data.category
                            this.max = data.max
                        });
                    
                })
            }

        },
         editProduct(product) {
            this.submitted = false 
            this.product = { ...product };
            this.productDialog = true;
        },
         confirmDeleteProduct(product) {
            this.product = product;
            this.deleteProductDialog = true;
        },

       
    }
}
</script>