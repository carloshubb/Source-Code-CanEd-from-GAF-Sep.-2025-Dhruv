import ErrorHandling from "../../ErrorHandling";

const reg_page_setting = {
    namespaced: true,
    state: {
        validationErros: new ErrorHandling(),
        error: null,
        form: {
            id: null,
            page_title: {},
            reg_first_name_label: {},
            reg_first_name_placeholder: {},
            reg_first_name_error: {},
            reg_last_name_label: {},
            reg_last_name_placeholder: {},
            reg_last_name_error: {},
            reg_email_label: {},
            reg_email_placeholder: {},
            reg_email_error: {},
            reg_passowrd_label: {},
            reg_passowrd_placeholder: {},
            reg_passowrd_error: {},
            reg_confirm_passowrd_label: {},
            reg_confirm_passowrd_placeholder: {},
            reg_confirm_passowrd_error: {},
            privacy_terms_text: {},
            reg_button_text: {},
            already_register_yet_text: {},
            login_button_text: {},
            protect_your_account_text: {},
            protect_your_account_description: {},
        },
        reg_page_setting: null,
        loading: false,
        limit: 10,
    },
    mutations: {
        setPageSetting(state, payload){
             
            state.form[payload.key] = payload.value;
        },
        updatePageSetting(state, payload){
            state.form[payload.key][`${payload.key}_${payload.id}`] = payload.value;
        },
        setRegPageSetting(state, payload) {
            state.reg_page_setting = payload;
        },
        setLoading(state, payload) {
            state.loading = payload ? payload : !state.loading;
        },
        resetForm(state) {
            state.form = {
                id: null,
                page_title: {},
                reg_first_name_label: {},
                reg_first_name_placeholder: {},
                reg_first_name_error: {},
                reg_last_name_label: {},
                reg_last_name_placeholder: {},
                reg_last_name_error: {},
                reg_email_label: {},
                reg_email_placeholder: {},
                reg_email_error: {},
                reg_passowrd_label: {},
                reg_passowrd_placeholder: {},
                reg_passowrd_error: {},
                reg_confirm_passowrd_label: {},
                reg_confirm_passowrd_placeholder: {},
                reg_confirm_passowrd_error: {},
                privacy_terms_text: {},
                reg_button_text: {},
                already_register_yet_text: {},
                login_button_text: {},
                protect_your_account_text: {},
                protect_your_account_description: {},
            };
            state.validationErros = new ErrorHandling();
            state.error = null;
        },
        setForm(state, payload) {
            state.form.id = payload.id
        },
        setValidationErros(state, payload) {
            state.validationErros.record(payload);
        },
        setEmptyError(state) {
            state.validationErros = new ErrorHandling();
        },
        setError(state, payload) {
            state.error = payload;
        },
    },
    actions: {
        addUpdateForm({ commit, state }) {
            let url = `${process.env.MIX_ADMIN_API_URL}reg-page-setting`;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.post(url, state.form)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            helper.swalSuccessMessage(res.data.message);
                            resolve(res);
                        } else {
                            helper.swalErrorMessage(res.data.message);
                        }
                    })
                    .catch((error) => {
                        commit("setEmptyError");
                        if (error.response && error.response.status == 422) {
                            commit("setValidationErros", error.response.data.errors);
                            helper.swalErrorMessage("you missed required fields please check all language tabs");
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
        fetchRegPageSetting({ commit, state }, payload) {
            let url = payload.url;
            commit("setLoading");
            return new Promise(function (resolve, reject) {
                axios.get(url)
                    .then((res) => {
                        if (res.data.status == "Success") {
                            commit("setForm", res.data.data);
                            resolve(res);
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => commit("setLoading"));
            });
        },
    },
};

export default reg_page_setting;
