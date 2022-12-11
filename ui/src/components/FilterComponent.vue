<template>
    <div>
        <div class="uk-grid-match" uk-grid>
            <div class="uk-width-1-4@s">
                <div class="uk-margin">
                    <button class="uk-button uk-button-small today-button uk-width-1-1" v-on:click="handleToday" v-bind:class="today == true ? 'today' : 'not'">
                        <i class="fa fa-check" v-if="today == true"></i>
                        <i class="fa fa-times" v-else-if="today == false"></i>
                        Today
                    </button>
                </div>
            </div>
            <div class="uk-width-3-4@s" v-if="today == false">
                <div class="uk-grid-match" uk-grid>
                    <div class="uk-width-1-2@m">
                        <div class="uk-margin">
                            <input type="date"
                                    class="uk-input uk-form-small" 
                                    placeholder="Start Date" 
                                    v-on:change="handleStart"
                                    :value="start_date"
                            />
                        </div>
                    </div>
                    <div class="uk-width-1-2@m">
                        <div class="uk-margin">
                            <input type="date" 
                                    class="uk-input uk-form-small" 
                                    placeholder="End Date" 
                                    v-on:change="handleEnd"
                                    :value="end_date"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FilterComponent',
        props: [
            'today',
            'start_date',
            'end_date',
            'handleToday',
            'handleStart',
            'handleEnd'
        ]
    }
</script>

<style>
    .today-button {
        color: #fff !important;
    }
    .today-button.today {
        background-color: #027a0c;
    }
    .today-button.not {
        background-color: #e62e09;
    }
</style>