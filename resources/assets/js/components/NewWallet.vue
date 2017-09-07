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
                        <address-input-list />
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
                name: ''
            }
        },

        methods: {
            addWallet: function (e) {
                e.preventDefault()

                axios.post('/wallet', { name: this.name }).then(() => {
                    this.name = ''
                    $('#new-wallet-modal').modal('hide')
                })
            }
        }
    }
</script>