import ErrorHandling from "../../ErrorHandling";

const signup = {
    namespaced: true,
    state: {
        form: new FormData(),
        validationErros: new ErrorHandling(),
        error: null,
        loading: false,
        registrationPackages : null,
        businessCategories : null,
        regPageSetting : null,
    },
    mutations: {
        setRegistrationPackages(state, payload) {
            state.registrationPackages = payload;
        },
        setRegPageSetting(state, payload) {
            state.regPageSetting = payload;
        },
        setBusinessCategories(state, payload) {
            state.businessCategories = payload;
        },
        setForm(state, payload) {
            state.form.set(payload.field, payload.value);
        },
        setBusinessCategoriesForm(state, payload) {
            if(payload.type == 'add'){
                if(!state.form.get('business_categories_id')){
                    state.form.set('business_categories_id', JSON.stringify([payload.value]));
                }
                else{
                    let business_categories_id = JSON.parse(state.form.get('business_categories_id'));
                    business_categories_id.push(payload.value);
                    state.form.set('business_categories_id', JSON.stringify(business_categories_id));
                }
            }
            else{
                let business_categories_id = JSON.parse(state.form.get('business_categories_id'));
                const index = business_categories_id.indexOf(payload.value);
                if (index > -1) {
                    business_categories_id.splice(index, 1);
                    state.form.set('business_categories_id', JSON.stringify(business_categories_id));
                }
            }
        },
        setValidationErros(state, payload) {
            state.validationErros.record(payload);
        },
        setEmptyError(state) {
            state.validationErros = new ErrorHandling();
        },
        setEmailErrorEmpty(state) {
            if(state.validationErros.has('email')){
                state.validationErros.clear('email');
            }
        },
        setError(state, payload) {
            state.error = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
    },
    actions:{
        addForm({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}signup`;
            let config = {
                headers : {
                    'Content-Type': 'multipart/form-data'
                }
            }
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit("setValidationErros", error.response.data.errors);
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessage(error.response.data.message);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        checkCustomerEmail({ commit }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}check-customer-email`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, payload)
                    .then((res) => {
                        if(res.data.status == 'Success'){
                            commit("setEmailErrorEmpty");
                        }
                    })
                    .catch((error) => {
                        commit("setEmailErrorEmpty");
                        if (error.response && error.response.status == 422) {
                            commit("setValidationErros", error.response.data.errors);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchRegistrationPackages({ commit }) {
            let url = `${process.env.MIX_WEB_API_URL}get-registration-packages`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setRegistrationPackages", res.data.data);
                            resolve(res);
                        }
                        reject(error);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchRegPageSetting({ commit }) {
            let url = `${process.env.MIX_WEB_API_URL}get-reg-page-setting`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setRegPageSetting", res.data.data);
                            resolve(res);
                        }
                        reject(error);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        fetchBusinessCategories({ commit }) {
            let url = `${process.env.MIX_WEB_API_URL}get-business-categories`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setBusinessCategories", res.data.data);
                            resolve(res);
                        }
                        reject(error);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        updateSocialMedia({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}social-media`;
            let config = {
                headers : {
                    'Content-Type': 'multipart/form-data'
                }
            }
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit("setValidationErros", error.response.data.errors);
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessage(error.response.data.message);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        getSocialMedia({ commit, state }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}show-social-media`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        updateUserProfile({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}user-profile`;
            let config = {
                headers : {
                    'Content-Type': 'multipart/form-data'
                }
            }
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit("setValidationErros", error.response.data.errors);
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessage(error.response.data.message);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        getUserProfile({ commit, state }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}show-user-profile`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        updateBussinessProfile({ commit, state }) {
            let url = `${process.env.MIX_WEB_API_URL}bussiness-profile`;
            let config = {
                headers : {
                    'Content-Type': 'multipart/form-data'
                }
            }
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, state.form, config)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
                            reject(res);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit("setValidationErros", error.response.data.errors);
                        } else if (
                            error.response &&
                            error.response.data &&
                            error.response.data.status == "Error"
                        ) {
                            helper.swalErrorMessage(error.response.data.message);
                        }
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
        getBussinessProfile({ commit, state }, payload) {
            let url = `${process.env.MIX_WEB_API_URL}show-bussiness-profile`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
    }
};

export default signup;
