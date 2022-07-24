<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <h5>Users</h5>
                <DataTable
                    :value="users"
                    :paginator="true"
                    class="p-datatable-gridlines"
                    :rows="10"
                    dataKey="id"
                    :rowHover="true"
                    v-model:filters="filters"
                    filterDisplay="menu"
                    :loading="loading"
                    :filters="filters"
                    responsiveLayout="scroll"
                    :globalFilterFields="['name', 'email', 'role']"
                >
                    <template #header>
                        <div
                            class="flex justify-content-between flex-column sm:flex-row"
                        >
                            <Button
                                label="New"
                                icon="pi pi-plus"
                                class="p-button-success mr-2"
                                @click="openNew"
                                ref="open_new"
                               
                            />
                            <span class="p-input-icon-left mb-2">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="filters['global'].value"
                                    placeholder="Keyword Search"
                                    style="width: 100%"
                                />
                            </span>
                        </div>
                    </template>
                    <template #empty> No users found. </template>
                    <template #loading>
                        Loading users data. Please wait.
                    </template>
                    <Column field="name" header="Name" style="min-width: 12rem">
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                        <!-- <template #filter="{filterModel}">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name"/>
                        </template> -->
                    </Column>
                    <Column
                        field="email"
                        header="Email"
                        style="min-width: 12rem"
                    >
                        <template #body="{ data }">
                            <img width="32" src="/images/avatar/nurse.png" />
                            {{ data.email }}
                        </template>
                        <!-- <template #filter="{filterModel}">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name"/>
                        </template> -->
                    </Column>
                    <Column field="role" header="Role" style="min-width: 12rem">
                        <template #body="{ data }">
                            {{ data.role }}
                        </template>
                        <!-- <template #filter="{filterModel}">
                            <InputText type="text" v-model="filterModel.value" class="p-column-filter" placeholder="Search by name"/>
                        </template> -->
                    </Column>
                    <Column headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button
                                icon="pi pi-pencil"
                                class="p-button-rounded p-button-success mr-2"
                                @click="editUser(slotProps.data)"
                            />
                            <Button
                                icon="pi pi-trash"
                                class="p-button-rounded p-button-warning mt-2"
                                
                                @click="confirmDeleteUser(slotProps.data)"
                            />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>
    <Dialog
        v-model:visible="deleteUserDialog"
        :style="{ width: '450px' }"
        header="Confirm"
        :modal="true"
    >
        <div class="flex align-items-center justify-content-center">
            <i
                class="pi pi-exclamation-triangle mr-3"
                style="font-size: 2rem"
            />
            <span v-if="user"
                >Anda yakin menghapus <b>{{ user.email }}</b
                >?</span
            >
        </div>
        <template #footer>
            <Button
                label="No"
                icon="pi pi-times"
                class="p-button-text"
                @click="deleteUserDialog = false"
            />
            <Button
                label="Yes"
                icon="pi pi-check"
                class="p-button-text"
                @click="deleteUser"
            />
        </template>
    </Dialog>

    <Dialog
        v-model:visible="editUserDialog"
        :style="{ width: '450px' }"
        :header="'User Form - ' + user_title"
        :modal="true"
    >
        <!-- <div class="surface-card p-4 shadow-2 border-round w-full lg:w-6"> -->
        <div class="text-center mb-5">
            <img
                src="/images/logo-sicaper.png"
                alt="Image"
                height="40"
                class=""
            />
            <!-- <div class="text-900 text-3xl font-medium mb-3">SICAPER</div> -->
        </div>

        <div>
            <label for="name" class="block text-900 font-medium mb-2"
                >Nama</label
            >
            <InputText
                id="name"
                v-model.trim="user.name"
                type="text"
                class="w-full mb-3"
                :class="{ 'p-invalid': submitted && !user.name }"
            />

            <label for="email1" class="block text-900 font-medium mb-2"
                >Email</label
            >
            <InputText
                id="email1"
                v-model.trim="user.email"
                :disabled="!newMode"
                type="text"
                class="w-full mb-3"
                :class="{ 'p-invalid': submitted && !user.email }"
            />

            <label for="role" class="block text-900 font-medium mb-2"
                >Role</label
            >
            <Dropdown
                v-model="selectedRole"
                :options="roles"
                optionLabel="name"
                optionValue="value"
                placeholder="Role"
            />

            <label for="password1" class="block text-900 font-medium mb-2"
                >Password</label
            >
            <!-- <InputText
                id="password1"
                v-model="user.password1"
                type="password"
                class="w-full mb-3"
                :class="{ 'p-invalid': submitted && (user.password1==undefined) }"
            /> -->

            <Password
                id="password1"
                v-model="user.password1"
                placeholder="Password"
                :toggleMask="true"
                class="w-full mb-3"
                inputClass="w-full"
                inputStyle="padding:1rem"
                :class="{
                    'p-invalid': submitted && !validate(),
                }"
            ></Password>

            <label for="password2" class="block text-900 font-medium mb-2"
                >Confirmed Password</label
            >
            <!-- <InputText
                id="password2"
                v-model="user.password2"
                type="password"
                class="w-full mb-3"
                :class="{ 'p-invalid': submitted && (user.password2==undefined) }"
            /> -->
            <Password
                id="password2"
                v-model="user.password2"
                placeholder="Password"
                :toggleMask="true"
                class="w-full mb-3"
                inputClass="w-full"
                inputStyle="padding:1rem"
                :class="{
                    'p-invalid': submitted && !validate(),
                }"
            ></Password>

            <!-- <div class="flex align-items-center justify-content-between mb-6">
            <div class="flex align-items-center">
                <Checkbox id="rememberme1" :binary="true" v-model="checked" class="mr-2"></Checkbox>
                <label for="rememberme1">Remember me</label>
            </div>
            <a class="font-medium no-underline ml-2 text-blue-500 text-right cursor-pointer">Forgot password?</a>
        </div> -->

            <Button
                label="Save"
                icon="pi pi-user"
                class="w-full"
                @click="saveUser"
            ></Button>
        </div>
        <!-- </div> -->
        <!--  <div class="flex align-items-center justify-content-center">
            <i
                class="pi pi-exclamation-triangle mr-3"
                style="font-size: 2rem"
            />
            <span v-if="product"
                >Anda yakin menghapus <b>{{ user.email }}</b
                >?</span
            >
        </div>
        <template #footer>
            <Button
                label="No"
                icon="pi pi-times"
                class="p-button-text"
                @click="deleteUserDialog = false"
            />
            <Button
                label="Yes"
                icon="pi pi-check"
                class="p-button-text"
                @click="deleteUser"
            />
        </template> -->
    </Dialog>
    <Toast />
