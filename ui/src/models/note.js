import axios from 'axios'
import { host } from '../utils'

class Note {
    static getNotes(today, start_date, end_date) {
        var url = host + '/api/time/list'
        let formData = {
            today: today,
            start_date: start_date,
            end_date: end_date
        }

        return axios.post(url, formData)
    }
}

export default Note