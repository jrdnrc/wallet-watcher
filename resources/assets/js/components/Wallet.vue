<template>
    <div class="thumbnail">
        <h3>{{ name }}</h3>
        <span><strong>Balance: </strong> &#3647;{{ balance }}</span>
        <ul class="list-group">
            <li class="list-group-item" v-for="a in addresses">
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
    export default {
        props: ['wallet_id', 'name', 'balance', 'addresses'],

        data: function () {
            return {
                newAddress: ''
            }
        },

        methods: {
            addAddress: function () {
                axios.post(`/wallet/${this.wallet_id}/address`, { address: this.newAddress }).then(() => {
                    this.$refs.newAddress.blur()
                    this.newAddress = ''
                })
            }
        }
    }
</script>