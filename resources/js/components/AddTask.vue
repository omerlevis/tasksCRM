<template>
    <div>
<!--        <h2>תזרים</h2>-->
   <form @submit.prevent="addTask" class="mb-3">
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <input  class="form-control" placeholder="name" v-model="task.title">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <textarea rows="4" cols="50" type="textarea" class="form-control" placeholder="Enter text here..." v-model="task.body">
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
                task: {
                    id: '',
                    title:'',
                    body:''
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
                        // alert('task Added');
                        // window.location.reload();

                    })
                    .catch(err => console.log(err));
            },
            clearForm() {
                this.task.id = null;
                this.task.title = '';
                this.task.body = '';
            },
        }
    };
</script>
