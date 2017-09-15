
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import sprintf from 'sprintf'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(require('vue-cookie'))
Vue.use(Vuex)

Vue.component('wallet', require('./components/Wallet.vue'));
Vue.component('add-wallet', require('./components/NewWallet.vue'))
Vue.component('draggable', require('vuedraggable'))

const store = new Vuex.Store({
    state: {
        wallets: []
    },

    mutations: {
        addWallet (state, wallet) {
            state.wallets.push(wallet)
        }
    }
})

const app = new Vue({
    el: '#app',

    store,

    mounted: function () {
        console.log(this.$store.state)
        this.fetchWallets()
    },

    data: {
        title: '',
        wallets: []
    },

    methods: {
        clearWallets: function () {
            this.wallets.length = 0
        },

        fetchWallets: function () {
            this.clearWallets()

            if (this.$cookie.get('wallets')) {
                this.wallets = JSON.parse(this.$cookie.get('wallets'))
            } else {
                this.fetchWalletsFromApi()
            }
        },

        fetchWalletsFromApi: function () {
            this.clearWallets()

            const pushToWallets = response => response.data.forEach(wallet => this.wallets.push(wallet))

            axios('/wallet')
                .then(pushToWallets)
                .catch(error => console.log(error))
        },

        updateTitle: function () {
            const wallet = this.wallets.slice(0, 1).pop()

            this.title = sprintf('%s - ฿%s', wallet.name, wallet.balance)
        },

        removeWallet: function (wallet_id) {
            this.wallets = this.wallets.filter(w => w.wallet_id !== wallet_id)
        }
    },

    watch: {
        title: function (val) {
            document.title = val
        },

        wallets: function (val) {
            this.updateTitle()

            this.$cookie.set('wallets', JSON.stringify(val.map(w => Object.assign({}, {
                wallet_id: w.wallet_id,
                name:      w.name,
                addresses: w.addresses
            }))))
        }
    }
});
