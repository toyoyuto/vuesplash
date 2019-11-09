const state = {
    user: null,
    users: []
}
const getters = {}

const mutations = {
  setUser (state, user) {
    state.user = user
  }
}

const actions = {
    async register (context, data) {
      const response = await axios.post('/api/register', data)
      console.log(response)
      context.commit('setUser', response.data)
    },
    async login (context, data) {
      const response = await axios.post('/api/login', data)
      console.log(response)
      context.commit('setUser', response.data)
    },
    async logout (context) {
      const response = await axios.post('/api/logout')
      context.commit('setUser', null)
    }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}