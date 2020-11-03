import BaseModelRequest from './BaseModelRequest';

export default class UserOvertimeRequest extends BaseModelRequest {
    getUserOvertimeRequests(params) {
        const url = '/admin/overtime-requests';
        return this.get(url, params);
    }
}