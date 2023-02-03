<template>
    <div>
        <div uk-grid>
            <div class="uk-width-1-4">
                <DateFilter
                    :date="date"
                    :handleDate="handleDate"
                    :size="'uk-width-1-1'"
                />
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
    import DateFilter from '../DateFilter.vue'

    export default {
        name: 'NoteComponent',
        components: {
            DateFilter
        },
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
                end_date: "",
                date: ""
            }
        },
        mounted() {
            console.log('Note component is mounted')
            this.getToday()
            this.getNotes()
        },
        methods: {
            getToday() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                this.date = yyyy + '-' + mm + '-' + dd;
            },
            handleDate(e) {
                this.date = e.target.value
                this.getNotes()
            },
            getNotes() {
                var note = Note.getNotes(this.date)
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