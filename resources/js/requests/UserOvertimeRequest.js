import BaseModelRequest from './BaseModelRequest';

export default class UserOvertimeRequest extends BaseModelRequest {
    getUserOvertimeRequests(params) {
        const url = '/admin/overtime-requests';
        return this.get(url, params);
    }

    getUserOvertimeDetail(id) {
        const url = `/admin/overtime-requests/${id}`;
        return this.get(url);
    }

    approveRequest(params) {
        const url = '/admin/overtime-requests/approve';
        return this.post(url, params);
    }

    rejectRequest(params) {
        const url = '/admin/overtime-requests/reject';
        return this.post(url, params);
    }

    createOvertimeRequest(params) {
        const url = '/overtime-create';
        return this.post(url, params);
    }

    getProjects() {
        const url = '/projects';
        return this.get(url);
    }
}
