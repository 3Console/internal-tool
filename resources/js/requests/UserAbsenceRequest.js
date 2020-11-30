import BaseModelRequest from './BaseModelRequest';

export default class UserAbsenceRequest extends BaseModelRequest {
    getUserAbsenceRequests(params) {
        const url = '/admin/absence-requests';
        return this.get(url, params);
    }

    getUserAbsenceDetail(id) {
        const url = `/admin/absence-requests/${id}`;
        return this.get(url);
    }

    approveRequest(params) {
        const url = '/admin/absence-requests/approve';
        return this.post(url, params);
    }

    rejectRequest(params) {
        const url = '/admin/absence-requests/reject';
        return this.post(url, params);
    }

    createAbsenceRequest(params) {
        const url = '/absence-create';
        return this.post(url, params);
    }

    getAbsenceTypes() {
        const url = '/absence-types';
        return this.get(url);
    }
}