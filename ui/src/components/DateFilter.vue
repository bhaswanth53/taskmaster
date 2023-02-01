<template>
    <div>
        <div class="uk-margin uk-width-1-3">
            <label class="uk-form-label">Date :</label>
            <input type="date"
                    class="uk-input uk-form-small"
                    v-on:change="handleDate"
                    :value="date" />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'DateFilter',
        props: [
            'date',
            'handleDate'
        ]
    }
</script>