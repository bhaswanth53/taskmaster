import axios from 'axios'
import { host } from '../utils'

class Time {
    static getTimes(today, start_date, end_date) {
        var url = host + '/api/time/list'
        let formData = {
            today: today,
            start_date: start_date,
            end_date: end_date
        }

        return axios.post(url, formData)
    }

    static addTime(date, start, end, description) {
        var url = host + '/api/time/create'
        let formData = {
            date: date,
            start: start,
            end: end,
            description: description
        }

        return axios.post(url, formData)
    }
}

export default Time