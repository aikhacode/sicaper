<template>
    <!-- <div class="flex justify-content-end mt-1 mb-3">
            <Button icon="pi pi-external-link" label="Nested Dialog" class="p-button-outlined p-button-success" @click="showInfo" />
        </div> -->

    <h5>Pilih Periode</h5>
    <div class="p-fluid grid formgrid">
        <div class="field col-12 md:col-6">
            <label for="date1">Awal</label>
            <Calendar id="date1" v-model="date1" dateFormat="dd-mm-yy" :class="{ 'p-invalid': submitted && !date2 && !valid_date}"/>
            <small
                            class="p-invalid"
                            v-if="submitted && !date1 && !valid_date"
                            >Harus diisi.</small
                        >
        </div>
        <div class="field col-12 md:col-6">
            <label for="date2">Akhir</label>
            <Calendar
                id="date2"
                v-model="date2"
                dateFormat="dd-mm-yy"
                :class="{ 'p-invalid': submitted && !date2 && !valid_date}"
            />
            <small
                            class="p-invalid"
                            v-if="submitted && !date2 && !valid_date"
                            >Harus diisi.</small
                        >
        </div>
    </div>
    <div class="p-dialog-footer mr-0">
        <Button label="Print" icon="pi pi-print" class="p-button-success" @click="print()"/>
    </div>
</template>

<script>
    import {parseWeb} from "@/func.js"
    import {dayjs} from "@/dayjs.js"

export default {
    inject: ["dialogRef"],
    props: {
        url: String,
    },
    data() {
        return {
            date1: null,
            date2: null,
            submitted:false,
            valid_date:false
        };
    },

    created() {},
    mounted() {
        this.submitted = false
    },
    methods: {
        validate(){
            this.valid_date =  (this.date1<=this.date2)
            return this.date1 && this.date2 && this.valid_date
        },
        print(){
            this.submitted = true
            
            if (this.validate()){
                let arg = {
                    date1: dayjs(this.date1).format('YYYY-MM-DD'),
                    date2: dayjs(this.date2).format('YYYY-MM-DD'),
                   
                }
                if (this.dialogRef.data.type=='print-stok'){
                    window.open(
                  parseWeb(`/print/rincianstok?start=${arg.date1}&end=${arg.date2}`),
                  '_blank' 
                );   
                }
                if (this.dialogRef.data.type=='print-kartu-stok'){
                    // console.log(arg.barcode)
                    arg.barcode = this.dialogRef.data.barcode,
                    window.open(
                      parseWeb(`/print/kartustok?barcode=${arg.barcode}&start=${arg.date1}&end=${arg.date2}`),
                      '_blank' 
                    );   
                }
                 if (this.dialogRef.data.type=='print-stok-masuk'){
                    // console.log(arg.barcode)
                    
                    window.open(
                      parseWeb(`/print/masuk?start=${arg.date1}&end=${arg.date2}`),
                      '_blank' 
                    );   
                }

                if (this.dialogRef.data.type=='print-stok-keluar'){
                    // console.log(arg.barcode)
                    
                    window.open(
                      parseWeb(`/print/keluar?start=${arg.date1}&end=${arg.date2}`),
                      '_blank' 
                    );   
                }
                 
            } else alert('date tidak sesuai')
            this.valid_date = false
        },
    },
};
</script>
