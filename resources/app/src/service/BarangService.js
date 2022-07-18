import axios from 'axios';
import {useStore} from '@/store.js';

export default class BarangService {

    getBarangCategory() {
    	let headersList = {
			Accept: "application/json",
			// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
			Authorization: `Bearer ${useStore().token}`,
		};
		let reqOptions = {
			url: this.parseApi("/barang/category/all") ,
			method: "GET",
			headers: headersList,
		};
		return axios(reqOptions).then(res => res.data);
	}

	getBarangs() {
		let headersList = {
			Accept: "application/json",
			// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
			Authorization: `Bearer ${useStore().token}`,
		};
		let reqOptions = {
			url: this.parseApi("/barang") ,
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
			url:  this.parseApi("/barang") ,
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
			url:  this.parseApi(`/barang/${id}`) ,
			method: "DELETE",
			headers: headersList,
		};
		
		return axios(reqOptions).then(res => res.data);	
    }



	parseApi(namespace) {
		return `${location.protocol}//${location.hostname}/api${namespace}`;
	}

	parseWeb(namespace){
		return `${location.protocol}//${location.hostname}${namespace}`;	
	}
    
	
}