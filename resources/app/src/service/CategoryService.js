import axios from 'axios';
import {useStore} from '@/store.js';
import {parseApi,parseWeb} from "@/func.js"

export default class CategoryService {
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

    getCategories() {
 		return axios(this.reqOptions('GET','/categories')).then(res => res.data);
	}

	saveCategory(newMode=true,id,data){
		let api = (newMode) ? '/categories' : `/categories/${id}`
		return axios({
			url: parseApi(api) ,
			method: (newMode) ? "POST" : "PUT",
			data:data,
			headers: {
				Accept: "application/json",
				// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
				Authorization: `Bearer ${useStore().token}`,
			},
		}).then(res => res.data);
	}

	
	// parseApi(namespace) {
	// 	return `../api${namespace}`;
	// }

	// parseWeb(namespace){
	// 	return `..${namespace}`;	
	// }
    
	
}