import { createRouter, createWebHashHistory } from "vue-router";
import App from "./App.vue";
import { useStore } from "./store.js";

import DataBarang from "./pages/DataBarang.vue";
// import StokMasuk from "./pages/StokMasuk.vue";
import PreviewStok from "./pages/PreviewStok.vue";

const routes = [
    {
        path: "/",
        name: "app",
        component: App,
        children: [
            {
                path: "",
                name: "hero",
                component: () => import("./pages/Hero.vue"),
            },
            {
                path: "/dashboard",
                name: "dashboard",
                component: () => import("./components/Dashboard.vue"),
                meta: { requiresAuth: true },
            },
            // {
            //     path: "/history",
            //     name: "history",
            //     component: () => import("./components/History.vue"),
            //     meta: { requiresAuth: true },
            // },
            {
                path: "/data-user",
                name: "datauser",
                component: () => import("./pages/DataUser.vue"),
                meta: { requiresAuth: true },
            },
            {
                path: "/data-barang",
                name: "databarang",
                // component: () => import("./pages/DataBarang.vue"),
                component: DataBarang,
                meta: { requiresAuth: true },
            },
            {
                path: "/readbarcode",
                name: "readbarcode",
                component: () => import("./components/BarcodeReader.vue"),
                meta: { requiresAuth: true },
            },
            {
                path: "/stok-masuk",
                name: "stokmasuk",
                component: () => import("./pages/StokMasuk.vue"),
                // component: StokMasuk,
                meta: { requiresAuth: true },
            },
            {
                path: "/stok-keluar",
                name: "stokkeluar",
                component: () => import("./pages/StokKeluar.vue"),
                meta: { requiresAuth: true },
            },
            {
                path: "/preview/stok/rincian/:id",
                name: "previewstokrincian",
                // component: () => import("./pages/PreviewStok.vue"),
                component: PreviewStok,
                meta: { requiresAuth: true },
                props: true,
            },
            // {
            //     path: "/stok-opname",
            //     name: "stokopname",
            //     component: () => import("./pages/StokOpname.vue"),
            //     meta: { requiresAuth: true },
            // },
        ],
    },
    {
        path: "/login",
        name: "login",
        component: () => import("./pages/Login.vue"),
    },
    {
        path: "/logout",
        name: "logout",
        component: () => import("./pages/Logout.vue"),
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

router.beforeEach((to, from) => {
    const auth = useStore();

    if (to.meta.requiresAuth && !auth.isLoggedIn()) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        return {
            path: "/login",
            // save the location we were at to come back later
            query: { redirect: to.fullPath },
        };
    }
});

router.beforeEach((to, from, next) => {
    window.scrollTo(0, 0);
    next();
});

export default router;
