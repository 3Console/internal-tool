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
}
