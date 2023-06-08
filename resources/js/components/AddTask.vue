<template>
    <div class="col-sm-3">
        <vs-alert color="#7d33ff">
            <template #title>
                Added task
            </template>
   <form @submit.prevent="addTask" class="py-5">
        <div>
            <div class="form-group">
                    <vs-input
                        color="rgb(59,222,200)"
                        v-model="task.title"
                        placeholder="Title" />
            </div>
                <div class="form-group">
                    <textarea rows="4" cols="50" type="textarea" class="form-control" placeholder="Enter text here..." v-model="task.body">
                            </textarea>
                </div>

            <div class="py-3 form-group">
            <vs-input
                type="date"
                v-model="task.destination"
                label="Destination Date"
            />
            </div>
       <div class="row">

                <vs-button
                    danger
                    border
                    @click="clearForm"
                >
                    <i class="clear_all"></i> clear
                </vs-button>
               <vs-button
                   type="submit"
                   color="rgb(59,222,200)"
                   gradient
               >
                   <i class="bx bxs-purchase-tag"></i> Save
               </vs-button>


        </div>
        </div>
   </form>
        </vs-alert>
</div>
</template>

<script>
import Vue from 'vue'
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css' //Vuesax styles
Vue.use(Vuesax, {
    // options here
})

    export default {
        data() {
            return {
                task: {
                    id: '',
                    title:'',
                    body:'',
                    status:0,
                    destination:null
                }
            };
        },
        methods: {
            addTask() {
                fetch('api/AddTask', {
                    method: 'post',
                    body: JSON.stringify(this.task),
                    headers: {
                        'content-type': 'application/json'
                    }
                }).then(res => res)
                    .then(data => {
                        console.log("adddadada");
                        console.log(data);
                        this.clearForm();
                        //alert('task Added');
                        window.location.reload();

                    })
                    .catch(err => console.log(err));
            },
            clearForm() {
                this.task.id = null;
                this.task.title = '';
                this.task.body = '';
                this.task.status = 0;
                this.task.destination = null;
            },
        }
    };
</script>
