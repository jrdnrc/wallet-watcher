<template>
    <div class="thumbnail">
        <span class="pull-right"><button class="btn btn-danger btn-xs" v-on:click="remove">&times;</button></span>
        <h3>{{ wallet.name }}</h3>
        <span><strong>Balance: </strong> &#3647;{{ wallet.balance }}</span><br />
        <span><strong>Fiat:</strong> &pound;{{ wallet.fiat }}</span>
        <ul class="list-group">
            <li class="list-group-item" v-for="a in wallet.addresses">
                <a :href="'//blockchain.info/address/' + a" target="_blank">
                    {{ a }}
                </a>
            </li>
        </ul>

        <form>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Address" v-model="newAddress" ref="newAddress">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-info" v-on:click="addAddress">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
</template>

<script>
    import Blockchain from './../lib/blockchain'
    import { mapMutations } from 'vuex'
    import { walletById } from './../lib/wallet/repository'

    export default {
        props: ['wallet_id'],

        data: function () {
            return {
                newAddress: ''
            }
        },

        mounted: function () {
            this.fetchBalances()
        },

        methods: {
            ...mapMutations([
                'addAddressToWallet',
                'updateWalletBalance',
            ]),

            addAddress: function () {
                const address = this.newAddress
                this.$refs.newAddress.blur()
                this.newAddress = ''
                this.addAddressToWallet({ walletId: this.wallet_id, address })

                axios.post(`/wallet/${this.wallet_id}/address`, { address }).then(() => {
                    this.fetchBalances()
                })
            },

            fetchBalances: function () {
                if (this.wallet.addresses.length == 0) {
                    return
                }

                Blockchain
                    .addressBalance(...this.wallet.addresses)
                    .then(r => this.updateWalletBalance({ walletId: this.wallet_id, balance: r.data.balance, fiat: r.data.fiat }))
            },

            remove: function () {
                axios.delete(`/wallet/${this.wallet_id}`).then(() => {
                    this.$emit('wallet-removed', { wallet_id: this.wallet_id })
                })
            }
        },

        computed: {
            wallet: {
                get () {
                    return this.$store.state.wallets.find(walletById(this.wallet_id))
                }
            }
        }
    }
</script>