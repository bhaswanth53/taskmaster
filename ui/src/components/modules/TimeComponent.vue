<template>
    <div>
        <h3>Timelogs :</h3>
        <FilterComponent
            :today="today"
            :start_date="start_date"
            :end_date="end_date"
            :handleToday="handleToday"
            :handleStart="handleStart"
            :handleEnd="handleEnd"
        />

        <div class="time-divs padding-vertical" v-if="data.length > 0">
            <div class="time-label" v-if="total">
                <p v-if="total.time">Total Time : <span class="time">{{ total.time }}</span></p>
            </div>

            <div class="time-logs" v-for="(time, key) in data" v-bind:key="key">
                <div class="uk-grid-match uk-flex-middle" uk-grid>
                    <div class="uk-width-1-6@s">
                        <button class="uk-button log-button">{{ time.start }}</button>
                    </div>
                    <div class="uk-width-1-6@s">
                        <button class="uk-button log-button">{{ time.end }}</button>
                    </div>
                    <div class="uk-width-1-2@s">
                        <p class="description" v-if="time.description">{{ time.description }}</p>
                        <p class="description" v-else>No description!</p>
                    </div>
                    <div class="uk-width-1-6@s">
                        <div>
                            <button class="delete-button" v-on:click="deleteTime(time.id)"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="time-card">
            <div class="uk-grid-match" uk-grid>
                <div class="uk-width-1-6@s">
                    <input type="time" class="time-input uk-input" v-model="start" placeholder="Start" />
                </div>
                <div class="uk-width-1-6@s">
                    <input type="time" class="time-input uk-input" v-model="end" placeholder="end" />
                </div>
                <div class="uk-width-1-4@s">
                    <input type="text" class="time-input uk-input" placeholder="description" v-model="description" />
                </div>
                <div class="uk-width-1-6@s">
                    <button class="uk-button uk-button-small add-button" v-on:click="createTime">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Time from '../../models/time'
    import FilterComponent from '../FilterComponent.vue'

    export default {
        name: 'TimeComponent',
        components: {
            FilterComponent
        },
        mounted() {
            console.log('Time component is mounted')
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
                description: ""
            }
        },
        methods: {
            getTimes() {
                var time = Time.getTimes(false, this.start_date, this.end_date)
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

<style>
    .log-button {
        background-color: #fff;
        font-weight: bold !important;
    }

    .time-logs {
        margin: 10px 0px;
    }

    .time-card {
        /* background-color: #fff; */
        padding: 5px;
    }

    .add-button {
        background-color: #0e3899;
        color: #fff !important;
        border: 0;
        cursor: pointer;
    }

    .description {
        background-color: #fff;
        padding: 7px;
        font-weight: 600;
        font-size: 14px;
        color: #808080;
    }

    .time-label {
        font-size: 20px;
        color: #000;
    }

    .time-label .time {
        color: #0e3899;
    }
</style>