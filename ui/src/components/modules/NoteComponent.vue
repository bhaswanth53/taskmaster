<template>
    <div>
        <div uk-grid>
            <div class="uk-width-1-4">
                <div class="list" v-for="i in 10" v-bind:key="i">
                    <table class="list-item uk-table uk-table-small">
                        <tr>
                            <td>Editor 1</td>
                            <td class="uk-text-right"><button><i class="fa fa-trash"></i></button></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="uk-width-2-3">
                <div class="uk-margin">
                    <input type="text" class="uk-input" placeholder="Title.." />
                </div>
                <ckeditor :editor="editor" v-model="content" :config="config"></ckeditor>
                <div class="uk-margin">
                    <button class="uk-button uk-button-primary" v-on:click="createNotes">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import Note from '../../models/note'

    export default {
        name: 'NoteComponent',
        data() {
            return {
                editor: ClassicEditor,
                content: '',
                config: {},
                data: [],
                today: true,
                start_date: "",
                end_date: "",
            }
        },
        mounted() {
            console.log('Note component is mounted')
            this.getNotes()
        },
        methods: {
            getNotes() {
                var note = Note.getNotes(this.today, this.start_date, this.end_date)
                note.then((response) => {
                    this.data = response.data
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            createNote() {
                //
            }
        }
    }
</script>

<style>
    .list {
        /* padding: 10px; */
        background-color: #ffffff;
        font-size: 18px;
        margin: 2px;
    }
</style>