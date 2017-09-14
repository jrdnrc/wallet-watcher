'use strict'

import urljoin from 'url-join'
import queryString from 'query-string'

const endpointMap = {
    MULTI_ADDRESS: { method: 'GET', ep: 'multiaddr' },
}

class Blockchain {
    constructor () {
        this.api        = '/btc'
        this.apiOptions = {}

        this.call = (endpoint, params) => {
            return axios({
                url: urljoin(this.api, endpoint.ep, `?${queryString.stringify(params.query, {arrayFormat: 'bracket'})}`),
                method: endpoint.method
            }).catch(err => console.error(err))
        }
    }

    addressBalance (...addresses) {
        return this.call(endpointMap.MULTI_ADDRESS, { query: { addresses } })
    }
}

const chain = new Blockchain()

export default chain