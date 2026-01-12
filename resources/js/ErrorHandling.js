export default class ErrorHandling {
    constructor() {
        this.errors = {};
    }

    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    any() {
        return Object.keys(this.errors).length > 0;
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }
    recordSingle(field, message) {
        this.errors[field][0] = message;
    }
    record(errors) {
        this.errors = errors;
    }

    clear(field) {
        delete this.errors[field];
    }
        clearAll() {
         this.errors={};
    }
   
}
