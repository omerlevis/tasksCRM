<template>
    <div>
        <div class="row">

            <div class="col-md-4"  v-for="(task,i) in tasks"  v-bind:key="task.id">

                <div @mouseout="hidebutton(i)" @mouseover="showbutton(i)" class="card card-widget widget-user-2">

                    <div class="widget-user-header bg-warning">

                        {{ task.id }}.<h3 ref="title" contenteditable @focusout="onFocusOut(i)" @focus="onFocus(i)" @input="onInput(task)" v-model="tasks[i].title" class="widget-user-username">{{ task.title }} </h3>
                        <input ref="title" contenteditable @focusout="onFocusOut(i)" @focus="onFocus(i)" @input="onInput(task)" v-model="tasks[i].title" class="widget-user-username">{{ task.title }} </input>
                        <vs-input border v-model="task.title" placeholder="Name" />
                        <p ref="body" contenteditable="true" @input="onInput(task)" v-model="tasks[i].body">{{ task.body }} </p>
                        <p ref="status"  contenteditable="true" @input="onInput(task)" v-model="tasks[i].status">{{ task.status }} </p>
                        <div class="col-5">
                            <button hidden type="button" ref="savebutton" @click="editTasks(task)" class="btn btn-light btn-block">שמור</button>
                        </div>
                        <div class="col-5">
                            <button hidden type="button" ref="deletebutton" @click="deleteTasks(task.id)" class="btn btn-danger btn-block">מחק</button>
                        </div>

                    </div>
                     </div>

            </div>

        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                timestamp:'',
                timestampMonth:0,
                tasks: [],
                task: {
                    id: '',
                    title:'',
                    body:'',
                    status: 0
                },
                edit: false
            };
        },
        created() {
            this.getDate();
            this.fetchTasks();

        },
        methods: {
            hidebutton(i) {

                // this.$refs.savebutton[i].hidden = true;
                // this.$refs.deletebutton[i].hidden = true;

            },
            showbutton(i) {
                // this.$refs.savebutton[i].hidden = false;
                // this.$refs.deletebutton[i].hidden = false;
            },
            onInput(task) {
                console.log(task);
                // console.log(this.$refs.body[task.id].innerText);
                // this.task.title = e.target.title;
                // this.task.body = e.target.body;
                // this.task.status = e.target.status;
                // switch (e.target.id){
                //     case 'title':
                //         this.task.title = e.target.innerText;
                //         break;
                //     case 'body':
                //         this.task.body = e.target.innerText;
                //         break;
                //     case 'status':
                //         this.task.status = e.target.innerText;
                //         break;
                // }
                // console.log(e.target.innerText);
                // console.log(e);
                // console.log(this.task);
            },
            onFocus(i) {
                this.$refs.savebutton[i].hidden = false;
                this.$refs.deletebutton[i].hidden = false;
            },
            onFocusOut(i) {
                this.$refs.savebutton[i].hidden = true;
                this.$refs.deletebutton[i].hidden = true;
            },
            fetchTasks(page_url) {
                let vm = this;
                page_url = page_url || 'api/tasks';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.tasks = res;
                        console.log(vm.tasks);
                    })
                    .catch(err => console.log(err));
            },
            deleteTasks(id) {
                if (confirm('Are You Sure?')) {
                    fetch(`api/budget/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert('Budget Removed');
                            this.fetchBudgets();
                        })
                        .catch(err => console.log(err));
                }
            },
            editTasks() {
                console.log(this.task)
                // Update
                fetch('api/tasks', {
                    method: 'put',
                    body: JSON.stringify(this.task),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res)
                    .then(data => {
                        console.log('data:');
                        console.log(data);
                        this.clearForm();
                        this.fetchTasks();
                    })
                    .catch(err1 => console.log(err1));
            },
            clearForm() {
                this.edit = false;
                this.task.id = null;
                this.task.title = null;
                this.task.body = '';
                this.task.status = 0;
            },
            getDate: function() {
                const today = new Date();
                const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                const dateTime = date +' '+ time;
                this.timestamp = dateTime;
                this.timestampMonth = today.getMonth();
                this.timestampYear = today.getFullYear();
                this.component_month = today.getMonth();
                this.component_year = today.getFullYear();
            }
        }
    };
</script>
