<template>
    <div>
        <h3>Tasks :</h3>
        <!-- <FilterComponent
            :today="today"
            :start_date="start_date"
            :end_date="end_date"
            :handleToday="handleToday"
            :handleStart="handleStart"
            :handleEnd="handleEnd"
        /> -->
        <DateFilter
            :date="date"
            :handleDate="handleDate"
        />
        <div class="tasks-div" v-if="data.length > 0">
            <div class="task-card" v-for="(task, key) in data" v-bind:key="key">
                <div class="uk-grid-match" uk-grid>
                    <div class="uk-width-2-3@s">
                        {{ task.task }}
                    </div>
                    <div class="uk-width-1-3 uk-text-right">
                        <div class="uk-inline">
                            <button class="move-button" title="Move to today" v-if="task.is_today == false" v-on:click="moveTask(task.id)"><i class="fa fa-arrow-circle-right"></i></button>
                            <button class="status-button" v-bind:class="task.status">
                                <span v-if="task.status == 'todo'">Todo</span>
                                <span v-else-if="task.status == 'in_progress'">In Progress</span>
                                <span v-else-if="task.status == 'finished'">Finished</span>
                            </button>
                            <div uk-dropdown="mode: hover" class="status-dropdown">
                                <ul class="uk-nav uk-dropdown-nav">
                                    <li><a href="javascript:void(0);" v-on:click="updateStatus(task.id, 'todo')">Todo</a></li>
                                    <li><a href="javascript:void(0);" v-on:click="updateStatus(task.id, 'in_progress')">In Progress</a></li>
                                    <li><a href="javascript:void(0);" v-on:click="updateStatus(task.id, 'finished')">Finished</a></li>
                                </ul>
                            </div>
                            <button class="delete-button" v-on:click="deleteTask(task.id)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="task-card">
            <div class="uk-inline uk-width-1-1">
                <button class="add-button uk-form-icon uk-form-icon-flip" v-on:click="createTask">
                    <i class="fa fa-plus"></i>
                </button>
                <input type="text" class="uk-input task-input" placeholder="Add Task..." v-model="task" />
            </div>
        </div>
    </div>
</template>

<script>
    import Task from '../../models/task'
    import DateFilter from '../DateFilter.vue'

    export default {
        name: 'TaskComponent',
        components: {
            DateFilter
        },
        mounted() {
            this.getToday()
            this.getTasks()
        },
        data() {
            return {
                today: true,
                start_date: "",
                end_date: "",
                data: [],
                task: "",
                date: ""
            }
        },
        methods: {
            getToday() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                this.date = yyyy + '-' + mm + '-' + dd;
            },
            handleDate(e) {
                this.date = e.target.value
                this.getTasks()
            },
            getTasks() {
                var task = Task.getTasks(this.date)
                task.then((response) => {
                    this.data = response.data.data
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            updateStatus(id, status) {
                var task = Task.updateStatus(id, status)
                task.then((response) => {
                    if(!response.data.error) {
                        this.getTasks()
                    }
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            createTask() {
                var task = Task.createTask(this.task)
                task.then((response) => {
                    if(!response.data.error) {
                        this.getTasks()
                        this.task = ""
                    }
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            deleteTask(id) {
                var task = Task.deleteTask(id)
                task.then((response) => {
                    if(!response.data.error) {
                        this.getTasks()
                    }
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            moveTask(id) {
                var task = Task.moveTask(id)
                task.then((response) => {
                    if(!response.data.error) {
                        this.getTasks()
                    }
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            handleToday() {
                if(this.today == false) {
                    this.today = true
                } else {
                    this.today = false
                }
                this.getTasks()
            },
            handleStart(e) {
                this.start_date = e.target.value
                this.getTasks()
            },
            handleEnd(e) {
                this.end_date = e.target.value
                this.getTasks()
            }
        }
    }
</script>