</template>

<script setup>
import { ref, onMounted } from "vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import UserService from "../service/UserService";
import { useToast } from "primevue/usetoast";
import {useStore} from "@/store.js"

const toast = useToast();
const users = ref(null);
const user = ref({});
const newMode = ref(false);
const filters = ref(null);
const loading = ref(true);
const deleteUserDialog = ref(false);
const editUserDialog = ref(false);
const user_title = ref("");
const submitted = ref(false);
const roles = ref([
    { name: "Admin", value: "Admin" },
    { name: "user", value: "user" },
]);
const selectedRole = ref('user')

const userService = UserService;

const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    };
};

const clearFilter = () => {
    initFilters();
};

const openNew = () => {
    editUserDialog.value = true;
    submitted.value = false;
    user_title.value = "New";
    newMode.value = true;
    user.value = {};
};
const confirmDeleteUser = (e) => {
    user.value = e
    console.log('del',e)
    deleteUserDialog.value = true;
};

const deleteUser = () => {
  console.log('akan',user.value)
  userService.delete(user.value).then((res)=>{
        toast.add({
                    severity: "success",
                    summary: "User deleted",
                    detail: "User deleted",
                    life: 3000,
                });

         userService.getUsers().then((data) => {
                users.value = data;
                loading.value = false;
            });

        deleteUserDialog.value = false;
        
  })
}

const editUser = (e) => {
    submitted.value = false;
    newMode.value = false;
    user_title.value = "Edit";
    user.value = { ...e };
    editUserDialog.value = true;
    console.log(e);
};

const validate = () => {
    return (
        user.value.name &&
        user.value.email &&
        user.value.password1 != undefined &&
        user.value.password2 != undefined &&
        user.value.password1 == user.value.password2
    );
};

const saveUser = (e) => {
    submitted.value = true;
    
    // console.log(user.value.password1)
    console.log(validate());
    if (validate()) {
        if (newMode.value){
            user.value.role = selectedRole.value
            console.log('nw',user.value)
        }
        userService
            .saveUser(user.value, newMode.value)
            .then((res) => {
                toast.add({
                    severity: "success",
                    summary: "User saved",
                    detail: "User saved",
                    life: 3000,
                });
                console.log(res);
                userService.getUsers().then((data) => {
                    users.value = data;
                    loading.value = false;
                });
                editUserDialog.value = false;
                newMode.value = false;
            })
            .catch((err) => {
                console.log(err);
                toast.add({
                    severity: "error",
                    summary: "User failed to saved",
                    detail: "User failed to saved",
                    life: 3000,
                });
            });
    }
};

initFilters();

onMounted(() => {
    userService.getUsers().then((data) => {
        users.value = data;
        loading.value = false;
    });
});
</script>

<style scoped lang="scss">
@import "../assets/demo/badges.scss";

::v-deep(.p-datatable-frozen-tbody) {
    font-weight: bold;
}

::v-deep(.p-datatable-scrollable .p-frozen-column) {
    font-weight: bold;
}
</style>
