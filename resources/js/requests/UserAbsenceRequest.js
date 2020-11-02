import BaseModelRequest from './BaseModelRequest';

export default class UserAbsenceRequest extends BaseModelRequest {
    getUserAbsenceRequests(params) {
        const url = '/admin/absence-requests';
        return this.get(url, params);
    }
}