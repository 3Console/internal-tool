import BaseModelRequest from './BaseModelRequest';

export default class UserOvertimeRequest extends BaseModelRequest {
    getUserOvertimeRequests(params) {
        const url = '/admin/overtime-requests';
        return this.get(url, params);
    }

    approveRequest(params) {
        const url = '/admin/overtime-requests/approve';
        return this.post(url, params);
    }

    rejectRequest(params) {
        const url = '/admin/overtime-requests/reject';
        return this.post(url, params);
    }

    getProjects() {
        const url = '/projects';
        return this.get(url);
    }
}
