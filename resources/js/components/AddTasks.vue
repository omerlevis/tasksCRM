<template>
    <div>
<!--        <h2>תזרים</h2>-->
   <form @submit.prevent="addTasks" class="mb-3">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <input  class="form-control" placeholder="name" v-model="tasks.title">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <textarea rows="4" cols="50" type="textarea" class="form-control" placeholder="Enter text here..." v-model="tasks.body">
                            </textarea>
                </div>
            </div>
            <div class="col-2">

        </div>
       <div class="row">
            <div class="col-5">
                <button type="submit" class="btn btn-light btn-block">שמור</button>
            </div>
            <div class="col-5">
                <button @click="clearForm()" class="btn btn-danger btn-block">נקה טופס</button>
            </div>
        </div>
        </div>
   </form>

</div>
</template>

<script>
    export default {
        data() {
            return {
                tasks: {
                    id: '',
                    title:'',
                    body:''
                }
            };
        },
        methods: {
            addTasks() {
                console.log(this.tasks);

            },
            clearForm() {
                this.tasks.id = null;
                this.tasks.title = '';
                this.tasks.body = '';
            },
        }
    };
</script>
