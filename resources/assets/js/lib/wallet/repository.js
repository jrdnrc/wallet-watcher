export function walletById (walletId) {
    return w => walletId === w.wallet_id
}

export function exceptWalletById(walletId) {
    return w => walletId !== w.wallet_id
}