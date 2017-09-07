<template>
    <div>
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
            <input type="text" class="form-control" placeholder="Address" v-model="newAddress">
            <span class="input-group-btn">
                <button type="button" class="btn btn-info" v-on:click="addAddress">
                    <i class="glyphicon glyphicon-plus"></i>
                </button>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                newAddress: '',
                addresses: []
            }
        },

        methods: {
            addAddress: function (e) {
                if (this.newAddress.length > 0) {
                    this.addresses.push(this.newAddress)
                    this.newAddress = ''
                }
            },

            removeAddress: function (i) {
                this.addresses.splice(i, 1)
            }
        }
    }
</script>