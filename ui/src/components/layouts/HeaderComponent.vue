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

<style>
    .cusnav {
        height: 50px;
        padding: 5px;
        background-color: #0e3899 !important;
    }

    .cusnav .uk-navbar-nav>li>a {
        min-height: 50px;
        text-transform: none;
        font-size: 20px;
        color: #fff;
    }

    .cusnav .uk-navbar-nav > li > a:hover {
        color: #fff;
    }

    .cusnav .uk-navbar-nav > li > a.active {
        border-bottom: 2px solid #fff;
    }
</style>