
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

const Vue = require('vue')
const axios = require('axios')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('wallet', require('./components/Wallet.vue'));
Vue.component('add-wallet', require('./components/NewWallet.vue'))

const app = new Vue({
    el: '#app',

    mounted: function () {
        this.fetchWallets()
    },

    data: {
        heading: 'Hello!',
        wallets: []
    },

    methods: {
        fetchWallets: function () {
            this.wallets.length = 0
            axios('/wallet').then(response => {
                response.data.forEach(wallet => {
                    axios(`/wallet/${wallet.wallet_id}`).then(r => {
                        this.wallets.push({
                            name:      wallet.name,
                            addresses: wallet.addresses.map(a => a.address),
                            balance:   r.data.balance,
                            fiat:      r.data.fiat
                        })
                    })
                })
            }).catch(error => console.log(error))
        }
    }
});
