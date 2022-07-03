<template>
	<div class="layout-topbar">
		<router-link to="/" class="layout-topbar-logo">
			
					<img alt="Logo" :src="topbarImage()" />
					<span>SIPArDi</span>
				
			
		</router-link>

		<button class="p-link layout-menu-button layout-topbar-button" @click="onMenuToggle">
			<i class="pi pi-bars"></i>
		</button>

		<button class="p-link layout-topbar-menu-button layout-topbar-button"
			v-styleclass="{ selector: '@next', enterClass: 'hidden', enterActiveClass: 'scalein', 
			leaveToClass: 'hidden', leaveActiveClass: 'fadeout', hideOnOutsideClick: true}">
			<i class="pi pi-ellipsis-v"></i>
		</button>
		<ul class="layout-topbar-menu hidden lg:flex origin-top">
			<!-- 
			<li>
				<button class="p-link layout-topbar-button">
					<i class="pi pi-calendar"></i>
					<span>Events</span>
				</button>
			</li>
			<li>
				<button class="p-link layout-topbar-button">
					<i class="pi pi-cog"></i>
					<span>Settings</span>
				</button>
			</li> 
			-->
			<li>
				<router-link class="p-link layout-topbar-button" :to="loginText().url">
					<i class="pi pi-user"></i>
					<span>{{loginText().text}}</span>
				</router-link>
			</li>
		</ul>
	</div>
</template>

<script>
	import {useStore} from './store.js'

export default {

    methods: {
    	loginText(){
    		const store=useStore()
    		return (store.isLoggedIn()) ? {text:'Logout',url:'/logout'} : {text:'Login',url:'/login'} 
    	},
        onMenuToggle(event) {
            this.$emit('menu-toggle', event);
        },
		onTopbarMenuToggle(event) {
            this.$emit('topbar-menu-toggle', event);
        },
		topbarImage() {
			return this.$appState.darkTheme ? 'images/logo-sipardi.png' : 'images/logo-sipardi.png';
		}
    },
	computed: {
		darkTheme() {
			return this.$appState.darkTheme;
		}
	}
}
</script>
<style scoped>
	.text-small{

		font-size: small;
	}
	</style>