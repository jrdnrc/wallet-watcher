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
    </div>
</template>

<script>
    export default {
        props: ['name', 'balance', 'addresses']
    }
</script>