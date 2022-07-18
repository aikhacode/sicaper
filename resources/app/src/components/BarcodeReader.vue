<template>
	<div class="grid">
		<div class="col-12">
			<div class="card">
				<StreamBarcodeReader
      @decode="onDecode"
      
    ></StreamBarcodeReader>
			</div>
		</div>
	</div>
</template>

<script setup>
import { StreamBarcodeReader } from "vue-barcode-reader";
import router from "@/router.js"

const onDecode = (e) =>{
	router.go(-1)   
}


</script>