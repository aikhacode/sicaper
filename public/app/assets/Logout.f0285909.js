import{u as c,i,j as n,r as l,o as r,c as d,a as e,d as u,w as _,k as m,f as p}from"./index.def2de93.js";var x="/app/layout/images/asset-access.svg";const h={class:"surface-0 flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden"},g={class:"grid justify-content-center p-2 lg:p-0",style:{"min-width":"80%"}},f=e("div",{class:"col-12 mt-5 xl:mt-0 text-center"},null,-1),v={class:"col-12 xl:col-6",style:{"border-radius":"56px",padding:"0.3rem",background:"linear-gradient("}},b={class:"h-full w-full m-0 py-7 px-4",style:{"border-radius":"53px",background:"linear-gradient("}},w={class:"grid flex flex-column align-items-center"},y=m('<div class="flex justify-content-center align-items-center bg-orange-500 border-circle" style="width:3.2rem;height:3.2rem;"><i class="pi pi-fw pi-lock text-2xl text-50"></i></div><h1 class="text-900 font-bold text-4xl lg:text-5xl mb-2"> Terima Kasih </h1><span class="text-600 text-center">Sampai berjumpa lagi..</span><img src="'+x+'" alt="Access denied" class="mt-5" width="80%">',4),k={class:"col-12 mt-5 text-center"},j=e("i",{class:"pi pi-fw pi-arrow-left text-blue-500 mr-2",style:{"vertical-align":"center"}},null,-1),T=p("Go to Dashboard"),S={__name:"Logout",setup(N){const s=c(),o=i();return n(async()=>{if(await s.doLogout()){const t=setTimeout(()=>{clearTimeout(t),o.push("/")},500)}}),(t,V)=>{const a=l("router-link");return r(),d("div",h,[e("div",g,[f,e("div",v,[e("div",b,[e("div",w,[y,e("div",k,[j,u(a,{to:"/",class:"text-blue-500"},{default:_(()=>[T]),_:1})])])])])])])}}};export{S as default};
