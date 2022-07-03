import{_ as n,u as i,E as l,o as c,c as a,a as e,t as o}from"./index.b2e359a7.js";import{P as r}from"./ProductService.232c8ba0.js";const d={data(){return{store:i(),products:null,lineData:{labels:["January","February","March","April","May","June","July"],datasets:[{label:"Revenue",data:[65,59,80,81,56,55,40],fill:!1,backgroundColor:"#2f4860",borderColor:"#2f4860",tension:.4},{label:"Sales",data:[28,48,40,19,86,27,90],fill:!1,backgroundColor:"#00bb7e",borderColor:"#00bb7e",tension:.4}]},items:[{label:"Add New",icon:"pi pi-fw pi-plus"},{label:"Remove",icon:"pi pi-fw pi-minus"}],lineOptions:null}},productService:null,themeChangeListener:null,mounted(){this.productService.getProductsSmall().then(t=>this.products=t),this.themeChangeListener=t=>{t.dark?this.applyDarkTheme():this.applyLightTheme()},l.on("change-theme",this.themeChangeListener),this.isDarkTheme()?this.applyDarkTheme():this.applyLightTheme()},beforeUnmount(){l.off("change-theme",this.themeChangeListener)},async created(){this.productService=new r},methods:{formatCurrency(t){return t.toLocaleString("en-US",{style:"currency",currency:"USD"})},isDarkTheme(){return this.$appState.darkTheme===!0},applyLightTheme(){this.lineOptions={plugins:{legend:{labels:{color:"#495057"}}},scales:{x:{ticks:{color:"#495057"},grid:{color:"#ebedef"}},y:{ticks:{color:"#495057"},grid:{color:"#ebedef"}}}}},applyDarkTheme(){this.lineOptions={plugins:{legend:{labels:{color:"#ebedef"}}},scales:{x:{ticks:{color:"#ebedef"},grid:{color:"rgba(160, 167, 181, .3)"}},y:{ticks:{color:"#ebedef"},grid:{color:"rgba(160, 167, 181, .3)"}}}}}}},h={class:"grid"},u={class:"col-12 lg:col-6 xl:col-3"},m={class:"card mb-0"},_={class:"flex justify-content-between mb-3"},p=e("span",{class:"block text-500 font-medium mb-3"},"Barang",-1),b={class:"text-900 font-medium text-xl"},f=e("div",{class:"flex align-items-center justify-content-center bg-blue-100 border-round",style:{width:"2.5rem",height:"2.5rem"}},[e("i",{class:"pi pi-server text-blue-500 text-xl"})],-1),g=e("span",{class:"text-green-500 font-medium"},null,-1),x=e("span",{class:"text-500"},null,-1),y={class:"col-12 lg:col-6 xl:col-3"},v={class:"card mb-0"},k={class:"flex justify-content-between mb-3"},S=e("span",{class:"block text-500 font-medium mb-3"},"Stok Masuk",-1),w={class:"text-900 font-medium text-xl"},C=e("div",{class:"flex align-items-center justify-content-center bg-orange-100 border-round",style:{width:"2.5rem",height:"2.5rem"}},[e("i",{class:"pi pi-download text-orange-500 text-xl"})],-1),D=e("span",{class:"text-green-500 font-medium"},null,-1),T=e("span",{class:"text-500"},null,-1),L={class:"col-12 lg:col-6 xl:col-3"},j={class:"card mb-0"},B={class:"flex justify-content-between mb-3"},E=e("span",{class:"block text-500 font-medium mb-3"},"Stok Keluar",-1),J={class:"text-900 font-medium text-xl"},M=e("div",{class:"flex align-items-center justify-content-center bg-cyan-100 border-round",style:{width:"2.5rem",height:"2.5rem"}},[e("i",{class:"pi pi-upload text-cyan-500 text-xl"})],-1),O=e("span",{class:"text-green-500 font-medium"},null,-1),P=e("span",{class:"text-500"},null,-1);function U(t,A,N,R,s,$){return c(),a("div",h,[e("div",u,[e("div",m,[e("div",_,[e("div",null,[p,e("div",b,o(s.store.barang.count),1)]),f]),g,x])]),e("div",y,[e("div",v,[e("div",k,[e("div",null,[S,e("div",w,o(s.store.stok.masuk.count),1)]),C]),D,T])]),e("div",L,[e("div",j,[e("div",B,[e("div",null,[E,e("div",J,o(s.store.stok.keluar.count),1)]),M]),O,P])])])}var V=n(d,[["render",U]]);export{V as default};
