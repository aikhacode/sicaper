<template>
	<div class="layout-footer">
		<img alt="Logo" :src="footerImage()" height="20" class="mr-2" />
		by
		<span class="font-medium ml-2">UPTD Puskesmas Ngujung - fastkrisna</span>
	</div>
</template>

<script>
	export default {
		name: "AppFooter",
		methods: {
			footerImage() {
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