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
            <div class="time-logs" v-for="(time, key) in data" v-bind:key="key">
                <div class="uk-width-1-4@s uk-grid-match" uk-grid>
                    <div class="uk-width-1-2@s">
                        <button class="uk-button log-button">{{ time.start }}</button>
                    </div>
                    <div class="uk-width-1-2@s">
                        <button class="uk-button log-button">{{ time.end }}</button>
                    </div>
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
                task: ""
            }
        },
        methods: {
            getTimes() {
                var time = Time.getTimes(false, '2022-11-01', '2022-12-11')
                time.then((response) => {
                    this.data = response.data
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
</style>