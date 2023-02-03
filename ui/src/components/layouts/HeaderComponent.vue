<template>
    <nav class="uk-navbar-container cusnav" uk-navbar>
        <div class="uk-navbar-left">
            <ul class="uk-navbar-nav">
                <li><a href="#">TaskMaster</a></li>
            </ul>
        </div>
        <div class="uk-navbar-right">
            <ul class="uk-navbar-nav">
                <li><a href="javascript:void(0);" v-bind:class="tab == 'task' ? 'active' : ''" v-on:click="$emit('handleTabs', 'task')">Tasks</a></li>
                <li><a href="javascript:void(0);" v-bind:class="tab == 'time' ? 'active' : ''" v-on:click="$emit('handleTabs', 'time')">Time</a></li>
                <li><a href="javascript:void(0);" v-bind:class="tab == 'note' ? 'active' : ''" v-on:click="$emit('handleTabs', 'note')">Notes</a></li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "HeaderComponent",
        props: {
            handleTabs : {
                type: Function
            },
            tab: {
                type: String
            }
        }
    }
</script>