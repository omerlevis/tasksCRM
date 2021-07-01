<template>
    <div class="col-9">
        <vs-table
            v-model="selected"
        >
            <template #header>
                <vs-input v-model="search" border placeholder="Search" />
            </template>
            <template #thead>
                <vs-tr>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'title')">
                        Title
                    </vs-th>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'body')">
                        Body
                    </vs-th>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'status')">
                        Status
                    </vs-th>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'destination')">
                        Destination Date
                    </vs-th>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'created_at')">
                        Created Date
                    </vs-th>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'id')">
                        Id
                    </vs-th>
                    <vs-th sort @click="tasks = $vs.sortData($event ,tasks, 'id')">
                        Action
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

                    <vs-td edit @click="edit = tr, editProp = 'title', editActive = true">
                        {{ tr.title }}
                    </vs-td>
                    <vs-td edit @click="edit = tr, editProp = 'body', editActive = true">
                        {{ tr.body }}
                    </vs-td>
                    <vs-td edit @click="edit = tr, editProp = 'status', editActive = true">
                        {{ optins[tr.status] }}
                    </vs-td>
                    <vs-td edit @click="edit = tr, editProp = 'destination', editActive = true">
                        {{ tr.destination }}
                    </vs-td>
                    <vs-td >
                        {{ tr.created_at }}
                    </vs-td>
                    <vs-td>
                        {{ tr.id }}
                    </vs-td>
                    <vs-td>
                        click hare to open!
                    </vs-td>

                    <template #expand>
                        <div class="con-content">
                            <div>
                                <vs-button @click="deleteTasks(tr.id,tr.destination)" border danger>
                                    Remove Task
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
            <vs-input @keypress.enter="editTasks"  v-if="editProp == 'title'" v-model="edit[editProp]" />
            <vs-input @keypress.enter="editTasks" v-if="editProp == 'body'" v-model="edit[editProp]" />
            <vs-select @change="editTasks" block  v-if="editProp == 'status'" v-model="edit[editProp]">
                <vs-option v-for="(val, i) in optins" :value="i" v-bind:key="val" placholder="">
                    {{ val }}
                </vs-option>
            </vs-select>
            <vs-input
                type="date"
                @keypress.enter="editTasks"
                v-if="editProp == 'destination'"
                v-model="edit[editProp]"
                label="Destination Date"
            />
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
        max: 100,
        active: 0,
        selected: [],
        optins:['open','process','done'],
        tasks: [],
        task: {
            id: '',
            title:'',
            body:'',
            status: 0,
            created_at: null,
            destination:null
        },
    }),
    created() {
        this.fetchTasks();

    },
    methods: {
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
        deleteTasks(id,destination) {
            const check_date = this.getDate(destination)
            if (check_date)
            {
                if (confirm('Are You Sure?')) {
                    fetch(`api/task/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert('Budget Removed');
                            this.fetchTasks();
                        })
                        .catch(err => console.log(err));
                }
            }else
            {
                alert('The date of destination bigger then 6! cennot remove!');
            }

        },
        editTasks() {
            this.editActive=false
            console.log(this.task)
            // Update
            fetch('api/task', {
                method: 'put',
                body: JSON.stringify(this.edit),
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
        getDate: function(des = null) {
            const today = new Date();
            const desday = new Date(des);
            const datdiff = desday.getDate() - today.getDate();
            console.log(datdiff);
            if (desday.getMonth() > today.getMonth())
            {
                return false
                console.log('false');
                console.log(datdiff);
            }else if(datdiff < 6)
            {
                return true
                console.log('true');
                console.log(datdiff);
            }else
            {
                return false
                console.log('false');
                console.log(datdiff);
            }
        }
    }
}
</script>
