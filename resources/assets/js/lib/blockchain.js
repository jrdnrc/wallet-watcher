'use strict'

import urljoin from 'url-join'
const endpointMap = {
    MULTI_ADDRESS: { method: 'GET', ep: 'multiaddr' },
    RATES: { method: 'GET', ep: 'frombtc' }
}

class Blockchain {
    constructor () {
        this.api        = 'https://blockchain.info'
        this.apiOptions = {}

        this.call = (endpoint, params) => {
            const { query, fetchOptions } = Object.assign(
                {},
                {
                    fetchOptions: Object.assign(
                        {},
                        this.apiOptions,
                        { method: endpoint.method }
                    ),
                    query: params.query
                }
            )


            return fetch(urljoin(this.api, endpoint.ep, `?${queryString(query)}`), fetchOptions)
                .catch(err => console.error(err))
        }
    }

    addressBalance (...addresses) {
        return this.call(endpointMap.MULTI_ADDRESS, { query: { active: addresses.join('|'), cors: true } })
    }

    fiat (amount) {
        return this.call(endpointMap.RATES, { query: { value: amount, currency: 'GBP' } })
    }
}

const queryString = params => Object.keys(params).map(k => encodeURIComponent(k) + '=' + encodeURIComponent(params[k])).join('&')

const chain = new Blockchain()

export default chain
export const pipes = {
    TEXT: r => r.text(),
    JSON: r => r.json()
}