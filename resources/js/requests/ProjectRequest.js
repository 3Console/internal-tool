import BaseModelRequest from './BaseModelRequest';

export default class ProjectRequest extends BaseModelRequest {
  getProjects(params) {
    const url = '/admin/projects';
    return this.get(url, params);
  }
  createProject(params) {
    const url = '/admin/project/create';
    return this.post(url, params);
  }
  getProject(projectId) {
    const url = '/admin/project/' + projectId;
    return this.get(url);
  }
  updateProject(projectId, params) {
    const url = `/admin/project/update/${projectId}`;
    return this.post(url, params);
  }
  deleteProject(projectId) {
    const url = `/admin/project/delete/${projectId}`;
    return this.post(url);
  }
  getProjectMembers(projectId, params) {
    const url = `/admin/project/${projectId}/members`;
    return this.get(url, params);
  }
  getPositions() {
    const url = '/admin/positions';
    return this.get(url);
  }
  getMember(memberId) {
    const url = '/admin/project/member/' + memberId;
    return this.get(url);
  }
  addMember(params) {
    const url = '/admin/project/member/create';
    return this.post(url, params);
  }
  updateMember(memberId, params) {
    const url = `/admin/project/member/update/${memberId}`;
    return this.post(url, params);
  }
  deleteMember(memberId) {
    const url = `/admin/project/member/delete/${memberId}`;
    return this.post(url);
  }
}
