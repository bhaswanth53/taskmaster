import axios from 'axios'
import { host } from '../utils'

class Note {
    static getNotes(date) {
        var url = host + '/api/note/list'
        let formData = {
            date: date
        }

        return axios.post(url, formData)
    }

    static addNote(date) {
        var url = host + '/api/note/create'
        let formData = {
            date: date,
            name: 'Untitled Note',
            contents: ''
        }

        return axios.post(url, formData)
    }

    static viewNote(id) {
        var url = host + '/api/note/view/' + id 

        return axios.get(url)
    }

    static updateNote(note) {
        var url = host + '/api/note/update/' + note.id
        let formData = {
            id: note.id,
            name: note.name,
            contents: note.contents
        }

        return axios.post(url, formData)
    }
}

export default Note