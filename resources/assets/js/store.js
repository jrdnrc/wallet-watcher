'use strict'

import Vue from 'vue'
import Vuex from 'vuex'
import { exceptWalletById, walletById } from "./lib/wallet/repository";

Vue.use(Vuex)

export const store = new Vuex.Store({
    state: {
        wallets: []
    },

    mutations: {
        setWallets (state, { wallets }) {
            state.wallets = wallets
        },

        removeWallet (state, walletId) {
            state.wallets = state.wallets.filter(exceptWalletById(walletId))
        },

        addAddressToWallet (state, { walletId, address }) {
            state.wallets.find(walletById(walletId)).addresses.push(address)
        },

        updateWalletBalance (state, { walletId, balance, fiat }) {
            state.wallets = state
                .wallets
                .filter(exceptWalletById(walletId))
                .concat(Object.assign({}, state.wallets.find(walletById(walletId)), { balance, fiat }))
        }
    }
})