import axios from 'axios';
import {useStore} from '@/store.js';
import {parseApi,parseWeb} from "@/func.js"

export default class KeluarService {

 	getUserId(){
		console.log(useStore().login)
		return useStore().login.userId
	}

	getKeluars() {
		let headersList = {
			Accept: "application/json",
			// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
			Authorization: `Bearer ${useStore().token}`,
		};
		let reqOptions = {
			url: parseApi("/keluar/all") ,
			method: "GET",
			headers: headersList,
		};
		return axios(reqOptions).then(res => res.data);
    }

    getPickBarang(){
    	let headersList = {
			Accept: "application/json",
			// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
			Authorization: `Bearer ${useStore().token}`,
		};
		let reqOptions = {
			url: parseApi("/barang") ,
			method: "GET",
			headers: headersList,
		};
		return axios(reqOptions).then(res => res.data);	
    }

    getBarangByBarcode(barcode){
    	let headersList = {
			Accept: "application/json",
			// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
			Authorization: `Bearer ${useStore().token}`,
		};
		let reqOptions = {
			url: parseApi("/barang/barcode/"+barcode) ,
			method: "GET",
			headers: headersList,
		};	
		return axios(reqOptions).then(res => res.data);	
    }

    saveKeluar(Keluar,newMode=true){
    	let headersList = {
			Accept: "application/json",
			// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
			Authorization: `Bearer ${useStore().token}`,
		};
		let reqOptions = {
			url:  parseApi("/keluar") ,
			method: (newMode) ? "POST" : "PUT",
			data: Keluar,
			headers: headersList,
		};
		return axios(reqOptions).then(res => res.data);
    }

    deleteKeluar(id){
		// console.log(id)
    	let headersList = {
			Accept: "application/json",
			// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
			Authorization: `Bearer ${useStore().token}`,
		};
		let reqOptions = {
			url:  parseApi(`/keluar/${id}`) ,
			method: "DELETE",
			headers: headersList,
		};
		
		return axios(reqOptions).then(res => res.data);	
    }



	// parseApi(namespace) {
	// 	return `../api${namespace}`;
	// }

	// parseWeb(namespace){
	// 	return `..${namespace}`;	
	// }
    
	
}