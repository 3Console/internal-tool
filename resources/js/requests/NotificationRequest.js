import BaseModelRequest from './BaseModelRequest';

export default class NotificationRequest extends BaseModelRequest {
  getLatestNotifications() {
    const url = '/notifications/latest';
    return this.get(url);
  }
  getAllNotifications() {
    const url = '/notifications/all';
    return this.get(url);
  }
  getNotificationDetail(id) {
    const url = `/notifications/${id}`;
    return this.get(url);
  }
  deleteNotification(id) {
    const url = `/notifications/delete/${id}`;
    return this.post(url);
  }
}