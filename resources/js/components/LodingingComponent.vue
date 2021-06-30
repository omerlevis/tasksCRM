
<template>
    <vs-button @click="openLoading">Open Loading</vs-button>
</template>
<script>
export default {
    methods: {
        openLoading() {
            const loading = this.$vs.loading()
            setTimeout(() => {
                loading.close()
            }, 3000)
        }
    }
}
</script>
