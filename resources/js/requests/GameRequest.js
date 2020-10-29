import BaseModelRequest from './BaseModelRequest';

export default class GameRequest extends BaseModelRequest {

    getGame3Resource(ids) {
        return this.post('/game/game3', {ids: ids});
    }

    getGame2Resource(ids) {
        return this.post('/game/game2', {ids: ids});
    }

    getGame1Resource(ids) {
        return this.post('/game/game1', {ids: ids});
    }

}