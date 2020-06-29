import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state :{
        counter :1000,
        deleteModalObj : {
            showDeleteModel : false,
            deleteUrl       :'',
            data            :null,
            deletingIndex   : -1,
            isDeleted       :false
        }
    },
    getters:{
        getCounter(state){
            return state.counter
        },
        getDeleteModalObj(state){
            return state.deleteModalObj
        }
    },
    mutations: {
       
        setDeleteModal( state, data){
           const deleteModalObj = {
                showDeleteModel : false,
                deleteUrl       :'',
                data            :null,
                deletingIndex   : -1,
                isDeleted       :data
            }
            state.deleteModalObj= deleteModalObj
            
            // state.deleteModalObj.showDeleteModel =false
            // state.deleteModalObj.isDeleted =true
        },
        setDeletingModalObj(state,data){
            state.deleteModalObj = data
        }
    },
    actions:{
        changeCounterAction({commit},data){
            commit('changeTheValue',data)
        }
    }
})