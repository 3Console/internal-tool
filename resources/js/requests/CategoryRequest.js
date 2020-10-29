import BaseModelRequest from './BaseModelRequest';

export default class CategoryRequest extends BaseModelRequest {
    getCategories(params) {
        const url = '/category';
        return this.get(url, params);
    }

    getCategoryIdBySlug(slug) {
        const url = `/category/id-by-slug/${slug}`;
        return this.get(url);
    }
    getCategory(categoryId) {
        const url = `/category/${categoryId}`;
        return this.get(url);
    }
    getWordsByCategory(caregoryId) {
        const url = `/word-by-category/${caregoryId}`;
        return this.get(url);
    }
    store(params) {
        const url = '/category';
        return this.post(url, params);
    }

    getTotalWordByCategories(params) {
        const url = '/category/total-word';
        return this.get(url, params);
    }

}