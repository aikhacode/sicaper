import axios from 'axios';
import {useStore} from '@/store.js';
import {parseApi,parseWeb} from "@/func.js"

export default class BarangService {
	reqOptions(methodRequest,namespace){
		return {
			url: parseApi(namespace) ,
			method: methodRequest,
			headers: {
				Accept: "application/json",
				// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
				Authorization: `Bearer ${useStore().token}`,
			},
		}
	}

    getBarangCategory() {
  //   	let headersList = {
		// 	Accept: "application/json",
		// 	// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
		// 	Authorization: `Bearer ${useStore().token}`,
		// };
		// let reqOptions = {
		// 	url: parseApi("/barang/category/all") ,
		// 	method: "GET",
		// 	headers: headersList,
		// };
		return axios(this.reqOptions('GET','/categories/category')).then(res => res.data);
	}

	getBarangByCategory(category){
		
		return axios(this.reqOptions('GET',`/categories/barang/${category}`)).then(res => res.data);	
	}

	getBarangs() {
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

    saveBarang(barang,newMode=true){
    	let headersList = {
			Accept: "application/json",
			// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
			Authorization: `Bearer ${useStore().token}`,
		};
		let reqOptions = {
			url:  parseApi("/barang") ,
			method: (newMode) ? "POST" : "PUT",
			data: barang,
			headers: headersList,
		};
		return axios(reqOptions).then(res => res.data);
    }

    deleteBarang(id){
		// console.log(id)
    	let headersList = {
			Accept: "application/json",
			// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
			Authorization: `Bearer ${useStore().token}`,
		};
		let reqOptions = {
			url:  parseApi(`/barang/${id}`) ,
			method: "DELETE",
			headers: headersList,
		};
		
		return axios(reqOptions).then(res => res.data);	
    }



	// parseApi(namespace) {
	// 	return `../api${namespace}`;
	// 	// return `api${namespace}`;
	// }

	// parseWeb(namespace){
	// 	return `..${namespace}`;	
	// }
    
	
}