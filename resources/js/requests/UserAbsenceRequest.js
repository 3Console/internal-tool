import BaseModelRequest from './BaseModelRequest';

export default class UserAbsenceRequest extends BaseModelRequest {
    getUserAbsenceRequests(params) {
        const url = '/admin/absence-requests';
        return this.get(url, params);
    }

    approveRequest(params) {
        const url = '/admin/absence-requests/approve';
        return this.post(url, params);
    }
}