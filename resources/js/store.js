import Vue from 'vue';
import vuex from 'vuex';

Vue.use(vuex);
export default new vuex.Store({
    state:{
        // counter:100
        deleteModalObj :{
            showDeleteModal:false,
            deleteUrl:"",
            data:null,
            deleteIndex:-1,
            isDeleting:false
        },
        user:false

    },
    getters:{
        getDeleteModalObj(state){
           return state.deleteModalObj
        },
        // loggedInUser(state){

        // }

    },
    mutations:{
        setDeleteModal(state,data){
            const deleteModalObj = {
                showDeleteModal:false,
                deleteUrl:"",
                data:null,
                deleteIndex:-1,
                isDeleting:data,
            }
            state.deleteModalObj= deleteModalObj;

        },
        setDeletingModalObj(state,data){
            state.deleteModalObj = data
        },
        updateUser(state,data){
            state.user = data;
        },
        
    }
})