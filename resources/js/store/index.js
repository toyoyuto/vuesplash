import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error' // ★ 追加

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    error // ★ 追加
  }
})

export default store