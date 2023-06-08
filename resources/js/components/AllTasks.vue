<template>
    <div>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchBudgets(pagination.prev_page_url)">Previous</a></li>

        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchBudgets(pagination.next_page_url)">Next</a></li>
    </ul>
</nav>
<div class="row">
<div class="col-5 card m-3 "  v-for="(budget,i) in tasks" v-bind:key="task.id" >
    <div >
<!--        <div class="row card-header" v-on:keyup.tab="editBudget(task)">-->
        <div class="row card-header" >
        <div class="col-4" >
            <div class="form-group" >
            <p contenteditable="true" ref="bval" @keydown="updateval(task,i)" @keydown.13.prevent="editBudget(task,i)" v-model="task.task_value">{{ task.task_value }} </p>

                <i class="fad fa-shekel-sign"></i>
            </div>
        </div>
        <div class="col-8">
            <div class="form-group">
                <h5><p contenteditable="true" ref="bdes" @keydown="updateval(task,i)" @keydown.13.prevent="editBudget(task,i)" v-model="task.task_des">{{ task.task_des }}</p></h5>
            </div>
        </div>

    </div>
        <div class="row card-body">
        <div class="col-4">
            <div class="form-group">
                <label>קטגוריה</label>
                    <select   @change="editBudget(task,i)" v-model="task.category_id" name="category_id" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" >
                        <option value="0"></option>
                        <option v-for="category in categorys" :value=category.id >{{ category.name }}</option>
                    </select>
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <label>חודש</label>
                <select id="month" name="month" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" v-model="task.month">
                    <option v-for="(month,index) in statuses" :key="index" :value="index">{{month}}</option>
                </select>
            </div>
            <!-- /.form-group -->
        </div>
            <div class="col-3 pull-left">
                <div class="form-group">
                    <label>סוג תזרים</label>
                    <select   name="incoming_edit" class="form-control input-sm select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" v-model="task.incoming">
                        <option value="0">הוצאה</option>
                        <option value="1">הכנסה</option>
                    </select>
                </div>
            </div>
        </div>

</div>
</div>
<!--    <h3>{{ task.task_value }}</h3>-->
<!--    <p>{{ task.task_des }}</p>-->
<!--    <hr>-->
<!--    <button @click="editBudget(task)" class="btn btn-warning mb-2">Edit</button>-->
<!--    <button @click="deleteBudget(task.id)" class="btn btn-danger">Delete</button>-->
</div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                statuses:['open','process','done'],
                timestamp:'',
                timestampDays:0,
                categorys: [],
                category: {
                    id: '',
                    name:''
                },
                tasks: [],
                task: {
                    id: '',
                    task_des:'',
                    task_value:'',
                    incoming:0,
                    category_id:'',
                    month:0
                },
                task_id: '',
                pagination: {},
                edit: false
            };
        },
        created() {
            this.fetchBudgets();
            this.fetchTyps();
            this.getMounth();
            //console.log(this.task.month);
        },
        methods: {
            fetchBudgets(page_url) {

                let vm = this;
                page_url = page_url || 'api/tasks';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.tasks = res;
                        console.log(this.tasks);
                        vm.makePagination(res);
                    })
                    .catch(err => console.log(err));
            },
            fetchTyps() {
                fetch('api/categorys')
                    .then(res => res.json())
                    .then(res => {
                        // console.log('typ')
                        // console.log(res)
                        this.categorys = res;
                    })
                    .catch(err => console.log(err));
            },
            makePagination(res) {
                let pagination = {
                    current_page: res.current_page,
                    last_page: res.last_page,
                    next_page_url: res.next_page_url,
                    prev_page_url: res.prev_page_url
                };
                this.pagination = pagination;
            },
            deleteBudget(id) {
                if (confirm('Are You Sure?')) {
                    fetch(`api/task/${id}`, {
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
            addBudget() {
                    // Add
                    fetch('api/task', {
                        method: 'post',
                        body: JSON.stringify(this.task),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res)
                        .then(data => {
                            console.log("adddadada");
                            console.log(data);
                            this.clearForm();
                            //alert('Article Added');
                            this.fetchBudgets();
                        })
                        .catch(err => console.log(err));

            },
            updateval(task,i) {
                console.log('task:');
                console.log(task);
                console.log('index:');
                console.log(i);
                console.log(this.$refs.bval[i].innerText);
                console.log(this.$refs.bdes[i].innerText);

                this.task.id = task.id;
                this.task.task_id = task.id;
                this.task.task_value = this.$refs.bval[i].innerText;
                this.task.task_des = this.$refs.bdes[i].innerText;
                this.task.incoming = task.incoming;
                this.task.category_id = task.category_id;
                this.task.month = task.month;
            },
            editBudget(task,i) {
                console.log('task:');
                console.log(task);
                console.log('index:');
                console.log(i);
                console.log(this.$refs.bval);
                console.log(this.$refs.bdes);
                this.edit = true;
                this.task.id = task.id;
                this.task.task_id = task.id;
                this.task.task_value = this.$refs.bval[i].innerText;
                this.task.task_des = this.$refs.bdes[i].innerText;
                this.task.incoming = task.incoming;
                this.task.category_id = task.category_id;
                this.task.month = task.month;

                // Update
                fetch('api/task', {
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
                        this.fetchBudgets();
                    })
                    .catch(err1 => console.log(err1));
            },
            clearForm() {
                this.edit = false;
                this.task.id = null;
                this.task.task_id = null;
                this.task.task_des = '';
                this.task.task_value = '';
            },
            getMounth: function() {
                const today = new Date();
                const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                const dateTime = date +' '+ time;
                this.timestamp = dateTime;
                this.timestampDays = today.getDay();
            }
        }
    };
</script>
