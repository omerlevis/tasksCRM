
<template>
    <div >

        <vs-input border warn type="date" icon-after v-model="value3" label-placeholder="Date">
        </vs-input>

    </div>
</template>

<script>
import vsButton from 'vuesax'
import Vue from 'vue'
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css' //Vuesax styles
Vue.use(Vuesax, {
    // options here
})
Vue.use(vsButton)
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data:() => ({
            value7: '',
            value3: '',
        })
    }
</script>
