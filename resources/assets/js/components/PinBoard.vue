<template>
    <div>
        <div class="row">
            <div class="col-xs-3 pull-right">
                <span class="btn btn-primary" data-toggle="modal" data-target="#new-wallet-modal">New Wallet</span>
            </div>

            <draggable v-model="wallets">
                <div class="col-xs-7 col-md-4" v-for="w in wallets" :key="w.wallet_id">
                    <wallet :wallet_id="w.wallet_id" @wallet-removed="removeWallet(w.wallet_id)" />
                </div>
            </draggable>
        </div>

        <add-wallet @wallet-added="fetchWalletsFromApi" />
    </div>
</template>

<script>
    import sprintf from 'sprintf'
    import { mapMutations } from 'vuex'
    import { exceptWalletById } from './../lib/wallet/repository'

    export default {
        components: {
            'wallet': require('./Wallet.vue'),
            'add-wallet': require('./NewWallet.vue'),
            'draggable': require('vuedraggable'),
        },

        mounted: function () {
            this.fetchWallets()
        },

        data: function () {
            return {
                title: ''
            }
        },

        methods: {
            ...mapMutations([
                'setWallets'
            ]),

            fetchWallets: function () {
                if (this.$cookie.get('wallets')) {
                    this.wallets = JSON.parse(this.$cookie.get('wallets'))
                } else {
                    this.fetchWalletsFromApi()
                }
            },

            fetchWalletsFromApi: function () {
                axios('/wallet')
                    .then(response => this.setWallets({ wallets: response.data }))
                    .catch(err => console.log(err))
            },

            updateTitle: function () {
                const { name, balance } = this.wallets.slice(0, 1).pop()

                this.title = sprintf('%s - ฿%s', name, balance)
            },

            removeWallet: function (wallet_id) {
                this.wallets = this.wallets.filter(exceptWalletById(wallet_id))
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
        },

        computed: {
            wallets: {
                get () {
                    return this.$store.state.wallets
                },

                set (wallets) {
                    this.$store.commit('setWallets', { wallets })
                }
            }
        }
    }
</script>