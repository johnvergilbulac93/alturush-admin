import BaseApi from './BaseApi'

export default {
    saveInfo(minorder) {
        return BaseApi.post('/masterfile/min_order/save', minorder)
    },
    updateInfo(minorder) {
        return BaseApi.post('/masterfile/min_order/update', minorder)
    },
    show(page, filterData) {
        return BaseApi.get(`/masterfile/min_order/show?page=${page}`, {
            params: filterData
        })
    },
    delete(id) {
        return BaseApi.delete(`/masterfile/min_order/${id}`)
    },
}
