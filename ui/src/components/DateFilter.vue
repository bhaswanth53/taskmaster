<template>
    <div>
        <div class="uk-margin" :class="size ?? ' uk-width-1-3'">
            <label class="uk-form-label">Date :</label>
            <input type="date"
                    class="uk-input"
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
            'handleDate',
            'size'
        ]
    }
</script>