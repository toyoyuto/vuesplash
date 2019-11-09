import Vue from 'vue'
// ルーティングの定義をインポートする
import router from './router'
import store from './store' // ★　追加
// ルートコンポーネントをインポートする
import App from './App.vue'
import './bootstrap'

new Vue({
  el: '#app',
  store, // ★　追加
  router, // ルーティングの定義を読み込む
  components: { App }, // ルートコンポーネントの使用を宣言する
  template: '<App />' // ルートコンポーネントを描画する
})