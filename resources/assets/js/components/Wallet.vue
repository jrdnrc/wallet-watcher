<template>
    <div class="thumbnail">
        <span class="pull-right"><button class="btn btn-danger btn-xs" v-on:click="remove">&times;</button></span>
        <h3>{{ mutableWallet.name }}</h3>
        <span><strong>Balance: </strong> &#3647;{{ mutableWallet.balance }}</span><br />
        <span><strong>Fiat:</strong> &pound;{{ mutableWallet.fiat }}</span>
        <ul class="list-group">
            <li class="list-group-item" v-for="a in mutableWallet.addresses">
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
    import { pipes } from './../lib/blockchain'

    export default {
        props: ['wallet'],

        data: function () {
            return {
                newAddress: '',
                mutableWallet: Object.assign({}, { balance: 0, fiat: 0 }, this.wallet)
            }
        },

        mounted: function () {
            this.fetchBalances()
        },

        methods: {
            addAddress: function () {
                this.mutableWallet.addresses.push(this.newAddress)
                this.fetchBalances()

                axios.post(`/wallet/${this.wallet.wallet_id}/address`, { address: this.newAddress }).then(() => {
                    this.$refs.newAddress.blur()
                    this.newAddress = ''
                })
            },

            fetchBalances: function () {
                if (this.mutableWallet.addresses.length == 0) {
                    return
                }

                const mutateWallet = fields => Object.assign({}, this.mutableWallet, fields)

                Blockchain
                    .addressBalance(...this.mutableWallet.addresses)
                    .then(r => this.mutableWallet = mutateWallet({ balance: r.data.balance, fiat: r.data.fiat }))
            },

            remove: function () {
                axios.delete(`/wallet/${this.wallet.wallet_id}`).then(() => {
                    this.$emit('wallet-removed', { wallet_id: this.wallet.wallet_id })
                })
            }
        }
    }
</script>