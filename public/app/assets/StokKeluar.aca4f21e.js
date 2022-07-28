import{u as f,m as v,l as y,_ as j,S as A,v as N,x as E,g as S,y as L,D as F,e as c,o as D,c as P,a,f as i,w as r,F as O,h as u,t as h,n as b,i as R,z as H,A as z,p as q,j as J,k as Y}from"./index.44bc9131.js";class W{getUserId(){return console.log(f().login),f().login.userId}getKeluars(){let e={Accept:"application/json",Authorization:`Bearer ${f().token}`},d={url:y("/keluar/all"),method:"GET",headers:e};return v(d).then(m=>m.data)}getPickBarang(){let e={Accept:"application/json",Authorization:`Bearer ${f().token}`},d={url:y("/barang"),method:"GET",headers:e};return v(d).then(m=>m.data)}getBarangByBarcode(e){let d={Accept:"application/json",Authorization:`Bearer ${f().token}`},m={url:y("/barang/barcode/"+e),method:"GET",headers:d};return v(m).then(t=>t.data)}saveKeluar(e,d=!0){let m={Accept:"application/json",Authorization:`Bearer ${f().token}`},t={url:y("/keluar"),method:d?"POST":"PUT",data:e,headers:m};return v(t).then(n=>n.data)}deleteKeluar(e){let d={Accept:"application/json",Authorization:`Bearer ${f().token}`},m={url:y(`/keluar/${e}`),method:"DELETE",headers:d};return v(m).then(t=>t.data)}}const G={components:{StreamBarcodeReader:A,PickBarang:N},data(){return{categories:{category:[],nama_Keluar:[]},products:null,productDialog:!1,deleteProductDialog:!1,deleteProductsDialog:!1,product:{},selectedProducts:null,filters:{},checkedHargaBaru:!1,submitted:!1,mode_edit:"Edit",pickCategoryModel:null,pickKeluarModel:null,modeEdit:"",barcodeDialog:!1,filteredData:null,menuPickBarang:[{label:"Pilih Barang",icon:"pi pi-upload",command:this.onPickBarang}]}},productService:null,created(){this.productService=new W,this.initFilters()},mounted(){this.productService.getKeluars().then(l=>{this.products=l,console.log("stokkeluar",this.products)})},methods:{onPickBarang(){this.$emitter.emit("pick-barang-dialog",{visible:!0})},formatCurrency(l){if(l){var e=new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR"});return e.format(l)}},changePickCategory(){this.product.id_category=this.pickCategoryModel.value,this.product.category=this.pickCategoryModel.label},changePickKeluar(){this.product.id_Keluar=this.pickKeluarModel.value,this.product.nama_Keluar=this.pickKeluarModel.label},openNew(){this.modeEdit="new",this.product={},this.product.user_id=this.productService.getUserId(),this.submitted=!1,this.mode_edit="- Baru",this.productDialog=!0},hideDialog(){this.productDialog=!1,this.submitted=!1},validate(){return this.product.tgl_keluar=E(this.product.tgl_keluar).format("YYYY-MM-DD"),console.log("validate",this.product.tgl_keluar),this.product.id_category&&this.product.category&&this.product.tgl_keluar&&this.product.id_barang&&this.product.nama_barang&&this.product.user_id&&this.product.jumlah&&this.product.sub_id&&this.product.keterangan&&this.product.tgl_keluar},async saveProduct(){console.log("save",this.product),this.submitted=!0,this.validate()?this.modeEdit=="new"?this.productService.saveKeluar(this.product,!0).then(l=>{console.log("save",l),this.$toast.add({severity:"success",summary:"Successful",detail:"Product Updated",life:3e3}),this.productService.getKeluars().then(e=>{this.products=e}),this.productDialog=!1,this.product={}}):this.productService.saveKeluar(this.product,!1).then(l=>{console.log("save edit",l),this.$toast.add({severity:"success",summary:"Successful",detail:"Product Updated",life:3e3}),this.productService.getKeluars().then(e=>{this.products=e}),this.productDialog=!1,this.product={}}):(this.$toast.add({severity:"error",summary:"Error saving",detail:"Coba cek isiannya.",life:3e3}),console.log(this.product))},editProduct(l){console.log("edit",l),this.modeEdit="edit",this.product={...l},this.product.user_id=this.productService.getUserId(),this.mode_edit="- Edit",this.productDialog=!0},confirmDeleteProduct(l){this.product=l,this.deleteProductDialog=!0},deleteProduct(){this.productService.deleteKeluar(this.product.id).then(l=>{console.log("del",l),this.deleteProductDialog=!1,this.product={},this.$toast.add({severity:"success",summary:"Successful",detail:"Product Deleted",life:3e3}),this.productService.getKeluars().then(e=>{this.products=e})})},findIndexById(l){let e=-1;for(let d=0;d<this.products.length;d++)if(this.products[d].id===l){e=d;break}return e},createId(){let l="";for(var e="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",d=0;d<5;d++)l+=e.charAt(Math.floor(Math.random()*e.length));return l},exportCSV(){this.$refs.dt.exportCSV()},confirmDeleteSelected(){this.deleteProductsDialog=!0},deleteSelectedProducts(){let l=this.selectedProducts.map(e=>this.productService.deleteKeluar(e.id));Promise.all(l).then(e=>{console.log(e),this.productService.getKeluars().then(d=>{this.products=d,this.deleteProductsDialog=!1,this.selectedProducts=null,this.$toast.add({severity:"success",summary:"Successful",detail:"Products Deleted",life:3e3})})})},initFilters(){this.filters={global:{value:null,matchMode:S.CONTAINS},category:{operator:L.AND,constraints:[{value:null,matchMode:S.STARTS_WITH}]}}},printstok(){window.open(this.productService.parseWeb("/print/stok/"),"_blank")},onFiltered(l){this.filteredData=l},scanNOW(){navigator&&navigator.mediaDevices&&"enumerateDevices"in navigator.mediaDevices?(this.barcodeDialog=!0,console.log("yes")):(console.log("no"),this.$toast.add({severity:"error",summary:"Barcode not supported",detail:"Silakan coba akses dari HP/address via https",life:3e3}),this.barcodeDialog=!1)},onDecodeBarcode(l){this.barcodeDialog=!1,this.product.barcode=l,this.productService.getBarangByBarcode(l).then(e=>{this.product.id_category=e.id_category,this.product.category=e.category,this.product.id_barang=e.id_barang,this.product.nama_barang=e.nama_barang,this.product.uraian=e.uraian,this.product.satuan=e.satuan,this.product.harga_satuan=e.harga_satuan,this.product.sub_id=e.sub_id})},actionSelectedPickBarang(l){console.log(l),this.product.id_category=l.id_category,this.product.category=l.category,this.product.id_barang=l.id_barang,this.product.nama_barang=l.nama_barang,this.product.uraian=l.uraian,this.product.satuan=l.satuan,this.product.harga_satuan=l.harga_satuan,this.product.sub_id=l.sub_id,this.product.barcode=l.barcode},print_stok_keluar(){this.$dialog.open(F,{props:{header:"Print Stok Keluar",style:{width:"80vw"},breakpoints:{"960px":"80vw","640px":"90vw"},modal:!0},data:{type:"print-stok-keluar"},templates:{},onClose:l=>{l.data}})}}},s=l=>(q("data-v-1f06587e"),l=l(),J(),l),Q={class:"grid"},X={class:"col-12"},Z={class:"card"},$={class:"my-2"},ee={class:"flex flex-column md:flex-row md:justify-content-between md:align-items-center"},te=s(()=>a("h5",{class:"m-0"},"Manage Stok Keluar",-1)),oe={class:"block mt-2 md:mt-0 p-input-icon-left"},ae=s(()=>a("i",{class:"pi pi-search"},null,-1)),le=s(()=>a("img",{width:"32",src:Y},null,-1)),ie=s(()=>a("span",{class:"p-column-title"},"User ID",-1)),se=s(()=>a("span",{class:"p-column-title"},"Tgl Keluar",-1)),re=s(()=>a("span",{class:"p-column-title"},"Category",-1)),de=s(()=>a("span",{class:"p-column-title"},"Jenis Barang",-1)),ne=s(()=>a("span",{class:"p-column-title"},"SUB ID",-1)),ce=s(()=>a("span",{class:"p-column-title"},"Barcode",-1)),ue=s(()=>a("span",{class:"p-column-title"},"Uraian",-1)),pe=s(()=>a("span",{class:"p-column-title"},"Jumlah",-1)),he=s(()=>a("span",{class:"p-column-title"},"Satuan",-1)),me=s(()=>a("span",{class:"p-column-title"},"Harga Satuan",-1)),_e=s(()=>a("span",{class:"p-column-title"},"Keterangan",-1)),ge={class:"grid"},be={class:"field col-12 md:col-6"},fe={class:"grid"},ve={class:"field col-8"},ye=s(()=>a("label",{for:"tgl_keluar"},"Tanggal Keluar",-1)),ke={class:"field col-4"},Se=s(()=>a("label",null,"Pilih/Input Barang",-1)),De={class:"grid col-12 md:col-6"},Pe={class:"field col-8"},we=s(()=>a("label",{for:"barcode"},"Barcode",-1)),Ce={class:"field col-4"},Ve=s(()=>a("label",null,"Scan via HP",-1)),Be={class:"grid"},Ke={class:"field col-6 md:col-6"},xe=s(()=>a("label",{for:"idCategory"},"ID Category",-1)),Ie={class:"field col-6 md:col-6"},Ue=s(()=>a("label",{for:"category"},"Kategori",-1)),Te={class:"field col-6 md:col-6"},Me=s(()=>a("label",{for:"idbarang"},"ID Barang",-1)),je={class:"field col-6 md:col-6"},Ae=s(()=>a("label",{for:"barang"},"Jenis Barang",-1)),Ne={class:"field col-6 md:col-6"},Ee=s(()=>a("label",{for:"uraian"},"Uraian",-1)),Le={class:"field col-6 md:col-6"},Fe=s(()=>a("span",{class:"field-checkbox justify-content-between mb-3"},[a("label",{for:"hargasatuan"},"Harga Satuan")],-1)),Oe={class:"field col-6 md:col-6"},Re=s(()=>a("label",{for:"jumlah"},"Jumlah Keluar",-1)),He={class:"field col-6 md:col-6"},ze=s(()=>a("label",{for:"stok"},"Satuan",-1)),qe={class:"field col-12"},Je=s(()=>a("label",{for:"keterangan"},"Keterangan",-1)),Ye={class:"flex align-items-center justify-content-center"},We=s(()=>a("i",{class:"pi pi-exclamation-triangle mr-3",style:{"font-size":"2rem"}},null,-1)),Ge={key:0},Qe=u("Anda yakin menghapus "),Xe=u("?");function Ze(l,e,d,m,t,n){const w=c("Toast"),g=c("Button"),C=c("Toolbar"),_=c("InputText"),p=c("Column"),V=c("DataTable"),B=c("Calendar"),K=c("SplitButton"),x=c("InputNumber"),k=c("Dialog"),I=c("StreamBarcodeReader"),U=c("PickBarang"),T=c("DynamicDialog");return D(),P(O,null,[a("div",Q,[a("div",X,[a("div",Z,[i(w),i(C,{class:"mb-4"},{start:r(()=>[a("div",$,[i(g,{label:"New",icon:"pi pi-plus",class:"p-button-success mr-2",onClick:n.openNew},null,8,["onClick"])])]),end:r(()=>[i(g,{label:"Print",icon:"pi pi-print",class:"p-button-success mr-2",onClick:e[0]||(e[0]=o=>n.print_stok_keluar())})]),_:1}),i(V,{ref:"dt",value:t.products,selection:t.selectedProducts,"onUpdate:selection":e[2]||(e[2]=o=>t.selectedProducts=o),dataKey:"id",paginator:!0,rows:10,filters:t.filters,"onUpdate:filters":e[3]||(e[3]=o=>t.filters=o),responsiveLayout:"scroll",filterDisplay:"menu",paginatorTemplate:"FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown",rowsPerPageOptions:[5,10,25],currentPageReportTemplate:"Showing {first} to {last} of {totalRecords} products",onValueChange:n.onFiltered},{header:r(()=>[a("div",ee,[te,a("span",oe,[ae,i(_,{modelValue:t.filters.global.value,"onUpdate:modelValue":e[1]||(e[1]=o=>t.filters.global.value=o),placeholder:"Search..."},null,8,["modelValue"])])])]),default:r(()=>[i(p,{field:"email",header:"User ID",sortable:!0,headerStyle:"width:14%; min-width:10rem;"},{body:r(o=>[le,ie,u(" "+h(o.data.email),1)]),_:1}),i(p,{field:"tgl_keluar",header:"Tgl Keluar",sortable:!0,headerStyle:"width:14%; min-width:10rem;"},{body:r(o=>[se,u(" "+h(new Date(o.data.tgl_keluar).toLocaleDateString("ID-id")),1)]),_:1}),i(p,{field:"category",header:"Category",sortable:!0,headerStyle:"width:14%; min-width:10rem;"},{body:r(o=>[re,u(" "+h(o.data.category),1)]),_:1}),i(p,{field:"nama_barang",header:"Jenis Barang",sortable:!0,headerStyle:"width:14%; min-width:8rem;"},{body:r(o=>[de,u(" "+h(o.data.nama_barang),1)]),_:1}),i(p,{field:"sub_id",header:"SUB ID",sortable:!0,headerStyle:"width:14%; min-width:8rem;"},{body:r(o=>[ne,u(" "+h(o.data.sub_id),1)]),_:1}),i(p,{field:"barcode",header:"Barcode",sortable:!0,headerStyle:"width:14%; min-width:10rem;"},{body:r(o=>[ce,u(" "+h(o.data.barcode),1)]),_:1}),i(p,{field:"uraian",header:"Uraian",sortable:!0,headerStyle:"width:14%; min-width:10rem;"},{body:r(o=>[ue,u(" "+h(o.data.uraian),1)]),_:1}),i(p,{field:"jumlah",header:"Jumlah",sortable:!0,headerStyle:"width:14%; min-width:10rem;"},{body:r(o=>[pe,u(" "+h(o.data.jumlah),1)]),_:1}),i(p,{field:"satuan",header:"Satuan",sortable:!0,headerStyle:"width:14%; min-width:10rem;"},{body:r(o=>[he,u(" "+h(o.data.satuan),1)]),_:1}),i(p,{field:"harga_satuan",header:"Harga Satuan",sortable:!0,dataType:"numeric",headerStyle:"width:14%; min-width:10rem;"},{body:r(o=>[me,u(" "+h(n.formatCurrency(o.data.harga_satuan)),1)]),_:1}),i(p,{field:"keterangan",header:"keterangan",sortable:!0,headerStyle:"width:14%; min-width:10rem;"},{body:r(o=>[_e,u(" "+h(o.data.keterangan),1)]),_:1}),i(p,{headerStyle:"min-width:10rem;"},{body:r(o=>[i(g,{icon:"pi pi-pencil",class:"p-button-rounded p-button-success mr-2",onClick:M=>n.editProduct(o.data)},null,8,["onClick"]),i(g,{icon:"pi pi-trash",class:"p-button-rounded p-button-warning mt-2",onClick:M=>n.confirmDeleteProduct(o.data)},null,8,["onClick"])]),_:1})]),_:1},8,["value","selection","filters","onValueChange"]),i(k,{visible:t.productDialog,"onUpdate:visible":e[15]||(e[15]=o=>t.productDialog=o),style:{width:"1024px"},header:`Stok Keluar ${t.mode_edit}`,modal:!0,class:"p-fluid"},{footer:r(()=>[i(g,{label:"Cancel",icon:"pi pi-times",class:"p-button-text",onClick:n.hideDialog},null,8,["onClick"]),i(g,{label:"Save",icon:"pi pi-check",class:"p-button-text",onClick:n.saveProduct},null,8,["onClick"])]),default:r(()=>[a("div",ge,[a("div",be,[a("div",fe,[a("div",ve,[ye,i(B,{class:b({"p-invalid":t.submitted&&!t.product.tgl_keluar}),id:"tgl_keluar",modelValue:t.product.tgl_keluar,"onUpdate:modelValue":e[4]||(e[4]=o=>t.product.tgl_keluar=o),dateFormat:"dd-mm-yy"},null,8,["class","modelValue"])]),a("div",ke,[Se,i(K,{label:"Pilih",model:t.menuPickBarang,class:"p-button-info p-button-raised mb-2"},null,8,["model"])])])]),a("div",De,[a("div",Pe,[we,i(_,{id:"barcode",modelValue:t.product.barcode,"onUpdate:modelValue":e[5]||(e[5]=o=>t.product.barcode=o),modelModifiers:{trim:!0},required:"false",autofocus:""},null,8,["modelValue"])]),a("div",Ce,[Ve,i(g,{label:"Scan",icon:"pi pi-search",class:"p-button-info",onClick:n.scanNOW},null,8,["onClick"])])])]),a("div",Be,[a("div",Ke,[xe,i(_,{id:"idCategory",modelValue:t.product.id_category,"onUpdate:modelValue":e[6]||(e[6]=o=>t.product.id_category=o),modelModifiers:{trim:!0},disabled:"",autofocus:"",class:b(["disable-input",{"p-invalid":t.submitted&&!t.product.id_category}])},null,8,["modelValue","class"])]),a("div",Ie,[Ue,i(_,{id:"category",modelValue:t.product.category,"onUpdate:modelValue":e[7]||(e[7]=o=>t.product.category=o),modelModifiers:{trim:!0},disabled:"",autofocus:"",class:b(["disable-input",{"p-invalid":t.submitted&&!t.product.category}])},null,8,["modelValue","class"])]),a("div",Te,[Me,i(_,{id:"idbarang",modelValue:t.product.id_barang,"onUpdate:modelValue":e[8]||(e[8]=o=>t.product.id_barang=o),modelModifiers:{trim:!0},disabled:"",autofocus:"",class:b(["disable-input",{"p-invalid":t.submitted&&!t.product.id_barang}])},null,8,["modelValue","class"])]),a("div",je,[Ae,i(_,{id:"barang",modelValue:t.product.nama_barang,"onUpdate:modelValue":e[9]||(e[9]=o=>t.product.nama_barang=o),modelModifiers:{trim:!0},disabled:"",autofocus:"",class:b(["disable-input",{"p-invalid":t.submitted&&!t.product.nama_barang}])},null,8,["modelValue","class"])]),a("div",Ne,[Ee,i(_,{id:"uraian",modelValue:t.product.uraian,"onUpdate:modelValue":e[10]||(e[10]=o=>t.product.uraian=o),modelModifiers:{trim:!0},disabled:"",autofocus:"",class:b(["disable-input",{"p-invalid":t.submitted&&!t.product.uraian}])},null,8,["modelValue","class"])]),a("div",Le,[Fe,i(_,{id:"hargasatuan",modelValue:t.product.harga_satuan,"onUpdate:modelValue":e[11]||(e[11]=o=>t.product.harga_satuan=o),modelModifiers:{trim:!0},disabled:!t.checkedHargaBaru,autofocus:"",mode:"currency",currency:"IDR",locale:"id-ID",class:b({"disable-input":!t.checkedHargaBaru,"p-invalid":t.submitted&&!t.product.harga_satuan})},null,8,["modelValue","disabled","class"])]),a("div",Oe,[Re,i(x,{id:"jumlah",modelValue:t.product.jumlah,"onUpdate:modelValue":e[12]||(e[12]=o=>t.product.jumlah=o),integeronly:""},null,8,["modelValue"])]),a("div",He,[ze,i(_,{id:"satuan",modelValue:t.product.satuan,"onUpdate:modelValue":e[13]||(e[13]=o=>t.product.satuan=o),disabled:"",class:"disable-input"},null,8,["modelValue"])]),a("div",qe,[Je,i(_,{id:"keterangan",modelValue:t.product.keterangan,"onUpdate:modelValue":e[14]||(e[14]=o=>t.product.keterangan=o),class:b({"p-invalid":t.submitted&&!t.product.harga_satuan})},null,8,["modelValue","class"])])])]),_:1},8,["visible","header"]),i(k,{visible:t.deleteProductDialog,"onUpdate:visible":e[17]||(e[17]=o=>t.deleteProductDialog=o),style:{width:"450px"},header:"Confirm",modal:!0},{footer:r(()=>[i(g,{label:"No",icon:"pi pi-times",class:"p-button-text",onClick:e[16]||(e[16]=o=>t.deleteProductDialog=!1)}),i(g,{label:"Yes",icon:"pi pi-check",class:"p-button-text",onClick:n.deleteProduct},null,8,["onClick"])]),default:r(()=>[a("div",Ye,[We,t.product?(D(),P("span",Ge,[Qe,a("b",null,h(t.product.uraian),1),Xe])):R("",!0)])]),_:1},8,["visible"]),i(k,{visible:t.barcodeDialog,"onUpdate:visible":e[18]||(e[18]=o=>t.barcodeDialog=o),style:{width:"450px"},header:"Scan",modal:!0},{default:r(()=>[H(a("div",null,[i(I,{onDecode:n.onDecodeBarcode},null,8,["onDecode"])],512),[[z,t.barcodeDialog]])]),_:1},8,["visible"])])])]),i(U,{onSelected:n.actionSelectedPickBarang},null,8,["onSelected"]),i(T)],64)}const et=j(G,[["render",Ze],["__scopeId","data-v-1f06587e"]]);export{et as default};
