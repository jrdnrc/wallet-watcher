<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="new-wallet-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form v-on:submit="addWallet">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add Wallet</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="wallet-name">Wallet Name</label>
                            <input type="text" class="form-control" id="wallet-name" placeholder="Wallet name" v-model="name"><br />
                        </div>

                        <label>Addresses</label>

                        <div class="input-group" v-for="(a, i) in addresses">
                            <input type="text" class="form-control" placeholder="Address" v-model="addresses[i]" name="address[]">
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-info" v-on:click="removeAddress(i)" v-model="addresses[i]">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                        </span>
                        </div>

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Address" v-model="newAddress" ref="newAddress">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info" v-on:click="addAddress">
                                    <i class="glyphicon glyphicon-plus"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Wallet</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</template>

<script>
    export default {
        data: function () {
            return {
                name: '',
                newAddress: '',
                addresses: []
            }
        },

        methods: {
            addWallet: function (e) {
                e.preventDefault()

                axios.post('/wallet', { name: this.name, addresses: this.addresses }).then(() => {
                    this.name = ''
                    $('#new-wallet-modal').modal('hide')
                })
            },

            addAddress: function (e) {
                if (this.newAddress.length > 0) {
                    this.addresses.push(this.newAddress)
                    this.newAddress = ''
                    this.$refs.newAddress.focus()
                }
            },

            removeAddress: function (i) {
                this.addresses.splice(i, 1)
            }
        }
    }
</script>