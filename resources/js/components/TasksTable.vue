
<template>
    <div class="center">
        <vs-table
            v-model="selected"
        >
            <template #header>
                <vs-input v-model="search" border placeholder="Search" />
            </template>
            <template #thead>
                <vs-tr>
                    <vs-th>
                        <vs-checkbox
                            :indeterminate="selected.length === tasks.length" v-model="allCheck"
                            @change="selected = $vs.checkAll(selected, tasks)"
                        />
                    </vs-th>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'title')">
                        Title
                    </vs-th>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'body')">
                        Body
                    </vs-th>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'status')">
                        Status
                    </vs-th>
                </vs-tr>
            </template>
            <template #tbody>
                <vs-tr
                    :key="i"
                    v-for="(tr, i) in $vs.getPage($vs.getSearch(tasks, search), page, max)"
                    :data="tr"
                    :is-selected="!!selected.includes(tr)"
                    not-click-selected
                    open-expand-only-td
                >
                    <vs-td checkbox>
                        <vs-checkbox :val="tr" v-model="selected" />
                    </vs-td>
                    <vs-td edit @click="edit = tr, editProp = 'name', editActive = true">
                        {{ tr.title }}
                    </vs-td>
                    <vs-td>
                        {{ tr.body }}
                    </vs-td>
                    <vs-td>
                        {{ tr.status }}
                    </vs-td>

                    <template #expand>
                        <div class="con-content">
                            <div>
                                <vs-avatar>
                                    <img :src="`/avatars/avatar-${i + 1}.png`" alt="">
                                </vs-avatar>
                                <p>
                                    {{ tr.title }}
                                </p>
                            </div>
                            <div>
                                <vs-button flat icon>
                                    <i class='bx bx-lock-open-alt' ></i>
                                </vs-button>
                                <vs-button flat icon>
                                    Send Email
                                </vs-button>
                                <vs-button border danger>
                                    Remove User
                                </vs-button>
                            </div>
                        </div>
                    </template>
                </vs-tr>
            </template>
            <template #footer>
                <vs-pagination v-model="page" :length="$vs.getLength($vs.getSearch(tasks, search), max)" />
            </template>
        </vs-table>

        <vs-dialog v-model="editActive">
            <template #header>
                Change Prop {{ editProp }}
            </template>
            <vs-input @keypress.enter="editActive = false" v-if="editProp == 'email'" v-model="edit[editProp]" />
            <vs-select @change="editActive = false" block v-if="editProp == 'name'" placeholder="Select" v-model="edit[editProp]">
                <vs-option label="Vuesax" value="Vuesax">
                    Vuesax
                </vs-option>
                <vs-option label="Vue" value="Vuejs">
                    Vue
                </vs-option>
                <vs-option label="Javascript" value="Javascript">
                    Javascript
                </vs-option>
                <vs-option disabled label="Sass" value="Sass">
                    Sass
                </vs-option>
                <vs-option label="Typescript" value="Typescript">
                    Typescript
                </vs-option>
                <vs-option label="Webpack" value="Webpack">
                    Webpack
                </vs-option>
                <vs-option label="Nodejs" value="Nodejs">
                    Nodejs
                </vs-option>
            </vs-select>
        </vs-dialog>
    </div>
</template>
<script>

import Vue from 'vue'
import Vuesax from 'vuesax'
// import { vsButton, vsSelect, vsPopup } from 'vuesax'
import 'vuesax/dist/vuesax.css' //Vuesax styles
Vue.use(Vuesax, {
    // options here
})
export default {
    data:() => ({
        editActive: false,
        edit: null,
        editProp: {},
        search: '',
        allCheck: false,
        page: 1,
        max: 5,
        active: 0,
        selected: [],
        tasks: [],
        task: {
            id: '',
            title:'',
            body:'',
            status: 0
        },
        users: [
            {
                "id": 1,
                "name": "Leanne Graham",
                "username": "Bret",
                "email": "Sincere@april.biz",
                "website": "hildegard.org",
            }
       ]
    }),
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
}
</script>



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
