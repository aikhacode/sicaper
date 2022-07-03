import axios from 'axios';
import {useStore} from '@/store.js';

export default class BarangService {

    getBarangCategory() {
		return axios(this.parseApi('/barang/category')).then(res => res.data);
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

	parseApi(namespace) {
		return `${location.protocol}//${location.hostname}/api${namespace}`;
	}
    
	
}