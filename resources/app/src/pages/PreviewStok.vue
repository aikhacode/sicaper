<template>
	<section v-html="html" />
</template>

<script>
	import axios from "axios"
	import {parseWeb} from "@/func.js"
export default {
	data() {
		return {
			html:null
		};
	},
	mounted(){
		fetch(parseWeb('/preview/rincianstok?start=2022-07-01&end=2022-07-24'))
		.then((res)=>{
			this.html = res.text()
		})
	}
};
</script>
