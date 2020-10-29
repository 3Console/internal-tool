import UserRequest from './UserRequest';
import EmployeeRequest from './EmployeeRequest';
import TranslateRequest from './TranslateRequest';
import WordRequest from './WordRequest';
import CategoryRequest from './CategoryRequest';
import GameRequest from './GameRequest';
import NotificationRequest from './NotificationRequest';

const requestMap = {
    UserRequest,
    EmployeeRequest,
    TranslateRequest,
    WordRequest,
    CategoryRequest,
    GameRequest,
    NotificationRequest
};

const instances = {};

export default class RequestFactory {

    static getRequest(classname) {
        const RequestClass = requestMap[classname];
        if (!RequestClass) {
            throw new Error(`Invalid request class name: ${classname}`);
        }

        let requestInstance = instances[classname];
        if (!requestInstance) {
            requestInstance = new RequestClass();
            instances[classname] = requestInstance;
        }

        return requestInstance;
    }

}