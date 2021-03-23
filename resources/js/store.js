import Vue from 'vue'
import Vuex from 'vuex'
import Axios from 'axios'

Vue.use(Vuex)


export default new Vuex.Store({
   state: {
      userAuth: {}
   },
   mutations: {
      setData(state, data) {
         state.userAuth = data;
      }
   },
   actions: {
      async getData(context) {
         let data = (await Axios.get('/user/auth')).data;
         context.commit("setData", data);
      }
   },
 })