import axios from 'axios'
import { host } from '../utils'

class Time {
    static getTimes(date) {
        var url = host + '/api/time/list'
        let formData = {
            date: date
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

    static delete(id) {
        var url = host + '/api/time/' + id

        return axios.delete(url)
    }

    static moveTime(id) {
        var url = host + '/api/time/' + id + '/move'

        return axios.delete(url)
    }
}

export default Time