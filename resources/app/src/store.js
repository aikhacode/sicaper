import { defineStore } from "pinia";
import axios from "axios";
import {parseApi} from "@/func.js"
// useStore could be anything like useUser, useCart
// the first argument is a unique id of the store across your application
// login api get data : {
//           role: String .....
//}
export const useStore = defineStore("main", {
    state: () => {
        return {
            authenticated: false,
            token: "",
            login: {
                userName: "",
                password: "",
                userId:"",
                email:"",
                data: {
                    role: "Admin",
                },
            },
            barang: {
                count: 0,
                data: [],
            },
            stok: {
                masuk: {
                    count: 0,
                },
                keluar: {
                    count: 0,
                },
            },
            mail: {
                inbox: {
                    count: 0,
                },
                outbox: {
                    count: 0,
                },
            },
            globalEvent: {
                newInputBarang:false
            },
            previewstok:{},
        };
    },
    actions: {
        isLoggedIn() {
            return this.authenticated;
        },
        async getPegawai() {
            let api = this.parseApi();
            let headersList = {
                Accept: "application/json",
                // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
                Authorization: `Bearer ${this.token}`,
            };
            let reqOptions = {
                url: this.parseApi() + "/pegawai",
                method: "GET",
                headers: headersList,
            };

            try {
                let res = await axios.request(reqOptions);
                // console.log(res.data);
                this.pegawai.count = res.data.length;
                this.pegawai.data = res.data;
                return {
                    data: res.data,
                    count: res.data.length,
                };
            } catch (err) {
                console.log(err.response.status);
                return false;
            }
        },
        async doLogin(obj) {
            let api = this.parseApi();

            try {
                let res = await axios.post(api + "/login", {
                    email: obj.email,
                    password: obj.password,
                });
                console.log(res.data);
                this.authenticated = true;
                this.token = res.data.token;
                this.login.userName = res.data.user.name;
                this.login.email = res.data.user.email;
                this.login.userId = res.data.user.id;
                this.login.data.role = res.data.user.role;
            } catch (err) {
                console.log(err.response.status);
                this.authenticated = false;
            }

            return this.authenticated;
        },
        async doLogout() {
            // let res = await axios.get('')
            let api = this.parseApi();
            try {
                let headersList = {
                    Accept: "application/json",
                    // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
                    Authorization: `Bearer ${this.token}`,
                };

                let reqOptions = {
                    url: this.parseApi() + "/logout",
                    method: "POST",
                    headers: headersList,
                };

                let res = await axios.request(reqOptions);

                this.token = "";
                this.login.userName = "";
                this.login.email = "";
                this.login.userId ="";
                this.authenticated = false;
            } catch (err) {}

            return !this.authenticated;
        },
        parseApi() {
            // return `${location.protocol}//${location.hostname}/api`;
            return parseApi();
        },
        async refreshDashboard(){
              let api = this.parseApi();
            
                let headersList = {
                    Accept: "application/json",
                    // "User-Agent": "Thunder Client (https://www.thunderclient.com)",
                    Authorization: `Bearer ${this.token}`,
                };

                let reqOptions = {
                    url: this.parseApi() + "/dashboard",
                    method: "GET",
                    headers: headersList,
                };

                return axios.request(reqOptions).then((res) => {
                    this.barang.count = res.data.barang.count
                    this.stok.masuk.count = res.data.stok.masuk.count
                    this.stok.keluar.count = res.data.stok.keluar.count
                });
        }

    },
});
