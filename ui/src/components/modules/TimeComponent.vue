<template>
    <div>
        <h3>Timelogs :</h3>
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

        <div class="time-divs padding-vertical">
            <div class="time-label" v-if="total">
                <p v-if="data.length > 0 && total.time">Total Time : <span class="time">{{ total.time }}</span></p>
            </div>

            <div class="uk-card uk-card-default">
                <div class="uk-responsive">
                    <table class="uk-table uk-table-divider uk-table-middle uk-width-1-1 timetable">
                        <thead>
                            <tr>
                                <th>Start</th>
                                <th>End</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(time, key) in data" v-bind:key="key">
                                <td>{{ time.start }}</td>
                                <td>{{ time.end }}</td>
                                <td>{{ time.description }}</td>
                                <td>
                                    <button class="move-button" title="Move to today" v-if="time.is_today == false"><i class="fa fa-arrow-circle-right"></i></button>
                                    <button class="delete-button" v-on:click="deleteTime(time.id)"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="time" class="time-input uk-input" v-model="start" placeholder="Start" />
                                </td>
                                <td>
                                    <input type="time" class="time-input uk-input" v-model="end" placeholder="end" />
                                </td>
                                <td>
                                    <input type="text" class="time-input uk-input" placeholder="description" v-model="description" />
                                </td>
                                <td>
                                    <button class="uk-button add-button" v-on:click="createTime"><i class="fa fa-plus"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Time from '../../models/time'
    import DateFilter from '../DateFilter.vue'

    export default {
        name: 'TimeComponent',
        components: {
            DateFilter
        },
        mounted() {
            this.getToday()
            this.getTimes()
        },
        data() {
            return {
                today: true,
                start_date: "",
                end_date: "",
                data: [],
                total: [],
                task: "",
                start: "",
                end: "",
                description: "",
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
                this.getTimes()
            },
            getTimes() {
                var time = Time.getTimes(this.date)
                time.then((response) => {
                    this.data = response.data.times
                    this.total = response.data.total
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
            },
            handleStart(e) {
                this.start_date = e.target.value
            },
            handleEnd(e) {
                this.end_date = e.target.value
            },
            createTime() {
                var time = Time.addTime('', this.start, this.end, this.description)
                time.then((response) => {
                    if(!response.data.error) {
                        this.getTimes()
                        this.start = ""
                        this.end = ""
                        this.description = ""
                    }
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            deleteTime(id) {
                Time.delete(id).then((response) => {
                    if(!response.data.error) {
                        this.getTimes()
                    }
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            }
        }
    }
</script>