
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
Vue.component('draggable', require('vuedraggable'))

const app = new Vue({
    el: '#app',

    mounted: function () {
        this.fetchWallets()
    },

    data: {
        wallets: []
    },

    methods: {
        fetchWallets: function () {
            this.wallets.length = 0

            const pushToWallets = response => {
                console.log(JSON.parse(JSON.stringify(response.data)))
                response.data.forEach(wallet => this.wallets.push(wallet))
            }


            axios('/wallet').then(pushToWallets).catch(error => console.log(error))
        },

        removeWallet: function(wallet_id) {
            this.wallets = this.wallets.filter(w => w.wallet_id !== wallet_id)
        }
    },

    computed: {
        title: {
            get() {
                if (this.wallets.length > 0) {
                    document.title = this.wallets[0].balance
                }

                return document.title
            },
            set(v) {
                document.title = v
            }
            // (function titleScroller(text) {
            //     document.title = text;
            //     setTimeout(function () {
            //         titleScroller(text.substr(1) + text.substr(0, 1));
            //     }, 500);
            // }(" Nature dff ssfd "));
        }
    }
});
