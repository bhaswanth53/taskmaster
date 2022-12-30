import axios from 'axios'
import { host, today } from '../utils'

class Task {
    static getTasks(today, start_date, end_date) {
        var url = host + '/api/task/list'
        let formData = {
            today: today,
            start_date: start_date,
            end_date: end_date
        }

        return axios.post(url, formData)
    }

    static updateStatus(id, status) {
        var url = host + '/api/task/status/update'
        let formData = {
            task: id,
            status: status
        }

        return axios.post(url, formData)
    }

    static createTask(task) {
        var url = host + '/api/task/create'
        let formData = {
            task: task,
            task_date: today()
        }

        return axios.post(url, formData)
    }

    static deleteTask(id) {
        var url = host + '/api/task/' + id

        return axios.delete(url)
    }
}

export default Task