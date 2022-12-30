<template>
  <HeaderComponent :tab="tab" @handleTabs="handleTabs" />

  <div class="uk-container padding-vertical">
    <TaskComponent v-if="tab == 'task'" />
    <TimeComponent v-if="tab == 'time'" />
    <NoteComponent v-if="tab == 'note'" />
  </div>
</template>

<script>
  import HeaderComponent from './components/layouts/HeaderComponent.vue';
  import TaskComponent from './components/modules/TaskComponent.vue';
  import TimeComponent from './components/modules/TimeComponent.vue';
  import NoteComponent from './components/modules/NoteComponent.vue';

  export default {
    name: 'App',
    components: {
      HeaderComponent,
      TaskComponent,
      TimeComponent,
      NoteComponent
    },
    data() {
      return {
        tab: 'task'
      }
    },
    methods: {
      handleTabs(tab) {
        this.tab = tab
      }
    }
  }
</script>

<style>
  @import "../node_modules/uikit/dist/css/uikit.min.css";

  body {
    min-height: 100vh;
    background-color: #e3e7e8;
  }

  .padding-vertical {
    padding-top: 15px;
    padding-bottom: 15px;
  }
</style>
