import BaseModelRequest from './BaseModelRequest';


export default class SalaryRequest extends BaseModelRequest {
  getEmployee() {
    const url = '/admin/employee';
    return this.get(url);
  }
  getUserAbsenceApprovedRequest(params) {
    const url = '/admin/approve-absence';
    return this.get(url, params);
  }
  getUserOvertimeApprovedRequest(params) {
    const url = '/admin/approve-overtime';
    return this.get(url, params);
  }
  submitPaySlip(params) {
    const url = '/admin/pay-slip';
    return this.post(url, params);
  }
}
