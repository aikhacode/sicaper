import axios from "axios";
import { useStore } from "@/store.js";
import { parseApi, parseWeb } from "@/func.js";

export default class MasukService {
    //    getMasukCategory() {
    //    	let headersList = {
    // 		Accept: "application/json",
    // 		// "User-Agent": "Thunder Client (https://www.thunderclient.com)",
    // 		Authorization: `Bearer ${useStore().token}`,
    // 	};
    // 	let reqOptions = {
    // 		url: parseApi("/masuk/category/all") ,
    // 		method: "GET",
    // 		headers: headersList,
    // 	};
    // 	return axios(reqOptions).then(res => res.data);
    // }
    getUserId() {
        console.log(useStore().login);
        return useStore().login.userId;
    }

    async getBarangId(subId) {
        let headersList = {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        };
        let reqOptions = {
            url: parseApi(`/barang/search/subid/${subId}`),
            method: "GET",
            headers: headersList,
        };
        return axios(reqOptions).then((res) => res.data);
    }

    getMasuks() {
        let headersList = {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        };
        let reqOptions = {
            url: parseApi("/masuk/all"),
            method: "GET",
            headers: headersList,
        };
        return axios(reqOptions).then((res) => res.data);
    }

    getPickBarang() {
        let headersList = {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        };
        let reqOptions = {
            url: parseApi("/barang?all=1"),
            method: "GET",
            headers: headersList,
        };
        return axios(reqOptions).then((res) => res.data);
    }

    getPickBarangStokAda() {
        let headersList = {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        };
        let reqOptions = {
            url: parseApi("/barang"),
            method: "GET",
            headers: headersList,
        };
        return axios(reqOptions).then((res) => res.data);
    }

    getBarangByBarcode(barcode) {
        let headersList = {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        };
        let reqOptions = {
            url: parseApi("/barang/barcode/" + barcode),
            method: "GET",
            headers: headersList,
        };
        return axios(reqOptions).then((res) => res.data);
    }

    saveMasuk(Masuk, newMode = true) {
        let headersList = {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        };
        let reqOptions = {
            url: parseApi("/masuk"),
            method: newMode ? "POST" : "PUT",
            data: Masuk,
            headers: headersList,
        };
        return axios(reqOptions).then((res) => res.data);
    }

    updateBarang(barang) {
        let headersList = {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        };
        let reqOptions = {
            url: parseApi("/barang"),
            method: "PUT",
            data: barang,
            headers: headersList,
        };
        return axios(reqOptions).then((res) => res.data);
    }

    saveHargaBaru(barang) {
        let headersList = {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        };
        let reqOptions = {
            url: parseApi("/barang"),
            method: "POST",
            data: barang,
            headers: headersList,
        };
        return axios(reqOptions).then((res) => res.data);
    }

    deleteMasuk(id) {
        // console.log(id)
        let headersList = {
            Accept: "application/json",
            // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
            Authorization: `Bearer ${useStore().token}`,
        };
        let reqOptions = {
            url: parseApi(`/masuk/${id}`),
            method: "DELETE",
            headers: headersList,
        };

        return axios(reqOptions).then((res) => res.data);
    }

    // parseApi(namespace) {
    // 	return `../api${namespace}`;
    // }

    // parseWeb(namespace){
    // 	return `..${namespace}`;
    // }
}
