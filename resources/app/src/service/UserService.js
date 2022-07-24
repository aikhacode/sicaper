import axios from 'axios';
import {useStore} from '@/store.js';
import {parseApi,parseWeb} from "@/func.js"

export default new class UserService {
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

    getUsers() {
 		return axios(this.reqOptions('GET','/bro')).then(res => res.data);
	}

	delete(user){
		return axios({
			url: parseApi('/bro/delete/'+user.email) ,
			method: 'DELETE',
			
			headers: {
				Accept: "application/json",
				// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
				Authorization: `Bearer ${useStore().token}`,
			},

		}).then(res => res.data);
	}

	saveUser(user,newMode=false){
		console.log(user)
		return axios({
			url: parseApi('/bro/update') ,
			method: 'POST',
			data:{
				name:user.name,
				email:user.email,
				password:user.password1,
				password_confirmation: user.password2,
				role:user.role,
				mode:(newMode) ? 'new' : 'old',
			},
			headers: {
				Accept: "application/json",
				// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
				Authorization: `Bearer ${useStore().token}`,
			},

		}).then(res => res.data);
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

	
	   
	
}