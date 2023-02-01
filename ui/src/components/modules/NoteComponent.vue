<template>
    <div>
        <div uk-grid>
            <div class="uk-width-1-4">
                <div class="list" v-for="(item, i) in data" v-bind:key="i">
                    <table class="list-item uk-table uk-table-small">
                        <tr>
                            <td>{{ item.name }}</td>
                            <td class="uk-text-right">
                                <button class="note-button view" v-on:click="viewNote(item.id)"><i class="fa fa-info"></i></button>
                                <!-- <button class="note-button"><i class="fa fa-trash"></i></button> -->
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="uk-text-center">
                    <button class="uk-button add-button uk-button-small" v-on:click="createNotes">Add Note</button>
                </div>
            </div>
            <div class="uk-width-2-3">
                <div v-if="note.id">
                    <div class="uk-margin">
                        <input type="text" class="uk-input" placeholder="Title.." v-model="note.name" />
                    </div>
                    <ckeditor :editor="editor" v-model="note.contents" :config="config"></ckeditor>
                    <div class="uk-margin">
                        <button class="uk-button add-button uk-button-small" v-on:click="updateNote">Update</button>
                    </div>
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
                config: {},
                data: [],
                note: {
                    id: '',
                    name: '',
                    contents: ''
                },
                today: true,
                start_date: "",
                end_date: ""
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
                    console.log(response.data)
                    this.data = response.data
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            createNotes() {
                var note = Note.addNote('today')
                note.then((response) => {
                    console.log(response.data)
                    this.getNotes()
                }).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            viewNote(id) {
                var note = Note.viewNote(id)
                note.then((response) => [
                    this.note = {
                        id: response.data.id,
                        name: response.data.name,
                        contents: response.data.content
                    }
                ]).catch((error) => {
                    if(error.response) {
                        console.log(error.response.data)
                    } else {
                        console.log(error)
                    }
                })
            },
            updateNote() {
                var note = Note.updateNote(this.note)
                note.then((response) => {
                    console.log(response.data)
                    this.getNotes()
                    this.viewNote(this.note.id)
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
    .list {
        /* padding: 10px; */
        background-color: #ffffff;
        font-size: 18px;
        margin: 2px;
    }

    .note-button {
        cursor: pointer;
    }

    .note-button.view {
        background-color: #0e3899;
        color: #fff;
        border: 0;
        padding: 5px 10px;
    }

    .add-button {
        background-color: #0e3899;
        color: #fff;
    }
</style>