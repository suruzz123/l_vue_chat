import Axios from "axios";
import { isContext } from "vm";

export default {
    state: {
        userList: [],
        userMessage: []

    },
    mutations: {
        userList(state,payload) {
            return state.userList = payload

        },
        userMessage(state,payload) {
            return state.userMessage = payload
        }
    },
    actions: {
        userList(context) {
            Axios.get('/userlist')
            .then(response=>{
                context.commit('userList',response.data)
            })
            
        },
        userMessage(context,payload) {
            Axios.get('/usermessage/'+payload)
            .then(response=>{
                context.commit('userMessage',response.data)
            })
        }
    },
    getters: {
        userList(state) {
            return state.userList

        },
        userMessage(state) {
            return state.userMessage
        }
    }
}